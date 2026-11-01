<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6 space-y-2">
                <div><span class="font-medium">{{ __('Sekolah') }}:</span> {{ $laporan->distribusi->sekolah->nama_sekolah }}</div>
                <div><span class="font-medium">{{ __('Distribusi') }}:</span> {{ $laporan->distribusi->menu }} ({{ $laporan->distribusi->tanggal->format('d M Y') }})</div>
                <div><span class="font-medium">{{ __('Deskripsi') }}:</span> {{ $laporan->deskripsi }}</div>
                <div><span class="font-medium">{{ __('Status') }}:</span> {{ ucfirst($laporan->status) }}</div>
                @if ($laporan->bukti)
                    <div><a href="{{ Storage::url($laporan->bukti) }}" target="_blank" class="text-indigo-600 underline">{{ __('Lihat Bukti') }}</a></div>
                @endif
                @if ($laporan->catatan)
                    <div><span class="font-medium">{{ __('Catatan Peninjauan') }}:</span> {{ $laporan->catatan }}</div>
                @endif
                @if ($laporan->forwarded_to)
                    <div><span class="font-medium">{{ __('Diteruskan ke') }}:</span> {{ $laporan->forwarded_to }} ({{ $laporan->forwarded_at->format('d M Y H:i') }})</div>
                @endif
            </div>

            @can('update', $laporan)
                @if (auth()->user()->isReporter() && $laporan->status === 'baru')
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="font-medium mb-4">{{ __('Perbaiki Laporan') }}</h3>
                        <form method="POST" action="{{ route('laporans.update', $laporan) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi Kejadian')" />
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="block mt-1 w-full border-gray-300 rounded-md">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="bukti" :value="__('Ganti Bukti Pendukung')" />
                                <input id="bukti" type="file" name="bukti" class="block mt-1 w-full" />
                                <x-input-error :messages="$errors->get('bukti')" class="mt-2" />
                            </div>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </form>
                    </div>
                @endif

                @if (auth()->user()->isMonitor() || auth()->user()->isKoordinator())
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="font-medium mb-4">{{ __('Tinjau Laporan') }}</h3>
                        <form method="POST" action="{{ route('laporans.review', $laporan) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md">
                                    @foreach (['baru', 'ditinjau', 'diteruskan', 'selesai'] as $status)
                                        <option value="{{ $status }}" @selected($laporan->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="catatan" :value="__('Catatan')" />
                                <textarea id="catatan" name="catatan" rows="2" class="block mt-1 w-full border-gray-300 rounded-md">{{ old('catatan', $laporan->catatan) }}</textarea>
                                <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                            </div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="ditandai" value="1" @checked($laporan->ditandai) />
                                {{ __('Tandai perlu diteruskan') }}
                            </label>
                            @if (auth()->user()->isKoordinator())
                                <div>
                                    <x-input-label for="forwarded_to" :value="__('Diteruskan ke')" />
                                    <input id="forwarded_to" name="forwarded_to" type="text" value="{{ old('forwarded_to', $laporan->forwarded_to) }}" class="block mt-1 w-full border-gray-300 rounded-md" placeholder="Sekolah / SPPG / Fasilitas Kesehatan" />
                                    <x-input-error :messages="$errors->get('forwarded_to')" class="mt-2" />
                                </div>
                            @endif
                            <x-primary-button>{{ __('Simpan Tinjauan') }}</x-primary-button>
                        </form>
                    </div>
                @endif
            @endcan
        </div>
    </div>
</x-app-layout>
