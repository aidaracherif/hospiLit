
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HospiLit - Inscription</title>
  
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
    
    .register-container {
      max-width: 500px;
      width: 100%;
      margin: 2rem auto;
    }
    
    .register-logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .register-logo img {
      max-width: 150px;
    }
    
    .register-title {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-logo">
      <img src="../assets/logo.png" alt="HospiLit Logo" onerror="this.src='../assets/logo-placeholder.png'; this.onerror=null;">
      <h1 class="register-title">HospiLit</h1>
    </div>
    
    <div class="form-container">
      <h2 class="form-title">Créer un compte</h2>
      
      <form id="registerForm" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-input" placeholder="Entrez votre nom" required>
            </div>

            <div class="form-group">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-input" placeholder="Entrez votre prénom" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" id="matricule" name="matricule" class="form-input" placeholder="Entrez votre matricule" required>
            </div>

            <div class="form-group">
                <label for="tel" class="form-label">Téléphone</label>
                <input type="text" id="tel" name="tel" class="form-input" placeholder="Entrez votre téléphone" required>
            </div>

            <div class="form-group">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-input" placeholder="Entrez votre adresse" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="" selected disabled>Sélectionnez votre rôle</option>
                    <option value="infirmier">Infirmier Major</option>
                    <option value="urgences">Service des Urgences</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>

            <div class="form-group" id="service-container" style="display: none;">
                <label for="serviceId" class="form-label">Service</label>
                <select id="serviceId" name="serviceId" class="form-select">
                    <option value="" selected disabled>Sélectionnez votre service</option>
                    <option value="1">Cardiologie</option>
                    <option value="2">Neurologie</option>
                    <option value="3">Pédiatrie</option>
                    <option value="4">Oncologie</option>
                    <option value="5">Urgences</option>
                    <option value="6">Réanimation</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Entrez votre mot de passe" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Confirmez votre mot de passe" required>
            </div>

            <div class="form-checkbox mb-3">
                <input type="checkbox" id="termsAgreement" required>
                <label for="termsAgreement">J'accepte les <a href="#" class="form-link">termes et conditions</a></label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
            </div>
        </form>

      
      <hr>
      
      <div class="text-center">
        <p>Vous avez déjà un compte ?</p>
        <a href="login.html" class="btn btn-secondary">Se connecter</a>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JS -->
  <script src="../js/main.js"></script>
  <script>
    document.getElementById('role').addEventListener('change', function() {
        var serviceContainer = document.getElementById('service-container');
        if (this.value === 'infirmier') {
            serviceContainer.style.display = 'block';
            document.getElementById('serviceId').setAttribute('required', 'required');
        } else {
            serviceContainer.style.display = 'none';
            document.getElementById('serviceId').removeAttribute('required');
        }
    });
</script>

</body>
</html>
