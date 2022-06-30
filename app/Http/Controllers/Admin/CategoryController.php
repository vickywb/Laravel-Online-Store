<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Processor\ProcessUploadFile;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $fileRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        FileRepository $fileRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $categories = $this->categoryRepository->get([
            'pagination' => 5,
            'order' => 'created_at DESC'
        ]);

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();

        return view('admin.categories.create', [
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request, Category $category)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image')->get();

            new ProcessUploadFile($file, [
                'field_name' => 'location',
                'extension' => $request->file('image')->getClientOriginalExtension(),
            ], $request);

            $uploadedFile = $this->fileRepository->store($request->only('location'));
            $request->merge([
                'file_id' => $uploadedFile->id
            ]);
        }

            $request->merge([
                'slug' => Str::slug($request->name, '-')
            ]);

           $data = $request->only([
                'name', 'slug', 'file_id', 'image'
            ]);
        
        try {
            DB::beginTransaction();
            $category = new Category($data);
            $category = $this->categoryRepository->store($category);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'erros' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-category.index')->with([
            'success' => 'Category successfully created'
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
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image')->get();

            new ProcessUploadFile($file, [
                'field_name' => 'location',
                'extension' => $request->file('image')->getClientOriginalExtension(),
            ], $request);

            $uploadedFile = $this->fileRepository->store($request->only('location'));
            $request->merge([
                'file_id' => $uploadedFile->id
            ]);

            if ($category->file_id) {
                $oldFileName = $category->file->location;
            }
        }
            $request->merge([
                'slug' => Str::slug($request->name, '-')
            ]);

           $data = $request->only([
                'name', 'slug', 'file_id', 'image'
            ]);
        
        try {
            DB::beginTransaction();
            $category = $category->fill($data);
            $category = $this->categoryRepository->store($category);

            if (isset($oldFileName)) {
                Storage::delete($oldFileName);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin-category.index')->withErrors([
                'erros' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-category.index')->with([
            'success' => 'Category successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();

            $category->delete();
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin-category.index')->withErrors([
                'erros' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-category.index')->with([
            'success' => 'Category successfully deleted'
        ]);
    }
}
