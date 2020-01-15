<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeEvent(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'short_description' => 'required',
            'full_description' => 'required',
            'image' => 'required|string|max:300',
            'topic_id' => 'required|integer',
            'event_date' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'address' => 'required|string|max:255'
        ]);

        $event = Event::create([
            'title' => $request['title'],
            'short_description' => $request['short_description'],
            'full_description' => $request['full_description'],
            'image' => $request['image'],
            'user_id' => $user->id,
            'topic_id' => $request['topic_id'],
            'event_date' => $request['event_date'],
            'start_at' => $request['start_at'],
            'end_at' => $request['end_at'],
            'address' => $request['address']
        ]);

        return response([
            'message' => 'Успешно послан запрос!',
            'id' => $event->id
        ], 201);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeEventSkills(Request $request)
    {
        $this->validate($request, [
            'skills' => 'required',
            'event_id' => 'required',
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        for ($i = 0; $i < count($request['skills']); $i++) {
            if ($request['skills'][$i]["skill_factor"] != 0) {
                DB::table('event_skill')
                    ->insert(array(
                        'event_id' => $request['event_id'],
                        'skill_id' => $request['skills'][$i]["skill_id"],
                        'skill_factor' => $request['skills'][$i]["skill_factor"]
                    ));
            }
        }
        return response([
            'message' => 'Успешно послан запрос!',
            'id' => $request['event_id']
        ], 201);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'event_id' => 'required'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $roleSelection = DB::table('roles')
            ->where(array('name' => 'Организатор'))
            ->select('id')
            ->first();
        $roleID = $roleSelection->id;

        DB::table('characters')
            ->insert(array(
                'user_id' => $user->id,
                'event_id' => $request['event_id'],
                'role_id' => $roleID,
                'comment' => $request['comment']
            ));

        return response(['message' => 'Заявка на организация успешно отправлена!'], 200);
    }
}
