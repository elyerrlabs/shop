<?php

namespace Shop\App\Http\Requests\Order;

use Shop\App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'variant_id' => ['required', 'exists:variants,id'],
            'quantity' => [
                'required',
                'min:1',
                'integer',
                function ($attribute, $value, $fail) {
                    $variant = \App\Models\Common\Variant::find($this->variant_id);
                    if ($variant && $value > $variant->stock) {
                        $fail(__("The requested quantity (:requested) exceeds the available stock (:stock).", [
                            'requested' => $value,
                            'stock' => $variant->stock,
                        ]));
                    }
                }
            ],
        ];
    }
}
