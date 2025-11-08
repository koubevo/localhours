<?php

namespace App\Support;

use Carbon\Carbon;

class HoursCalculator
{
    public static function calculateMinutesBetween(string $startTimeHhMm, string $endTimeHhMm): ?float
    {
        $start = Carbon::createFromFormat('H:i', $startTimeHhMm);
        $end = Carbon::createFromFormat('H:i', $endTimeHhMm);

        if (! isset($start) || ! isset($end)) {
            return null;
        }

        if ($end->equalTo($start)) {
            return 1440;
        }

        if ($end->lessThan($start)) {
            $end->addDay();
        }

        return round($start->diffInMinutes($end));
    }

    public static function calculateEarning(string $startTimeHhMm, string $endTimeHhMm, int $hourRate): int
    {
        $minutes = self::calculateMinutesBetween($startTimeHhMm, $endTimeHhMm);

        return (int) round(($minutes / 60) * $hourRate);
    }

    public static function calculateEarningByMinutes(int $minutes, int $hourRate): int
    {
        return (int) round(($minutes / 60) * $hourRate);
    }
}
