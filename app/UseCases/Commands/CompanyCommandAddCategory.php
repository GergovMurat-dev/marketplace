<?php

namespace App\UseCases\Commands;

use App\Domains\CompanyDomainCreateCategory;
use App\DTO\Category\CategoryCreateDTO;
use App\Models\Category;
use App\Utils\OperationResult;
use Illuminate\Support\Facades\Validator;

class CompanyCommandAddCategory
{
    public function __construct(
        private readonly CompanyDomainCreateCategory $createCategory
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

        $categoryCreateDTO = CategoryCreateDTO::make($data);

        $createCategoryOperationResult = $this->createCategory->do(
            $categoryCreateDTO
        );
        if ($createCategoryOperationResult->isError) {
            return $createCategoryOperationResult;
        }

        /** @var Category $category */
        $category = $createCategoryOperationResult->data;

        return OperationResult::success(
            $category
        );
    }
}
