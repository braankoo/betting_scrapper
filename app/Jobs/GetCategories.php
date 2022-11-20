<?php

namespace App\Jobs;

use App\Library\Bookie\Factory;
use App\Models\Bookie;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetCategories implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Bookie
     */
    private Bookie $bookie;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bookie $bookie)
    {
        $this->bookie = $bookie;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        $categories = Factory::category($this->bookie)()->getCategories();
        Category::upsert(
            array_map(fn($category) => $category->toArray(), $categories),
            [ 'name' ], [ 'url' ]
        );
    }
}
