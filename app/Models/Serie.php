<?php

namespace Shop\App\Models;
 
class Serie extends Master
{
    /**
     * Table name
     * @var string
     */
    protected $table = "series";

    /**
     * Fillable
     * @var array
     */
    protected $fillable = [
        'code',
        'status'
    ];

    /**
     * Properties cats
     * @var array
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Product, Serie>
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
