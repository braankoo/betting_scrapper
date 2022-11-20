<?php

namespace App\Library\Bookie;

use App\Library\Scrapper\ScrapperInterface;
use App\Models\Bookie;
use App\Models\Category;

/**
 *
 */
abstract class AbstractCategory {

    /**
     * @var \App\Models\Category[]
     */
    protected array $categories;
    /**
     * @var \App\Library\Scrapper\ScrapperInterface
     */
    protected ScrapperInterface $scrapper;
    protected Bookie $bookie;

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param \App\Models\Category[] $categories
     * @return void
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return \App\Library\Scrapper\ScrapperInterface
     */
    protected function getScrapper(): ScrapperInterface
    {
        return $this->scrapper;
    }

    /**
     * @param \App\Library\Scrapper\ScrapperInterface $scrapper
     */
    public function __construct(ScrapperInterface $scrapper, Bookie $bookie)
    {
        $this->scrapper = $scrapper;
        $this->bookie = $bookie;
    }


    /**
     * @return $this
     */
    public function __invoke(): static
    {
        $this->setCategories(array_map(fn($category) => new Category($category), $this->scrape($this->bookie)));
        $this->scrapper->getClient()->quit();
        return $this;
    }

    /**
     * @return array
     */
    abstract protected function scrape(): array;

}
