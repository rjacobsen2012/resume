<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * started_at is nullable in the schema and nullable in the form requests, but the
 * accessors used to fall straight through to Carbon::parse(), and Carbon::parse(null)
 * is TODAY. A record saved with no start date therefore rendered in the editor as
 * whatever today happened to be, which reads as a date the user never entered.
 */
class NullableStartDateTest extends TestCase
{
    public static function modelsWithStartDates(): array
    {
        return [
            'education' => [Education::class],
            'experience' => [Experience::class],
        ];
    }

    #[DataProvider('modelsWithStartDates')]
    public function test_a_missing_start_date_stays_empty_instead_of_becoming_today(string $model): void
    {
        $record = new $model(['started_at' => null]);

        $this->assertNull($record->started_at);
        $this->assertNotSame(now()->format('Y-m-d'), $record->started_at);
    }

    #[DataProvider('modelsWithStartDates')]
    public function test_a_real_start_date_is_still_formatted_for_the_date_input(string $model): void
    {
        $record = new $model(['started_at' => '2004-08-01']);

        $this->assertSame('2004-08-01', $record->started_at);
    }

    #[DataProvider('modelsWithStartDates')]
    public function test_a_missing_end_date_stays_empty(string $model): void
    {
        $record = new $model(['ended_at' => null]);

        $this->assertNull($record->ended_at);
    }
}
