<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Product;
use Response;

class ProductsController extends Controller
{
    /** @var  ProductRepository */
    private $productRepository;

    private $categoryRepository;

    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepository = $productRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->all();

        return response()->json([
            'products' => $products == null ? $products : $products->toArray(),
            'success' => true,
            'message' => 'Products retrieved successfully'
        ]);
    }

    

    /**
     * Display a listing of products of concrete category.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductsOfConcreteCategory(Request $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->where('name', $input['category_name']??null)->pluck('id')->toArray();

        if(empty($category)) return abort(404, 'Category not found');

        $products = $this->productRepository->where('category_id', $category[0])->get();
        
        return response()->json([
            'products' => $products == null ? $products : $products->toArray(),
            'success' => true,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->createProduct($input);

        return response()->json([
            'product_name' => $product->name,
            'success' => true,
            'message' => 'Product created successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->where('id', $input['product']['id'])->get();

        if(empty($product)) return abort(404, 'Product not found');

        $product = $this->productRepository->update($input['product'], $input['product']['id'], $input['product']['category_id']??null);

        return response()->json([
            'product' => $product,
            'success' => true,
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return abort(404, 'Product not found');
        }

        $product->delete();

        return response()->json([
            'id' => $id,
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
