<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HospiLit - Dashboard">
    <title>@yield('title', 'HospiLit - Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('storage/admin/css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/css/cards.css') }}">


    
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
<nav class="navbar">
    <div class="navbar-brand">
      <i class="fas fa-hospital"></i> HospiLit
    </div>
    
    <div class="navbar-menu">
      <div class="navbar-item">
        <a href="#" class="navbar-link">
          <i class="fas fa-bell"></i>
          <span class="badge bg-danger">3</span>
        </a>
      </div>

      <div class="navbar-item dropdown">
        <a href="#" class="navbar-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="navbar-user">
            <img src="{{ asset('storage/admin/assets/avatar.png') }}" alt="Avatar" class="navbar-user-avatar">
            <span class="navbar-user-name">Dr. Abdou</span>
          </div>
        </a>

        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
      </div>
    </div>

    <div class="navbar-burger">
      <span></span>
      <span></span>
      <span></span>
    </div>
</nav>

<aside class="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-title">Menu principal</div>
  </div>

  <div class="sidebar-menu">
    <a href="" class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
      <div class="sidebar-icon"><i class="fas fa-tachometer-alt"></i></div>
      <span>Tableau de bord</span>
    </a>

    <a href="{{ route('lits.index') }}" class="sidebar-item {{ request()->routeIs('lits.index') ? 'active' : '' }}">
      <div class="sidebar-icon"><i class="fas fa-bed"></i></div>
      <span>Gestion des lits</span>
    </a>

    <a href="{{ route('patients.index') }}" class="sidebar-item {{ request()->routeIs('patients.index') ? 'active' : '' }}">
      <div class="sidebar-icon"><i class="fas fa-user-injured"></i></div>
      <span>Patients</span>
    </a>

    <a href="{{ route('services.index') }}" class="sidebar-item {{ request()->routeIs('services.index') ? 'active' : '' }}">
      <div class="sidebar-icon"><i class="fas fa-hospital"></i></div>
      <span>Services</span>
    </a>

    <div class="sidebar-divider"></div>

    <a href="" class="sidebar-item">
      <div class="sidebar-icon"><i class="fas fa-chart-bar"></i></div>
      <span>Rapports</span>
    </a>

    <a href="" class="sidebar-item">
      <div class="sidebar-icon"><i class="fas fa-cog"></i></div>
      <span>Paramètres</span>
    </a>
  </div>

  <div class="sidebar-footer">
    HospiLit v1.0 &copy; 2025
  </div>
</aside>

<main class="main-content">
  <div class="container-fluid">
    @yield('content')
  </div>
</main>

<!-- Bootstrap JS -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  @if (session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Succès',
      text: '{{ session('success') }}',
      timer: 3000,
      showConfirmButton: false
    });
  @endif

  @if (session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Erreur',
      text: '{{ session('error')}}',
      timer: 4000,
      showConfirmButton: false
    });
  @endif

  @if ($errors->any())
    Swal.fire({
      icon: 'error',
      title: 'Erreur de validation',
      html: '{!! implode("<br>", $errors->all()) !!}',
      confirmButtonText: 'Ok'
    });
  @endif

  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-delete')) {
      e.preventDefault();
      let serviceId = e.target.closest('.btn-delete').dataset.id;

      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + serviceId).submit();
        }
      });
    }
  });
</script>

<!-- Custom JS -->
<script src="{{ asset('storage/admin/js/main.js') }}"></script>
<script src="{{ asset('storage/admin/js/charts.js') }}"></script>

</body>
</html>
