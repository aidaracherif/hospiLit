@extends('admin.page')

@section('content')
<!-- <div class="row mb-4">
  <div class="col-md-3 mb-3">
    <div class="card text-center" style="background: linear-gradient(45deg, #f8bbd0, #f48fb1); color: white;">
      <div class="card-body">
        <div class="display-4">{{ $activeUsers }}</div>
        <div class="text-muted">Utilisateurs actifs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card text-center" style="background: linear-gradient(45deg, #f8bbd0, #e57373); color: white;">
      <div class="card-body">
        <div class="display-4">{{ $inactiveUsers }}</div>
        <div class="text-muted">Utilisateurs inactifs</div>
      </div>
    </div>
  </div>
</div> -->
<div class="row mb-4">
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $activeUsers }}</div>
        <div class="text-muted">Utilisateurs actifs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $inactiveUsers }}</div>
        <div class="text-muted">Utilisateurs inactifs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $totalUsers }}</div>
        <div class="text-muted">Utilisateurs totaux</div>
      </div>
    </div>
  </div>  

</div>
<!-- Add User Button -->
<div class="mb-4">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
    <i class="fas fa-plus"></i> Ajouter un utilisateur
  </button>
</div>

<!-- Users Table -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title">Liste des utilisateurs</h5>
  </div>
  <div class="card-body">
    <div class="table-container">
      <div class="table-search">
        <input type="text" class="table-search-input" placeholder="Rechercher un utilisateur..." data-table="usersTable">
        <button class="table-search-button">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <table class="table table-striped" id="usersTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Matricule</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->Nom }}</td>
              <td>{{ $user->Prenom }}</td>
              <td>{{ $user->Matricule }}</td>
              <td>{{ $user->Email }}</td>
              <td>{{ $user->Role }}</td>
              
                <td>
                    <span class="badge bg-secondary">
                        {{ $user->statut ?? 'N/A' }}
                    </span>
                </td>

              <td>
                <div class="table-actions">
                  <!-- Voir -->
                  <button class="btn btn-sm btn-info btn-view" data-bs-toggle="modal" data-bs-target="#viewUserModal"
                    data-id="{{ $user->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <!-- Modifier -->
                  <button class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editUserModal"
                    data-id="{{ $user->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <!-- Supprimer -->
                  <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}">
                    <i class="fas fa-trash"></i>
                  </button>
                  <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Ajouter un utilisateur -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <!-- <div class="modal-content"> -->
        <div class="form-container modal-content">
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
                        <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                    </div>
                </form>
            </div>
        
            <hr>
        </div>
    </div>

<!-- Modal Voir utilisateur -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalLabel">Détails de l'utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body" id="viewUserContent">
        <div class="text-center">Chargement...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary btn-edit-from-view">Modifier</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modifier utilisateur -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <form id="editUserForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body" id="editUserContent">
          <div class="text-center">Chargement...</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  console.log('Script de gestion des utilisateurs chargé correctement');

  $(document).ready(function() {
    console.log('==== DÉBUT DU DÉBOGAGE UTILISATEURS ====');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Modal de vue existe:', $('#viewUserModal').length > 0);
    console.log('Modal d\'édition existe:', $('#editUserModal').length > 0);
    console.log('Boutons de vue trouvés:', $('.btn-view').length);
    
    // Ajout du token CSRF à toutes les requêtes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // ===================================================
    // MODAL "AFFICHER L'UTILISATEUR" - Lors du clic sur .btn-view
    // ===================================================
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        console.log('Affichage de l\'utilisateur ID:', userId);

        // Afficher un indicateur de chargement
        $('#viewUserContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <span class="ms-3">Chargement des données...</span>
            </div>
        `);
        
        // Appel AJAX pour charger les détails (URL construite avec window.location.origin)
        $.ajax({
            url: window.location.origin + '/users/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Données utilisateur reçues avec succès:', data);
                
                var html = `
                  <div class="row">
                    <div class="col-md-6">
                      <h6>Informations personnelles</h6>
                      <table class="table table-bordered">
                        <tr>
                          <th>ID</th>
                          <td>${data.id}</td>
                        </tr>
                        <tr>
                          <th>Nom</th>
                          <td>${data.Nom || '-'}</td>
                        </tr>
                        <tr>
                          <th>Prénom</th>
                          <td>${data.Prenom || '-'}</td>
                        </tr>
                        <tr>
                          <th>Matricule</th>
                          <td>${data.Matricule || '-'}</td>
                        </tr>
                        <tr>
                          <th>Téléphone</th>
                          <td>${data.Tel || '-'}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <h6>Informations professionnelles</h6>
                      <table class="table table-bordered">
                        <tr>
                          <th>Email</th>
                          <td>${data.Email || '-'}</td>
                        </tr>
                        <tr>
                          <th>Adresse</th>
                          <td>${data.Adresse || '-'}</td>
                        </tr>
                        <tr>
                          <th>Rôle</th>
                          <td>${data.Role || '-'}</td>
                        </tr>
                        <tr>
                          <th>Service</th>
                          <td>${data.service ? data.service.nom : '-'}</td>
                        </tr>
                        <tr>
                          <th>Statut</th>
                          <td>
                            <span class="badge ${data.statut === 'Actif' ? 'bg-success' : 'bg-secondary'}">
                              ${data.statut || '-'}
                            </span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                `;
                $('#viewUserContent').html(html);
                // Stocker l'ID dans le bouton pour pouvoir passer en mode édition depuis ce modal
                $('.btn-edit-from-view').data('id', userId);
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', status, error);
                console.log('Statut HTTP:', xhr.status);
                console.log('Réponse:', xhr.responseText);
                
                $('#viewUserContent').html(`
                    <div class="alert alert-danger">
                        <h5>Erreur lors du chargement des données</h5>
                        <p><strong>Statut:</strong> ${xhr.status}</p>
                        <p><strong>Message:</strong> ${error}</p>
                        <p><strong>Réponse:</strong> ${xhr.responseText.substring(0, 200)}${xhr.responseText.length > 200 ? '...' : ''}</p>
                        <hr>
                        <p class="mb-0">Vérifiez la console pour plus de détails.</p>
                    </div>
                `);
            }
        });
    });
    
    // ===================================================
    // Passage de "vue" à "édition" depuis le modal d'affichage
    // ===================================================
    $(document).on('click', '.btn-edit-from-view', function() {
        var userId = $(this).data('id');
        console.log('Passage de la vue à l\'édition pour l\'utilisateur ID:', userId);
        $('#viewUserModal').modal('hide'); // Ferme le modal d'affichage
        
        // On attend que le modal soit fermé pour éviter les conflits
        setTimeout(function() {
            // Déclencher le clic sur le bouton d'édition correspondant
            $('.btn-edit[data-id="' + userId + '"]').trigger('click');
            $('#editUserModal').modal('show');
        }, 500);
    });
    
    // ===================================================
    // MODAL "MODIFIER L'UTILISATEUR" - Chargement du formulaire d'édition
    // ===================================================
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        console.log('Édition de l\'utilisateur ID:', userId);
        
        // Mettre à jour l'action du formulaire d'édition
        $('#editUserForm').attr('action', window.location.origin + '/users/' + userId);
        
        // Indicateur de chargement
        $('#editUserContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <span class="ms-3">Chargement du formulaire...</span>
            </div>
        `);
        
        // Appel AJAX pour charger le formulaire d'édition depuis la route dédiée (/users/{id}/edit)
        $.ajax({
            url: window.location.origin + '/users/' + userId + '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Données reçues pour l\'édition:', data);
                
                // Construction du select pour les services
                let serviceOptions = '';
                if (data.services && data.services.length > 0) {
                    data.services.forEach(service => {
                        const selected = data.ServiceId == service.id ? 'selected' : '';
                        serviceOptions += `<option value="${service.id}" ${selected}>${service.nom}</option>`;
                    });
                }
                
                var formHtml = `
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nom_edit" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom_edit" name="Nom" value="${data.Nom || ''}" required>
                      </div>
                      <div class="mb-3">
                        <label for="prenom_edit" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom_edit" name="Prenom" value="${data.Prenom || ''}" required>
                      </div>
                      <div class="mb-3">
                        <label for="matricule_edit" class="form-label">Matricule</label>
                        <input type="text" class="form-control" id="matricule_edit" name="Matricule" value="${data.Matricule || ''}" required>
                      </div>
                      <div class="mb-3">
                        <label for="tel_edit" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="tel_edit" name="Tel" value="${data.Tel || ''}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="email_edit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="Email" value="${data.Email || ''}" required>
                      </div>
                      <div class="mb-3">
                        <label for="adresse_edit" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse_edit" name="Adresse" value="${data.Adresse || ''}">
                      </div>
                      <div class="mb-3">
                        <label for="role_edit" class="form-label">Rôle</label>
                        <select class="form-select" id="role_edit" name="Role" required>
                          <option value="">Sélectionner un rôle</option>
                          <option value="admin" ${data.Role === 'admin' ? 'selected' : ''}>Administrateur</option>
                          <option value="medecin" ${data.Role === 'medecin' ? 'selected' : ''}>Médecin</option>
                          <option value="infirmier" ${data.Role === 'infirmier' ? 'selected' : ''}>Infirmier</option>
                          <option value="reception" ${data.Role === 'reception' ? 'selected' : ''}>Réception</option>
                        </select>
                      </div>
                      <div class="mb-3" id="service-container-edit" ${data.Role === 'infirmier' ? '' : 'style="display:none"'}>
                        <label for="service_edit" class="form-label">Service</label>
                        <select class="form-select" id="service_edit" name="ServiceId" ${data.Role === 'infirmier' ? 'required' : ''}>
                          <option value="">Sélectionner un service</option>
                          ${serviceOptions}
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="statut_edit" class="form-label">Statut</label>
                        <select class="form-select" id="statut_edit" name="statut" required>
                          <option value="Actif" ${data.statut === 'Actif' ? 'selected' : ''}>Actif</option>
                          <option value="Inactif" ${data.statut === 'Inactif' ? 'selected' : ''}>Inactif</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="change_password" name="change_password">
                      <label class="form-check-label" for="change_password">
                        Changer le mot de passe
                      </label>
                    </div>
                  </div>
                  <div class="mb-3 password-field" style="display:none;">
                    <label for="password_edit" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="password_edit" name="password">
                  </div>
                  <div class="mb-3 password-field" style="display:none;">
                    <label for="password_confirmation_edit" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation_edit" name="password_confirmation">
                  </div>
                `;
                $('#editUserContent').html(formHtml);
                
                // Gestion de l'affichage des champs mot de passe
                $('#change_password').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('.password-field').show();
                        $('#password_edit, #password_confirmation_edit').attr('required', 'required');
                    } else {
                        $('.password-field').hide();
                        $('#password_edit, #password_confirmation_edit').removeAttr('required');
                    }
                });
                
                // Gestion de l'affichage du champ service en fonction du rôle
                $('#role_edit').on('change', function() {
                    if ($(this).val() === 'infirmier') {
                        $('#service-container-edit').show();
                        $('#service_edit').attr('required', 'required');
                    } else {
                        $('#service-container-edit').hide();
                        $('#service_edit').removeAttr('required');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX pour le formulaire d\'édition:', status, error);
                console.log('Réponse:', xhr.responseText);
                $('#editUserContent').html(`
                    <div class="alert alert-danger">
                        <h5>Erreur lors du chargement du formulaire</h5>
                        <p><strong>Statut:</strong> ${xhr.status}</p>
                        <p><strong>Message:</strong> ${error}</p>
                        <hr>
                        <p class="mb-0">Vérifiez la console pour plus de détails.</p>
                    </div>
                `);
            }
        });
    });
    
    // ===================================================
    // SUPPRESSION UTILISATEUR
    // ===================================================
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var userId = $(this).data('id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
            $('#delete-form-' + userId).submit();
        }
    });
    
    // Pour le submit du formulaire d'édition (optionnel, vous pouvez ajouter votre validation)
    $('#editUserForm').on('submit', function(e) {
        console.log('Formulaire de modification d\'utilisateur soumis');
    });
});
</script>
@endsection
