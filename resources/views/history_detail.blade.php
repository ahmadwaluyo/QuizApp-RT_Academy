@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-extrabold text-white mb-2">Hasil Pengerjaan</h1>
        <p class="text-slate-400">Rincian jawaban untuk quiz <span class="text-indigo-400 font-semibold">{{ $historyData['quiz_title'] }}</span></p>
    </div>
    <!-- <a href="{{ route('history.index') }}" class="text-sm font-semibold text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a> -->
</div>

<!-- Stats Dashboard -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="glass-panel rounded-2xl p-5 border-t-2 border-t-indigo-500">
        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Pemain</p>
        <p class="text-white font-bold text-xl">{{ $historyData['player_name'] }}</p>
    </div>
    <div class="glass-panel rounded-2xl p-5 border-t-2 border-t-emerald-500">
        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Benar</p>
        <p class="text-emerald-400 font-bold text-2xl">{{ $historyData['correct_count'] }}</p>
    </div>
    <div class="glass-panel rounded-2xl p-5 border-t-2 border-t-rose-500">
        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Salah</p>
        <p class="text-rose-400 font-bold text-2xl">{{ $historyData['wrong_count'] }}</p>
    </div>
    <div class="glass-panel rounded-2xl p-5 border-t-2 border-t-purple-500">
        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Waktu Dihabiskan</p>
        <p class="text-purple-400 font-bold text-xl">{{ floor($historyData['time_spent_seconds'] / 60) }}m {{ $historyData['time_spent_seconds'] % 60 }}s</p>
    </div>
</div>

<!-- Details List -->
<div class="space-y-6">
    <h2 class="text-xl font-bold text-slate-200 border-b border-slate-700/50 pb-2 mb-4">Rincian Jawaban</h2>
    
    @foreach($historyData['details'] as $index => $detail)
    <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border {{ $detail['is_correct'] ? 'border-emerald-500/30' : 'border-rose-500/30' }}">
        <!-- Indicator Banner -->
        <div class="absolute top-0 right-0 px-4 py-1 rounded-bl-xl text-xs font-bold {{ $detail['is_correct'] ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
            {{ $detail['is_correct'] ? 'BENAR' : 'SALAH' }}
        </div>

        <div class="flex gap-4 mb-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm {{ $detail['is_correct'] ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                {{ $index + 1 }}
            </div>
            <h3 class="text-lg font-medium text-slate-200 pt-1 leading-snug">{{ $detail['question'] }}</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-0 sm:pl-12">
            @foreach($detail['options'] as $key => $value)
                @php
                    $isPlayerAnswer = $detail['player_answer'] === $key;
                    $isCorrectAnswer = $detail['correct_answer'] === $key;
                    
                    $bgClass = 'bg-slate-800/40 border-slate-700/50';
                    $textClass = 'text-slate-400';
                    $icon = '';
                    
                    if ($isCorrectAnswer) {
                        $bgClass = 'bg-emerald-500/10 border-emerald-500/50';
                        $textClass = 'text-emerald-400 font-semibold';
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 ml-auto" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>';
                    } elseif ($isPlayerAnswer && !$detail['is_correct']) {
                        $bgClass = 'bg-rose-500/10 border-rose-500/50';
                        $textClass = 'text-rose-400 font-semibold';
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-400 ml-auto" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
                    }
                @endphp
                <div class="flex items-center p-3 rounded-xl border {{ $bgClass }} transition-colors">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-3 border border-slate-600 {{ $isPlayerAnswer ? 'bg-slate-700 text-white' : 'bg-transparent text-slate-500' }}">
                        {{ strtoupper($key) }}
                    </span>
                    <span class="{{ $textClass }}">{{ $value }}</span>
                    {!! $icon !!}
                </div>
            @endforeach
        </div>
        
        @if($detail['player_answer'] === null)
        <div class="mt-4 pl-0 sm:pl-12">
            <span class="inline-block px-3 py-1 bg-yellow-500/20 text-yellow-500 text-xs font-semibold rounded-md border border-yellow-500/30">
                ⚠️ Tidak dijawab
            </span>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
