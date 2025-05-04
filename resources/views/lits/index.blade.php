@extends('admin.page') 

@section('content')
 
 <!-- Filters -->
 <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="serviceFilter" class="form-label">Service</label>
              <select id="serviceFilter" class="form-select">
                <option value="all">Tous les services</option>
                <option value="cardiologie">Cardiologie</option>
                <option value="neurologie">Neurologie</option>
                <option value="pediatrie">Pédiatrie</option>
                <option value="oncologie">Oncologie</option>
                <option value="urgences">Urgences</option>
                <option value="reanimation">Réanimation</option>
              </select>
            </div>
            
            <div class="col-md-3 mb-3">
              <label for="statusFilter" class="form-label">Statut</label>
              <select id="statusFilter" class="form-select">
                <option value="all">Tous les statuts</option>
                <option value="available">Disponible</option>
                <option value="occupied">Occupé</option>
                <option value="maintenance">En maintenance</option>
                <option value="reserved">Réservé</option>
              </select>
            </div>
            
            <div class="col-md-3 mb-3">
              <label for="floorFilter" class="form-label">Étage</label>
              <select id="floorFilter" class="form-select">
                <option value="all">Tous les étages</option>
                <option value="1">1er étage</option>
                <option value="2">2ème étage</option>
                <option value="3">3ème étage</option>
                <option value="4">4ème étage</option>
              </select>
            </div>
            
            <div class="col-md-3 mb-3 d-flex align-items-end">
              <button id="applyFilters" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Appliquer les filtres
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bed Status Summary -->
      <div class="row mb-4">
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4 text-success">{{ $disponibles }}</div>
              <div class="text-muted">Lits disponibles</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4 text-danger">{{ $occupes }}</div>
              <div class="text-muted">Lits occupés</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4 text-warning">{{ $maintenance }}</div>
              <div class="text-muted">Lits en maintenance</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4 text-info">{{ $reserves }}</div>
              <div class="text-muted">Lits réservés</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bed Grid -->
      <!-- <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title">Cardiologie - 1er étage</h5>
          <div class="card-actions">
            <button class="btn btn-sm btn-primary">
              <i class="fas fa-plus"></i> Ajouter un lit
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="beds-grid">
            <div class="bed-item" data-bed-id="101" data-status="occupied">
              <div class="bed-number">101</div>
              <div><span class="bed-status bed-status-occupied"></span> Occupé</div>
              <div class="bed-info">Depuis: 3j</div>
            </div>
            
            <div class="bed-item" data-bed-id="102" data-status="occupied">
              <div class="bed-number">102</div>
              <div><span class="bed-status bed-status-occupied"></span> Occupé</div>
              <div class="bed-info">Depuis: 1j</div>
            </div>
            
            <div class="bed-item" data-bed-id="103" data-status="available">
              <div class="bed-number">103</div>
              <div><span class="bed-status bed-status-available"></span> Disponible</div>
              <div class="bed-info">Depuis: 5h</div>
            </div>
            
            <div class="bed-item" data-bed-id="104" data-status="maintenance">
              <div class="bed-number">104</div>
              <div><span class="bed-status bed-status-maintenance"></span> Maintenance</div>
              <div class="bed-info">Jusqu'à: 08/04</div>
            </div>
            
            <div class="bed-item" data-bed-id="105" data-status="available">
              <div class="bed-number">105</div>
              <div><span class="bed-status bed-status-available"></span> Disponible</div>
              <div class="bed-info">Depuis: 10min</div>
            </div>
            
            <div class="bed-item" data-bed-id="106" data-status="reserved">
              <div class="bed-number">106</div>
              <div><span class="bed-status bed-status-reserved"></span> Réservé</div>
              <div class="bed-info">Pour: 18h00</div>
            </div>
            
            <div class="bed-item" data-bed-id="107" data-status="occupied">
              <div class="bed-number">107</div>
              <div><span class="bed-status bed-status-occupied"></span> Occupé</div>
              <div class="bed-info">Depuis: 2j</div>
            </div>
            
            <div class="bed-item" data-bed-id="108" data-status="occupied">
              <div class="bed-number">108</div>
              <div><span class="bed-status bed-status-occupied"></span> Occupé</div>
              <div class="bed-info">Depuis: 4j</div>
            </div>
            
            <div class="bed-item" data-bed-id="109" data-status="occupied">
              <div class="bed-number">109</div>
              <div><span class="bed-status bed-status-occupied"></span> Occupé</div>
              <div class="bed-info">Depuis: 1j</div>
            </div>
            
            <div class="bed-item" data-bed-id="110" data-status="available">
              <div class="bed-number">110</div>
              <div><span class="bed-status bed-status-available"></span> Disponible</div>
              <div class="bed-info">Depuis: 2h</div>
            </div>
          </div>
        </div>
      </div> -->
      
<!-- Table et bouton Ajouter -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title">Liste des lits</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLitModal">
      <i class="fas fa-plus"></i> Ajouter un lit
    </button>
  </div>
  <div class="card-body">
    <div class="table-container">
      <div class="table-search">
        <input type="text" class="table-search-input" placeholder="Rechercher un lit..." data-table="litsTable">
        <button class="table-search-button">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <table class="table table-striped" id="litsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Numéro</th>
            <th>Service</th>
            <th>Étage</th>
            <th>Statut</th>
            <th>Date d'occupation</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lits as $lit)
            <tr>
              <td>{{ $lit->id }}</td>
              <td>{{ $lit->numero }}</td>
              <td>{{ $lit->service->nom }}</td>
              <td>{{ $lit->etage }}</td>
              <td>
                <span class="badge bg-{{ $lit->status == 'Occupé' ? 'danger' : ($lit->status == 'Disponible' ? 'success' : 'warning') }}">
                  {{ $lit->status }}
                </span>
              </td>
              <!-- <td>{{ $lit->patient ?? '-' }}</td> -->
              <td>{{ $lit->dateOccupation ? date('d/m/Y', strtotime($lit->dateOccupation)) : '-' }}</td>
              <td>
                <div class="table-actions">
                  <!-- Bouton Voir -->
                  <button class="btn btn-sm btn-info btn-view" data-bs-toggle="modal" data-bs-target="#viewLitModal"
                    data-id="{{ $lit->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <!-- Bouton Modifier -->
                  <button class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editLitModal"
                    data-id="{{ $lit->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <!-- Bouton Supprimer -->
                  <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $lit->id }}">
                    <i class="fas fa-trash"></i>
                  </button>

                  <!-- Formulaire de suppression caché -->
                  <form id="delete-form-{{ $lit->id }}" action="{{ route('lits.destroy', $lit) }}" method="POST" style="display: none;">
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

<div class="row mb-4">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Distribution des lits par service</h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="litDistributionChart"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Taux d'occupation des lits</h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="litOccupationChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ajouter un Lit -->
<div class="modal fade" id="addLitModal" tabindex="-1" aria-labelledby="addLitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLitModalLabel">Ajouter un Lit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('lits.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="numero_add" class="form-label">Numéro</label>
            <input type="text" class="form-control" id="numero_add" name="numero" required>
          </div>
          <div class="mb-3">
            <label for="serviceId_add" class="form-label">Service</label>
            <select class="form-select" id="serviceId_add" name="serviceId" required>
              <option value="">Sélectionner un service</option>
              @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->nom }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="etage_add" class="form-label">Étage</label>
            <input type="text" class="form-control" id="etage_add" name="etage" required>
          </div>
          <div class="mb-3">
            <label for="statut_add" class="form-label">Status</label>
            <select class="form-select" id="status_add" name="status" required>
              <option value="Disponible" selected>Disponible</option>
              <option value="Occupé">Occupé</option>
              <option value="En maintenance">En maintenance</option>
            </select>
          </div>
          <!-- <div class="mb-3">
            <label for="patient_add" class="form-label">Patient</label>
            <input type="text" class="form-control" id="patient_add" name="patient">
          </div> -->
          <div class="mb-3">
            <label for="date_occupation_add" class="form-label">Date d'occupation</label>
            <input type="date" class="form-control" id="date_occupation_add" name="dateOccupation">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Ajouter le lit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal voir un lit -->
<div class="modal fade" id="viewLitModal" tabindex="-1" aria-labelledby="viewLitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewLitModalLabel">Détails du lit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewLitContent">
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


<!-- Modal Modifier un lit -->
<div class="modal fade" id="editLitModal" tabindex="-1" aria-labelledby="editLitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLitModalLabel">Modifier le lit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Le formulaire d'édition sera chargé via AJAX -->
      <form id="editLitForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body" id="editLitContent">
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
$(document).ready(function() {
  // Initialisation des graphiques
  initializeCharts();

  // Gestion de la recherche dans les tableaux
  $('.table-search-input').on('keyup', function() {
    const searchTable = $(this).data('table');
    const searchText = $(this).val().toLowerCase();
    
    $(`#${searchTable} tbody tr`).filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
    });
  });

  // Gestion du modal de visualisation
  $('.btn-view').on('click', function() {
    const litId = $(this).data('id');
    loadLitDetails(litId);
  });

  // Gestion du modal d'édition
  $('.btn-edit').on('click', function() {
    const litId = $(this).data('id');
    loadLitForEditing(litId);
  });

  // Passage du modal de visualisation à édition
  $('.btn-edit-from-view').on('click', function() {
    const litId = $('#viewLitContent').data('id');
    $('#viewLitModal').modal('hide');
    setTimeout(() => {
      $('#editLitModal').modal('show');
      loadLitForEditing(litId);
    }, 500);
  });

  // Gestion de la suppression
  $('.btn-delete').on('click', function() {
    const litId = $(this).data('id');
    confirmDelete(litId);
  });

  // Gestion dynamique des champs conditionnels dans le formulaire d'ajout
  $('#status_add').on('change', function() {
    togglePatientFields('#status_add', '#date_occupation_add');
  });

  // Fonction exécutée lors du chargement initial pour les formulaires d'édition
  $('#editLitModal').on('shown.bs.modal', function() {
    const statut = $('#status_edit').val();
    togglePatientFields('#status_edit', '#date_occupation_edit');
  });
});


// Chargement des détails d'un lit pour la visualisation
function loadLitDetails(litId) {
  $('#viewLitContent').html('<div class="text-center">Chargement...</div>');
  
  $.ajax({
    url: `/lits/${litId}`,
    method: 'GET',
    success: function(response) {
      // Stockage de l'ID pour utilisation ultérieure
      $('#viewLitContent').data('id', litId);
      
      // Construction du contenu HTML
      let html = `
        <div class="lit-details">
          <div class="row mb-3">
            <div class="col-md-6">
              <p><strong>ID:</strong> ${response.id}</p>
              <p><strong>Numéro:</strong> ${response.numero}</p>
              <p><strong>Service:</strong> ${response.service.nom}</p>
              <p><strong>Étage:</strong> ${response.etage}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Statut:</strong> <span class="badge bg-${getStatusColor(response.status)}">${response.status}</span></p>
              <p><strong>Date d'occupation:</strong> ${response.date_occupation ? formatDate(response.date_occupation) : '-'}</p>
            </div>
          </div>
        </div>
      `;
      
      $('#viewLitContent').html(html);
    },
    error: function() {
      $('#viewLitContent').html(`
        <div class="alert alert-danger">
          Une erreur s'est produite lors du chargement des détails.
        </div>
      `);
    }
  });
}

// Chargement d'un lit pour l'édition
function loadLitForEditing(litId) {
  $('#editLitContent').html('<div class="text-center">Chargement...</div>');
  
  $.ajax({
    url: `/lits/${litId}/edit`,
    method: 'GET',
    success: function(response) {
      // Mise à jour de l'action du formulaire
      $('#editLitForm').attr('action', `/lits/${litId}`);
      
      // Construction du formulaire d'édition
      let html = `
        <input type="hidden" name="id" value="${response.id}">
        
        <div class="mb-3">
          <label for="numero_edit" class="form-label">Numéro</label>
          <input type="text" class="form-control" id="numero_edit" name="numero" value="${response.numero}" disabled>
        </div>
        
        <div class="mb-3">
          <label for="serviceId_edit" class="form-label">Service</label>
          <select class="form-select" id="serviceId_edit" name="serviceId" required>
            ${response.services.map(service => `
              <option value="${service.id}" ${service.id === response.serviceId ? 'selected' : ''}>
                ${service.nom}
              </option>
            `).join('')}
          </select>
        </div>
        
        <div class="mb-3">
          <label for="etage_edit" class="form-label">Étage</label>
          <input type="text" class="form-control" id="etage_edit" name="etage" value="${response.etage}" required>
        </div>
        
        <div class="mb-3">
          <label for="statut_edit" class="form-label">Statut</label>
          <select class="form-select" id="status_edit" name="status" required>
            <option value="Disponible" ${response.status === 'Disponible' ? 'selected' : ''}>Disponible</option>
            <option value="Occupé" ${response.status === 'Occupé' ? 'selected' : ''}>Occupé</option>
            <option value="En maintenance" ${response.status === 'En maintenance' ? 'selected' : ''}>En maintenance</option>
          </select>
        </div>
    
        
        <div class="mb-3">
          <label for="date_occupation_edit" class="form-label">Date d'occupation</label>
          <input type="date" class="form-control" id="date_occupation_edit" name="dateOccupation" value="${response.date_occupation || ''}">
        </div>
      `;
      
      $('#editLitContent').html(html);
      
      // Initialisation de l'affichage conditionnel des champs
      $('#statut_edit').on('change', function() {
        togglePatientFields('#statut_edit', '#date_occupation_edit');
      });
      
      // Déclenchement initial pour configurer l'affichage
      togglePatientFields('#statut_edit', '#date_occupation_edit');
    },
    error: function() {
      $('#editLitContent').html(`
        <div class="alert alert-danger">
          Une erreur s'est produite lors du chargement du formulaire d'édition.
        </div>
      `);
    }
  });
}

// Confirmation de suppression
function confirmDelete(litId) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce lit ? Cette action est irréversible.')) {
    $(`#delete-form-${litId}`).submit();
  }
}

// Initialisation des graphiques
function initializeCharts() {
  // Récupération des données pour les graphiques
  $.ajax({
    url: '/lits/charts-data',
    method: 'GET',
    success: function(data) {
      // Graphique de distribution des lits par service
      const distributionCtx = document.getElementById('litDistributionChart').getContext('2d');
      new Chart(distributionCtx, {
        type: 'pie',
        data: {
          labels: data.distribution.labels,
          datasets: [{
            data: data.distribution.data,
            backgroundColor: [
              '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
              '#6f42c1', '#5a5c69', '#858796', '#f8f9fc', '#d1d3e2'
            ],
            borderWidth: 1
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
      
      // Graphique de taux d'occupation
      const occupationCtx = document.getElementById('litOccupationChart').getContext('2d');
      new Chart(occupationCtx, {
        type: 'bar',
        data: {
          labels: data.occupation.labels,
          datasets: [{
            label: 'Lits occupés',
            data: data.occupation.occupied,
            backgroundColor: '#e74a3b',
            borderWidth: 1
          }, {
            label: 'Lits disponibles',
            data: data.occupation.available,
            backgroundColor: '#1cc88a',
            borderWidth: 1
          }, {
            label: 'Lits en maintenance',
            data: data.occupation.maintenance,
            backgroundColor: '#f6c23e',
            borderWidth: 1
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
          }
        }
      });
    }
  });
}

// Fonction utilitaire pour formatter les dates
function formatDate(dateString) {
  if (!dateString) return '-';
  
  const date = new Date(dateString);
  return date.toLocaleDateString('fr-FR');
}

// Fonction utilitaire pour déterminer la couleur du badge selon le statut
function getStatusColor(statut) {
  switch (statut) {
    case 'Disponible': return 'success';
    case 'Occupé': return 'danger';
    case 'En maintenance': return 'warning';
    default: return 'secondary';
  }
}
</script>

@endsection


