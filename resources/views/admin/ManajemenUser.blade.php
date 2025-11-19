@extends('admin.layouts.app')

@section('title', 'User Management - CampusCare')

@section('content')

<main class="p-6 sm:p-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-600 mt-1">Manage all system users</p>
        </div>

        <button onclick="openModal()" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New User
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif


    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Users</p>
                    <p class="text-3xl font-bold mt-1">{{ $users->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Admin Users</p>
                    <p class="text-3xl font-bold mt-1">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Mahasiswa</p>
                    <p class="text-3xl font-bold mt-1">{{ \App\Models\User::where('role', 'pengguna')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $users->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white font-bold text-base">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <span class="text-xs text-blue-600 font-medium">(You)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->role == 'admin')
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">Admin</span>
                            @elseif($user->role == 'mitra')
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">Mitra</span>
                            @else
                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">Pengguna</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" class="inline-flex items-center px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all text-sm font-medium shadow">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.user-management.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all text-sm font-medium shadow">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                                @else
                                <button disabled class="inline-flex items-center px-3 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm font-medium" title="Cannot delete your own account">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Delete
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-xl font-semibold text-gray-500 mb-2">No users found</p>
                            <p class="text-gray-400">Start by creating your first user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</main>

<div id="userModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-2xl rounded-2xl bg-white my-10">

        <div class="flex justify-between items-center pb-4 border-b">
            <h3 class="text-2xl font-bold text-gray-800">Add New User</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="mt-6">
            <form action="{{ route('admin.user-management.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="mitra">Mitra</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>


                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Create User
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-2xl rounded-2xl bg-white my-10">

        <div class="flex justify-between items-center pb-4 border-b">
            <h3 class="text-2xl font-bold text-gray-800">Edit User</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="mt-6">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>

                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="edit_email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>

                <div class="mb-4">
                    <label for="edit_role" class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                    <select id="edit_role" name="role" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="mitra">Mitra</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit_password" class="block text-sm font-semibold text-gray-700 mb-2">New Password <span class="text-gray-400">(Leave blank to keep current)</span></label>
                    <input type="password" id="edit_password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters if changing</p>
                </div>

                <div class="mb-6">
                    <label for="edit_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" id="edit_password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>


                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Update User
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>

    function openModal() {
        document.getElementById('userModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }


    function openEditModal(id, name, email, role) {
        const form = document.getElementById('editForm');
        form.action = `/admin/user-management/${id}`;

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_password_confirmation').value = '';

        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }


    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });


    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeEditModal();
        }
    });
</script>

@endsection
