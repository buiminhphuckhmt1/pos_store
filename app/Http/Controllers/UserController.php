<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = new Role();
        $roles = $roles->latest()->paginate(100);
        if (request()->wantsJson()) {
            return response(
                User::all()
            );
        }
        $users = User::latest()->paginate(10);
        return view('users.index',compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('users', 'public');
        }
        else{
            $image_path = 'products/defaulppicture.jpg';
        }
        
        $user = User::create([
            'image' => $image_path,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi đã gặp vấn đề trong lúc tạo người dùng mới.');
        }
        return redirect()->route('users.index')->with('success', 'Đã tạo người dùng mới thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if ($request->password != 'null') {
            $user->password =Hash::make($request->password);
        } 
            
        if ($request->hasFile('image')) {
            // Delete old image
            if ($user->image) {
                Storage::delete($user->image);
            }
            // Store image
            $image_path = $request->file('image')->store('users', 'public');
            // Save to Database
            $user->image = $image_path;
        }

        if (!$user->save()) {
            return redirect()->back()->with('error', 'Xin lỗi, đã gặp vấn đền trong lúc cập nhật khách hàng.');
        }
        return redirect()->route('users.index')->with('success', 'Đã cập nhật thông tin người dùng thành công.');
    }

    public function destroy(User $user)
    {
        $user->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
