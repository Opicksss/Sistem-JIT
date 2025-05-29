<x-layout>
    <x-slot:title>Edit Supplier</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Edit Supplier</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Supplier</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="me-2">
                        <a href="{{ url('/') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="active" aria-current="page">Edit Supplier</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Edit Supplier</h5>
                <form class="row g-3" action="{{ route('acount.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-lg-6">
                        <label for="id_akun" class="form-label">Id Account</label>
                        <input type="text" class="form-control" id="id_akun" name="id_akun" value="{{ old('id_akun', $user->profile->id_akun ?? '' ) }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $user->profile->telepon ?? '' ) }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="name" class="form-label">Nama Account</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control" id="password" name="password">
                            <a href="javascript:;" class="input-group-text bg-transparent "><i
                                    class="bi bi-eye-slash-fill"></i></a>
                        </div>
                        <small>* Jika Tidak Ada Perubahan Pada Password Tidak Perlu Di Isi!</small>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group" id="show_hide_password1">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <a href="javascript:;" class="input-group-text bg-transparent "><i
                                    class="bi bi-eye-slash-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{old('alamat', $user->profile->alamat ?? '' )}}</textarea>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="provinsi" class="form-label">Menu</label>
                        <div class="row">
                            @foreach ($menus as $menu)
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="menu_ids[]"
                                            value="{{ $menu->id }}"
                                            {{ isset($userMenuIds) && in_array($menu->id, $userMenuIds) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $menu->label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <button type="submit" class="btn btn-grd-primary px-4 text-white">Update</button>
                            <a href="{{ route('acount.index') }}" class="btn btn-grd-royal px-4 text-white">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
