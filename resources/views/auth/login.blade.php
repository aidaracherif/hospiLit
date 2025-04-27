
{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HospiLit - Connexion</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('storage/admin/css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('storage/admin/css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('storage/admin/css/forms.css') }}">

  <style>
    body {
      background-color: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    .login-container {
      max-width: 400px;
      width: 100%;
    }
    .login-logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    .login-logo img {
      max-width: 150px;
    }
    .login-title {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="login-logo">
  
      <i class="fas fa-hospital rgb(255, 9, 153)" ></i>
      <h1 class="login-title">HospiLit</h1>
    </div>

    <div class="form-container">
    <h2 class="form-title">Connexion</h2>

    {{-- Message de statut (ex : lien de réinitialisation envoyé) --}}
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    {{-- Message d’erreur générique --}}
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-control @error('email') is-invalid @enderror"
          placeholder="Entrez votre email"
          value="{{ old('email') }}"
          required
          autofocus
        >
        @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control @error('password') is-invalid @enderror"
          placeholder="Entrez votre mot de passe"
          required
        >
        @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-check mb-3">
        <input
          class="form-check-input"
          type="checkbox"
          name="remember"
          id="rememberMe"
          {{ old('remember') ? 'checked' : '' }}
        >
        <label class="form-check-label" for="rememberMe">
          Se souvenir de moi
        </label>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">
          Se connecter
        </button>
      </div>

      <div class="text-center">
        @if (Route::has('password.request'))
          <a class="form-link" href="{{ route('password.request') }}">
            Mot de passe oublié ?
          </a>
        @endif
      </div>
    </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="{{ asset('storage/admin/js/main.js') }}"></script>
</body>
</html>
