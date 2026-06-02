<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupIdempotencyRecords extends Command
{
    protected $signature = 'idempotency:cleanup {--days=30 : Keep idempotency records for this many days}';

    protected $description = 'Delete stale idempotency records older than the configured retention period.';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $cutoff = Carbon::now()->subDays($days);

        $deleted = DB::table('tbl_api_idempotency')
            ->where('insertdatetime', '<', $cutoff)
            ->delete();

        $this->info("Deleted {$deleted} stale idempotency record(s) older than {$days} day(s).");

        return self::SUCCESS;
    }
}