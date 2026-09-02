<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex flex-wrap gap-3">
            @foreach ($this->getFormActions() as $action)
                {{ $action }}
            @endforeach
        </div>
    </form>

    <x-filament::section class="mt-8" collapsible collapsed>
        <x-slot name="heading">Live preview</x-slot>
        <x-slot name="description">
            The React site running at
            <code>{{ $this->getPreviewUrl() }}</code>.
            Save &amp; activate a preset, then refresh this frame.
        </x-slot>

        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
            <iframe
                src="{{ $this->getPreviewUrl() }}"
                class="h-[70vh] w-full"
                loading="lazy"
                title="Front-of-site preview"
            ></iframe>
        </div>
    </x-filament::section>
</x-filament-panels::page>
