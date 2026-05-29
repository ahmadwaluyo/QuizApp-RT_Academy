@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 mb-2">Riwayat Pengerjaan</h1>
    <p class="text-slate-400">Lihat riwayat hasil quiz dari semua pemain.</p>
</div>

<div class="glass-panel rounded-3xl overflow-hidden border border-slate-700/50">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/50 border-b border-slate-700/50">
                    <th class="py-4 px-6 font-semibold text-slate-300 text-sm uppercase tracking-wider">Pemain</th>
                    <th class="py-4 px-6 font-semibold text-slate-300 text-sm uppercase tracking-wider">Quiz</th>
                    <th class="py-4 px-6 font-semibold text-slate-300 text-sm uppercase tracking-wider">Skor (B/S)</th>
                    <th class="py-4 px-6 font-semibold text-slate-300 text-sm uppercase tracking-wider">Waktu Selesai</th>
                    <th class="py-4 px-6 font-semibold text-slate-300 text-sm uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                @forelse($histories as $h)
                <tr class="hover:bg-slate-800/30 transition-colors duration-150">
                    <td class="py-4 px-6">
                        <div class="font-medium text-white">{{ $h['player_name'] }}</div>
                    </td>
                    <td class="py-4 px-6 text-slate-300">{{ $h['quiz_title'] }}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded-md">{{ $h['correct_count'] }} Benar</span>
                            <span class="px-2 py-1 bg-rose-500/10 text-rose-400 text-xs font-bold rounded-md">{{ $h['wrong_count'] }} Salah</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-slate-400 text-sm">
                        {{ \Carbon\Carbon::parse($h['end_time'])->format('d M Y, H:i') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('history.detail', ['filename' => $h['file']]) }}" class="inline-flex px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 rounded-lg text-sm font-semibold transition-colors">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 px-6 text-center text-slate-400">
                        Belum ada riwayat permainan. Jadilah yang pertama!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
