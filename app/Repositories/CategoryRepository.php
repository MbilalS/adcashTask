<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Category;

/**
 * Class CategoryRepository.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function createCategory(array $attributes)
    {
        $attributes = array_merge([
            'name' => $attributes['category_name']
        ], $attributes);

        $category = Category::create($attributes);
        return $category;
    }
    
}
