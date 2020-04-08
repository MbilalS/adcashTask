<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Product;

/**
 * Class ProductRepository.
 *
 * @package namespace App\Repositories;
 */
class ProductRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    public function createProduct(array $attributes)
    {
        $attributes = array_merge([
            'name' => $attributes['product_name'],
            'category_id' => $attributes['category_id']??null
        ], $attributes);

        $product = Product::create($attributes);
		return $product;
    }
    
}
