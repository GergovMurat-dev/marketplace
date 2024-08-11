<?php

namespace App\Domains;

use App\Models\Product;
use App\Utils\OperationResult;

class CompanyDomainValidateProductSku
{
    public function do(
        int $companyId,
        int $sku
    ): OperationResult
    {
        $product = Product::query()->firstWhere([
            ['company_id', $companyId],
            ['sku', $sku],
        ]);

        // Я знаю что можно сделать просто !is_null(), мне нравится такое написание кода
        if (is_null($product) === false) {
            return OperationResult::error(
                message: 'Товар с данным SKU уже существует'
            );
        }

        return OperationResult::success();
    }
}
