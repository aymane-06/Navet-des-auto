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
    <!-- Navigation -->
    <nav class="bg-wine text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/admin" class="text-2xl font-bold">NavShuttle Admin</a>
            <div class="flex items-center space-x-4">
                <a href="/admin/users" class="hover:text-dutch-white transition font-bold">Utilisateurs</a>
                <a href="/admin/companies" class="hover:text-dutch-white transition">Sociétés</a>
                <a href="/admin/roles" class="hover:text-dutch-white transition">Rôles</a>
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

    <!-- Contenu principal -->
    <div class="flex-grow container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-wine">Gestion des Rôles Utilisateurs</h1>
            <p class="mt-2 text-gray-600">Modifiez les privilèges d'accès des utilisateurs</p>
        </div>

        <!-- Formulaire de modification -->
        <div id="roleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-bold text-wine mb-4">Modifier le Rôle</h3>
                <form id="roleForm" action="{{ route('admin.users.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="userId" name="user_id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Sélectionner un nouveau rôle</label>
                        <select name="role_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-wine">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" 
                                class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Annuler</button>
                        <button type="submit" 
                                class="bg-wine text-white px-4 py-2 rounded-lg hover:bg-wine/90 transition">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-wine/10">
                    <tr>
                        <th class="text-left py-4 px-6 text-wine">Utilisateur</th>
                        <th class="text-left py-4 px-6 text-wine">Email</th>
                        <th class="text-left py-4 px-6 text-wine">Rôle Actuel</th>
                        <th class="text-left py-4 px-6 text-wine">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="hover:bg-dutch-white/10 border-t">
                        <td class="py-4 px-6 font-medium">{{ $user->name }}</td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-wine/10 text-wine rounded-full text-sm">
                                {{ $user->role->name }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <button onclick="openModal('{{ $user->id }}','{{ $user->role->id }}')" 
                                    class="text-wine hover:text-wine/80 transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Modifier
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 NavShuttle. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function openModal(userId,currentRoleId) {
            const modal = document.getElementById('roleModal');
            const form = document.getElementById('roleForm');
            
            form.action = `/admin/users/${userId}/role`;
            document.getElementById('userId').value = userId;
            document.querySelector('select[name="role_id"]').value = currentRoleId;
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('roleModal').classList.add('hidden');
        }

       
    </script>
</body>
</html>