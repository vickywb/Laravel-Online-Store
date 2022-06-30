<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Processor\ProcessUploadFile;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $fileRepository;
    private $userRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        FileRepository $fileRepository,
        UserRepository $userRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->fileRepository = $fileRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $products = $this->productRepository->get([
            'with' => ['user', 'category'],
            'pagination' => 5,
            'oder' => 'created_at DESC',
        ]);

        return view('admin.products.index', [
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
        $product = new Product();

        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);
        
        $users = $this->userRepository->get([
            'order' => 'name ASC'
        ]);

        return view('admin.products.create', [
            'product' => $product,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request, Product $product)
    {       
        $listImage = [];
      
        $request->merge([
            'slug' => Str::slug($request->product_name, '-')
        ]);

        $data = $request->only([
            'product_name', 'category_id', 'price', 'description', 'slug', 'user_id'
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

                    $listImage[] = [
                        'file_id' => $uploadedFile->id,
                        'product_id' => $product->id
                    ];
                }
            }
         
            $product->productImages()->createMany($listImage);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-product.index')->with([
            'success' => 'Product has successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);
        
        $users = $this->userRepository->get([
            'order' => 'name ASC'
        ]);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->get();

            new ProcessUploadFile($filename, [
                'field_name' => 'location',
                'extension' => $request->file('image')->getClientOriginalExtension()
            ], $request);

            $uploadedFile = $this->fileRepository->store($request->only('location'));

            $request->merge([
                'file_id' => $uploadedFile->id
            ]);

            if ($product->file_id) {
                $oldFileName = $product->file->location;
            }
        }

        $request->merge([
            'slug' => Str::slug($request->product_name, '-')
        ]);

        $data = $request->only([
            'product_name', 'category_id', 'price', 'description', 'image', 
            'file_id', 'slug', 'user_id'
        ]);

        try {
            DB::beginTransaction();

            $product = $product->fill($data);
            $product = $this->productRepository->store($product);

            if (isset($oldFileName)) {
                Storage::delete($oldFileName);
            }

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-product.index')->with([
            'success' => 'Product has successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-product.index')->with([
            'success' => 'Product has successfully deleted'
        ]);
    }
}
