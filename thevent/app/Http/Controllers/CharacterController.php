<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = Character::all();

        return response($characters, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            'event_id' => 'required',
            'status' => 'nullable|boolean',
            'comment' => 'nullable'
        ]);

        $request['status'] = $request['status'] == 0 ? null : $request['status'];

        Character::create([
            'role_id' => $request['role_id'],
            'user_id' => $request['user_id'],
            'event_id' => $request['event_id'],
            'status' => $request['status'],
            'comment' => $request['comment']
        ]);

        return response(['Successfully created!'], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            'event_id' => 'required'
        ]);

        $role_id = $request['role_id'];
        $user_id = $request['user_id'];
        $event_id = $request['event_id'];

        $character = Character::where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        return response($character, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            'event_id' => 'required',
            'status' => 'required|boolean'
        ]);

        $role_id = $request['role_id'];
        $user_id = $request['user_id'];
        $event_id = $request['event_id'];

        //TODO: correct update!
        $character = Character::where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();
        $character->status = $request['status'];
        $character->save();

        return response(['Successfully updated status!'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            'event_id' => 'required'
        ]);

        $role_id = $request['role_id'];
        $user_id = $request['user_id'];
        $event_id = $request['event_id'];

        Character::where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->delete();

        return response(['Successfully deleted!'], 200);
    }
}
