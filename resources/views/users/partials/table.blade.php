<div class="overflow-x-auto rounded-lg shadow border border-gray-300 dark:border-gray-700">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
          <div class="flex items-center gap-1">
            Usuario
            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
            </svg>
          </div>
        </th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
          <div class="flex items-center gap-1">
            Rol
            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
            </svg>
          </div>
        </th>
        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
          <div class="flex items-center gap-1">
            Estado
            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
            </svg>
          </div>
        </th>
      </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
      @foreach ($users as $user)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
            {{ $user->usuario }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 space-x-1">
            @foreach ($user->roles as $role)
              <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $role->name }}</span>
            @endforeach
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            @if($user->is_active)
              <span class="inline-flex items-center px-3 py-1 rounded-full text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300 font-semibold">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 13l4 4L19 7"></path>
                </svg>
                Activo
              </span>
            @else
              <span class="inline-flex items-center px-3 py-1 rounded-full text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-300 font-semibold">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Inactivo
              </span>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
