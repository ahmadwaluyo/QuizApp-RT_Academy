@extends('layouts.app')

@section('content')
<div class="glass-panel rounded-3xl p-8 sm:p-12 w-full max-w-lg mx-auto transform transition-all duration-500 hover:scale-[1.01]">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 mb-3">Persiapan Quiz</h1>
        <p class="text-slate-400 text-base">Masukkan nama dan pilih topik quiz untuk memulai tantangan.</p>
    </div>

    <form action="{{ route('quiz.setup') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label for="player_name" class="block text-sm font-semibold text-slate-300 mb-2 ml-1">Nama Pemain</label>
            <input type="text" name="player_name" id="player_name" required 
                class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-5 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
                placeholder="Contoh: Budi Sudarsono">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-3 ml-1">Pilih Topik Quiz</label>
            <div class="space-y-3">
                @forelse($quizzes as $quiz)
                <label class="relative flex items-center p-4 rounded-xl cursor-pointer bg-slate-800/30 border border-slate-700/50 hover:bg-slate-800/80 transition-all duration-200 group">
                    <input type="radio" name="quiz_file" value="{{ $quiz['file'] }}" required class="peer sr-only">
                    <div class="w-5 h-5 rounded-full border-2 border-slate-500 peer-checked:border-indigo-500 peer-checked:border-[6px] mr-4 transition-all duration-200"></div>
                    <div class="flex-1">
                        <h3 class="text-slate-200 font-semibold text-lg peer-checked:text-indigo-400 group-hover:text-indigo-300 transition-colors">{{ $quiz['title'] }}</h3>
                        <p class="text-slate-500 text-sm mt-0.5"><i class="fa-regular fa-clock"></i> Waktu: {{ floor($quiz['time_limit'] / 60) }} menit {{ $quiz['time_limit'] % 60 }} detik</p>
                    </div>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-indigo-500/50 pointer-events-none transition-all duration-300"></div>
                </label>
                @empty
                <div class="text-center p-6 bg-slate-800/50 rounded-xl border border-slate-700/50">
                    <p class="text-slate-400">Belum ada quiz yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>

        <button type="submit" @if(empty($quizzes)) disabled @endif
            class="w-full mt-8 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-indigo-500/30 transform transition-all duration-200 hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
            Mulai Bermain <span class="ml-2">🚀</span>
        </button>
    </form>
</div>
@endsection
