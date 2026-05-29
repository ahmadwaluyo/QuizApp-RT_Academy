@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4">
    <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-500/20 animate-bounce">
        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg> -->
        <span class="text-5xl">Q</span>
    </div>
    
    <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 mb-6 tracking-tight">
        QuizApp
    </h1>
    
    <p class="text-xl text-slate-400 max-w-2xl mb-12 leading-relaxed">
        Uji pengetahuanmu dengan berbagai topik menarik. Berlomba dengan waktu, cetak skor tertinggi, dan jadilah sang juara!
    </p>

    <!-- <a href="{{ route('quiz.setup.page') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-gradient-to-r from-indigo-600 to-purple-600 font-pj rounded-xl hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 shadow-xl shadow-indigo-500/30 hover:scale-105 active:scale-95">
        <span class="mr-3 text-lg">Mainkan Quiz Sekarang</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
    </a> -->
</div>
@endsection
