@extends ('layouts.app1')
@section('content')
<!-- Hero Section -->
<section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 mb-4">Bienvenue sur HospiLit</h1>
                    <p class="lead mb-4">La plateforme qui révolutionne l'accès aux services hospitaliers pour les professionnels de santé.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-lg px-4" style="background-color: var(--primary-color); color: white;">Découvrir</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg px-4">En savoir plus</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <img src="{{ asset('storage/images/nurse-preparing-their-shift.jpg') }}" alt="HospiLit Interface" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: var(--primary-color);">Nos Services</h2>
                <p class="lead text-muted">Découvrez comment HospiLit peut améliorer vos services d'hospitalsation</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Consultation des Disponibilités</h5>
                            <p class="card-text">Accédez rapodement et facilement aux informations de disponibilité des lits dans chaque service.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion des hospitalisations</h5>
                            <p class="card-text">Accédez à votre dossier médical et suivez vos traitements en temps réel.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Alerte de saturation</h5>
                            <p class="card-text">Réception d'alertes en cas de saturation des places, permettant une anticipation des situations critiques et une meilleure gestion des flux.
                            .</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="display-5 mb-4">Prêt à rejoindre HospiLit ?</h2>
            <p class="lead mb-4">Créez votre compte gratuitement et commencez à gérer vos soins de santé en toute simplicité.</p>
            <div class="d-flex justify-content-center gap-3">
                <!-- <a href="#" class="btn btn-light btn-lg px-4">S'inscrire maintenant</a> -->
                <a href="#" class="btn btn-outline-light btn-lg px-4">En savoir plus</a>
            </div>
        </div>
    </section>


@endsection