@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/auth/passwords/reset.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HospiLit - Réinitialisation</title>
  
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
    .login-logo i {
      font-size: 3rem;
      color: var(--primary-color);
    }
    .login-title {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .form-title {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-logo">
      <i class="fas fa-hospital"></i>
      <h1 class="login-title">HospiLit</h1>
    </div>

    <div class="form-container">
      <h2 class="form-title">Réinitialiser le mot de passe</h2>

      {{-- Statut (lien de reset envoyé…) --}}
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      {{-- Erreur générique --}}
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ $email ?? old('email') }}"
            placeholder="Entrez votre email"
            required
            autofocus
          >
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Nouveau mot de passe</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Entrez votre nouveau mot de passe"
            required
          >
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password-confirm" class="form-label">Confirmez le mot de passe</label>
          <input
            type="password"
            id="password-confirm"
            name="password_confirmation"
            class="form-control"
            placeholder="Confirmez votre mot de passe"
            required
          >
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">
            Réinitialiser
          </button>
        </div>

        <div class="text-center">
          <a href="{{ route('login') }}" class="form-link">
            Retour à la connexion
          </a>
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
