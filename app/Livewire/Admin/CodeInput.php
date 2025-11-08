<?php

namespace App\Livewire\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CodeInput extends Component
{
    public string $code = '';

    public function submit(): RedirectResponse|Redirector|null
    {
        $throttleKey = 'admin-login:'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, $perMinute = 5)) {
            $this->addError('code', 'Příliš mnoho pokusů. Zkuste to za minutu.');

            return null;
        }

        if ($this->code === config('admin.admin_code')) {
            session()->put('is_admin', true);

            RateLimiter::clear($throttleKey);

            return redirect()->route('admin.dashboard');
        } else {
            RateLimiter::increment($throttleKey);
            $this->addError('code', 'Neplatný kód');

            return null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.code-input');
    }
}
