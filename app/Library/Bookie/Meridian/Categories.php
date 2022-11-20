<?php

namespace App\Library\Bookie\Meridian;

use App\Library\Bookie\AbstractCategory;
use App\Models\Bookie;

/**
 *
 */
class Categories extends AbstractCategory {

    /**
     * @return array
     */
    protected function scrape(): array
    {
        $this->getScrapper()->getClient()->request('GET', $this->bookie->url);
        $crawler = $this->getScrapper()->getClient()->waitFor('#sidebar', 300);
        $menu = $crawler->filter('#sidebar .sidebar-wrapper .category.single');
        return $menu->each(function ($item) {
            $categoryNode = $item->filter('a.link')->first();
            $url = $categoryNode->getAttribute('href');
            $name = $categoryNode->filter('.name-count > .name')->getText();

            return [
                'name'      => strtolower($name),
                'url'       => 'https://meridianbet.rs' . $url,
                'bookie_id' => $this->bookie->id
            ];
        });
    }

}
