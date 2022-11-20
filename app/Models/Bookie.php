<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookie extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }
}
