
<table id="filter-table">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    Usuario
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Rol
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Estado
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300">{{ $user->usuario }}</td>
                <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300">
                    @foreach ($user->roles as $role)
                        <span>{{ $role->name }}</span>
                    @endforeach
                </td>
                <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300">
                    <!-- Mostrar si el usuario está activo o no -->
                    @if($user->is_active)
                        <span class="text-green-500">Activo</span>
                    @else
                        <span class="text-red-500">Inactivo</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
