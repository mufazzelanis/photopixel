<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Latest leads</x-slot>
        <x-slot name="description">Newest quote, contact and free-trial submissions</x-slot>

        @php($leads = $this->getLeads())

        @if (empty($leads))
            <p class="text-sm text-gray-500 dark:text-gray-400">No leads yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-400 dark:border-white/10">
                            <th class="py-2 pr-3 font-medium">Type</th>
                            <th class="py-2 pr-3 font-medium">Name</th>
                            <th class="py-2 pr-3 font-medium">Contact</th>
                            <th class="py-2 pr-3 font-medium">Detail</th>
                            <th class="py-2 pr-3 font-medium">When</th>
                            <th class="py-2 pr-3 font-medium">Status</th>
                            <th class="py-2 pr-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($leads as $lead)
                            <tr class="align-top">
                                <td class="py-3 pr-3">
                                    <x-filament::badge :color="$lead['color']">{{ $lead['type'] }}</x-filament::badge>
                                </td>
                                <td class="py-3 pr-3 font-medium text-gray-900 dark:text-white">
                                    {{ $lead['name'] ?: '—' }}
                                </td>
                                <td class="py-3 pr-3 text-gray-500 dark:text-gray-400">
                                    <div>{{ $lead['email'] ?: '—' }}</div>
                                    @if ($lead['phone'])
                                        <div class="text-xs">{{ $lead['phone'] }}</div>
                                    @endif
                                </td>
                                <td class="py-3 pr-3 max-w-xs text-gray-500 dark:text-gray-400">
                                    {{ $lead['detail'] }}
                                </td>
                                <td class="py-3 pr-3 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    {{ $lead['at']?->diffForHumans() }}
                                </td>
                                <td class="py-3 pr-3">
                                    <select
                                        wire:change="setStatus('{{ $lead['kind'] }}', {{ $lead['id'] }}, $event.target.value)"
                                        wire:loading.attr="disabled"
                                        wire:key="status-{{ $lead['kind'] }}-{{ $lead['id'] }}"
                                        class="ll-status ll-status--{{ \App\Filament\Widgets\LatestLeads::statusColor($lead['status']) }}"
                                    >
                                        @foreach ($lead['statuses'] as $s)
                                            <option value="{{ $s }}" @selected($s === $lead['status'])>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-3 pr-3 text-right">
                                    <x-filament::button tag="a" :href="$lead['url']" size="xs" color="gray" icon="heroicon-m-arrow-top-right-on-square">
                                        Open
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <style>
            .ll-status {
                appearance: none;
                -webkit-appearance: none;
                border: 1px solid transparent;
                border-radius: 9999px;
                padding: .2rem 1.6rem .2rem .6rem;
                font-size: .75rem;
                font-weight: 600;
                line-height: 1;
                cursor: pointer;
                background-repeat: no-repeat;
                background-position: right .45rem center;
                background-size: .7rem;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E");
                transition: filter .12s ease;
            }
            .ll-status:hover { filter: brightness(0.97); }
            .ll-status:focus { outline: 2px solid rgb(99 102 241 / .5); outline-offset: 1px; }
            .ll-status:disabled { opacity: .5; cursor: wait; }

            .ll-status--warning { background-color: #fef3c7; color: #92400e; border-color: #fde68a; }
            .ll-status--success { background-color: #dcfce7; color: #166534; border-color: #bbf7d0; }
            .ll-status--danger  { background-color: #fee2e2; color: #991b1b; border-color: #fecaca; }
            .ll-status--gray    { background-color: #f3f4f6; color: #374151; border-color: #e5e7eb; }

            .dark .ll-status--warning { background-color: rgb(120 53 15 / .35); color: #fcd34d; border-color: rgb(180 83 9 / .4); }
            .dark .ll-status--success { background-color: rgb(20 83 45 / .35); color: #86efac; border-color: rgb(21 128 61 / .4); }
            .dark .ll-status--danger  { background-color: rgb(127 29 29 / .35); color: #fca5a5; border-color: rgb(185 28 28 / .4); }
            .dark .ll-status--gray    { background-color: rgb(63 63 70 / .5); color: #d4d4d8; border-color: rgb(82 82 91 / .5); }
            .dark .ll-status option { color: #18181b; }
        </style>
    </x-filament::section>
</x-filament-widgets::widget>
