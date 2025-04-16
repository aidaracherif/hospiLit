<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HospiLit - Plateforme de services hospitaliers</title>


    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('storage/css/style.css') }}" rel="stylesheet">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <i class="fas fa-hospital"></i> HospiLit
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{route('login')}}" class="btn btn-outline-light me-2">Connexion</a>
                    <a href="{{route('register')}}" class="btn btn-light">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

        {{-- MAIN CONTENT --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

            @yield('content')
     


    {{-- FOOTER --}}
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white">HospiLit</h5>
                    <p>La plateforme qui révolutionne l'accès aux services hospitaliers pour les patients et les professionnels de santé.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="text-white">Liens</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Accueil</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Services</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">À propos</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h6 class="text-white">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Consultation des Disponibilites</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Gestion des Hospitalisation</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Suivi médical</a></li>
                        <li><a href="#" class="text-decoration-none" style="color: #aaa;">Urgences</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white">Contact</h6>
                    <ul class="list-unstyled">
                        <li style="color: #aaa;"><i class="fas fa-envelope me-2"></i> contact@hospilit.com</li>
                        <li style="color: #aaa;"><i class="fas fa-phone me-2"></i> 33 825 31 01</li>
                        <li style="color: #aaa;"><i class="fas fa-map-marker-alt me-2"></i> Dakar, Senegal</li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none me-2" style="color: #aaa;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-decoration-none me-2" style="color: #aaa;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-decoration-none me-2" style="color: #aaa;"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-decoration-none" style="color: #aaa;"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="background-color: #444;">
            <div class="text-center" style="color: #888;">
                <small>&copy; 2025 HospiLit. Tous droits réservés.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
