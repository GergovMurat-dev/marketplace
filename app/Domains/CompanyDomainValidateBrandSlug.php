<?php

namespace App\Domains;

use App\Models\Brand;
use App\Utils\OperationResult;

class CompanyDomainValidateBrandSlug
{
    public function do(
        int    $companyId,
        string $brandSlug
    ): OperationResult
    {
        $brand = Brand::query()->firstWhere([
            ['company_id', $companyId],
            ['slug', $brandSlug]
        ]);

        if (is_null($brand) === false) {
            return OperationResult::error(
                message: 'Бренд с таким названием уже существует'
            );
        }

        return OperationResult::success();
    }
}
