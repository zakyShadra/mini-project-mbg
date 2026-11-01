<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Rekap Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" action="{{ route('rekap.index') }}" class="flex gap-3">
                    <select name="sekolah_id" class="border-gray-300 rounded-md">
                        <option value="">{{ __('Semua sekolah') }}</option>
                        @foreach ($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" @selected(request('sekolah_id') == $sekolah->id)>{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                    <x-secondary-button type="submit">{{ __('Filter') }}</x-secondary-button>
                </form>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold">{{ $totalLaporan }}</div>
                    <div class="text-gray-500 text-sm">{{ __('Total Laporan') }}</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold">{{ $laporanDiproses }}</div>
                    <div class="text-gray-500 text-sm">{{ __('Masih Diproses') }}</div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold">{{ $laporanSelesai }}</div>
                    <div class="text-gray-500 text-sm">{{ __('Selesai') }}</div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-medium mb-4">{{ __('Jumlah Laporan per Sekolah') }}</h3>
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">{{ __('Sekolah') }}</th>
                            <th class="py-2">{{ __('Jumlah Laporan') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapPerSekolah as $sekolah)
                            <tr class="border-b">
                                <td class="py-2">{{ $sekolah->nama_sekolah }}</td>
                                <td class="py-2">{{ $sekolah->total_laporan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-gray-500">{{ __('Belum ada data.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
