<x-layouts.app title="Tambah Dokter">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Dokter</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('dokter.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 font-medium">Nama Dokter <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_dokter" value="{{ old('nama_dokter') }}"
                        class="w-full border rounded-lg px-4 py-2" placeholder="Masukkan nama dokter...">
                    @error('nama_dokter')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border rounded-lg px-4 py-2" placeholder="Masukkan email...">
                    @error('email')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. KTP <span class="text-red-600">*</span></label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}"
                        class="w-full border rounded-lg px-4 py-2" placeholder="Masukkan No. KTP...">
                    @error('no_ktp')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-medium">No. HP <span class="text-red-600">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full border rounded-lg px-4 py-2" placeholder="Masukkan No. HP...">
                    @error('no_hp')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block mb-2 font-medium">Alamat <span class="text-red-600">*</span></label>
                <textarea name="alamat" rows="4" class="w-full border rounded-lg px-4 py-2"
                    placeholder="Masukkan alamat...">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Poli <span class="text-red-600">*</span></label>
                <select name="poli_id" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Pilih Poli --</option>
                    @foreach($polis as $item)
                        <option value="{{ $item->id }}" {{ old('poli_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_poli }}
                        </option>
                    @endforeach
                </select>
                @error('poli_id')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Password <span class="text-red-600">*</span></label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-4 py-2" placeholder="Minimal 8 karakter...">
                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('dokter.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>