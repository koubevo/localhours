<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class CodeInput extends Component
{
    public string $code = '';

    public function submit()
    {
        $throttleKey = 'admin-login:'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, $perMinute = 5)) {
            $this->addError('code', 'Příliš mnoho pokusů. Zkuste to za minutu.');

            return;
        }

        if ($this->code === config('admin.admin_code')) {
            session()->put('is_admin', true);

            RateLimiter::clear($throttleKey);

            return redirect()->route('admin.dashboard');
        } else {
            RateLimiter::increment($throttleKey);
            $this->addError('code', 'Neplatný kód');
        }
    }

    public function render()
    {
        return view('livewire.admin.code-input');
    }
}
