<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Models\User;
use App\Models\UserMemberProfile;
use App\Repositories\CategoryRepository;
use App\Repositories\UserMemberProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserMemberController extends Controller
{
    private $userRepository;
    private $userMemberProfileRepository;
    private $categoryRepository;

    public function __construct(
        UserRepository $userRepository,
        UserMemberProfileRepository $userMemberProfileRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userMemberProfileRepository = $userMemberProfileRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create()
    {
        $categories = $this->categoryRepository->get([
            'order' => 'name ASC'
        ]);

        return view('auth.register', [
            'categories' => $categories
        ]);
    }

    public function store(MemberStoreRequest $request, User $user)
    {   
        if ($request->is_store_open == "true") {
            $request->merge([
                'store_status' => $request->is_open_store,
                'store_name' => $request->store_name
            ]);
        }else {
            $request->merge([
                'store_name' => Str::slug($request->name . mt_rand(99, 99999), '-') 
            ]);
        }
        
        $data = $request->only([
            'email', 'name', 'password', 'category_id',
            'store_name', 'store_status'
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
           DB::rollBack();

           return redirect()->back()->withErrors([
            'errors' => $th->getMessage()
        ]);
       }

       return redirect()->route('home')->with(Auth::login($user));
    }

    public function success()
    {
        return view('auth.success');
    }
}
