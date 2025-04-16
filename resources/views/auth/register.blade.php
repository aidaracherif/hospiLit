@extends('layouts.app1')
@section('content')
<div class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header py-4 text-center" style="background: linear-gradient(135deg,rgb(254, 82, 125),rgb(255, 44, 100)); color: white; border: none;">
                    <h3 class="mb-0">{{ __('Inscription') }}</h3>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Nom') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="border-left: none;">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Adresse Email') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color:rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="border-left: none;">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Mot de passe') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border-left: none;">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Confirmer Mot de passe') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="border-left: none;">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="role" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color:rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="role" type="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required autocomplete="role" style="border-left: none;">
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn text-white px-4 py-2" style="background: linear-gradient(135deg, rgb(251, 85, 126), #ff0044); border: none; border-radius: 5px;">
                                    {{ __('S\'inscrire') }}
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <p class="mb-0">Déjà inscrit? <a href="{{ route('login') }}" style="color: rgb(251, 85, 126); font-weight: 600; text-decoration: none;">Se connecter</a></p>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <p class="text-muted small">En vous inscrivant, vous acceptez nos <a href="#" style="color: rgb(251, 85, 126);">conditions d'utilisation</a> et notre <a href="#" style="color: #ff3366;">politique de confidentialité</a>.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection