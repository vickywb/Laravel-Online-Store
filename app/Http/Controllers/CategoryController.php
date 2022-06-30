<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
    private $categoryRepository;
    private $productRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->get([
            'pagination' => 6,
            'order' => 'name ASC'
        ]);

        $products = $this->productRepository->get([
            'pagination' => 16,
            'order' => 'created_at DESC'
        ]); 

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $category = $this->categoryRepository->findByColumn($slug, 'slug');

        $categories = $this->categoryRepository->get([
            'pagination' => 6,
            'order' => 'name ASC'
        ]);
        
        $products = $this->productRepository->get([
            'pagination' => 16,
            'with' => ['productImages'],
            'category_id' => $category->id,
            'order' => 'created_at DESC'
        ]); 

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products,
            'category' => $category
        ]);
    }
}
