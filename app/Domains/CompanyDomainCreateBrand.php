<?php

namespace App\Domains;

use App\DTO\Brand\BrandCreateDTO;
use App\Models\Brand;
use App\Utils\OperationResult;
use Psr\Log\LoggerInterface;

class CompanyDomainCreateBrand
{

    public function __construct(
        private readonly LoggerInterface                $logger,
        private readonly CompanyDomainValidateBrandSlug $validateBrandSlug
    )
    {
    }

    public function do(
        BrandCreateDTO $brandCreateDTO
    ): OperationResult
    {
        try {
            $brandSlugValidateOperationResult = $this->validateBrandSlug->do(
                companyId: $brandCreateDTO->companyId,
                brandSlug: $brandCreateDTO->slug
            );
            if ($brandSlugValidateOperationResult->isError) {
                return $brandSlugValidateOperationResult;
            }

            $brand = Brand::create($brandCreateDTO->toArrayAsSnakeCase());

            if (is_null($brand)) {
                return OperationResult::error(
                    message: 'При создании бренда возникла ошибка, проверьте входящие данные'
                );
            }

            return OperationResult::success(
                $brand
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
