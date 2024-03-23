@extends('layouts.master')
@section('title') @lang('translation.basic-tables') @endsection
@section('content')

    <!-- Varying modal content -->
    <!-- Contenu modal variable pour l'ajout d'un client -->
    <div class="modal fade" id="addeleveModal" tabindex="-1" aria-labelledby="addeleveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeleveModalLabel">Ajouter eleve</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addeleveForm" action="{{ route('store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="eleve-name" class="col-form-label">Nom:</label>
                            <input type="text" class="form-control" id="eleve-name" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-firstname" class="col-form-label">Prénom:</label>
                            <input type="text" class="form-control" id="eleve-firstname" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-phone" class="col-form-label">Téléphone:</label>
                            <input type="tel" class="form-control" id="eleve-phone" name="telephone" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-address" class="col-form-label">Adresse:</label>
                            <input type="text" class="form-control" id="eleve-address" name="adresse" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-birth" class="col-form-label">date de naissance:</label>
                            <input type="text" class="form-control" id="eleve-birth" name="birth" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-genre" class="col-form-label">Genre:</label>
                            <input type="text" class="form-control" id="eleve-genre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-nationalite" class="col-form-label">nationalite:</label>
                            <input type="text" class="form-control" id="eleve-nationalite" name="nationalite" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-classe" class="col-form-label">classe:</label>
                            <input type="text" class="form-control" id="eleve-classe" name="classe" required>
                        </div>


                        <button type="submit" class="text-center btn btn-primary">Enregistrer</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>

                </div>
            </div>
        </div>
    </div>
    <!--modal de modification -->
    <div class="modal fade" id="editereleveModal" tabindex="-1" aria-labelledby="editereleveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editereleveModalLabel">Éditer eleve</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editereleveForm" action="" method="POST">
                        @csrf
                        @method('PUT') <!-- Ajout de la directive pour simuler une requête PUT -->
                        <input type="hidden" name="id" id="eleve-id"> <!-- Champ caché pour l'ID du client -->

                        <div class="mb-3">
                            <label for="edit-eleve-name" class="col-form-label">Nom:</label>
                            <input type="text" class="form-control" id="edit-eleve-name" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-eleve-firstname" class="col-form-label">Prénom:</label>
                            <input type="text" class="form-control" id="edit-eleve-firstname" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-eleve-phone" class="col-form-label">Téléphone:</label>
                            <input type="tel" class="form-control" id="edit-eleve-phone" name="telephone" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-eleve-address" class="col-form-label">Adresse:</label>
                            <input type="text" class="form-control" id="edit-eleve-address" name="adresse" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-eleve-birth" class="col-form-label">Date de naissance:</label>
                            <label for="edit-eleve-name"></label><input type="text" class="form-control" id="edit-eleve-birth" name="birth" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-genre" class="col-form-label">Genre:</label>
                            <input type="text" class="form-control" id="eleve-genre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-nationalite" class="col-form-label">nationalite:</label>
                            <input type="text" class="form-control" id="eleve-nationalite" name="nationalite" required>
                        </div>
                        <div class="mb-3">
                            <label for="eleve-classe" class="col-form-label">classe:</label>
                            <input type="text" class="form-control" id="eleve-classe" name="classe" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (min-width: 992px) { /* Correspond à 'lg' dans Bootstrap */
            .text-lg-nowrap {
                white-space: nowrap;
            }
        }

    </style>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Listes</h4>






                    <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addeleveModal">
                        <i class="uil uil-plus me-2"></i> Ajouter
                    </button>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-striped">
                            <thead class="table-light">
                            <tr>


                                <th scope="col">Nom</th>
                                <th scope="col">Prenom</th>
                                <th scope="col">telephone</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Date de naissance</th>
                                <th scope="col">natinalité</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Classe</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Eleves as $eleve)
                                <tr>




                                    <!-- <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="build/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1">
                                                {{ $client->prenom }} {{ $client->nom }}
                                    </div>
                                </div>
                            </td>-->
                                    <td>{{$eleve->nom}}</td>
                                    <td>{{$eleve->prenom}}</td>
                                    <td>{{$eleve->number}}</td>
                                    <td>{{$eleve->adresse}}</td>
                                    <td>{{$eleve->birth}}</td>
                                    <td>{{$eleve->nationalite}}</td>
                                    <td>{{$eleve->genre}}</td>
                                    <td>{{$eleve->classe_id}}</td>

                                    <td>
                                        <!-- Bouton Éditer -->
                                        <!-- Bouton Éditer dans la boucle des clients -->
                                        <a href="{{ route('eleve.index', ['eleve_id' => $eleve->id]) }}" class="btn btn-sm btn-success">eleve</a>

                                        <button class="btn btn-sm btn-info edit-promotion-button" data-bs-toggle="modal" data-bs-target="#editerpromotionModal"

                                                data-nom="{{ $eleve->nom }}"
                                                data-prenom="{{ $eleve->prenom }}"
                                                data-number="{{ $eleve->number }}"
                                                data-adresse="{{ $eleve->adresse }}"
                                                data-birth="{{ $eleve->birth }}"
                                                data-nationalite="{{ $eleve->nationalite }}"
                                                data-genre="{{ $eleve->genre }}"
                                                data-classe_id="{{ $eleve->classe_id }}">Éditer</button>


                                        <!-- Bouton Supprimer -->
                                        <!-- Notez que nous utilisons un formulaire pour la suppression pour inclure le CSRF token -->
                                        <form action="{{ route('eleve.destroy', $eleve->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        <!-- end table -->
                    </div>

                    <!-- end table responsive -->
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>


@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editerEleveModal = document.getElementById('editereleveModal');
            editerEleveModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Bouton qui a déclenché le modal
                var nom = button.getAttribute('data-nom');
                var prenom = button.getAttribute('data-prenom');
                var adresse = button.getAttribute('data-adresse');
                var number = button.getAttribute('data-number');
                var birth = button.getAttribute('data-birth');
                var nationalite = button.getAttribute('data-nationalite');
                var genre = button.getAttribute('data-genre');
                var classe_id = button.getAttribute('data-classe_id');


                // Mise à jour de l'action du formulaire avec l'ID du client
                var form = this.querySelector('form');
                var actionURL = '/promotions/' + promotionId; // Assurez-vous que cette URL correspond à votre route de mise à jour
                form.action = actionURL;

                // Pré-remplir les champs du formulaire
                this.querySelector('#edit-eleve-nom').value = nom;
                this.querySelector('#edit-eleve-prenom').value = prenom;
                this.querySelector('#edit-eleve-adresse').value = adresse;
                this.querySelector('#edit-eleve-birth').value = birth;
                this.querySelector('#edit-eleve-number').value = number;
                this.querySelector('#edit-eleve-nationalite').value = nationalite;
                this.querySelector('#edit-eleve-genre').value = genre;
                this.querySelector('#edit-eleve-classe_id').value = classe_id;


                // Si vous avez un champ caché pour l'ID, mettez-le à jour également raina
                this.querySelector('form input[name="id"]').value = eleveId;
            });
        });
    </script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
