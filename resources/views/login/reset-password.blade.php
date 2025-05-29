<x-login.layout>
    <x-slot:title>Reset Password</x-slot:title>

    <h4 class="fw-bold">Reset Your Password</h4>
    <p>Please enter your new password.</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('reset-password-proses') }}" method="POST" class="my-4">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group" id="show_hide_password">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="New Password"required>
                <a href="javascript:;" class="input-group-text bg-transparent "><i class="bi bi-eye-slash-fill"></i></a>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <div class="input-group" id="show_hide_password1">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                placeholder="Confirm New Password" required>
            <a href="javascript:;" class="input-group-text bg-transparent "><i class="bi bi-eye-slash-fill"></i></a>
        </div>
        </div>
        <div class="col-12">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-grd-voilet text-white">Reset Password</button>
                <a href="{{ route('login') }}" class="btn btn-light">Back to Login</a>
            </div>
        </div>
    </form>
</x-login.layout>
