<?php

namespace App\Console\Commands;

use App\Models\Rent;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckContracts extends Command
{

    protected $signature = 'app:check-contracts';

    protected $description = 'Check expired contracts and mark them as complete';

    public function handle()
    {
        $rents = Rent::where('status', '!=', 'completed')
            ->where('endRent', '<=', Carbon::now())
            ->get();

        if ($rents->isEmpty()) {
            $this->info('No expired contracts found.');
            return Command::SUCCESS;
        }

        foreach ($rents as $rent) {
            $this->info("Completing Rent ID: {$rent->id} | End: {$rent->endRent}");

            $rent->update([
                'status' => 'completed'
            ]);
        }

        $this->info('Total contracts updated: ' . $rents->count());

        return Command::SUCCESS;
    }
}
