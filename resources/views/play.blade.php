@extends('layouts.app')

@section('content')
@php
    $timeLimit = $quizData['time_limit_seconds'];
    $startTimeRaw = session('start_time');
    if (is_numeric($startTimeRaw)) {
        $timeSpent = time() - $startTimeRaw;
    } else {
        $timeSpent = now()->diffInSeconds(\Carbon\Carbon::parse($startTimeRaw));
    }
    if ($timeSpent < 0) $timeSpent = 0;
    $timeRemaining = max(0, $timeLimit - $timeSpent);
@endphp

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 sticky top-16 z-40 py-4 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 glass-nav rounded-b-2xl border-t-0">
    <div>
        <h1 class="text-3xl font-extrabold text-white mb-2">{{ $quizData['title'] }}</h1>
        <p class="text-slate-400">Pemain: <span class="text-indigo-400 font-semibold">{{ session('player_name') }}</span></p>
    </div>
    
    <!-- Timer Display -->
    <div class="glass-panel px-6 py-3 rounded-2xl flex items-center gap-4 border-indigo-500/30">
        <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Sisa Waktu</p>
            <div id="timerDisplay" class="text-2xl font-bold text-white font-mono tracking-widest">
                00:00
            </div>
        </div>
    </div>
</div>

<form id="quizForm" action="{{ route('quiz.submit') }}" method="POST">
    @csrf
    
    <div class="space-y-8 mb-24">
        @foreach($quizData['questions'] as $index => $q)
        <div class="glass-panel rounded-3xl p-6 sm:p-8 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-indigo-500 to-purple-500 opacity-50 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="flex gap-4 mb-6">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400 font-bold border border-slate-700">
                    {{ $index + 1 }}
                </div>
                <h2 class="text-xl font-medium text-slate-100 leading-relaxed pt-1">{{ $q['question'] }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-0 sm:pl-14">
                @foreach($q['options'] as $key => $value)
                <label class="relative flex items-center p-4 rounded-xl cursor-pointer bg-slate-800/40 border border-slate-700/50 hover:bg-slate-700/60 transition-all duration-200 group/option">
                    <input type="radio" name="answers[{{ $q['id'] }}]" value="{{ $key }}" class="peer sr-only">
                    <div class="w-6 h-6 rounded-full border-2 border-slate-500 peer-checked:border-indigo-500 peer-checked:border-[6px] mr-4 transition-all duration-200 flex-shrink-0"></div>
                    <div class="text-slate-300 font-medium peer-checked:text-white transition-colors">{{ $value }}</div>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-indigo-500/50 pointer-events-none transition-all duration-300"></div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Floating Submit Button -->
    <div class="fixed bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/90 to-transparent z-40 pointer-events-none flex justify-center pb-8">
        <button type="submit" id="submitBtn" class="pointer-events-auto shadow-2xl shadow-indigo-500/40 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-4 px-12 rounded-full text-lg transform transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-3">
            <span>Selesai & Kumpulkan</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeRemaining = {{ $timeRemaining }};
        const timerDisplay = document.getElementById('timerDisplay');
        const form = document.getElementById('quizForm');
        
        function updateDisplay() {
            if (timeRemaining <= 0) {
                timerDisplay.textContent = "00:00";
                timerDisplay.classList.add('text-rose-500');
                timerDisplay.classList.remove('text-white');
                return;
            }
            
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerDisplay.textContent = 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
                
            if (timeRemaining <= 10) {
                timerDisplay.classList.add('text-rose-400');
                timerDisplay.classList.remove('text-white');
            }
        }
        
        updateDisplay();
        
        if (timeRemaining > 0) {
            const timerInterval = setInterval(function() {
                timeRemaining--;
                updateDisplay();
                
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    // Disable button to prevent double submit
                    document.getElementById('submitBtn').disabled = true;
                    document.getElementById('submitBtn').innerHTML = 'Waktu Habis! Mengumpulkan...';
                    form.submit();
                }
            }, 1000);
        } else {
            // Already expired
            form.submit();
        }
    });
</script>
@endsection
