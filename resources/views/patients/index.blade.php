@extends('admin.page') 

@section('content')
@php use \Carbon\Carbon; @endphp

<div class="container-fluid">
      
      <!-- Patient Stats -->
      <div class="row mb-4">
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4">125</div>
              <div class="text-muted">Patients hospitalisés</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4">18</div>
              <div class="text-muted">Admissions aujourd'hui</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4">12</div>
              <div class="text-muted">Sorties aujourd'hui</div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="display-4">4.2j</div>
              <div class="text-muted">Durée moyenne de séjour</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Add Patient Button -->
      <!-- <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
          <i class="fas fa-plus"></i> Ajouter un patient
        </button>
      </div> -->

      <div class="mb-4">
        <button 
          type="button"
          class="btn btn-primary btn-add-patient"
          data-bs-toggle="modal" 
          data-bs-target="#addHospitalizationModal"
        >
          <i class="fas fa-plus"></i> Ajouter un patient
        </button>
      </div>

      
      <!-- Patients Table -->
      
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title">Liste des patients hospitalisés</h5>
  </div>
  <div class="card-body">
    <table class="table table-striped table-paginated" id="patientsTable" data-rows-per-page="10">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Âge</th>
          <th>Service</th>
          <th>Lit</th>
          <th>Date d'admission</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($hospitalizations as $hosp)
        <tr>
          <td>P-{{ $hosp->patient->id }}</td>
          <td>{{ $hosp->patient->nom }} {{ $hosp->patient->prenom }}</td>
          <td>{{ $hosp->patient->dateNaissance ? \Carbon\Carbon::parse($hosp->patient->dateNaissance)->age . ' ans' : 'N/A' }}
          </td>
          <td>{{ $hosp->service->nom}}</td>
          <td>{{ $hosp->lit->numero }}</td>

          <td>{{ Carbon::parse($hosp->dateAdmission)->format('d/m/Y') }}</td>
          <td>
            @php
              $classes = [
                'Admis' => 'bg-success',
                'En attente' => 'bg-warning',
                'Transfere' => 'bg-info',
                'Sorti' => 'bg-secondary'
              ];
            @endphp
            <span class="badge {{ $classes[$hosp->status] ?? 'bg-light' }}">
              {{ ucfirst($hosp->status) }}
            </span>
          </td>
          <td>
            <div class="table-actions">
              <button class="btn btn-sm btn-info btn-view-hosp" data-id="{{ $hosp->patient->id }}" data-bs-toggle="modal" data-bs-target="#viewHospitalizationModal"><i class="fas fa-eye"></i></button>
              <button class="btn btn-sm btn-primary btn-edit-hosp" data-id="{{ $hosp->patient->id }}" data-bs-toggle="modal" data-bs-target="#editHospitalizationModal"><i class="fas fa-edit"></i></button>
              <form action="{{ route('patients.destroy', $hosp->patient->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>

        </tr>
        @empty
        <tr><td colspan="8" class="text-center">Aucun patient hospitalisé.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


      <!-- Patient Distribution Chart -->
      <div class="row mb-4">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Distribution par service</h5>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="patientDistributionChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Distribution par âge</h5>
            </div>
            <div class="card-body">
              <div class="chart-container">
                <canvas id="patientAgeChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
  {{-- Ajouter une hospitalisation --}}
<div class="modal fade" id="addHospitalizationModal" tabindex="-1" aria-labelledby="addHospitalizationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle hospitalisation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addHospitalizationForm" action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <h6>Informations du patient</h6>
          <div class="row">
            <div class="col-md-6 mb-3"><label>Nom</label><input type="text" name="nom" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label>Prénom</label><input type="text" name="prenom" class="form-control" required></div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3"><label>Date de naissance</label><input type="date" name="dateNaissance" class="form-control" required></div>
            <div class="col-md-4 mb-3">
              <label>Genre</label>
              <select name="genre" class="form-select" required>
                <option disabled selected>Choisir</option>
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
                <option value="O">Autre</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label>Groupe sanguin</label>
              <select name="groupeSanguin" class="form-select" required>
                <option disabled selected>Choisir</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $grp)
                  <option value="{{ $grp }}">{{ $grp }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3"><label>Téléphone</label><input type="tel" name="tel" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="email" class="form-control"></div>
          </div>
          <div class="mb-3"><label>Adresse</label><textarea name="adresse" class="form-control" rows="2"></textarea></div>
          <div class="mb-3"><label>Notes médicales</label><textarea name="noteMedical" class="form-control" rows="3"></textarea></div>

          <hr><h6>Détails d’hospitalisation</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Service</label>
              <select name="serviceId" id="serviceId_add" class="form-select" required>
                <option disabled selected>Sélectionner</option>
                @foreach($services as $s)
                  <option value="{{ $s->id }}">{{ $s->nom }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Lit</label>
              <select name="litId" id="litId_add" class="form-select" required>
                <option disabled selected>Sélectionner</option>
                @foreach($beds as $b)
                  <option value="{{ $b->id }}">Lit {{ $b->numero }} – {{ $b->status }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Date d'admission</label>
              <input type="date" name="dateAdmission" class="form-control" required>
          </div>
            <div class="col-md-6 mb-3">
              <label>Date de sortie prévue</label>
              <input type="date" name="dateSortie" class="form-control">
            </div>
        </div>
          <div class="mb-3">
            <label>Statut</label>
            <select name="status" class="form-select" required>
              <option disabled selected>Sélectionner</option>
              <option value="Admis">Admis</option>
              <option value="En attente">En attente</option>
              <option value="Transféré">Transféré</option>
              <option value="Sorti">Sorti</option>
            </select>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

   {{-- Voir une hospitalisation --}}
<div class="modal fade" id="viewHospitalizationModal" tabindex="-1" aria-labelledby="viewHospitalizationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewHospitalizationModalLabel">Détails de l’hospitalisation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewHospitalizationContent">
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status"></div>
          <p>Chargement des informations...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

{{-- Modifier une hospitalisation --}}
<div class="modal fade" id="editHospitalizationModal" tabindex="-1" aria-labelledby="editHospitalizationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editHospitalizationModalLabel">Modifier l’hospitalisation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editHospitalizationForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body" id="editHospitalizationContent">
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-3">Chargement du formulaire…</p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


</div>




<!-- <script>

  document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    $(document).on('click', '.btn-view-hosp', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        $('#viewHospitalizationContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height:200px">
                <div class="spinner-border text-primary" role="status"></div>
                <span class="ms-3">Chargement…</span>
            </div>
        `);

        let modal = new bootstrap.Modal(document.getElementById('viewHospitalizationModal'));
        modal.show();

        $.getJSON(`/patients/${id}`, function(data) {
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
        }).fail(function(xhr) {
            $('#viewHospitalizationContent').html(`
                <div class="alert alert-danger">Erreur ${xhr.status} : impossible de charger les données.</div>
            `);
        });
    });
    $('#viewHospitalizationModal').modal({
});
    


    $(document).on('click', '.btn-edit-hosp', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        $('#editHospitalizationForm').attr('action', `/patients/${id}`);
        $('#editHospitalizationContent').html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height:200px">
                <div class="spinner-border text-primary" role="status"></div>
                <span class="ms-3">Chargement…</span>
            </div>
        `);

        let editModal = new bootstrap.Modal(document.getElementById('editHospitalizationModal'));
        editModal.show();

        $.getJSON(`/patients/${id}/edit`, function(data) {
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
                    <textarea class="form-control" id="noteMedical" name="noteMedical" rows="3">${data.patient.noteMedical}</textarea>
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
        }).fail(function(xhr) {
            $('#editHospitalizationContent').html(`
                <div class="alert alert-danger">Erreur ${xhr.status} : impossible de charger les données.</div>
            `);
        });
    });
});

</script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
  console.log('Script d\'hospitalisation chargé correctement');

// Définir une fonction pour vérifier si le DOM est prêt
function domReady(fn) {
  // Si le document est déjà chargé
  if (document.readyState === "complete" || document.readyState === "interactive") {
    setTimeout(fn, 1);
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}

// Exécuter tout notre code dans cette fonction
domReady(function() {
  console.log('==== DÉBUT DU DÉBOGAGE - HOSPITALISATIONS ====');
  console.log('jQuery version:', $.fn.jquery);
  console.log('Modal de vue existe:', $('#viewHospitalizationModal').length > 0);
  console.log('Modal d\'édition existe:', $('#editHospitalizationModal').length > 0);
  console.log('Boutons de vue trouvés:', $('.btn-view-hosp').length);
  
  // Ajout du token CSRF à toutes les requêtes AJAX
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    // Ajoutons un déclencheur manuel pour les modaux au cas où les attributs data-bs n'existeraient pas ou ne fonctionneraient pas
  });
  
  // Pour les modaux de vue
  if ($('.btn-view-hosp[data-id]').length > 0 && !$('.btn-view-hosp').attr('data-bs-toggle')) {
    console.log('Configuration manuelle des boutons de vue');
    $('.btn-view-hosp').on('click', function() {
      var viewModal = new bootstrap.Modal(document.getElementById('viewHospitalizationModal'));
      viewModal.show();
    });
  }
  
  // Pour les modaux d'édition
  if ($('.btn-edit-hosp[data-id]').length > 0 && !$('.btn-edit-hosp').attr('data-bs-toggle')) {
    console.log('Configuration manuelle des boutons d\'édition');
    $('.btn-edit-hosp').on('click', function() {
      var editModal = new bootstrap.Modal(document.getElementById('editHospitalizationModal'));
      editModal.show();
    });
  }
});
  
  // ===================================================
  // MODAL "AFFICHER L'HOSPITALISATION" - Lors du clic sur .btn-view-hosp
  // ===================================================
  $(document).on('click', '.btn-view-hosp', function(e) {
    // Ne pas empêcher le comportement par défaut pour permettre à Bootstrap d'ouvrir le modal
    // e.preventDefault();
    var hospitalizationId = $(this).data('id');
    console.log('Affichage de l\'hospitalisation ID:', hospitalizationId);

    // Afficher un indicateur de chargement
    $('#viewHospitalizationContent').html(`
      <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Chargement...</span>
        </div>
        <span class="ms-3">Chargement des données...</span>
      </div>
    `);
    
    // Le modal sera ouvert automatiquement par Bootstrap grâce à data-bs-toggle et data-bs-target
    
    // Appel AJAX pour charger les détails
    $.ajax({
      url: window.location.origin + '/patients/' + hospitalizationId,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        console.log('Données reçues avec succès:', data);
        
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
        $('.btn-edit-from-view-hosp').data('id', hospitalizationId);
      },
      error: function(xhr, status, error) {
        console.error('Erreur AJAX:', status, error);
        console.log('Statut HTTP:', xhr.status);
        console.log('Réponse:', xhr.responseText);
        
        $('#viewHospitalizationContent').html(`
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
  $(document).on('click', '.btn-edit-from-view-hosp', function() {
    var hospitalizationId = $(this).data('id');
    console.log('Passage de la vue à l\'édition pour ID:', hospitalizationId);
    
    // Utilisons la méthode Bootstrap pour cacher le modal
    var viewModal = bootstrap.Modal.getInstance(document.getElementById('viewHospitalizationModal'));
    if (viewModal) {
      viewModal.hide();
    } else {
      // Fallback si l'instance n'est pas accessible
      $('#viewHospitalizationModal').modal('hide');
    }
    
    // On attend que le modal soit fermé pour éviter les conflits
    setTimeout(function() {
      // Déclencher le clic sur le bouton d'édition correspondant
      $('.btn-edit-hosp[data-id="' + hospitalizationId + '"]').trigger('click');
    }, 500);
  });
  
  // ===================================================
  // MODAL "MODIFIER L'HOSPITALISATION" - Chargement du formulaire d'édition
  // ===================================================
  $(document).on('click', '.btn-edit-hosp', function(e) {
    // Ne pas empêcher le comportement par défaut pour permettre à Bootstrap d'ouvrir le modal
    // e.preventDefault();
    var hospitalizationId = $(this).data('id');
    console.log('Édition de l\'hospitalisation ID:', hospitalizationId);
    
    // Mettre à jour l'action du formulaire d'édition
    $('#editHospitalizationForm').attr('action', window.location.origin + '/patients/' + hospitalizationId);
    
    // Indicateur de chargement
    $('#editHospitalizationContent').html(`
      <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Chargement...</span>
        </div>
        <span class="ms-3">Chargement du formulaire...</span>
      </div>
    `);
    
    // Le modal sera ouvert automatiquement par Bootstrap grâce à data-bs-toggle et data-bs-target
    
    // Appel AJAX pour charger le formulaire d'édition
    $.ajax({
      url: window.location.origin + '/patients/' + hospitalizationId + '/edit',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        console.log('Données reçues pour l\'édition:', data);
        
        var formHtml = `
          <h6 class="mb-3">Informations du patient</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="${data.patient.nom}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="prenom" name="prenom" value="${data.patient.prenom}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="dateNaissance" class="form-label">Date de naissance</label>
              <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="${data.patient.dateNaissance}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="genre" class="form-label">Genre</label>
              <select class="form-select" id="genre" name="genre" required>
                <option value="M" ${data.patient.genre === 'M' ? 'selected' : ''}>Masculin</option>
                <option value="F" ${data.patient.genre === 'F' ? 'selected' : ''}>Féminin</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="groupeSanguin" class="form-label">Groupe sanguin</label>
              <select class="form-select" id="groupeSanguin" name="groupeSanguin" required>
                ${['A+','A-','B+','B-','AB+','AB-','O+','O-'].map(grp => `
                  <option value="${grp}" ${data.patient.groupeSanguin === grp ? 'selected' : ''}>${grp}</option>
                `).join('')}
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="tel" class="form-label">Téléphone</label>
              <input type="tel" class="form-control" id="tel" name="tel" value="${data.patient.tel}">
            </div>
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="${data.patient.email}">
            </div>
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <textarea class="form-control" id="adresse" name="adresse" rows="2">${data.patient.adresse}</textarea>
          </div>
          <div class="mb-3">
            <label for="noteMedical" class="form-label">Notes médicales</label>
            <textarea class="form-control" id="noteMedical" name="noteMedical" rows="3">${data.patient.noteMedical || ''}</textarea>
          </div>

          <hr>
          <h6 class="mb-3">Détails d'hospitalisation</h6>
        `;
        
        // Gestion conditionnelle selon qu'il existe ou non une hospitalisation
        if (data.hosp) {
          formHtml += `
            <input type="hidden" name="hospitalization_id" value="${data.hosp.id}">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="service_id" class="form-label">Service</label>
                <select class="form-select" id="service_id" name="service_id" required>
                  ${Object.entries(data.services).map(([id, nom]) => `
                    <option value="${id}" ${id == data.hosp.serviceId ? 'selected' : ''}>${nom}</option>
                  `).join('')}
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lit_id" class="form-label">Lit</label>
                <select class="form-select" id="lit_id" name="lit_id" required>
                  ${data.beds.map(b => `
                    <option value="${b.id}" ${b.id == data.hosp.litId ? 'selected' : ''}>Lit ${b.numero}</option>
                  `).join('')}
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="admission_date" class="form-label">Date d'admission</label>
                <input type="date" class="form-control" id="admission_date" name="admission_date" value="${data.hosp.dateAdmission}" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="date_sortie" class="form-label">Date de sortie prévue</label>
                <input type="date" class="form-control" id="date_sortie" name="date_sortie" value="${data.hosp.dateSortie || ''}">
              </div>
              <div class="col-md-4 mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-select" id="status" name="status" required>
                  ${['Admis', 'En attente', 'Transfere', 'Sorti'].map(s => `
                    <option value="${s}" ${s == data.hosp.status ? 'selected' : ''}>${s}</option>
                  `).join('')}
                </select>
              </div>
            </div>
          `;
        } else {
          formHtml += `
            <div class="alert alert-info">
              Ce patient n'a pas d'hospitalisation active.
              <button type="button" class="btn btn-sm btn-primary mt-2" id="btn-create-hosp" data-id="${data.patient.id}">Créer une hospitalisation</button>
            </div>
          `;
        }
        
        $('#editHospitalizationContent').html(formHtml);
        
        // Gestionnaire d'événement pour le bouton "Créer une hospitalisation"
        $('#btn-create-hosp').on('click', function() {
          chargerFormulaireCreation($(this).data('id'));
        });
      },
      error: function(xhr, status, error) {
        console.error('Erreur AJAX pour le formulaire d\'édition:', status, error);
        console.log('Réponse:', xhr.responseText);
        
        $('#editHospitalizationContent').html(`
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
  // SOUMISSION DU FORMULAIRE D'ÉDITION/CRÉATION
  // ===================================================
  $('#editHospitalizationForm').on('submit', function(e) {
    e.preventDefault();
    console.log('Soumission du formulaire d\'hospitalisation');
    
    const formData = $(this).serialize();
    const url = $(this).attr('action');
    
    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log('Réponse du serveur:', response);
        
        if (response.success) {
          // Fermer le modal
          $('#editHospitalizationModal').modal('hide');
          
          // Afficher un message de succès (à adapter selon votre interface)
          $('body').append(`
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
              <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                  <strong class="me-auto">Succès</strong>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
                <div class="toast-body">
                  ${response.message || 'Opération réussie'}
                </div>
              </div>
            </div>
          `);
          
          // Auto-disparition du toast après 3 secondes
          setTimeout(function() {
            $('.toast').toast('hide');
          }, 3000);
          
          // Rafraîchir le tableau des hospitalisations si présent
          if (typeof rechargerTableauHospitalisations === 'function') {
            rechargerTableauHospitalisations();
          } else {
            // Sinon, recharger la page après un court délai
            setTimeout(function() {
              window.location.reload();
            }, 1000);
          }
        } else {
          // Afficher les erreurs dans le formulaire
          afficherErreurs(response.errors || {});
        }
      },
      error: function(xhr, status, error) {
        console.error('Erreur lors de la soumission:', status, error);
        
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.errors) {
            afficherErreurs(response.errors);
          } else {
            afficherAlerte('Une erreur est survenue lors de l\'opération: ' + (response.message || error));
          }
        } catch (e) {
          afficherAlerte('Une erreur inattendue est survenue: ' + error);
        }
      }
    });
  });
  
  // ===================================================
  // FONCTION D'AFFICHAGE DES ERREURS DE VALIDATION
  // ===================================================
  function afficherErreurs(erreurs) {
    // Réinitialiser les états des champs
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    
    // Parcourir les erreurs et les afficher
    $.each(erreurs, function(champ, messages) {
      const input = $(`[name="${champ}"]`);
      input.addClass('is-invalid');
      
      if (Array.isArray(messages)) {
        input.after(`<div class="invalid-feedback">${messages.join('<br>')}</div>`);
      } else {
        input.after(`<div class="invalid-feedback">${messages}</div>`);
      }
    });
    
    // Afficher une alerte générale en haut du formulaire
    if (Object.keys(erreurs).length > 0) {
      $('#editHospitalizationContent').prepend(`
        <div class="alert alert-danger alert-dismissible fade show">
          Veuillez corriger les erreurs dans le formulaire.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      `);
    }
  }
  
  // ===================================================
  // FONCTION D'AFFICHAGE D'ALERTE GÉNÉRALE
  // ===================================================
  function afficherAlerte(message, type = 'danger') {
    $('#editHospitalizationContent').prepend(`
      <div class="alert alert-${type} alert-dismissible fade show">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
      </div>
    `);
    
    // Faire défiler vers le haut pour voir l'alerte
    $('#editHospitalizationContent').animate({ scrollTop: 0 }, 200);
  }
  
  // ===================================================
  // FONCTION DE RECHARGEMENT DU TABLEAU DES HOSPITALISATIONS
  // ===================================================
  function rechargerTableauHospitalisations() {
    // À implémenter selon la structure de votre page
    if ($('#tableau-hospitalisations').length > 0) {
      console.log('Rechargement du tableau des hospitalisations');
      
      $.ajax({
        url: window.location.origin + '/hospitalisations/liste',
        type: 'GET',
        success: function(html) {
          $('#tableau-hospitalisations').html(html);
          console.log('Tableau des hospitalisations rechargé');
        },
        error: function(xhr, status, error) {
          console.error('Erreur lors du rechargement du tableau:', status, error);
        }
      });
    }
  }
</script>
@endsection