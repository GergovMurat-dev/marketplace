<?php

namespace App\Domains;

use App\DTO\Product\ProductCreateDTO;
use App\Models\Product;
use App\Utils\OperationResult;
use Psr\Log\LoggerInterface;

class CompanyDomainCreateProduct
{

    public function __construct(
        private readonly LoggerInterface                 $logger,
        private readonly CompanyDomainValidateProductSku $validateProductSku,
    )
    {
    }

    public function do(
        ProductCreateDTO $productCreateDTO
    ): OperationResult
    {
        try {
            $productSkuValidateOperationResult = $this->validateProductSku->do(
                companyId: $productCreateDTO->companyId,
                sku: $productCreateDTO->sku,
            );
            if ($productSkuValidateOperationResult->isError) {
                return $productSkuValidateOperationResult;
            }

            $product = Product::create($productCreateDTO->toArrayAsSnakeCase());
            if (is_null($product)) {
                return OperationResult::error(
                    message: 'При создании товара возникла ошибка, проверьте входящие данные'
                );
            }

            return OperationResult::success(
                $product
            );
        } catch (\Exception $e) {
            $this->logger->error(
                $e->getMessage()
            );
            return OperationResult::error(
                message: 'Произошла непредвиденная ошибка'
            );
        }
    }
}
