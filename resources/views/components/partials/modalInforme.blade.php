<!-- Modal -->
<div id="wizard-modal" class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-50 hidden dark:bg-gray-900 dark:bg-opacity-75">
    <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg shadow-lg w-96">
        <!-- Header -->
        <div class="px-6 py-4 border-b dark:border-gray-700">
            <h2 id="modal-title" class="text-xl font-semibold">Selecciona una opción</h2>
        </div>
        <!-- Body -->
        <div id="modal-body" class="px-6 py-4">
            <!-- Paso 1: Opciones -->
            <div id="step-1" class="step">
                <p>¿Qué tipo de informe deseas generar?</p>
                <div class="flex flex-col gap-2 mt-4">
                    <button class="option-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Informe Consolidado</button>
                    <button class="option-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Entregados</button>
                    <button class="option-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Solicitados</button>
                </div>
            </div>
            <!-- Paso 2: Fechas -->
            <div id="step-2" class="step hidden">
                <p>Selecciona el rango de fechas:</p>
                <div class="flex flex-col gap-4 mt-4">
                    <input type="date" id="start-date" class="border-gray-300 dark:border-gray-700 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <input type="date" id="end-date" class="border-gray-300 dark:border-gray-700 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                </div>
                <button id="next-to-step-3" class="bg-green-500 text-white py-2 px-4 rounded mt-4 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700">Siguiente</button>
            </div>
            <!-- Paso 3: Formatos -->
            <div id="step-3" class="step hidden">
                <p>¿En qué formato deseas ver el informe?</p>
                <div class="flex flex-col gap-2 mt-4">
                    <button class="format-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Excel</button>
                    <button class="format-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">PDF</button>
                    <button class="format-btn bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Ver en la Web</button>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t dark:border-gray-700 flex justify-between items-center">
            <button id="back-step" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 hidden">Retroceder</button>
            <button id="close-modal" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">Cerrar</button>
        </div>
    </div>
</div>

<!-- Botón para abrir el modal -->
<button id="open-modal" class=" text-white py-2 px-4">Informe</button>
