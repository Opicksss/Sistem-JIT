<x-login.layout>
    <x-slot:title>Forgot Password</x-slot:title>
    <h4 class="fw-bold">Forgot Password?</h4>
    <p class="mb-0">Enter your registered email ID to reset the password</p>

    <div class="form-body my-4">
        <form action="{{ route('forgot-proses') }}" method="POST">
            @csrf
            <div class="col-12 mb-4">
                <label class="form-label">Registered Email</label>
                <input type="email" class="form-control " placeholder="Enter Your Email Address" id="email"
                    name="email" required>
            </div>
            <div class="col-12">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-grd-voilet text-white">Send</button>
                    <a href="{{ route('login') }}" class="btn btn-light">Back to Login</a>
                </div>
            </div>
        </form>
    </div>
</x-login.layout>
