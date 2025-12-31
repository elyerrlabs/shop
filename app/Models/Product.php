<?php

namespace Shop\App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Master
{
    //

    /**
     * Table name
     * @var string
     */
    public $table = "shop_products";

    /**
     * Tag to use in category
     * @var string
     */
    public $tag = "shop_products";

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'specification',
        'featured',
        'published',
        'category_id',
    ];

    /**
     * Property cats
     * @var array
     */

    public $cats = [
        'featured' => 'boolean',
        'published' => 'boolean'
    ];

    /**
     * Get tag
     * @return string
     */
    public static function getTag()
    {
        return (new static())->tag;
    }


    /**
     * @param mixed $value
     * @return void
     */
    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Product, Product, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function parent()
    {
        return $this->belongsToMany(
            static::class,
            'shop_related_products',
            'children_id',
            'parent_id'
        );
    }

    /**
     * Has children
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Product, Product, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function children()
    {
        return $this->belongsToMany(
            static::class,
            'shop_related_products',
            'parent_id',
            'children_id'
        );
    }

    /**
     *
     * @param mixed $value
     * @return void
     */
    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Belongs to category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Product>
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Has many files
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<File, Product>
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Attributes
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<Attribute, Product>
     */
    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }

    /**
     * Summary of tags
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<Tag, Product>
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getAttrCollection(Collection $collection, $transformer = ProductAttributeTransformer::class)
    {
        $result = $collection
            ->groupBy('name')
            ->map(function ($items, $key) {
                return [
                    'name' => $key,
                    'slug' => $items->first()['slug'],
                    'value' => $items->pluck('value')->all(),
                ];
            })
            ->values();

        return fractal(
            $result,
            new $transformer($this)
        )->toArray()['data'] ?? [];
    }

    /**
     *Variant
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function variants()
    {
        return $this->morphMany(Variant::class, 'variantable');
    }
}
