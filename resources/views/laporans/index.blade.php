<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            @if (auth()->user()->isReporter())
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="font-medium mb-4">{{ __('Buat Laporan') }}</h3>
                    <form method="POST" action="{{ route('laporans.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="sekolah_id" :value="__('Sekolah')" />
                            <select id="sekolah_id" class="block mt-1 w-full border-gray-300 rounded-md">
                                <option value="">-- pilih sekolah --</option>
                                @foreach ($sekolahs as $sekolah)
                                    <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="distribusi_id" :value="__('Distribusi')" />
                            <select id="distribusi_id" name="distribusi_id" class="block mt-1 w-full border-gray-300 rounded-md" required>
                                <option value="">-- pilih sekolah dulu --</option>
                            </select>
                            <x-input-error :messages="$errors->get('distribusi_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Kejadian')" />
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="block mt-1 w-full border-gray-300 rounded-md">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="bukti" :value="__('Bukti Pendukung (JPG/PNG/PDF, maks 2MB)')" />
                            <input id="bukti" type="file" name="bukti" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('bukti')" class="mt-2" />
                        </div>
                        <x-primary-button>{{ __('Kirim Laporan') }}</x-primary-button>
                    </form>
                </div>

                <script>
                    document.getElementById('sekolah_id').addEventListener('change', async function (event) {
                        const distribusiSelect = document.getElementById('distribusi_id');
                        const sekolahId = event.target.value;

                        distribusiSelect.innerHTML = '<option value="">-- memuat... --</option>';

                        if (!sekolahId) {
                            distribusiSelect.innerHTML = '<option value="">-- pilih sekolah dulu --</option>';
                            return;
                        }

                        try {
                            const response = await fetch(`/sekolahs/${sekolahId}/distribusis`);

                            if (!response.ok) {
                                distribusiSelect.innerHTML = '<option value="">-- gagal memuat distribusi --</option>';
                                return;
                            }

                            const distribusis = await response.json();

                            if (distribusis.length === 0) {
                                distribusiSelect.innerHTML = '<option value="">-- belum ada distribusi --</option>';
                                return;
                            }

                            distribusiSelect.innerHTML = '<option value="">-- pilih distribusi --</option>' +
                                distribusis.map(d => `<option value="${d.id}">${d.menu} (${d.tanggal.substring(0, 10)})</option>`).join('');
                        } catch (error) {
                            distribusiSelect.innerHTML = '<option value="">-- gagal memuat distribusi --</option>';
                        }
                    });
                </script>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" action="{{ route('laporans.index') }}" class="flex flex-wrap gap-3 mb-6">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari deskripsi...') }}" class="border-gray-300 rounded-md" />
                    <select name="status" class="border-gray-300 rounded-md">
                        <option value="">{{ __('Semua status') }}</option>
                        @foreach (['baru', 'ditinjau', 'diteruskan', 'selesai'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <x-secondary-button type="submit">{{ __('Filter') }}</x-secondary-button>
                </form>

                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">{{ __('Deskripsi') }}</th>
                            <th class="py-2">{{ __('Status') }}</th>
                            <th class="py-2">{{ __('Tanggal') }}</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr class="border-b">
                                <td class="py-2">{{ Str::limit($laporan->deskripsi, 60) }}</td>
                                <td class="py-2">{{ ucfirst($laporan->status) }}</td>
                                <td class="py-2">{{ $laporan->created_at->format('d M Y') }}</td>
                                <td class="py-2">
                                    <a href="{{ route('laporans.show', $laporan) }}" class="text-indigo-600 underline">{{ __('Detail') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-gray-500">{{ __('Belum ada laporan.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
