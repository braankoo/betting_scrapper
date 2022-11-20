<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

    use HasFactory;

    protected $fillable = [ 'time', 'first', 'second', 'final_1', 'final_2', 'draw', 'category_id' ];
}
