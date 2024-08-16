<?php

namespace App\UseCases\Commands;

use App\Domains\CompanyDomainCreateProduct;
use App\DTO\Product\ProductCreateDTO;
use App\Models\Product;
use App\Utils\OperationResult;
use Illuminate\Support\Facades\Validator;

class CompanyCommandAddProduct
{

    public function __construct(
        private readonly CompanyDomainCreateProduct $createProduct
    )
    {
    }

    public function handle(array $data): OperationResult
    {
        $v = Validator::make(
            $data,
            [
                'name' => ['required', 'string'],
                'sku' => ['required', 'string'],
                'description' => ['nullable', 'string'],
                'shortDescription' => ['nullable', 'string'],
                'price' => ['nullable', 'numeric'],
                'oldPrice' => ['nullable', 'numeric'],
                'companyId' => ['nullable', 'exists:companies,id']
            ]
        );

        if ($v->fails()) {
            return OperationResult::error(
                message: __('messages.incorrect_data'),
                errors: $v->errors()->toArray()
            );
        }

        $productCreateDTO = ProductCreateDTO::make($data);

        $createProductOperationResult = $this->createProduct->do(
            $productCreateDTO
        );
        if ($createProductOperationResult->isError) {
            return $createProductOperationResult;
        }

        /** @var Product $product */
        $product = $createProductOperationResult->data;

        return OperationResult::success(
            $product
        );
    }
}
