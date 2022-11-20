<?php

namespace App\Library\Bookie\Meridian;

use App\Library\Bookie\AbstractOffer;
use App\Models\Category;

/**
 *
 */
class Offer extends AbstractOffer {

    /**
     * @return array
     */
    protected function scrape(): array
    {
        $this->scrapper->getClient()->request('GET', $this->category->url);
        $crawler = $this->scrapper->getClient()->waitFor('#events', 120);
        do
        {
            $numberOfEvents = $crawler->filter('.event')->count();
            $this->scrapper->getClient()->executeScript("document.querySelector('#page-wrapper').scroll(1000,100000000)");
            $startTime = microtime(true);
            $this->scrapper->getClient()->wait(60)->until(function () use ($crawler, $numberOfEvents, $startTime) {
                return $crawler->filter('.event')->count() > $numberOfEvents || abs($startTime - microtime(true)) > 55;
            });
        } while ( $crawler->filter('.event')->count() > $numberOfEvents );

        $this->scrapper->getClient()->refreshCrawler();

        return $this->extractOfferData($crawler, $this->category);
    }

    /**
     * @param $crawler
     * @param \App\Models\Category $category
     * @return array
     */
    private function extractOfferData($crawler, Category $category): array
    {
        return $crawler->filter('#events .event')->each(function ($node) use ($category) {

            $first = ucwords(strtolower($node->filter('.details .home')->first()->getText()));
            $second = ucwords(strtolower($node->filter('.details .away')->first()->getText()));
            $results = $node->filter('.games .game:first-child .ng-star-inserted div');

            if (!$results->count())
            {
                return [
                    'time'        => 'N/A',
                    'first'       => 'N/A',
                    'second'      => 'N/A',
                    'final_1'     => 'N/A',
                    'final_2'     => 'N/A',
                    'draw'        => 'N/A',
                    'category_id' => $category->id
                ];
            }

            $time = $node->filter('.time')->first()->getText();
            $date = $node->filter('.date')->first()->getText();

            $time .= ' ' . $date;

            $final_1 = null;
            if ($results->eq(0))
            {
                $final_1 = $results->eq(0)->getText(true);
            }
            $draw = null;
            if ($results->eq(1)->count())
            {
                $draw = $results->eq(1)->getText(true);
            }

            $final_2 = null;
            if ($results->eq(2)->count())
            {
                $final_2 = $results->eq(2)->getText(true);
            }

            return [
                'time'        => $time,
                'first'       => $first,
                'second'      => $second,
                'final_1'     => $final_1,
                'final_2'     => $final_2,
                'draw'        => $draw,
                'category_id' => $category->id
            ];
        });
    }
}
