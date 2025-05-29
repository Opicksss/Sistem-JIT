<x-login.layout>
    <x-slot:title>Verify Code</x-slot:title>

    <h4 class="fw-bold">Verify Your Email Code</h4>
    <p>Enter the 6-digit code sent to your email</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('verify-code-proses') }}" method="POST" class="my-4">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Verification Code</label>
            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                maxlength="6" placeholder="Enter Your Code" required autofocus>
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-grd-voilet text-white">Verify Code</button>
                <a href="{{ route('login') }}" class="btn btn-light">Back to Login</a>
            </div>
        </div>
    </form>
</x-login.layout>
