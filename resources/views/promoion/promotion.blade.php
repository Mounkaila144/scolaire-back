@extends('layouts.master')
@section('title') @lang('translation.basic-tables') @endsection
@section('content')

    <!-- Varying modal content -->
    <!-- Contenu modal variable pour l'ajout d'un client -->
    <div class="modal fade" id="addpromotionModal" tabindex="-1" aria-labelledby="addpromotionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addpromotionModalLabel">Ajouter promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addpromotionForm" action="{{ route('store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="promotion-debut" class="col-form-label">Debut:</label>
                            <input type="text" class="form-control" id="promotion-debut" name="debut" required>
                        </div>
                        <div class="mb-3">
                            <label for="promotion-fin" class="col-form-label">Fin:</label>
                            <input type="text" class="form-control" id="promotion-fin" name="fin" required>
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
    <div class="modal fade" id="editerpromotionModal" tabindex="-1" aria-labelledby="editerpromotionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editerpromotionModalLabel">Éditer promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editerpromotionForm" action="" method="POST">
                        @csrf
                        @method('PUT') <!-- Ajout de la directive pour simuler une requête PUT -->
                        <input type="hidden" name="id" id="promotion-id"> <!-- Champ caché pour l'ID du client -->
                        <div class="mb-3">
                            <label for="edit-promotion-debut" class="col-form-label">Debut:</label>
                            <label for="edit-promotion-name"></label><input type="text" class="form-control" id="edit-promotion-name" name="debut" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-promotion-fin" class="col-form-label">Fin:</label>
                            <input type="text" class="form-control" id="edit-promotion-fin" name="fin" required>
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






                    <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addpromotionModal">
                        <i class="uil uil-plus me-2"></i> Ajouter
                    </button>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-striped">
                            <thead class="table-light">
                            <tr>

                                <th scope="col">Date de debut</th>
                                <th scope="col">Date de fin</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Promotions as $promotion)
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
                                    <td>{{$promotion->debut}}</td>
                                    <td>{{$promotion->fin}}</td>
                                    <td>
                                        <!-- Bouton Éditer -->
                                        <!-- Bouton Éditer dans la boucle des clients -->
                                        <a href="{{ route('promotion.index', ['promotion_id' => $promotion->id]) }}" class="btn btn-sm btn-success">promotion</a>

                                        <button class="btn btn-sm btn-info edit-promotion-button" data-bs-toggle="modal" data-bs-target="#editerpromotionModal"

                                                data-debut="{{ $promotion->debut }}"
                                                data-fin="{{ $promotion->fin }}">Éditer</button>


                                        <!-- Bouton Supprimer -->
                                        <!-- Notez que nous utilisons un formulaire pour la suppression pour inclure le CSRF token -->
                                        <form action="{{ route('promotion.destroy', $promotion->id) }}" method="POST" style="display: inline-block;">
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
            var editerPromotionModal = document.getElementById('editerpromotionModal');
            editerPromotionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Bouton qui a déclenché le modal
                var debut = button.getAttribute('data-debut');
                var fin = button.getAttribute('data-fin');


                // Mise à jour de l'action du formulaire avec l'ID du client
                var form = this.querySelector('form');
                var actionURL = '/promotions/' + promotionId; // Assurez-vous que cette URL correspond à votre route de mise à jour
                form.action = actionURL;

                // Pré-remplir les champs du formulaire
                this.querySelector('#edit-promotion-debut').value = debut;
                this.querySelector('#edit-promotion-fin').value = fin;


                // Si vous avez un champ caché pour l'ID, mettez-le à jour également
                this.querySelector('form input[name="id"]').value = promotionId;
            });
        });
    </script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
