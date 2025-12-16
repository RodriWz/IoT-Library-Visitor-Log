<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Reset Password</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- STEP 1: KIRIM KODE --}}
                <div class="card mb-4">
                    <div class="card-header">Step 1: Kirim Kode Reset</div>
                    <div class="card-body">
                        <form action="{{ route('reset.send.code') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Kode</button>
                        </form>
                    </div>
                </div>

                {{-- STEP 2: RESET PASSWORD --}}
                <div class="card">
                    <div class="card-header">Step 2: Reset Password</div>
                    <div class="card-body">
                        <form action="{{ route('reset.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Reset (6 Digit)</label>
                                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" maxlength="6" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control @error('password_baru') is-invalid @enderror" required>
                                @error('password_baru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_baru_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Reset Password</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>