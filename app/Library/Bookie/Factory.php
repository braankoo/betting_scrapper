<?php

namespace App\Library\Bookie;

use App\Models\Bookie;
use App\Library\Scrapper\Phanter;
use App\Models\Category;

class Factory {

    /**
     * @param Bookie $bookie
     * @return \App\Library\Bookie\AbstractCategory
     * @throws \Exception
     */
    public static function category(Bookie $bookie): AbstractCategory
    {
        return match ($bookie->name)
        {
            'meridian' => new \App\Library\Bookie\Meridian\Categories(Phanter::getInstance(), $bookie),
            default => throw new \Exception('Bookie not supported'),
        };
    }

    /**
     * @param \App\Models\Category $category
     * @return \App\Library\Bookie\AbstractOffer
     */
    public static function offer(Category $category): AbstractOffer
    {
        switch ( $category->bookie->name )
        {
            case 'meridian':
                return new \App\Library\Bookie\Meridian\Offer(Phanter::getInstance(), $category);
            default:
                break;
        }
    }

}
