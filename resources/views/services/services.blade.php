@extends('admin.page') 

@section('content')
<div class="row mb-4">
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $activeServices }}</div>
        <div class="text-muted">Services actifs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $inactiveServices }}</div>
        <div class="text-muted">Services inactifs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $totalBeds }}</div>
        <div class="text-muted">Lits totaux</div>
      </div>
    </div>
  </div>  
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">{{ $totalUsers }}</div>
        <div class="text-muted">Utilisateurs</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-body text-center">
        <div class="display-4">0%</div>
        <div class="text-muted">Taux d'occupation moyen</div>
      </div>
    </div>
  </div>
</div>

<!-- Add Service Button -->
<div class="mb-4">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
    <i class="fas fa-plus"></i> Ajouter un service
  </button>
</div>

<!-- Services Table -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title">Liste des services</h5>
  </div>
  <div class="card-body">
    <div class="table-container">
      <div class="table-search">
        <input type="text" class="table-search-input" placeholder="Rechercher un service..." data-table="servicesTable">
        <button class="table-search-button">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <table class="table table-striped" id="servicesTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom du service</th>
            <th>Capacité (lits)</th>
            <th>Responsable</th>
            <th>Étage</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($services as $service)
            <tr>
              <td>{{ $service->id }}</td>
              <td>{{ $service->nom }}</td>
              <td>{{ $service->nombreLit }}</td>
              <td>{{ $service->responsable ?? '-' }}</td>
              <td>{{ $service->etage }}</td>
              <td>
                <span class="badge {{ $service->statut == 'Actif' ? 'bg-success' : 'bg-secondary' }}">{{ $service->statut }}</span>
              </td>
              <td>
                <div class="table-actions">
                  <!-- Bouton Voir -->
                  <button class="btn btn-sm btn-info btn-view" data-bs-toggle="modal" data-bs-target="#viewServiceModal"
                    data-id="{{ $service->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <!-- Bouton Modifier (utilisé pour charger le formulaire dans un modal) -->
                  <button class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editServiceModal"
                    data-id="{{ $service->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <!-- Bouton Supprimer -->
                  <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $service->id }}">
                    <i class="fas fa-trash"></i>
                  </button>

                  <!-- Formulaire de suppression caché -->
                  <form id="delete-form-{{ $service->id }}" action="{{ route('services.destroy', $service) }}" method="POST" style="display: none;">
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

<!-- Chart Containers -->
<div class="row mb-4">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Capacité par service</h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="serviceCapacityChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Taux d'occupation par service</h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="serviceOccupancyChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ajouter un Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceModalLabel">Ajouter un Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('services.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="nom_add" class="form-label">Nom du service</label>
            <input type="text" class="form-control" id="nom_add" name="nom" required>
          </div>
          <div class="mb-3">
            <label for="nombreLit_add" class="form-label">Capacité (lits)</label>
            <input type="number" class="form-control" id="nombreLit_add" name="nombreLit" required>
          </div>
          <div class="mb-3">
            <label for="responsable_add" class="form-label">Responsable</label>
            <input type="text" class="form-control" id="responsable_add" name="responsable">
          </div>
          <div class="mb-3">
            <label for="etage_add" class="form-label">Étage</label>
            <input type="text" class="form-control" id="etage_add" name="etage">
          </div>
          <div class="mb-3">
            <label for="description_add" class="form-label">Description</label>
            <textarea class="form-control" id="description_add" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="statut_add" class="form-label">Statut</label>
            <select class="form-select" id="statut_add" name="statut" required>
              <option value="Actif" selected>Actif</option>
              <option value="Inactif">Inactif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Ajouter le service</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Voir un Service -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewServiceModalLabel">Détails du service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewServiceContent">
        <!-- Le contenu sera chargé via AJAX -->
        <div class="text-center">Chargement...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <!-- Bouton pour passer en mode édition -->
        <button type="button" class="btn btn-primary btn-edit-from-view">Modifier</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modifier un Service -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceModalLabel">Modifier le service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Le formulaire d'édition sera chargé via AJAX -->
      <form id="editServiceForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body" id="editServiceContent">
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

<!-- <script>
  console.log('Script chargé correctement');

  $(document).ready(function() {
    console.log('==== DÉBUT DU DÉBOGAGE ====');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Modal de vue existe:', $('#viewServiceModal').length > 0);
    console.log('Modal d\'édition existe:', $('#editServiceModal').length > 0);
    console.log('Boutons de vue trouvés:', $('.btn-view').length);
    
    // Ajout du token CSRF à toutes les requêtes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // ===================================================
    // MODAL "AFFICHER LE SERVICE" - Lors du clic sur .btn-view
    // ===================================================
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        var serviceId = $(this).data('id');
        console.log('Affichage du service ID:', serviceId);

        // Afficher un indicateur de chargement
        $('#viewServiceContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <span class="ms-3">Chargement des données...</span>
            </div>
        `);
        
        // Appel AJAX pour charger les détails (URL construite avec window.location.origin)
        $.ajax({
            url: window.location.origin + '/services/' + serviceId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Données reçues avec succès:', data);
                
                var html = `
                  <div class="row">
                    <div class="col-md-6">
                      <h6>Informations générales</h6>
                      <table class="table table-bordered">
                        <tr>
                          <th>ID</th>
                          <td>${data.id}</td>
                        </tr>
                        <tr>
                          <th>Nom</th>
                          <td>${data.nom}</td>
                        </tr>
                        <tr>
                          <th>Responsable</th>
                          <td>${data.responsable || '-'}</td>
                        </tr>
                        <tr>
                          <th>Étage</th>
                          <td>${data.etage || '-'}</td>
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
                    <div class="col-md-6">
                      <h6>Capacité</h6>
                      <table class="table table-bordered">
                        <tr>
                          <th>Capacité totale</th>
                          <td>${data.nombreLit || 0} lits</td>
                        </tr>
                        <tr>
                          <th>Description</th>
                          <td>${data.description || '-'}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                `;
                $('#viewServiceContent').html(html);
                // Stocker l'ID dans le bouton pour pouvoir passer en mode édition depuis ce modal
                $('.btn-edit-from-view').data('id', serviceId);
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', status, error);
                console.log('Statut HTTP:', xhr.status);
                console.log('Réponse:', xhr.responseText);
                
                $('#viewServiceContent').html(`
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
        var serviceId = $(this).data('id');
        console.log('Passage de la vue à l\'édition pour ID:', serviceId);
        $('#viewServiceModal').modal('hide'); // Ferme le modal d'affichage
        
        // On attend que le modal soit fermé pour éviter les conflits
        setTimeout(function() {
            // Déclencher le clic sur le bouton d'édition correspondant
            $('.btn-edit[data-id="' + serviceId + '"]').trigger('click');
            $('#editServiceModal').modal('show');
        }, 500);
    });
    
    // ===================================================
    // MODAL "MODIFIER LE SERVICE" - Chargement du formulaire d'édition
    // ===================================================
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var serviceId = $(this).data('id');
        console.log('Édition du service ID:', serviceId);
        
        // Mettre à jour l'action du formulaire d'édition
        $('#editServiceForm').attr('action', window.location.origin + '/services/' + serviceId);
        
        // Indicateur de chargement
        $('#editServiceContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <span class="ms-3">Chargement du formulaire...</span>
            </div>
        `);
        
        // Appel AJAX pour charger le formulaire d'édition depuis la route dédiée (/services/{id}/edit)
        $.ajax({
            url: window.location.origin + '/services/' + serviceId + '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Données reçues pour l\'édition:', data);
                var formHtml = `
                  <div class="mb-3">
                    <label for="nom_edit" class="form-label">Nom du service</label>
                    <input type="text" class="form-control" id="nom_edit" name="nom" value="${data.nom || ''}" required>
                  </div>
                  <div class="mb-3">
                    <label for="nombreLit_edit" class="form-label">Capacité (lits)</label>
                    <input type="number" class="form-control" id="nombreLit_edit" name="nombreLit" value="${data.nombreLit || 0}" required>
                  </div>
                  <div class="mb-3">
                    <label for="responsable_edit" class="form-label">Responsable</label>
                    <input type="text" class="form-control" id="responsable_edit" name="responsable" value="${data.responsable || ''}">
                  </div>
                  <div class="mb-3">
                    <label for="etage_edit" class="form-label">Étage</label>
                    <input type="text" class="form-control" id="etage_edit" name="etage" value="${data.etage || ''}">
                  </div>
                  <div class="mb-3">
                    <label for="description_edit" class="form-label">Description</label>
                    <textarea class="form-control" id="description_edit" name="description">${data.description || ''}</textarea>
                  </div>
                  <div class="mb-3">
                    <label for="statut_edit" class="form-label">Statut</label>
                    <select class="form-select" id="statut_edit" name="statut" required>
                      <option value="Actif" ${data.statut === 'Actif' ? 'selected' : ''}>Actif</option>
                      <option value="Inactif" ${data.statut === 'Inactif' ? 'selected' : ''}>Inactif</option>
                    </select>
                  </div>
                `;
                $('#editServiceContent').html(formHtml);
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX pour le formulaire d\'édition:', status, error);
                console.log('Réponse:', xhr.responseText);
                $('#editServiceContent').html(`
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
    
    // Pour le submit du formulaire d'édition (optionnel, vous pouvez ajouter votre validation)
    $('#editServiceForm').on('submit', function(e) {
        console.log('Formulaire soumis');
    });
});
</script>  -->
<script>
console.log('Script d\'hospitalisation chargé correctement');

document.addEventListener('DOMContentLoaded', function() {
  console.log('==== DÉBUT DU DÉBOGAGE HOSPITALISATION ====');
  console.log('jQuery version:', $.fn.jquery);
  console.log('Modal de vue existe:', $('#viewHospitalizationModal').length > 0);
  console.log('Modal d\'édition existe:', $('#editHospitalizationModal').length > 0);
  console.log('Boutons de vue trouvés:', $('.btn-view-hosp').length);
  
  // Ajout du token CSRF à toutes les requêtes AJAX
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  // ===================================================
  // MODAL "AFFICHER L'HOSPITALISATION" - Lors du clic sur .btn-view-hosp
  // ===================================================
  $(document).on('click', '.btn-view-hosp', function(e) {
      e.preventDefault();
      var patientId = $(this).data('id');
      console.log('Affichage de l\'hospitalisation pour patient ID:', patientId);

      // Afficher un indicateur de chargement
      $('#viewHospitalizationContent').html(`
          <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Chargement...</span>
              </div>
              <span class="ms-3">Chargement des données...</span>
          </div>
      `);
      
      // Appel AJAX pour charger les détails (URL construite avec window.location.origin)
      $.ajax({
          url: window.location.origin + '/patients/' + patientId,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
              console.log('Données d\'hospitalisation reçues avec succès:', data);
              
              if (data.error) {
                  $('#viewHospitalizationContent').html(`
                      <div class="alert alert-danger">${data.error}</div>
                  `);
                  return;
              }

              let badge = {
                  'Admis': 'bg-success',
                  'En attente': 'bg-warning',
                  'Transfere': 'bg-info',
                  'Sorti': 'bg-secondary'
              }[data.hospitalization.status] || 'bg-light';

              const html = `
                  <div class="row">
                      <div class="col-md-6">
                          <h6>Infos patient</h6>
                          <table class="table table-bordered">
                              <tr><th>Nom</th><td>${data.patient.nom} ${data.patient.prenom}</td></tr>
                              <tr><th>Date de naissance</th><td>${data.patient.dateNaissance} (${data.patient.age} ans)</td></tr>
                              <tr><th>Genre</th><td>${data.patient.genre}</td></tr>
                              <tr><th>Groupe sanguin</th><td>${data.patient.groupeSanguin}</td></tr>
                              <tr><th>Téléphone</th><td>${data.patient.tel}</td></tr>
                              <tr><th>Email</th><td>${data.patient.email}</td></tr>
                              <tr><th>Adresse</th><td>${data.patient.adresse}</td></tr>
                          </table>
                      </div>
                      <div class="col-md-6">
                          <h6>Détails d'hospitalisation</h6>
                          <table class="table table-bordered">
                              <tr><th>Service</th><td>${data.hospitalization.service}</td></tr>
                              <tr><th>Lit</th><td>${data.hospitalization.lit}</td></tr>
                              <tr><th>Date d'admission</th><td>${data.hospitalization.dateAdmission}</td></tr>
                              <tr><th>Date de sortie prévue</th><td>${data.hospitalization.dateSortie || '-'}</td></tr>
                              <tr><th>Statut</th><td><span class="badge ${badge}">${data.hospitalization.status}</span></td></tr>
                              <tr><th>Notes médicales</th><td>${data.hospitalization.noteMedical || '<em>Aucune note</em>'}</td></tr>
                          </table>
                      </div>
                  </div>
              `;
              $('#viewHospitalizationContent').html(html);
              
              // Stocker l'ID dans le bouton pour pouvoir passer en mode édition depuis ce modal
              $('.btn-edit-from-view-hosp').data('id', patientId);
          },
          error: function(xhr, status, error) {
              console.error('Erreur AJAX pour hospitalisation:', status, error);
              console.log('Statut HTTP:', xhr.status);
              console.log('Réponse:', xhr.responseText);
              
              $('#viewHospitalizationContent').html(`
                  <div class="alert alert-danger">
                      <h5>Erreur lors du chargement des données d'hospitalisation</h5>
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
  // Passage de "vue" à "édition" depuis le modal d'affichage d'hospitalisation
  // ===================================================
  $(document).on('click', '.btn-edit-from-view-hosp', function() {
      var patientId = $(this).data('id');
      console.log('Passage de la vue à l\'édition d\'hospitalisation pour patient ID:', patientId);
      $('#viewHospitalizationModal').modal('hide'); // Ferme le modal d'affichage
      
      // On attend que le modal soit fermé pour éviter les conflits
      setTimeout(function() {
          // Déclencher le clic sur le bouton d'édition correspondant
          $('.btn-edit-hosp[data-id="' + patientId + '"]').trigger('click');
          $('#editHospitalizationModal').modal('show');
      }, 500);
  });
  
  // ===================================================
  // MODAL "MODIFIER L'HOSPITALISATION" - Chargement du formulaire d'édition
  // ===================================================
  $(document).on('click', '.btn-edit-hosp', function(e) {
      e.preventDefault();
      var patientId = $(this).data('id');
      console.log('Édition de l\'hospitalisation pour patient ID:', patientId);
      
      // Mettre à jour l'action du formulaire d'édition
      $('#editHospitalizationForm').attr('action', window.location.origin + '/patients/' + patientId);
      
      // Indicateur de chargement
      $('#editHospitalizationContent').html(`
          <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Chargement...</span>
              </div>
              <span class="ms-3">Chargement du formulaire d'hospitalisation...</span>
          </div>
      `);
      
      // Appel AJAX pour charger le formulaire d'édition
      $.ajax({
          url: window.location.origin + '/patients/' + patientId + '/edit',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
              console.log('Données reçues pour l\'édition d\'hospitalisation:', data);
              
              const form = `
                  <h6 class="mb-3">Informations du patient</h6>
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label for="nom">Nom</label>
                          <input type="text" class="form-control" id="nom" name="nom" value="${data.patient.nom}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="prenom">Prénom</label>
                          <input type="text" class="form-control" id="prenom" name="prenom" value="${data.patient.prenom}" required>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4 mb-3">
                          <label for="dateNaissance">Date de naissance</label>
                          <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="${data.patient.dateNaissance}" required>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="genre">Genre</label>
                          <select class="form-select" id="genre" name="genre" required>
                              <option value="M" ${data.patient.genre === 'M' ? 'selected' : ''}>Masculin</option>
                              <option value="F" ${data.patient.genre === 'F' ? 'selected' : ''}>Féminin</option>
                          </select>
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="groupeSanguin">Groupe sanguin</label>
                          <select class="form-select" id="groupeSanguin" name="groupeSanguin" required>
                              ${['A+','A-','B+','B-','AB+','AB-','O+','O-'].map(grp => `
                                  <option value="${grp}" ${data.patient.groupeSanguin === grp ? 'selected' : ''}>${grp}</option>
                              `).join('')}
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label for="tel">Téléphone</label>
                          <input type="tel" class="form-control" id="tel" name="tel" value="${data.patient.tel}">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" value="${data.patient.email}">
                      </div>
                  </div>
                  <div class="mb-3">
                      <label for="adresse">Adresse</label>
                      <textarea class="form-control" id="adresse" name="adresse" rows="2">${data.patient.adresse}</textarea>
                  </div>
                  <div class="mb-3">
                      <label for="noteMedical">Notes médicales</label>
                      <textarea class="form-control" id="noteMedical" name="noteMedical" rows="3">${data.patient.noteMedical || ''}</textarea>
                  </div>

                  <hr>
                  <h6 class="mb-3">Détails d'hospitalisation</h6>

                  ${data.hosp ? `
                      <input type="hidden" name="hospitalization_id" value="${data.hosp.id}">
                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label for="service_id">Service</label>
                              <select class="form-select" id="service_id" name="service_id" required>
                                  ${Object.entries(data.services).map(([id, nom]) => `
                                      <option value="${id}" ${id == data.hosp.serviceId ? 'selected' : ''}>${nom}</option>
                                  `).join('')}
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label for="lit_id">Lit</label>
                              <select class="form-select" id="lit_id" name="lit_id" required>
                                  ${data.beds.map(b => `
                                      <option value="${b.id}" ${b.id == data.hosp.litId ? 'selected' : ''}>Lit ${b.numero}</option>
                                  `).join('')}
                              </select>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 mb-3">
                              <label for="admission_date">Date d'admission</label>
                              <input type="date" class="form-control" id="admission_date" name="admission_date" value="${data.hosp.dateAdmission}" required>
                          </div>
                          <div class="col-md-4 mb-3">
                              <label for="date_sortie">Date de sortie prévue</label>
                              <input type="date" class="form-control" id="date_sortie" name="date_sortie" value="${data.hosp.dateSortie || ''}">
                          </div>
                          <div class="col-md-4 mb-3">
                              <label for="status">Statut</label>
                              <select class="form-select" id="status" name="status" required>
                                  ${['Admis', 'En attente', 'Transfere', 'Sorti'].map(s => `
                                      <option value="${s}" ${s == data.hosp.status ? 'selected' : ''}>${s}</option>
                                  `).join('')}
                              </select>
                          </div>
                      </div>
                  ` : `
                      <div class="alert alert-info">Ce patient n'a pas d'hospitalisation active.
                          <button type="button" class="btn btn-sm btn-primary mt-2" id="btn-create-hosp" data-id="${data.patient.id}">Créer une hospitalisation</button>
                      </div>
                  `}
              `;
              $('#editHospitalizationContent').html(form);
          },
          error: function(xhr, status, error) {
              console.error('Erreur AJAX pour le formulaire d\'édition d\'hospitalisation:', status, error);
              console.log('Réponse:', xhr.responseText);
              $('#editHospitalizationContent').html(`
                  <div class="alert alert-danger">
                      <h5>Erreur lors du chargement du formulaire d'hospitalisation</h5>
                      <p><strong>Statut:</strong> ${xhr.status}</p>
                      <p><strong>Message:</strong> ${error}</p>
                      <hr>
                      <p class="mb-0">Vérifiez la console pour plus de détails.</p>
                  </div>
              `);
          }
      });
  });
  
  // Pour le submit du formulaire d'édition (optionnel, vous pouvez ajouter votre validation)
  $('#editHospitalizationForm').on('submit', function(e) {
      console.log('Formulaire d\'hospitalisation soumis');
  });

  // ===================================================
  // Chargement dynamique des lits par service
  // ===================================================
  $(document).on('change', '#service_id', function() {
      var serviceId = $(this).val();
      console.log('Service sélectionné:', serviceId);
      
      if (serviceId) {
          $.ajax({
              url: '/get-beds-by-service/' + serviceId,
              type: 'GET',
              success: function(data) {
                  $('#lit_id').empty();
                  if(data.length > 0){
                      $('#lit_id').append('<option disabled selected>Sélectionner</option>');
                      $.each(data, function(key, bed) {
                          $('#lit_id').append('<option value="' + bed.id + '">Lit ' + bed.numero + ' – ' + bed.status + '</option>');
                      });
                  } else {
                      $('#lit_id').append('<option disabled selected>Aucun lit disponible</option>');
                  }
              },
              error: function(xhr, status, error) {
                  console.error('Erreur lors du chargement des lits:', status, error);
                  $('#lit_id').empty().append('<option disabled selected>Erreur de chargement</option>');
              }
          });
      } else {
          $('#lit_id').empty().append('<option disabled selected>Sélectionner un service d\'abord</option>');
      }
  });

  // ===================================================
  // Gestion du bouton "Créer une hospitalisation"
  // ===================================================
  $(document).on('click', '#btn-create-hosp', function() {
      const patientId = $(this).data('id');
      console.log('Création d\'une hospitalisation pour patient ID:', patientId);
      
      // Ici vous pouvez soit:
      // 1. Rediriger vers une page de création
      // 2. Afficher un formulaire dynamique dans le modal actuel
      
      // Option 2: Afficher un formulaire dynamique
      $.ajax({
          url: window.location.origin + '/services/list',
          type: 'GET',
          dataType: 'json',
          success: function(services) {
              const formHTML = `
                  <h6 class="mb-3">Nouvelle hospitalisation</h6>
                  <input type="hidden" name="patient_id" value="${patientId}">
                  <div class="row">
                      <div class="col-md-12 mb-3">
                          <label for="service_id">Service</label>
                          <select class="form-select" id="service_id" name="service_id" required>
                              <option disabled selected>Sélectionner un service</option>
                              ${services.map(service => `
                                  <option value="${service.id}">${service.nom}</option>
                              `).join('')}
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12 mb-3">
                          <label for="lit_id">Lit</label>
                          <select class="form-select" id="lit_id" name="lit_id" required disabled>
                              <option disabled selected>Sélectionner un service d'abord</option>
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label for="admission_date">Date d'admission</label>
                          <input type="date" class="form-control" id="admission_date" name="admission_date" value="${new Date().toISOString().split('T')[0]}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="date_sortie">Date de sortie prévue</label>
                          <input type="date" class="form-control" id="date_sortie" name="date_sortie">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12 mb-3">
                          <label for="status">Statut</label>
                          <select class="form-select" id="status" name="status" required>
                              <option value="Admis">Admis</option>
                              <option value="En attente" selected>En attente</option>
                          </select>
                      </div>
                  </div>
              `;
              
              // Remplacer le message d'alerte par le formulaire
              $('.alert.alert-info').html(formHTML);
          },
          error: function(xhr, status, error) {
              console.error('Erreur lors du chargement des services:', status, error);
              $('.alert.alert-info').html(`
                  <div class="alert alert-danger">
                      Erreur de chargement des services. Veuillez réessayer.
                  </div>
              `);
          }
      });
  });
});
</script>
@endsection
