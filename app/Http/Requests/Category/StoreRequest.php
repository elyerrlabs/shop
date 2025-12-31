<?php

namespace Shop\App\Http\Requests\Category; 

use App\Rules\BooleanRule;
use Illuminate\Support\Str;
use App\Rules\UndefinedValues;
use App\Models\Common\Category;
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
                    $searchSlug = Category::where('slug', $slug)->first();

                    if ($searchSlug) {
                        if ($currentId) {
                            $owner = Category::find($currentId);

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
                new UndefinedValues(),
            ],

            'description' => ['required', 'max:1500', new UndefinedValues()],
            /*'icon' => [
                Rule::requiredIf(function () {
                    return !$this->filled('id');
                }),
                'max:100',
                new UndefinedValues()
            ],*/
            'featured' => ['nullable', new BooleanRule()],
            'published' => ['nullable', new BooleanRule()],
            'images' => [
                Rule::requiredIf(function () {
                    return !$this->filled('id');
                }),
                'array',
                'max:5'
            ],
            'images.*' => ['image', 'mimes:webp,jpg,jpeg,bmp,png', 'max:2048'],
            'parent_id' => ['nullable']
        ];
    }
}
