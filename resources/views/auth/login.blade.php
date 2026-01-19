<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Absensi Karyawan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #312e81, #2563eb);
    font-family: 'Segoe UI', sans-serif;
}

/* Card */
.card {
    border-radius: 22px;
    background: rgba(255,255,255,0.92);
    padding: 2.4rem;
    box-shadow: 0 20px 40px rgba(0,0,0,.25);
    transition: .4s ease;
}

.card:hover {
    transform: translateY(-6px);
}

/* Title */
h3 {
    font-weight: 800;
    color: #1f2937;
}

/* Label */
label {
    font-weight: 600;
    color: #374151;
}

/* Input */
.form-control {
    border-radius: 14px;
    padding: 12px 14px;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 .25rem rgba(99,102,241,.25);
}

/* Button */
.btn-login {
    border-radius: 16px;
    background: linear-gradient(45deg, #6366f1, #ec4899);
    color: #fff;
    font-weight: 600;
    padding: 12px;
    transition: .35s;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(236,72,153,.45);
}

/* Alert */
.alert-danger {
    background: rgba(239,68,68,.12);
    color: #991b1b;
    border: none;
    border-radius: 16px;
}

/* Footer */
.footer-text {
    font-size: .85rem;
    color: #6b7280;
}
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="col-md-5 col-lg-4">

<div class="card border-0">

    <h3 class="text-center mb-4">
        <i class="bi bi-person-badge-fill me-2 text-primary"></i>
        Absensi Karyawan
    </h3>

    @if($errors->has('loginError'))
    <div class="alert alert-danger mb-4">
        <strong>Login Gagal</strong><br>
        <small>{{ $errors->first('loginError') }}</small>
    </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control"
                   placeholder="email@example.com"
                   required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control"
                   placeholder="••••••••"
                   required>
        </div>

        <button type="submit" class="btn btn-login w-100">
            Login
        </button>
    </form>

    <p class="text-center mt-3 footer-text">
        © 2026 Absensi Karyawan
    </p>

</div>

</div>
</div>

</body>
</html>
