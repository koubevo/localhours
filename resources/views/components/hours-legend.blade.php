@props(['rowOnly' => false])
<x-card>
    <div @class([
        'flex',
        'justify-center',
        'px-2',
        'gap-x-6',
        'flex-row',
        'md:flex-col' => !$rowOnly,
    ])>
        <div class="flex items-center">
            <flux:badge class="me-2 mt-0.5 opacity-70" size="sm"
                style="padding: 4px !important; background-color: #16a34a;">
            </flux:badge>
            <flux:text>Vyplněno</flux:text>
        </div>
        <div class="flex items-center">
            <flux:badge class="me-2 mt-0.5 opacity-70" size="sm"
                style="padding: 4px !important; background-color: #f59e0b;">
            </flux:badge>
            <flux:text>Rozděláno</flux:text>
        </div>
        <div class="flex items-center">
            <flux:badge class="me-2 mt-0.5 opacity-70" size="sm"
                style="padding: 4px !important; background-color: #ef4444;">
            </flux:badge>
            <flux:text>Nevyplněno</flux:text>
        </div>
    </div>
</x-card>