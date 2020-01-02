<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

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
    public function show($id)
    {
        $event = Event::find($id);

        return response($event, 200);
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
}
