<?php

namespace Shop\App\Models;

use Shop\App\Models\Product;

class Attribute extends \App\Models\Common\Attribute
{
    /**
     * Products
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<Product, Attribute>
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'attributable');
    }
}
