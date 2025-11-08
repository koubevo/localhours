<form wire:submit.prevent="save">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-2/3 space-y-4">
            <div>
                <flux:field>
                    <flux:label>
                        Zaměstnanec *
                    </flux:label>

                    <flux:select wire:model.live="employee" :disabled="$isEditMode">
                        <flux:select.option value="0" disabled>Zaměstnanec</flux:select.option>
                        @foreach ($employees as $emp)
                            <flux:select.option id="{{ $emp->id }}" value="{{ $emp->id }}">
                                {{ $emp->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </div>
            <div>
                <flux:field>
                    <flux:label>Datum platby *</flux:label>

                    <flux:input id="payment_date" type="date" wire:model="payment_date" />

                    <flux:error name="payment_date" />
                </flux:field>
            </div>
            <div>
                <flux:field>
                    <flux:label>Částka (Kč) *</flux:label>
                    <flux:input.group>
                        <flux:input id="amount" type="number" step="0.01" wire:model.live="amount" />
                        <flux:input.group.suffix>Kč</flux:input.group.suffix>
                    </flux:input.group>
                    <flux:error name="amount" />
                </flux:field>
            </div>
        </div>
        @php
            $selectedEmployee = $employees->firstWhere('id', $employee);
            $currentDebt = $selectedEmployee ? $selectedEmployee->debt() : 0;
            $newDebt = $currentDebt - $amount;
        @endphp
        <div class="w-full md:w-1/3 self-start md:mt-6">
            <x-card>
                <flux:text class="mb-1">Původní dluh</flux:text>
                <flux:heading size="xl">
                    {{ $currentDebt }} Kč
                </flux:heading>

                <flux:text class="mb-1">Nový dluh</flux:text>
                <flux:heading size="xl">
                    {{ $newDebt }} Kč
                </flux:heading>
            </x-card>
        </div>
    </div>


    <flux:text class="mt-2">* Povinné pole</flux:text>

    <flux:button class="cursor-pointer mt-2" type="submit" variant="primary">
        {{ $isEditMode ? 'Uložit změny' : 'Přidat' }}
    </flux:button>
</form>