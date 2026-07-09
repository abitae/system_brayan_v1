<?php
namespace App\Traits;

use Carbon\Carbon;

trait UtilsTrait
{
    function dateNow(String $format)
    {
       return now()->setTimezone('America/Lima')->format($format);
    }

    function filterDateStart(): string
    {
        return now()->setTimezone('America/Lima')->startOfDay()->format('Y-m-d\TH:i');
    }

    function filterDateEnd(): string
    {
        return now()->setTimezone('America/Lima')->endOfDay()->format('Y-m-d\TH:i');
    }

    function filterDateStartOfMonth(): string
    {
        return now()->setTimezone('America/Lima')->startOfMonth()->format('Y-m-d\TH:i');
    }

    function parseFilterDateStart(string $value): Carbon
    {
        return Carbon::parse($value, 'America/Lima')->startOfDay();
    }

    function parseFilterDateEnd(string $value): Carbon
    {
        return Carbon::parse($value, 'America/Lima')->endOfDay();
    }

    function ensureDateRangeOrder(?string &$start, ?string &$end): void
    {
        if (!$start || !$end) {
            return;
        }

        $ini = Carbon::parse($start, 'America/Lima');
        $fin = Carbon::parse($end, 'America/Lima');

        if ($ini->gt($fin)) {
            $end = $ini->copy()->endOfDay()->format('Y-m-d\TH:i');
        }
    }
}
