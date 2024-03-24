{% extends 'base.html.twig' %}

{% block title %}Hello OccasionController!
{% endblock %}

{% block body %}




<div class="container"> <div class="row">
        <div class="col-lg-4">
            <div class="mt-5">
                <h3>Filtre par prix</h3>
            </div>

            <input id="myRange" min="0" max="50000" step="1000" type="range" class="form-range"/>

            <h4>Valeur:
                <span id="curr"></span>
            </h4>
        </div>
        <div class="col-lg-4">
            <div class="mt-5">
                <h3>Filtre par kilomètres</h3>
            </div>

            <input id="myRange1" min="0" max="500000" step="10000" type="range" class="form-range"/>

            <h4>Valeur:
                <span id="curr1"></span>
            </h4>
        </div>
        <div class="col-lg-4">
            <div class="mt-5">
                <h3>Filtre par année</h3>
            </div>

            <input id="myRange2" min="0" max="5000" step="1000" type="range" class="form-range"/>

            <h4>Valeur:
                <span id="curr2"></span>
            </h4>
        </div>
    </div>
</div>
<section class="container">
    <h1 class="text-center">Les filtres</h1>
    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/FORD.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Ford</p><p>Caractéristiques :
                        Année
                        <span class="annee">2010</span>
                        Nombre de kilomètres :
                        <span class="kilom">100 000km</span>
                        4 portes Carburant : Essence
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        38900 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/citroen.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">citroen</p>
                    <p>Caractéristiques :
                        Année
                        <span class="annee">2007</span>
                        Nombre de kilomètres :
                        <span class="kilom">200 000km</span>
                        5 portes Carburant : Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        3250 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/Audi.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">AUDI</p>
                    <p>Caractéristiques:
                        Année
                        <span class="annee">2022</span>
                        Nombre de kilomètres=
                        <span class="kilom">80 000km</span>
                        5 portes Carburant : Essence
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        18 000 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/clio.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">clio</p>
                    <p>Caractéristiques:
                        Année
                        <span class="annee">2014</span>
                        Bombre de kilomètres:
                        <span class="kilom">80 000km</span>
                        3 portes Carburant: Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        3600 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/espace.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">espace</p>
                    <p>Caractéristiques
                        Année
                        <span class="annee">2007</span>
                        Nombre de kilomètres:
                        <span class="kilom">120 000km</span>
                        5 portes Carburant : Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        4250 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/PEUGEOT.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">PEUGEOT</p>
                    Caractéristiques
                    <p>Année
                        <span class="annee">2009</span>
                        Nombre de kilomètres :
                        <span class="kilom">150 000km</span>
                        5portes Carburant : Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        3050 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/clio1.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">clio1</p>
                    <p>Caractéristiques:
                        Année
                        <span class="annee">2002</span>
                        Nombre de kilomètres :
                        <span class="kilom">150 000km</span>
                        5 portes Carburant : Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        2700 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/ZOE.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">ZOE</p>
                    <p>Caractéristiques:
                        Année
                        <span class="annee">2022</span>
                        Nombre de kilomètres :
                        <span class="kilom">80 000km</span>
                        3 portes Carburant : électrique
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        15 400 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/mercedes.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">mercedes</p>
                    <p>Caractéristiiques :
                        Année
                        <span class="annee">2022</span>
                        Nombre de kilomètres:
                        <span class="kilom">80 000km</span>
                        5 portes Carburant : électrque ou Essence
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        40 000 €</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="assets/images/ImagesAuto/citroenc3.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">citroenc3</p>
                    <p>
                        Caractéristiiques:
                        Année
                        <span class="annee">2008</span>
                        Nombre de kilomètres :
                        <span class="kilom">150 000km</span>
                        5 portes Carburant : Diesel
                    </p>
                    <a class="btn btn-dark" href="javascript:void(0)" role="button">
                        3500 €</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <p>Adresse : GARAGE VINCENT PARROT<br/>
                RUE DE LA FORET<br/>
                60000 TOULOUSE<br/>
                Téléphone : 06 00 00 00 00
            </p>
        </div>
        <div class="col-lg-6">
            <h4>
                Horaires d'ouverture:</h4>
            <h4>Du Lundi au Vendredi :8h45-12h et de 14h-18h</h4>
            <h4>
                Samedi : 8h45-12h</h4>
            <h4>
                Dimanche : Fermé</h4>
        </div>
    </div>
    <script src="{{asset('assets/js/filtres.js')}}"></script>
</section>


{% endblock %}
