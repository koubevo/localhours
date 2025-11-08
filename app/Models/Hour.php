<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\HourFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hour extends Model
{
    /**
     * @use HasFactory<HourFactory>
     */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'work_date',
        'start_time',
        'end_time',
        'earning',
        'description',
        'status',
    ];

    /**
     * @var list<string>
     */
    protected $appends = ['formatted_work_date'];

    /**
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getStartTimeAttribute(string $value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getEndTimeAttribute(?string $value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getFormattedWorkDateAttribute(): ?string
    {
        return $this->work_date ? Carbon::parse($this->work_date)->format('d.m.y') : null;
    }

    public function getFormattedDeletedAtAttribute(): ?string
    {
        return $this->deleted_at ? Carbon::parse($this->deleted_at)->format('d.m.y H:i') : null;
    }
}
