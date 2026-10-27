<?php

namespace App\Support;

use App\Models\SkillPeriod;
use Illuminate\Support\Carbon;

/**
 * How long a skill has actually been in use, across however many stretches.
 *
 * ⚠️ OVERLAPPING PERIODS ARE MERGED, NOT ADDED. Recording 2010-2016 and 2014-2018
 * is eight years of using the skill, not twelve.
 *
 * ⚠️ MONTHS ARE COUNTED BY THE CALENDAR, NOT BY DIVIDING DAYS. An exact 17 year
 * span is 6208 days, and 6208 / 365.25 is 16.99, which floors to 16. Measured
 * against the real data on 2026-10-27: 14 of 25 skills came out a year short that
 * way. Carbon knows how long a year actually was; arithmetic on an average does not.
 */
class SkillDuration
{
    /**
     * Total time in whole calendar months, and the leftover days, with overlapping
     * periods merged.
     *
     * @param  iterable<SkillPeriod>  $periods
     * @return array{months: int, days: int}
     */
    public static function totals(iterable $periods): array
    {
        $ranges = [];

        foreach ($periods as $period) {
            // `started_on` is cast to a date, so it is already a Carbon here.
            $start = $period->started_on->copy()->startOfDay();

            $end = $period->endsOn()->copy()->startOfDay();

            // A period that ends before it starts is bad data, not negative time.
            if ($end->lessThan($start)) {
                continue;
            }

            $ranges[] = [$start, $end];
        }

        if ($ranges === []) {
            return ['months' => 0, 'days' => 0];
        }

        usort($ranges, fn (array $a, array $b) => $a[0] <=> $b[0]);

        $months = 0;
        $days = 0;
        [$currentStart, $currentEnd] = $ranges[0];

        $flush = function () use (&$months, &$days, &$currentStart, &$currentEnd): void {
            $wholeMonths = (int) $currentStart->diffInMonths($currentEnd);
            $months += $wholeMonths;
            $days += (int) $currentStart->copy()->addMonths($wholeMonths)->diffInDays($currentEnd);
        };

        foreach (array_slice($ranges, 1) as [$start, $end]) {
            if ($start->lessThanOrEqualTo($currentEnd)) {
                // overlapping or touching: extend rather than count twice
                if ($end->greaterThan($currentEnd)) {
                    $currentEnd = $end;
                }

                continue;
            }

            $flush();
            [$currentStart, $currentEnd] = [$start, $end];
        }

        $flush();

        return ['months' => $months, 'days' => $days];
    }

    /**
     * The short label on the pill: 12d, 7m, 23y. Empty when there is no time
     * recorded at all, so the pill shows just the skill name as it always did.
     *
     * @param  array{months: int, days: int}  $totals
     */
    public static function label(array $totals): string
    {
        $months = $totals['months'];

        if ($months >= 12) {
            return intdiv($months, 12).'y';
        }

        if ($months >= 1) {
            return $months.'m';
        }

        return $totals['days'] > 0 ? $totals['days'].'d' : '';
    }
}
