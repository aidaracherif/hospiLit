@extends('layouts.app1')
@section('content')
<div class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header py-4 text-center" style="background: linear-gradient(135deg, rgb(251, 85, 126), #ff0044); color: white; border: none;">
                    <h3 class="mb-0">{{ __('Connexion') }}</h3>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Adresse Email') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: rgb(251, 85, 126); color: white; border: none;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="border-left: none;">
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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="border-left: none;">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="border-color: #ff3366;">
                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn text-white px-4 py-2" style="background: linear-gradient(135deg, rgb(251, 85, 126), #ff0044); border: none; border-radius: 5px;">
                                    {{ __('Connexion') }}
                                </button>
                                
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}" style="color: rgb(251, 85, 126); text-decoration: none;">
                                    {{ __('Mot de passe oublié?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <p class="mb-0">Pas encore de compte? <a href="{{ route('register') }}" style="color: rgb(251, 85, 126); font-weight: 600; text-decoration: none;">S'inscrire</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection