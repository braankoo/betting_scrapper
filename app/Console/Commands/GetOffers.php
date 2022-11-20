<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch get offers job';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \App\Models\Bookie::each(function ($bookie) {
            $bookie->categories()->each(function ($category) {
                dispatch(new \App\Jobs\GetOffers($category));
            });
        });
        return Command::SUCCESS;
    }
}
