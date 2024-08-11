<?php

namespace App\Domains;

use App\Models\Category;
use App\Utils\OperationResult;

class CompanyDomainValidateCategorySlug
{
    public function do(
        int    $companyId,
        string $categorySlug
    )
    {
        $category = Category::query()->firstWhere([
            ['company_id', $companyId],
            ['slug', $categorySlug]
        ]);

        if (is_null($category) === false) {
            return OperationResult::error(
                message: 'Категория с таким названием уже существует'
            );
        }

        return OperationResult::success();
    }
}
