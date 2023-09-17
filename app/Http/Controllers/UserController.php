<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson()) {
            return response(
                User::all()
            );
        }
        $users = User::latest()->paginate(10);
        return view('users.index')->with('users', $users);
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
        $user = User::create([
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $request->user()->id,
        ]);

        if (!$user) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi đã gặp vấn đề trong lúc tạo khách hàng mới.');
        }
        return redirect()->route('users.index')->with('Thành công', 'Đã tạo khách hàng mới thành công.');
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
        $user->address = $request->address;


        if (!$user->save()) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi, đã gặp vấn đền trong lúc cập nhật khách hàng.');
        }
        return redirect()->route('users.index')->with('Thành công', 'Đã cập nhật thông tin khách hàng thành công.');
    }

    public function destroy(User $user)
    {
        $user->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
