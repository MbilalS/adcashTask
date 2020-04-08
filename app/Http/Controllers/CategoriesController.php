<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use App\Category;
use Response;

class CategoriesController extends Controller
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();

        return response()->json([
            'categories' => $categories == null ? $categories : $categories->toArray(),
            'success' => true,
            'message' => 'Categories retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->createCategory($input);

        return response()->json([
            'category_name' => $category->name,
            'success' => true,
            'message' => 'Category created successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->where('id', $input['category']['id'])->get();

        if(empty($category)) return abort(404, 'Category not found');

        $category = $this->categoryRepository->update($input['category'], $input['category']['id']);
        
        return response()->json([
            'category' => $category,
            'success' => true,
            'message' => 'Category updated successfully'
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
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return abort(404, 'Category not found');
        }

        $category->delete();

        return response()->json([
            'category_id' => $id,
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
