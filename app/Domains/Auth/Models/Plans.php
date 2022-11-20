<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Role.
 */
class Plans extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable=[
        "meta_title",
        "meta_description",
        "price",
        "status",
        "type"
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
}
