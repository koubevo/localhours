<?php

namespace App\Models;

use App\Enum\HoursStatus;
use Carbon\Carbon;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    /**
     * @use HasFactory<EmployeeFactory>
     */
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'hour_rate',
        'is_hidden',
    ];

    /**
     * @return HasMany<Hour, $this>
     */
    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }

    /**
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function hasHoursToday(): bool
    {
        return $this->hours()->where('work_date', Carbon::today()->toDateString())->exists();
    }

    public function hasDraftHoursToday(): bool
    {
        return $this->hours()
            ->where('work_date', Carbon::today()->toDateString())
            ->where('status', '=', HoursStatus::Draft)
            ->exists();
    }

    public function firstDraftHoursToday(): ?Hour
    {
        return $this->hours()
            ->where('work_date', Carbon::today()->toDateString())
            ->where('status', '=', HoursStatus::Draft)
            ->first();
    }

    /**
     * @return Collection<int, Hour>
     */
    public function todayHours(): Collection
    {
        return $this->hours()->where('work_date', Carbon::today()->toDateString())->get();
    }

    public function debt(): float
    {
        $sumOfPayments = $this->payments()->sum('amount');
        $sumOfEarnings = $this->hours()->sum('earning');

        return $sumOfEarnings - $sumOfPayments;
    }
}
