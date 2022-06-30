<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);

        $products = $this->productRepository->get([
            'pagination' => 8,
            'order' => 'product_name DESC'
        ]);
        return view('pages.home', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
