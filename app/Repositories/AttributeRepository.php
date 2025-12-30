<?php

namespace Shop\App\Repositories;

use Shop\App\Models\Attribute;

class AttributeRepository
{

    private $model;

    public function __construct(Attribute $attribute)
    {
        $this->model = $attribute;
    }

    /**
     * List the attributes
     * @return \Illuminate\Database\Eloquent\Collection 
     */
    public function listAttributes()
    {
        $attributes = $this->model->query()
            ->whereHas('products')
            ->get();

        $grouped = $attributes->groupBy(function ($item) {
            return $item->name . '|' . ($item->multiple ? '1' : '0');
        })->map(function ($items, $key) {
            $first = $items->first();

            return [
                "name" => ucfirst($first->name),
                "slug" => $first->slug,
                "type" => $first->type,
                "widget" => $first->widget,
                "multiple" => $first->multiple,
                "unit_id" => $first->unit_id,
                "values" => $items->pluck('value')->unique()->values()->all()
            ];
        })->values();

        return $grouped;
    }

}

