<?php

namespace Shop\App\Http\Requests\Product;

use App\Rules\BooleanRule;
use Shop\App\Models\Product;
use Illuminate\Support\Str;
use App\Rules\UndefinedValues;
use Illuminate\Validation\Rule;
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
            'name' => [
                'required',
                'max:150',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    $currentId = $this->input('id');
                    $searchSlug = Product::where('slug', $slug)->first();

                    if ($searchSlug) {
                        if ($currentId) {
                            $owner = Product::find($currentId);

                            if (
                                $owner &&
                                $searchSlug->id !== $owner->id &&
                                $searchSlug->tag !== $owner->tag
                            ) {
                                $fail(__("The name has already been registered in another context."));
                            }
                        } else {

                            $fail(__("The name has already been registered."));
                        }
                    }
                },
                new UndefinedValues()
            ],
            'short_description' => ['required', new UndefinedValues(), 'min:0', 'max:1000',],
            'description' => ['required', new UndefinedValues()],
            'category' => ['required', new UndefinedValues(), 'exists:categories,id', 'max:100',],
            'images' => [
                Rule::requiredIf(function () {
                    return !$this->filled('id');
                }),
                'array',
                'max:5'
            ],
            'images.*' => ['image', 'mimes:webp,jpg,jpeg,bmp,png', 'max:2048'],
            'attributes' => ['required', 'array'],
            'attributes.*.name' => ['required', new UndefinedValues(), 'max:100', 'min:1'],
            'attributes.*.type' => ['required', new UndefinedValues(), 'in:string,number,boolean,date'],
            'attributes.*.value' => ['required', new UndefinedValues(), 'max:100', 'min:1'],
            'attributes.*.widget' => ['required', new UndefinedValues(), 'max:100', 'min:1'],
            'attributes.*.multiple' => ['required', new UndefinedValues(), new BooleanRule()],
            'variants' => ['array', 'required'],
            'variants.*.name' => ['string', 'required', 'max:150'],
            'variants.*.stock' => ['required', 'integer', 'min:0'],
            'variants.*.price' => ['required', 'integer', 'min:1'],
            'variants.*.currency' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (empty(billing_get_currency($value))) {
                        $fail(__("The currency is invalid"));
                    }
                }
            ],
            'variants.*.description' => ['required', 'max:800'],
            'children_id' => ['nullable', 'array']
        ];
    }
}
