<?php

namespace Shop\App\Models;

use Shop\App\Models\Product;

class Tag extends \App\Models\Common\Tag
{

    /**
     * Products
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<Product, Tag>
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
