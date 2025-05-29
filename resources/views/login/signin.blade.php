<x-login.layout>
    <x-slot:title>Login</x-slot:title>
    <h4 class="fw-bold">Login</h4>
    <p class="mb-0">Enter your credentials to login your account</p>

    <div class="form-body my-4">
        <form action="{{ route('login-proses') }}" method="POST" class="row g-3" validate>
            @csrf
            <div class="col-12">
                <label for="inputEmailAddress" class="form-label">Email</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Input Email"
                    value="{{ old('login') }}" required>
            </div>
            <div class="col-12">
                <label for="inputChoosePassword" class="form-label">Password</label>
                <div class="input-group" id="show_hide_password">
                    <input type="password" class="form-control border-end-0" id="password" name="password"
                        placeholder="Enter Password" required>
                    <a href="javascript:;" class="input-group-text bg-transparent "><i
                            class="bi bi-eye-slash-fill"></i></a>
                </div>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-end"> <a href="{{ route('forgot') }}">Forgot
                    Password ?</a>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-grd-voilet text-white">Login</button>
                </div>
            </div>
        </form>
    </div>
</x-login.layout>
