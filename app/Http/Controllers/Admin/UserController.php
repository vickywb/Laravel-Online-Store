<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\UserMemberProfile;
use App\Processor\ProcessUploadFile;
use App\Repositories\CategoryRepository;
use App\Repositories\FileRepository;
use App\Repositories\UserMemberProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $userRepository;
    private $fileRepository;
    private $userMemberProfileRepository;
    private $categoryRepository;

    public function __construct(
        UserRepository $userRepository,
        FileRepository $fileRepository,
        UserMemberProfileRepository $userMemberProfileRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->fileRepository = $fileRepository;
        $this->userMemberProfileRepository = $userMemberProfileRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->get([
            'pagination' => 10,
            'order' => 'created_at DESC',
            'with' => ['profile']
        ]);
       
        return view('admin.users.index',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);

        return view('admin.users.create',[
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request, User $user)
    {   
        $request->merge([
            'store_status' => (bool) $request->store_status
        ]);

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

        $data = $request->only([
            'email', 'name', 'password', 'image', 'file_id', 'category_id',
            'address', 'address2', 'phone_number', 'country', 'province', 'city',
            'post_code', 'store_name', 'store_status'
        ]);

        try {
            DB::beginTransaction();

            $user = new User($data);
            $user = $this->userRepository->store($user);

            $data['user_id'] = $user->id;
            $profile = new UserMemberProfile($data);
            $this->userMemberProfileRepository->store($profile);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-user.index')->with([
            'success' => 'User has successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);

        return view('admin.users.edit', [
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $request->merge([
            'store_status' => (bool) $request->store_status
        ]);

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

        if ($user->profile->file_id) {
            $oldFileName = $user->profile->file->location;
        }

        $data = $request->only([
            'email', 'name', 'password', 'image', 'file_id', 'category_id',
            'address', 'address2', 'phone_number', 'country', 'province', 'city',
            'post_code', 'store_name', 'store_status'
        ]);

        try {
            DB::beginTransaction();

            $user = $user->fill($data);
            $profile = $user->profile->fill($data);

            $this->userRepository->store($user);
            $this->userMemberProfileRepository->store($profile);

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

        return redirect()->route('admin-user.index')->with([
            'success' => 'User has successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return redirect()->back()->withErrors([
                'errors' => $th->getMessage()
            ]);
        }

        return redirect()->route('admin-user.index')->with([
            'success' => 'User has successfully deleted'
        ]);
    }
    
    public function profile(User $user)
    {   
        return view('admin.profiles.index', [
            'user' => $user
        ]);
    }

    public function profileEdit(User $user)
    {   
        return view('admin.profiles.edit', [
            'user' => $user
        ]);
    }


    public function profileUpdate(AdminUpdateRequest $request, User $user)
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

        // if ($user->profile->file_id) {
        //     $oldFileName = $user->profile->file->location;
        // }

        $data = $request->only([
            'name', 'email', 'image', 'file_id', 'password'
        ]);
        // dd($data);
        try {
            Db::beginTransaction();

            $user = $user->fill($data);
            $profile = $user->profile->fill($data);

            $this->userRepository->store($user);
            $this->userMemberProfileRepository->store($profile);
        
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

        return redirect()->route('admin-profile.index')->with([
            'message' => 'Profile successfully updated'
        ]);
    }
}
