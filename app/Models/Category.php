<?php

namespace Shop\App\Models;

use Shop\App\Models\Product;

class Category extends \App\Models\Common\Category
{
    /**
     * Has products
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Product, Category>
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
