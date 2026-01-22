@if($orders && count($orders) > 0)
    <div class="space-y-4">
        <!-- Resumen -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $orders->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Total Órdenes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $orders->where('status', 'pagado')->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Pagadas</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $orders->where('status', 'pendiente')->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Pendientes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($orders->sum('total'), 2) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Total Facturado</div>
                </div>
            </div>
        </div>

        <!-- Lista de órdenes -->
        <div class="overflow-hidden shadow ring-1 ring-black dark:ring-gray-600 ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Clicks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vigencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Creada</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $order->plan->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
                                        'pagado' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                                        'expirado' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if($order->plan)
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $order->clicks_used }} / {{ $order->plan->clicks_limit }}</span>
                                        @php
                                            $remaining = $order->remaining_clicks ?? 0;
                                            $percentage = $order->plan->clicks_limit > 0 ? ($remaining / $order->plan->clicks_limit) * 100 : 0;
                                            $progressColor = $percentage > 50 ? 'bg-green-500' : ($percentage > 20 ? 'bg-yellow-500' : 'bg-red-500');
                                        @endphp
                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2 mt-1">
                                            <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $remaining }} restantes</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                @if($order->start_date && $order->end_date)
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Inicio:</span>
                                        <span class="text-sm">{{ $order->start_date->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Fin:</span>
                                        <span class="text-sm">{{ $order->end_date->format('d/m/Y') }}</span>

                                        @if($order->status === 'pagado')
                                            @php
                                                $daysRemaining = now()->diffInDays($order->end_date, false);
                                                $isExpiring = $daysRemaining <= 7 && $daysRemaining >= 0;
                                                $isExpired = $daysRemaining < 0;
                                            @endphp
                                            @if($isExpired)
                                                <span class="inline-flex items-center px-2 py-1 mt-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 rounded-full">
                                                    Expirado
                                                </span>
                                            @elseif($isExpiring)
                                                <span class="inline-flex items-center px-2 py-1 mt-1 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100 rounded-full">
                                                    {{ ceil($daysRemaining) }} días restantes
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Sin definir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Información adicional -->
        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Información sobre las órdenes</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Las órdenes pagadas muestran el progreso de clicks utilizados</li>
                            <li>Los clicks restantes se calculan automáticamente</li>
                            <li>Las órdenes próximas a vencer se destacan en color naranja</li>
                            <li>Para gestionar órdenes, edita el cliente desde la página principal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4v12.9c0 5.4 3.9 9.8 9.2 10.7l16.3 2.8c5.3.9 9.5-4.7 9.5-10.1V7l-8 4-9-4z"/>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Sin órdenes registradas</h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Este cliente aún no tiene órdenes en el sistema.</p>
        <div class="mt-6">
            <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 dark:bg-blue-700">
                Puedes crear una nueva orden editando el cliente
            </span>
        </div>
    </div>
@endif
