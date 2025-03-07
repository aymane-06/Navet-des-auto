<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rôles - NavShuttle</title>
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
    <!-- Navigation identique au dashboard -->
    <nav class="bg-wine text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/admin" class="text-2xl font-bold">NavShuttle Admin</a>
            <div class="flex items-center space-x-4">
                <a href="/admin/users" class="hover:text-dutch-white transition">Utilisateurs</a>
                <a href="/admin/companies" class="hover:text-dutch-white transition">Sociétés</a>
                <a href="/admin/offers" class="hover:text-dutch-white transition">Offres</a>
                <a href="/admin/subscriptions" class="hover:text-dutch-white transition">Abonnements</a>
                @if (auth()->user()->role->name == 'admin')
                    <a href="/admin/roles" class="hover:text-dutch-white transition font-bold">Rôles</a>
                    <a href="/admin/tags" class="hover:text-dutch-white transition font-bold">Tags</a>

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
                    <h1 class="text-3xl font-bold">Gestion des Rôles</h1>
                    <p class="mt-2">Créez et gérez les permissions des utilisateurs</p>
                </div>
                <button onclick="toggleRoleForm()" class="bg-dutch-white text-wine px-6 py-2 rounded-lg hover:bg-dutch-white/90 transition">
                    + Nouveau Rôle
                </button>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <!-- Formulaire flottant -->
        <div id="roleForm" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 w-full max-w-md">
                <h2 class="text-2xl font-bold text-wine mb-4">Nouveau Rôle</h2>
                <form id="form" method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Nom du rôle</label>
                        <input type="text" name="name" 
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-wine">
                    </div>
                    @error('name')
                        <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Permissions</label>
                        <div class="grid grid-cols-2 gap-2 h-48 overflow-y-auto p-2 border rounded">
                            @foreach($permissions as $permission)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       class="form-checkbox text-wine">
                                <span class="text-sm">{{ $permission->slug }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleRoleForm()" 
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                        <button type="submit" 
                                class="bg-wine text-white px-4 py-2 rounded-lg hover:bg-wine/90 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des rôles -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-wine/10">
                    <tr>
                        <th class="text-left py-4 px-6 text-wine">Nom du Rôle</th>
                        <th class="text-left py-4 px-6 text-wine">Permissions</th>
                        <th class="text-left py-4 px-6 text-wine">Utilisateurs</th>
                        <th class="text-left py-4 px-6 text-wine">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="hover:bg-dutch-white/10 border-t">
                        <td class="py-4 px-6 font-medium">{{ $role->name }}</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach($role->permissions as $permission)
                                <span class="px-3 py-1 bg-wine/10 text-wine rounded-full text-sm">
                                    {{ $permission->slug }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6 text-wine">{{ count($role->users) }}</td>
                        <td class="py-4 px-6 space-x-3">
                            <button onclick="toggleRoleForm('{{ $role->id }}')" 
                                    class="text-blue-600 hover:text-blue-900">Éditer</button>
                            <button onclick="confirmDelete('{{ $role->id }}')" 
                                    class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $roles->links() }}
        </div>
    </div>

    <!-- Footer identique -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 NavShuttle. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        async function toggleRoleForm(roleId = null) {
            const form = document.getElementById('roleForm');
            form.classList.toggle('hidden');
            let forma=document.getElementById('form');
            forma.setAttribute('action', roleId ? `/admin/roles/${roleId}/edit` : '/admin/roles');
            forma.reset();
            
            if(roleId) {
                // Pré-remplir le formulaire pour l'édition
               await fetch(`/admin/roles/${roleId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        
                        // Populate the form fields with the data retrieved from the server
                        document.querySelector('#roleForm input[name="name"]').value = data.role.name;
                        document.querySelectorAll('#roleForm input[name="permissions[]"]').forEach(checkbox => {
                            const permissionIds = data.role.permissions.map(permission => permission.id);
                            checkbox.checked = permissionIds.includes(parseInt(checkbox.value));
                        });
                    });
            }
        }

        async function confirmDelete(roleId) {
            if(confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')) {
                await fetch(`/admin/roles/${roleId}/delete`, {method: 'DELETE',headers: {'X-CSRF-TOKEN':'{{csrf_token()}}'}})
                .then(response => response.json())
                .then(data => {
                    
                    alert(data.message);
                    window.location.reload();
                });
            }
        }
    </script>
</body>
</html>