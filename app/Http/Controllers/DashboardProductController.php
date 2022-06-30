<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Processor\ProcessUploadFile;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $fileRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        FileRepository $fileRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->fileRepository = $fileRepository;
    }

    public function index()
    {
        $user = auth()->user()->id;

        $products = $this->productRepository->get([
            'with' => ['productImages', 'category'],
            'user_id' => $user
        ]);
        // $products = Product::with(['productImages', 'category'])
        //     ->where('user_id', $user)
        //     ->get();

        return view('pages.dashboard-products', [
            'products' => $products
        ]);
    }

    public function details(Request $request, Product $product)
    {
        // $product = $this->productRepository->get([
        //     'with' => ['productImages', 'user', 'category'],
        //     'id' => $product->id
        // ]);

        // $product = Product::with(['productImages', 'user', 'category'])->findOrFail($id);
        $product->with([
            'productImages', 'user', 'category'
        ]);

        $categories = Category::all();

        return view('pages.dashboard-products-details', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);

        return view('pages.dashboard-products-create', [
            'categories' => $categories
        ]);
    }

    public function store(ProductStoreRequest $request, Product $product)
    {
        $listImage = [];
        
        $request->merge([
            'slug' => Str::slug($request->product_name, '-')
        ]);

        $data = $request->only([
            'user_id', 'product_name', 'category_id', 'price', 'description', 
            'slug'
        ]);

        try {
            DB::beginTransaction();
            $product = new Product($data);
            $product = $this->productRepository->store($product);

            if ($request->has('product_images')) {
                foreach ($request->product_images as $uploadedImage) {
                    
                    new ProcessUploadFile($uploadedImage->get(), [
                        'field_name' => 'location',
                        'extension' => $uploadedImage->getClientOriginalExtension(),
                    ], $request);

                    $uploadedFile = $this->fileRepository->store($request->only('location'));
                    $listImage[]= [
                        'file_id' => $uploadedFile->id,
                        'product_id' => $product->id
                    ];
                }
            }

            $product->productImages()->createMany($listImage);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('dashboard-product')->with([
            'success' => 'Product has successfully created'
        ]);
    }
    
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'slug' => Str::slug($request->product_name, '-')
        ]);

        $data = $request->only([
            'user_id', 'product_name', 'category_id', 'price', 'description', 
            'slug', 'quantity'
        ]);

        try {
            DB::beginTransaction();
            $product = $product->fill($data);
            $product = $this->productRepository->store($product);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('dashboard-product')->with([
            'success' => 'Product has successfully updated'
        ]);
    }

    public function uploadImage(Request $request)
    {
        $listImage = [];
        $product = $request->product_id;

        try {
            DB::beginTransaction();

            if ($request->has('product_images')) {
                foreach ($request->product_images as $uploadedImage) {
                    
                    new ProcessUploadFile($uploadedImage->get(), [
                        'field_name' => 'location',
                        'extension' => $uploadedImage->getClientOriginalExtension(),
                    ], $request);

                    $uploadedFile = $this->fileRepository->store($request->only('location'));
                    $listImage[]= [
                        'file_id' => $uploadedFile->id,
                        'product_id' => $product
                    ];
                }
            }
            
            ProductImage::insert($listImage);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('dashboard-product-details', $product)->with([
            'success' => 'Product Image has successfully uploaded'
        ]);
    }

    public function deleteImage(Request $request, ProductImage $productImage)
    {
        try {
            DB::beginTransaction();

            $productImage->delete();

            if (isset($oldFileName)) {
                Storage::delete($oldFileName);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('dashboard-product-details', $productImage->product_id)->with([
            'success' => 'Product Image has successfully deleted'
        ]);
    }
}
