<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex justify-content-center bg-light" style="min-height: 100vh;">
<div class="align-self-start mt-5 card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4">Sign In</h3>

    @if (session('error'))
        <div id="message-area" class="alert alert-danger" role="alert" style="display: block;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="login" class="form-label">Username</label>
            <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Log In</button>
        </div>
    </form>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
