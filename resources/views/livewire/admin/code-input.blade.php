<div class="flex min-h-screen items-center justify-center">
    <form wire:submit.prevent="submit" class="p-8 rounded-lg shadow space-y-2">
        <div class="space-y-1">
            <flux:heading size="lg">Přihlášení</flux:heading>
            <flux:input icon="key" wire:model="code" type="password"  />
            @error('code')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <flux:button type="submit" variant="primary" size="sm" class="cursor-pointer">
            Přihlásit se
        </flux:button>
        @if (session()->has('message'))
            <div class="mt-4 text-green-600">{{ session('message') }}</div>
        @endif
    </form>
</div>