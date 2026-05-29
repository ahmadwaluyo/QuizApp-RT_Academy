<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function setupPage()
    {
        $quizzes = [];
        if (Storage::exists('quizzes')) {
            $files = Storage::files('quizzes');
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $content = json_decode(Storage::get($file), true);
                    $quizzes[] = [
                        'file' => basename($file),
                        'title' => $content['title'] ?? 'Unknown Quiz',
                        'time_limit' => $content['time_limit_seconds'] ?? 0,
                    ];
                }
            }
        }
        
        return view('setup', compact('quizzes'));
    }

    public function setup(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
            'quiz_file' => 'required|string'
        ]);

        session([
            'player_name' => $request->player_name,
            'quiz_file' => $request->quiz_file,
            'start_time' => null // reset start time on new setup
        ]);

        return redirect()->route('quiz.play');
    }

    public function play()
    {
        $playerName = session('player_name');
        $quizFile = session('quiz_file');

        if (!$playerName || !$quizFile) {
            return redirect()->route('home')->with('error', 'Silakan masukkan nama dan pilih quiz terlebih dahulu.');
        }

        $path = 'quizzes/' . $quizFile;
        if (!Storage::exists($path)) {
            return redirect()->route('home')->with('error', 'Quiz tidak ditemukan.');
        }

        $quizData = json_decode(Storage::get($path), true);

        // Set start time if not already set
        if (!session()->has('start_time') || session('start_time') === null) {
            session(['start_time' => time()]);
        }

        return view('play', compact('quizData'));
    }

    public function submit(Request $request)
    {
        $playerName = session('player_name');
        $quizFile = session('quiz_file');
        $startTimeRaw = session('start_time');

        if (!$playerName || !$quizFile || !$startTimeRaw) {
            return redirect()->route('home');
        }

        // Handle both old string format and new timestamp format
        if (is_numeric($startTimeRaw)) {
            $startTimeTs = $startTimeRaw;
            $startTime = now()->setTimestamp($startTimeTs);
        } else {
            $startTime = \Carbon\Carbon::parse($startTimeRaw);
            $startTimeTs = $startTime->timestamp;
        }

        $path = 'quizzes/' . $quizFile;
        $quizData = json_decode(Storage::get($path), true);

        $endTime = now();
        $timeSpentSeconds = time() - $startTimeTs;
        if ($timeSpentSeconds < 0) {
            $timeSpentSeconds = 0;
        }
        
        // Enforce max time limit (allow few seconds buffer for submission delay)
        $limit = $quizData['time_limit_seconds'];
        if ($timeSpentSeconds > $limit + 5) {
            $timeSpentSeconds = $limit; // Cap it
        }

        $answers = $request->input('answers', []);
        
        $correctCount = 0;
        $wrongCount = 0;
        $details = [];

        foreach ($quizData['questions'] as $q) {
            $id = $q['id'];
            $playerAnswer = $answers[$id] ?? null;
            $correctAnswer = $q['answer'];
            $isCorrect = $playerAnswer === $correctAnswer;

            if ($isCorrect) {
                $correctCount++;
            } else {
                $wrongCount++;
            }

            $details[] = [
                'id' => $id,
                'question' => $q['question'],
                'options' => $q['options'],
                'correct_answer' => $correctAnswer,
                'player_answer' => $playerAnswer,
                'is_correct' => $isCorrect
            ];
        }

        $historyData = [
            'player_name' => $playerName,
            'quiz_title' => $quizData['title'],
            'correct_count' => $correctCount,
            'wrong_count' => $wrongCount,
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'time_spent_seconds' => $timeSpentSeconds,
            'details' => $details
        ];

        // Ensure history directory exists
        if (!Storage::exists('history')) {
            Storage::makeDirectory('history');
        }

        $filename = preg_replace('/[^a-zA-Z0-9]+/', '_', trim($playerName)) . '_' . time() . '.json';
        Storage::put('history/' . $filename, json_encode($historyData, JSON_PRETTY_PRINT));

        // Clear session play data
        session()->forget(['player_name', 'quiz_file', 'start_time']);

        return redirect()->route('history.detail', ['filename' => $filename]);
    }

    public function history()
    {
        $histories = [];
        if (Storage::exists('history')) {
            $files = Storage::files('history');
            
            // Sort files by last modified (newest first)
            usort($files, function ($a, $b) {
                return Storage::lastModified($b) <=> Storage::lastModified($a);
            });

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $content = json_decode(Storage::get($file), true);
                    $histories[] = [
                        'file' => basename($file),
                        'player_name' => $content['player_name'] ?? 'Unknown',
                        'quiz_title' => $content['quiz_title'] ?? '',
                        'correct_count' => $content['correct_count'] ?? 0,
                        'wrong_count' => $content['wrong_count'] ?? 0,
                        'start_time' => $content['start_time'] ?? '',
                        'end_time' => $content['end_time'] ?? '',
                    ];
                }
            }
        }
        
        return view('history', compact('histories'));
    }

    public function historyDetail($filename)
    {
        $path = 'history/' . $filename;
        if (!Storage::exists($path)) {
            abort(404, 'History not found.');
        }

        $historyData = json_decode(Storage::get($path), true);
        return view('history_detail', compact('historyData'));
    }
}
