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
                                    <x-filament::badge :color="\App\Filament\Widgets\LatestLeads::statusColor($lead['status'])">
                                        {{ ucfirst($lead['status']) }}
                                    </x-filament::badge>
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
    </x-filament::section>
</x-filament-widgets::widget>
