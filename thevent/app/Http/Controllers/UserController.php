<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response as Response;
use Illuminate\Support\Facades\DB;
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
        $events = DB::table('characters')
            ->join('roles', 'characters.role_id', '=', 'roles.id')
            ->join('events', 'characters.event_id', '=', 'events.id')
            ->where(array('characters.user_id' => $id, 'characters.status' => true))
            ->select('events.id', 'roles.name', 'events.title', 'events.image', 'events.event_date')
            ->get();
        $skills = DB::table('user_skill')
            ->join('skills', 'user_skill.skill_id', '=', 'skills.id')
            ->where(array('user_skill.user_id' => $id))
            ->select('skills.name', 'user_skill.skill_factor')
            ->get();
        return response(['user' => $user, 'events' => $events, 'skills' => $skills], 200);
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

    /**
     * @param $id
     * @return Response
     */
    public function getUserRoles($id)
    {
        $roles = DB::table('user_role')
            ->select(array('role_id'))
            ->where('user_id', '=', $id)
            ->get();

        return response($roles, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function getUserSkills($id)
    {
        $skills = DB::table('user_skill')
            ->select(array('skill_id', 'skill_factor'))
            ->where('user_id', '=', $id)
            ->get();

        return response($skills, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function getUserTopics($id)
    {
        $topics = DB::table('user_topic')
            ->select(array('topic_id'))
            ->where('user_id', '=', $id)
            ->get();

        return response($topics, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeUserRole(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required'
        ]);

        $user_id = $id;
        $role_id = $request['role_id'];
        DB::table('user_role')->insert(array('user_id' => $user_id, 'role_id' => $role_id));

        return response(["Successfully updated user's roles!"], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function storeUserSkills(Request $request, $id)
    {
        $array_c = $request['skills'];
        $array_b = DB::table('user_skill')
            ->select(array('skill_id', 'skill_factor'))
            ->where(array('user_id' => $id))
            ->orderBy('skill_id', 'asc')
            ->get()
            ->toArray();
        //return response($array_c, 200);
        usort($array_c, function($a, $b) { return $a["skill_id"] > $b["skill_id"]; });
        //return response([$array_b[0]->skill_id], 200);
        $pointer_c = 0;
        $pointer_b = 0;
        $limit_c = count($array_c);
        $limit_b = count($array_b);
        while (true) {
            if ($pointer_c == $limit_c && $pointer_b == $limit_b) {
                break;
            }
            if (count($array_b) == 0) {
                $array_b = $array_c;
                break;
            }
            if ($pointer_b == $limit_b) {
                for ($i = $pointer_c; $i < $limit_c; $i++) {
                    array_push($array_b, $array_c[$i]);
                }
                break;
            }
            if (
                (int)$array_c[$pointer_c]["skill_id"] == $array_b[$pointer_b]->skill_id
            ) {
                $array_b[$pointer_b]->skill_factor =
                    $array_b[$pointer_b]->skill_factor +
                    (int)$array_c[$pointer_c]["skill_factor"];
                $pointer_b++;
                $pointer_c++;
            } else if (
                (int)$array_c[$pointer_c]["skill_id"] < $array_b[$pointer_b]->skill_id
            ) {
                array_push($array_b, $array_c[$pointer_c]);
                $pointer_c++;
            } else if (
                (int)$array_c[$pointer_c]["skill_id"] > $array_b[$pointer_b]->skill_id
            ) {
                $pointer_b++;
            }
        }
        for ($i = 0; $i < $limit_b; $i++) {
            DB::table('user_skill')
                ->where(array('user_id' => $id, 'skill_id' => $array_b[$i]->skill_id))
                ->update(array('skill_factor' => $array_b[$i]->skill_factor));
        }
        for ($i = $limit_b; $i < count($array_b); $i++) {
            DB::table('user_skill')
                ->insert(array(
                    'user_id' => $id,
                    'skill_id' => $array_b[$i]["skill_id"],
                    'skill_factor' => $array_b[$i]["skill_factor"]
                ));
        }
        return response(["Successfully updated user's skills!"], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function storeUserTopics(Request $request, $id)
    {
        $array_a = $request['topics'];
        $array_b = DB::table('user_topic')
            ->select(array('topic_id'))
            ->where(array('user_id' => $id))
            ->get();

        $tmp_a = array_map('intval', $array_a);
        $collection_a = collect($tmp_a);

        $tmp_b = array();
        foreach ($array_b as $item) {
            array_push($tmp_b, $item->topic_id);
        }
        $collection_b = collect($tmp_b);

        $insert_items = $collection_a->diff($collection_b);
        $delete_items = $collection_b->diff($collection_a);

        foreach ($delete_items as $item) {
            DB::table('user_topic')
                ->where(array(
                    array('user_id', '=', $id),
                    array('topic_id', '=', $item)
                ))
                ->delete();
        }

        foreach ($insert_items as $item) {
            DB::table('user_topic')
                ->insert(array('user_id' => $id, 'topic_id' => $item));
        }

        return response([
            'insert data' => $insert_items->all(),
            'delete data' => $delete_items->all()
        ], 200);
    }
}
