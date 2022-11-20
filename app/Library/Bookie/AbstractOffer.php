<?php

namespace App\Library\Bookie;

use App\Library\Scrapper\ScrapperInterface;
use App\Models\Category;
use App\Models\Offer;

/**
 *
 */
abstract class AbstractOffer {

    /**
     * @var \App\Library\Scrapper\ScrapperInterface
     */
    protected ScrapperInterface $scrapper;


    /**
     * @var \App\Models\Offer[]
     */
    private array $offers;
    /**
     * @var \App\Models\Category
     */
    protected Category $category;

    /**
     * @return array
     */
    public function getOffers(): array
    {
        return $this->offers;
    }

    /**
     * @param \App\Library\Scrapper\ScrapperInterface $scrapper
     */
    public function __construct(ScrapperInterface $scrapper, Category $category)
    {
        $this->scrapper = $scrapper;
        $this->category = $category;
    }


    /**ß
     * @return $this
     */
    public function __invoke(): static
    {

        $this->offers = array_map(fn($offer) => new Offer($offer), $this->scrape($this->category));
        $this->scrapper->getClient()->quit();

        return $this;
    }

    /**
     * @return array
     */
    abstract protected function scrape(): array;
}
