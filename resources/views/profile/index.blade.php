@extends('layouts.app')

@section('content')
<style>
    .form-container { background: white; border-radius: 24px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .input-field { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 20px; width: 100%; transition: all 0.3s; color: #1b254b; font-weight: 500; }
    .input-field:focus { outline: none; border-color: #5b80ff; background-color: white; box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1); }
    .input-error { border-color: #fc8181; background-color: #fff5f5; }
    .input-label { display: block; font-weight: 700; color: #1b254b; margin-bottom: 10px; font-size: 14px; }
    .section-title { font-size: 18px; font-weight: 800; color: #1b254b; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; }
</style>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Pengaturan Akun</h2>
    <p class="text-gray-400 mt-1 font-medium">Kelola informasi profil dan keamanan akun admin Anda.</p>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif
@if(session('info'))
    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl mb-6 font-medium border border-blue-100 flex items-center">
        <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 font-medium border border-red-100 flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-8">
        
        <div class="form-container">
            <h3 class="section-title"><i class="fas fa-user-edit text-[#5b80ff]"></i> Informasi Profil</h3>
            <form action="{{ route('profile.updateName') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="input-label">Nama Admin</label>
                        <input type="text" name="nama_admin" value="{{ old('nama_admin', Auth::user()->nama_admin ?? '') }}" class="input-field" required>
                    </div>
                    <div>
                        <label class="input-label">Alamat Email <span class="text-xs text-gray-400 font-normal ml-2">(Tidak dapat diubah)</span></label>
                        <input type="email" value="{{ Auth::user()->email ?? '' }}" class="input-field bg-gray-100 text-gray-400 cursor-not-allowed border-gray-100" disabled>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#5b80ff] hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="form-container">
            <h3 class="section-title"><i class="fas fa-lock text-[#5b80ff]"></i> Keamanan (Ubah Password)</h3>
            <form action="{{ route('profile.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="input-label">Password Lama</label>
                        <input type="password" name="current_password" class="input-field @error('current_password') input-error @enderror" required placeholder="Masukkan password saat ini">
                        @error('current_password') <p class="text-red-500 text-xs italic mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Password Baru</label>
                        <input type="password" name="new_password" class="input-field @error('new_password') input-error @enderror" required placeholder="Minimal 6 karakter">
                        @error('new_password') <p class="text-red-500 text-xs italic mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="input-field" required placeholder="Ketik ulang password baru">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#1b254b] hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-md">
                            Perbarui Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="lg:col-span-1">
        <div class="bg-white border-2 border-red-100 rounded-[24px] p-8 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 rounded-full z-0 opacity-50"></div>
            
            <h3 class="text-xl font-extrabold text-[#1b254b] mb-2 relative z-10 text-red-600 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i> Danger Zone
            </h3>
            <p class="text-gray-500 text-sm font-medium mb-6 relative z-10 leading-relaxed">
                Menghapus akun admin akan menghilangkan akses Anda ke sistem InvoPay secara permanen. Tindakan ini tidak dapat dibatalkan.
            </p>
            
            <form action="{{ route('profile.destroy') }}" method="POST" class="relative z-10" onsubmit="return confirm('PERINGATAN!\n\nApakah Anda benar-benar yakin ingin menghapus akun admin ini? Anda akan langsung dikeluarkan dari sistem.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3.5 px-6 rounded-xl transition duration-300 shadow-md shadow-red-500/30">
                    Hapus Akun Permanen
                </button>
            </form>
        </div>
    </div>

</div>
@endsection