<x-filament-panels::page>
    <div class="mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800">Reporte de Autorizaciones de Privacidad</h3>
                    <p class="text-sm text-blue-700 mt-1">
                        Este reporte muestra el estado de las autorizaciones de privacidad y compartir datos de todos los candidatos registrados.
                        Útil para auditorías y cumplimiento de LGPD.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $stats = \App\Models\Candidate::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN autorizacion_datos_compartidos = 1 THEN 1 ELSE 0 END) as datos_autorizados,
                SUM(CASE WHEN aviso_privacidad2_aceptado = 1 THEN 1 ELSE 0 END) as aviso_aceptado,
                SUM(CASE WHEN autorizacion_datos_compartidos = 1 AND aviso_privacidad2_aceptado = 1 THEN 1 ELSE 0 END) as completos
            ')->first();
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $stats->total }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Total Candidatos</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                {{ $stats->datos_autorizados }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Datos Autorizados</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                {{ $stats->aviso_aceptado }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Aviso Aceptado</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                {{ $stats->completos }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Estado Completo</div>
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
