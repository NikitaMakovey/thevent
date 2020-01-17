<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = DB::table('events')
            ->join('topics', 'events.topic_id', '=', 'topics.id')
            ->where('events.status', '=', true)
            ->where('events.event_date', '>=', date('Y-m-d'))
            ->orderBy('events.event_date')
            ->select('events.*', 'topics.name')
            ->paginate(6);

        return response($events, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getTopicEvents(int $id)
    {
        $events = DB::table('events')
            ->join('topics', 'events.topic_id', '=', 'topics.id')
            ->where('events.status', '=', true)
            ->where('events.topic_id', '=', $id)
            ->where('events.event_date', '>=', date('Y-m-d'))
            ->orderBy('events.event_date')
            ->select('events.*', 'topics.name')
            ->paginate(6);

        return response($events, 200);
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
            'title' => 'required|string|max:255',
            'short_description' => 'required',
            'full_description' => 'required',
            'image' => 'required|string|max:300',
            'user_id' => 'required|integer',
            'topic_id' => 'required|integer',
            'event_date' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'address' => 'required|string|max:255'
        ]);

        Event::create([
            'title' => $request['title'],
            'short_description' => $request['short_description'],
            'full_description' => $request['full_description'],
            'image' => $request['image'],
            'user_id' => $request['user_id'],
            'topic_id' => $request['topic_id'],
            'event_date' => $request['event_date'],
            'start_at' => $request['start_at'],
            'end_at' => $request['end_at'],
            'address' => $request['address']
        ]);

        return response(['Successfully created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $event = DB::table('events')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->join('topics', 'events.topic_id', '=', 'topics.id')
            ->where(array('events.id' => $id))
            ->select(
                'events.*',
                'users.first_name',
                'users.second_name',
                'users.third_name',
                'users.email',
                'users.phone_number',
                'topics.name'
            )
            ->first();
        $organizers = DB::table('characters')
            ->join('roles', 'characters.role_id', '=', 'roles.id')
            ->join('users', 'characters.user_id', '=', 'users.id')
            ->where(
                array(
                    'roles.name' => 'Организатор',
                    'characters.status' => true,
                    'characters.event_id' => $id
                )
            )
            ->select(
                'users.first_name',
                'users.second_name',
                'users.third_name',
                'users.image',
                'users.id'
            )
            ->get();
        $speakers = DB::table('characters')
            ->join('roles', 'characters.role_id', '=', 'roles.id')
            ->join('users', 'characters.user_id', '=', 'users.id')
            ->where(
                array(
                    'roles.name' => 'Спикер',
                    'characters.status' => true,
                    'characters.event_id' => $id
                )
            )
            ->select(
                'users.first_name',
                'users.second_name',
                'users.third_name',
                'users.image',
                'users.id'
            )
            ->get();
        $skills = DB::table('event_skill')
            ->join('skills', 'event_skill.skill_id', '=', 'skills.id')
            ->where(array('event_skill.event_id' => $id))
            ->select('event_skill.skill_factor', 'skills.name')
            ->get();

        return response(
            [
                'event' => $event,
                'organizers' => $organizers,
                'speakers' => $speakers,
                'skills' => $skills
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|boolean'
        ]);

        $event = Event::find($id);
        $event->status = $request['status'];
        $event->save();

        return response(['Successfully updated event status : '.$event->status.'.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response(['Successfully deleted!'], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function storeEventSkills(Request $request, int $id) {
        for ($i = 0; $i < count($request['skills']); $i++) {
            DB::table('event_skill')
                ->insert(array(
                    'event_id' => $id,
                    'skill_id' => $request['skills'][$i]["skill_id"],
                    'skill_factor' => $request['skills'][$i]["skill_factor"]
                ));
        }
        return response(["Successfully created event's skills!"], 201);
    }
}
