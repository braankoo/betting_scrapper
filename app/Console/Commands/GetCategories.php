<?php

namespace App\Console\Commands;

use App\Models\Bookie;
use Illuminate\Console\Command;

class GetCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch get categories job';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Bookie::each(function ($bookie) {
            dispatch(new \App\Jobs\GetCategories($bookie));
        });

        return Command::SUCCESS;
    }
}
