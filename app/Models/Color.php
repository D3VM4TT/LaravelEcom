<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Color extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'code'];

    /**
     * Get the products that are associated with the color.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductColor::class, 'product_colors', 'color_id', 'product_id');
    }
}
