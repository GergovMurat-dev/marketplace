<?php

namespace App\Domains;

use App\DTO\Category\CategoryCreateDTO;
use App\Models\Category;
use App\Utils\OperationResult;
use Psr\Log\LoggerInterface;

class CompanyDomainCreateCategory
{

    public function __construct(
        private readonly LoggerInterface                   $logger,
        private readonly CompanyDomainValidateCategorySlug $validateCategorySlug
    )
    {
    }

    public function do(
        CategoryCreateDTO $categoryCreateDTO
    ): OperationResult
    {
        try {
            $categorySlugValidateOperationResult = $this->validateCategorySlug->do(
                companyId: $categoryCreateDTO->companyId,
                categorySlug: $categoryCreateDTO->slug
            );
            if ($categorySlugValidateOperationResult->isError) {
                return $categorySlugValidateOperationResult;
            }

            $category = Category::create($categoryCreateDTO->toArrayAsSnakeCase());

            if (is_null($category)) {
                return OperationResult::error(
                    message: 'При создании товара возникла ошибка, проверьте входящие данные'
                );
            }

            return OperationResult::success(
                $category
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
