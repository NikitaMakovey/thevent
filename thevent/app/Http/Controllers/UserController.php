<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'sex' => 'required|integer',
            'birth_date' => 'nullable'
        ]);

        $request['third_name'] = $request['third_name'] == 0 ? null : $request['third_name'];
        $request['birth_date'] = $request['birth_date'] == 0 ? null : $request['birth_date'];

        User::create([
            'first_name' => $request['first_name'],
            'second_name' => $request['second_name'],
            'third_name' => $request['third_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['password']),
            'sex' => $request['sex'],
            'birth_date' => $request['birth_date']
        ]);

        return response(['Successfully created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'nullable|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'birth_date' => 'nullable',
            'info' => 'nullable',
        ]);

        $user = User::findOrFail($id);


        if ($request['first_name']) $user->first_name = $request['first_name'];
        if ($request['second_name']) $user->second_name = $request['second_name'];
        if ($request['third_name']) $user->third_name = $request['third_name'];
        if ($request['specialization']) $user->specialization = $request['specialization'];
        if ($request['image']) $user->image = $request['image'];
        if ($request['birth_date']) $user->birth_date = $request['birth_date'];
        if ($request['info']) $user->info = $request['info'];

        $user->save();

        return response(['Successfully updated!'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAllowStatus(Request $request, $id)
    {
        $this->validate($request, [
            'allow_status' => 'nullable|boolean'
        ]);

        $user = User::find($id);

        $user->allow_status = $request['allow_status'];

        $user->save();

        return response(['Successfully updated allow status!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response(['Successfully deleted!'], 200);
    }
}
