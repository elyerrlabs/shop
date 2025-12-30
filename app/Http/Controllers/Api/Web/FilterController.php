<?php

namespace Shop\App\Http\Controllers\Api\Web;
 
use App\Http\Controllers\WebController;
use Shop\App\Repositories\AttributeRepository;
use Shop\App\Transformer\User\UserAttributeTransformer;
use Illuminate\Http\Request;

class FilterController extends WebController
{

    private $repository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->repository = $attributeRepository;
    }

    /**
     * List the attributes
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->filled('per_page')) {
            $request->merge(['per_page' => 150]);
        }

        $query = $this->repository->listAttributes();

        return $this->showAll($query, UserAttributeTransformer::class);
    }
}
