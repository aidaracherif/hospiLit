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
        <div class="display-4">0</div>
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

<script>
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
</script> 
@endsection
