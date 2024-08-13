<?php

namespace App\UseCases\Commands;

use App\Domains\CompanyDomainCreateBrand;
use App\DTO\Brand\BrandCreateDTO;
use App\Models\Brand;
use App\Utils\OperationResult;
use Illuminate\Support\Facades\Validator;

class CompanyCommandAddBrand
{
    public function __construct(
        private readonly CompanyDomainCreateBrand $createBrand
    )
    {
    }

    public function handle(array $data): OperationResult
    {
        $v = Validator::make(
            $data,
            [
                'name' => ['required', 'string'],
                'slug' => ['required', 'string'],
                'companyId' => ['required', 'integer', 'exists:companies,id'],
            ]
        );

        if ($v->fails()) {
            return OperationResult::error(
                message: 'Введены не корректные данные',
                errors: $v->errors()->toArray()
            );
        }

        $brandCreateDTO = BrandCreateDTO::make($data);

        $createBrandOperationResult = $this->createBrand->do(
            $brandCreateDTO
        );
        if ($createBrandOperationResult->isError) {
            return $createBrandOperationResult;
        }

        /** @var Brand $brand */
        $brand = $createBrandOperationResult->data;

        return OperationResult::success(
            $brand
        );
    }
}
