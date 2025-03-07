<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une offre - NavShuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dutch-white': '#EFDFBB',
                        'wine': '#C89B3C',
                    }
                }
            }
        }
    </script>
    <style>
        .ts-control {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem !important;
        }
        .ts-wrapper.multi .ts-control > div {
            background-color: #C89B3C !important;
            color: white !important;
            border-radius: 0.375rem !important;
        }
        .ts-dropdown {
            border-color: #e5e7eb !important;
            border-radius: 0.375rem !important;
        }
        .ts-dropdown .active {
            background-color: #EFDFBB !important;
            color: #1f2937 !important;
        }
    </style>
</head>
<body class="bg-dutch-white/30 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-wine text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">NavShuttle</a>
            <div class="flex items-center space-x-4">
                <a href="/dashboard" class="hover:text-dutch-white transition">Tableau de bord</a>
                <a href="/offres" class="hover:text-dutch-white transition">Mes offres</a>
                <a href="/demandes" class="hover:text-dutch-white transition">Demandes</a>
                <div class="relative">
                    <button class="flex items-center space-x-1 hover:text-dutch-white transition">
                        <span>TransExpress</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-wine text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Créer une nouvelle offre de navette</h1>
            <p class="mt-2">Définissez les détails de votre service de navette</p>
        </div>
    </div>

    <!-- Create Offer Form -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="p-6">
                <form action="{{ isset($shuttle_offer)?route('shuttle_Offer.update',$shuttle_offer):route("shuttle_offer.store") }}" method="POST">
                    @csrf
                    @if(isset($shuttle_offer))
                        @method('PUT')
                        @endif
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-wine">Informations de base</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre de l'offre</label>
                                    <input type="text" id="title" name="title" value="{{ old("title",$shuttle_offer->title ?? '') }}" placeholder="Ex: Navette quotidienne Casablanca-Rabat" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="depart" class="block text-sm font-medium text-gray-700 mb-1">Ville de départ</label>
                                        <select id="depart"  name="depart" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                                <option value="{{ old('depart',$shuttle_offer->departure_city ?? "") }}" selected>{{  old('depart',$shuttle_offer->departure_city ?? "Sélectionner une ville") }} </option>
                                                <option value="agadir">Agadir</option>
                                                <option value="ain_harrouda">Aïn Harrouda</option>
                                                <option value="al_hoceima">Al Hoceïma</option>
                                                <option value="azilal">Azilal</option>
                                                <option value="azrou">Azrou</option>
                                                <option value="ben_guerir">Ben Guerir</option>
                                                <option value="beni_mellal">Beni Mellal</option>
                                                <option value="berkane">Berkane</option>
                                                <option value="berrechid">Berrechid</option>
                                                <option value="benslimane">Benslimane</option>
                                                <option value="bouarfa">Bouarfa</option>
                                                <option value="casablanca">Casablanca</option>
                                                <option value="chefchaouen">Chefchaouen</option>
                                                <option value="chichaoua">Chichaoua</option>
                                                <option value="dakhla">Dakhla</option>
                                                <option value="el_jadida">El Jadida</option>
                                                <option value="errachidia">Errachidia</option>
                                                <option value="essaouira">Essaouira</option>
                                                <option value="fahs_anjra">Fahs-Anjra</option>
                                                <option value="fez">Fez</option>
                                                <option value="figuig">Figuig</option>
                                                <option value="fnideq">Fnideq</option>
                                                <option value="guelmim">Guelmim</option>
                                                <option value="guercif">Guercif</option>
                                                <option value="ifrane">Ifrane</option>
                                                <option value="inezgane_ait_melloul">Inezgane-Aït Melloul</option>
                                                <option value="jerada">Jerada</option>
                                                <option value="kenitra">Kenitra</option>
                                                <option value="khemisset">Khemisset</option>
                                                <option value="khenifra">Khenifra</option>
                                                <option value="khouribga">Khouribga</option>
                                                <option value="larache">Larache</option>
                                                <option value="laayoune">Laâyoune</option>
                                                <option value="marrakech">Marrakech</option>
                                                <option value="medio">Mediouna</option>
                                                <option value="midelt">Midelt</option>
                                                <option value="missour">Missour</option>
                                                <option value="mohammedia">Mohammedia</option>
                                                <option value="moulay_yacoub">Moulay Yacoub</option>
                                                <option value="nador">Nador</option>
                                                <option value="nouaceur">Nouaceur</option>
                                                <option value="ouarzazate">Ouarzazate</option>
                                                <option value="oued_eddahab">Oued Eddahab</option>
                                                <option value="oujda_angad">Oujda-Angad</option>
                                                <option value="rabat">Rabat</option>
                                                <option value="safi">Safi</option>
                                                <option value="sale">Salé</option>
                                                <option value="settat">Settat</option>
                                                <option value="sidi_bennour">Sidi Bennour</option>
                                                <option value="sidi_ifni">Sidi Ifni</option>
                                                <option value="sidi_kacem">Sidi Kacem</option>
                                                <option value="sidi_slimane">Sidi Slimane</option>
                                                <option value="skhirate_temara">Skhirate-Témara</option>
                                                <option value="tan_tan">Tan-Tan</option>
                                                <option value="tanger">Tanger</option>
                                                <option value="tafilalet">Tafilalet</option>
                                                <option value="taourirt">Taourirt</option>
                                                <option value="taounate">Taounate</option>
                                                <option value="taroudant">Taroudant</option>
                                                <option value="tata">Tata</option>
                                                <option value="taza">Taza</option>
                                                <option value="tetouan">Tétouan</option>
                                                <option value="tiznit">Tiznit</option>
                                                <option value="youssoufia">Youssoufia</option>
                                                <option value="zagora">Zagora</option>
                                            </select>

                                    </div>
                                    <div>
                                        <label for="arrivee" class="block text-sm font-medium text-gray-700 mb-1">Ville d'arrivée</label>
                                        <select id="arrivee" name="arrivee" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                        py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                                <option value="{{ old("arrivee",$shuttle_offer->arrival_city ?? "") }}" selected>{{ old("arrivee",$shuttle_offer->arrival_city ?? "Sélectionner une ville") }}</option>
                                                <option value="agadir">Agadir</option>
                                                <option value="ain_harrouda">Aïn Harrouda</option>
                                                <option value="al_hoceima">Al Hoceïma</option>
                                                <option value="azilal">Azilal</option>
                                                <option value="azrou">Azrou</option>
                                                <option value="ben_guerir">Ben Guerir</option>
                                                <option value="beni_mellal">Beni Mellal</option>
                                                <option value="berkane">Berkane</option>
                                                <option value="berrechid">Berrechid</option>
                                                <option value="benslimane">Benslimane</option>
                                                <option value="bouarfa">Bouarfa</option>
                                                <option value="casablanca">Casablanca</option>
                                                <option value="chefchaouen">Chefchaouen</option>
                                                <option value="chichaoua">Chichaoua</option>
                                                <option value="dakhla">Dakhla</option>
                                                <option value="el_jadida">El Jadida</option>
                                                <option value="errachidia">Errachidia</option>
                                                <option value="essaouira">Essaouira</option>
                                                <option value="fahs_anjra">Fahs-Anjra</option>
                                                <option value="fez">Fez</option>
                                                <option value="figuig">Figuig</option>
                                                <option value="fnideq">Fnideq</option>
                                                <option value="guelmim">Guelmim</option>
                                                <option value="guercif">Guercif</option>
                                                <option value="ifrane">Ifrane</option>
                                                <option value="inezgane_ait_melloul">Inezgane-Aït Melloul</option>
                                                <option value="jerada">Jerada</option>
                                                <option value="kenitra">Kenitra</option>
                                                <option value="khemisset">Khemisset</option>
                                                <option value="khenifra">Khenifra</option>
                                                <option value="khouribga">Khouribga</option>
                                                <option value="larache">Larache</option>
                                                <option value="laayoune">Laâyoune</option>
                                                <option value="marrakech">Marrakech</option>
                                                <option value="medio">Mediouna</option>
                                                <option value="midelt">Midelt</option>
                                                <option value="missour">Missour</option>
                                                <option value="mohammedia">Mohammedia</option>
                                                <option value="moulay_yacoub">Moulay Yacoub</option>
                                                <option value="nador">Nador</option>
                                                <option value="nouaceur">Nouaceur</option>
                                                <option value="ouarzazate">Ouarzazate</option>
                                                <option value="oued_eddahab">Oued Eddahab</option>
                                                <option value="oujda_angad">Oujda-Angad</option>
                                                <option value="rabat">Rabat</option>
                                                <option value="safi">Safi</option>
                                                <option value="sale">Salé</option>
                                                <option value="settat">Settat</option>
                                                <option value="sidi_bennour">Sidi Bennour</option>
                                                <option value="sidi_ifni">Sidi Ifni</option>
                                                <option value="sidi_kacem">Sidi Kacem</option>
                                                <option value="sidi_slimane">Sidi Slimane</option>
                                                <option value="skhirate_temara">Skhirate-Témara</option>
                                                <option value="tan_tan">Tan-Tan</option>
                                                <option value="tanger">Tanger</option>
                                                <option value="tafilalet">Tafilalet</option>
                                                <option value="taourirt">Taourirt</option>
                                                <option value="taounate">Taounate</option>
                                                <option value="taroudant">Taroudant</option>
                                                <option value="tata">Tata</option>
                                                <option value="taza">Taza</option>
                                                <option value="tetouan">Tétouan</option>
                                                <option value="tiznit">Tiznit</option>
                                                <option value="youssoufia">Youssoufia</option>
                                                <option value="zagora">Zagora</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="heure_depart" class="block text-sm font-medium text-gray-700 mb-1">Heure de départ</label>
                                        <input type="time" id="heure_depart" value="{{ old("heure_depart",date("H:i",strtotime($shuttle_offer->departure_time)) ?? '') }}" name="heure_depart" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label for="heure_arrivee" class="block text-sm font-medium text-gray-700 mb-1">Heure d'arrivée</label>
                                        <input type="time" id="heure_arrivee" value="{{ old("heure_depart",date("H:i",strtotime($shuttle_offer->arrival_time)) ?? '') }}" name="heure_arrivee" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                        <input type="date" id="date_debut" name="date_debut" value="{{ old("date_debut",date("Y-m-d",strtotime($shuttle_offer->start_date)) ?? '') }}" min="{{date('Y-m-d')}}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                        <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin',  date('Y-m-d', strtotime($shuttle_offer->end_date)) ?? '') }}" min="{{date('Y-m-d')}}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                    </div>
                                </div>
                                
                               
                                
                                <div>
                                    <label for="places" class="block text-sm font-medium text-gray-700 mb-1">Nombre de places disponibles</label>
                                    <input type="number" id="places" name="available_places" value="{{ old("available_places",$shuttle_offer->max_subscribers ?? '') }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>
                                </div>
                                
                               
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4 text-wine">Informations sur l'autocar</h2>
                            
                            <div class="space-y-4 mb-6">
                            <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <select id="tags" name="tags[]" multiple placeholder="Sélectionnez des tags..." autocomplete="off">
                                        @foreach($tags as $tag)
                                            <?php $selected = ''; ?>
                                            @if (old('tags') && in_array($tag->id, old('tags')) || isset($shuttle_offer) && $shuttle_offer->tags->contains($tag))
                                                <?php $selected = 'selected'; ?>
                                            @endif
                                            <option value="{{ $tag->id }}" {{ $selected }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-sm text-gray-500 mt-1">Sélectionnez ou créez de nouveaux tags (max 5)</p>
                                </div>   

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-wine focus:border-transparent" required>{{ old('description',$shuttle_offer->description ?? "" ) }}</textarea>
                                </div>
                              
                            </div>
                            
                            
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">Annuler</button>
                        <button type="submit" class="px-6 py-2 bg-wine text-white rounded-md hover:bg-wine/90 transition">Créer l'offre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">NavShuttle</h3>
                    <p class="text-gray-300">La plateforme de référence pour les navettes et abonnements de transport interurbain.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-dutch-white transition">Accueil</a></li>
                        <li><a href="/offres" class="text-gray-300 hover:text-dutch-white transition">Offres</a></li>
                        <li><a href="/demandes/create" class="text-gray-300 hover:text-dutch-white transition">Soumettre une demande</a></li>
                        <li><a href="/contact" class="text-gray-300 hover:text-dutch-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Pour les sociétés</h4>
                    <ul class="space-y-2">
                        <li><a href="/societes/inscription" class="text-gray-300 hover:text-dutch-white transition">Devenir partenaire</a></li>
                        <li><a href="/societes/login" class="text-gray-300 hover:text-dutch-white transition">Espace société</a></li>
                        <li><a href="/offres/create" class="text-gray-300 hover:text-dutch-white transition">Créer une offre</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>contact@navshuttle.com</li>
                        <li>+212 5XX XX XX XX</li>
                        <li>Casablanca, Maroc</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2025 NavShuttle. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
     <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Initialize Tom Select
        new TomSelect('#tags', {
            plugins: {
            'remove_button': {
                title: 'Supprimer ce tag',
            }
            },
            create: false,
            createFilter: function(input) {
            return input.length >= 2;
            },
            maxItems: 5,
            maxOptions: null,
            closeAfterSelect: true,
            persist: false,
            createOnBlur: true,
            render: {
            option: function(data, escape) {
                return '<div class="flex items-center p-2">' +
                '<span class="text-wine">' + escape(data.name || data.text) + '</span>' +
                '</div>';
            },
            item: function(data, escape) {
                return '<div class="item bg-wine/10 text-wine px-2 py-1 rounded">' + 
                escape(data.name || data.text) +
                '</div>';
            },
            no_results: function(data, escape) {
                return '<div class="no-results p-2">Aucun résultat trouvé pour "' + escape(data.input) + '"</div>';
            }
            }
        });
    </script>
</body>
</html>

