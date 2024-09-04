<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unprocessed orders if over 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            $orderId = DB::table('orders')
                ->where('status', 'new')
                ->where('created_at', '<', now()->subHours(24))
                ->pluck('id');

            if ($orderId->isNotEmpty()) {
                DB::table('order_items')->whereIn('order_id', $orderId)->delete();
                DB::table('orders')->whereIn('id', $orderId)->delete();
                Log::info('Delete unprocessed orders if over 24 hours successfully');
            }
        });
    }
}
