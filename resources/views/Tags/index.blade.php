<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tags - NavShuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-dutch-white/30 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-wine text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/admin" class="text-2xl font-bold">NavShuttle Admin</a>
            <div class="flex items-center space-x-4">
                <a href="/admin/users" class="hover:text-dutch-white transition">Utilisateurs</a>
                <a href="/admin/companies" class="hover:text-dutch-white transition">Sociétés</a>
                <a href="/admin/offers" class="hover:text-dutch-white transition">Offres</a>
                <a href="/admin/subscriptions" class="hover:text-dutch-white transition">Abonnements</a>
                @if (auth()->user()->role->name == 'admin')
                    <a href="/admin/roles" class="hover:text-dutch-white transition">Rôles</a>
                    <a href="/admin/tags" class="hover:text-dutch-white transition font-bold">Tags</a>
                    <a href="/admin/users" class="hover:text-dutch-white transition font-bold">Users</a>
                @endif
                <div class="relative group">
                    <button class="flex items-center space-x-1 hover:text-dutch-white transition">
                        <span>{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute hidden group-hover:block right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-wine text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">Gestion des Tags</h1>
                    <p class="mt-2">Créez et gérez les étiquettes pour les offres</p>
                </div>
                <button onclick="toggleTagForm()" class="bg-dutch-white text-wine px-6 py-2 rounded-lg hover:bg-dutch-white/90 transition">
                    + Nouveau Tag
                </button>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <!-- Formulaire flottant -->
        <div id="tagForm" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 w-full max-w-md">
                <h2 class="text-2xl font-bold text-wine mb-4" id="formTitle">Nouveau Tag</h2>
                <form id="tagFormElement" method="POST" action="{{ route('admin.tags.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Nom du tag</label>
                        <input type="text" name="name" id="tagName"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-wine"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleTagForm()" 
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                        <button type="submit" 
                                class="bg-wine text-white px-4 py-2 rounded-lg hover:bg-wine/90 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des tags -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-wine/10">
                    <tr>
                        <th class="text-left py-4 px-6 text-wine">Nom</th>
                        <th class="text-left py-4 px-6 text-wine">Offres associées</th>
                        <th class="text-left py-4 px-6 text-wine">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr class="hover:bg-dutch-white/10 border-t">
                        <td class="py-4 px-6 font-medium">{{ $tag->name }}</td>
                        <td class="py-4 px-6 text-wine">{{ $tag->offers_count }}</td>
                        <td class="py-4 px-6 space-x-3">
                            <button onclick="editTag('{{ $tag->id }}', '{{ $tag->name }}')" 
                                    class="text-blue-600 hover:text-blue-900">Éditer</button>
                            <button onclick="confirmDelete('{{ $tag->id }}')" 
                                    class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 px-6 text-center text-gray-500">Aucun tag trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $tags->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 NavShuttle. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function toggleTagForm() {
            const form = document.getElementById('tagForm');
            form.classList.toggle('hidden');
            document.getElementById('formTitle').textContent = 'Nouveau Tag';
            document.getElementById('tagFormElement').action = "{{ route('admin.tags.store') }}";

            
        }

        async function editTag(id) {
            await fetch(`/admin/tags/${id}`)
            .then(res=>res.json())
            .then(data=>{
                console.log(data);
                
                document.getElementById('tagName').value=data.name;
            })
            
            toggleTagForm();
            document.getElementById('tagFormElement').action = ` /admin/tags/${id}/update`;

        }

        async function confirmDelete(id) {
            if(confirm('Êtes-vous sûr de vouloir supprimer ce tag ?')) {

                    await fetch(`/admin/tags/${id}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(res=>res.json())
                    .then(data=>{
                        console.log(data);
                        
                    })
                    window.location.reload();
                    
                    
                
            }
        }
    </script>
</body>
</html>