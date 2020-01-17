<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getRoles(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $roles = DB::table('user_role')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->where('user_role.user_id', '=', $user->id)
            ->where('roles.name', '!=', 'Участник')
            ->orderBy('roles.id')
            ->select('roles.id', 'roles.name')
            ->get();

        return response(['roles' => $roles], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getMainModeratorRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $events = DB::table('events')
            ->whereRaw('status IS NULL')
            ->where('event_date', '>', date('Y-m-d'))
            ->orderBy('created_at')
            ->get();

        return response(['events' => $events], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getMainModeratorRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

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
        $comment = DB::table('characters')
            ->join('roles', 'characters.role_id', '=', 'roles.id')
            ->where(
                array(
                    'characters.user_id' => $event->user_id,
                    'characters.event_id' => $id,
                    'roles.name' => 'Организатор'
                )
            )
            ->first();
        $skills = DB::table('event_skill')
            ->join('skills', 'event_skill.skill_id', '=', 'skills.id')
            ->where(array('event_skill.event_id' => $id))
            ->select('event_skill.skill_factor', 'skills.name')
            ->get();

        return response(
            [
                'event' => $event,
                'skills' => $skills,
                'comment' => $comment
            ], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteMainModeratorRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $event = Event::find($id);
        $event->status = false;
        $event->save();

        DB::table('characters')
            ->where(
                array(
                    'user_id' => $event->user_id,
                    'role_id' => 4,
                    'event_id' => $event->id
                )
            )
            ->update(['status' => false]);

        return response(['message' => 'Запросу отказано!'], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateMainModeratorRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $event = Event::find($id);
        $event->status = true;
        $event->save();

        $role = DB::table('roles')
            ->where('name', '=', 'Организатор')
            ->select('id')
            ->first();

        DB::table('characters')
            ->where(
                array(
                    'user_id' => $event->user_id,
                    'role_id' => $role->id,
                    'event_id' => $event->id
                )
            )
            ->update(['status' => true]);

        $user_role = DB::table('user_role')
            ->where(
                array(
                    'user_id' => $event->user_id,
                    'role_id' => $role->id
                )
            )
            ->get();
        if (count($user_role) == 0) {
            DB::table('user_role')
                ->insert(
                    array(
                        'user_id' => $event->user_id,
                        'role_id' => $role->id
                    )
                );
        }

        return response(['message' => 'Запрос одобрен!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getEventModeratorRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $events = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('events', 'events.id', '=', 'characters.event_id')
            ->where(
                array(
                    'roles.name' => 'Модератор мероприятий',
                    'characters.user_id' => $user->id,
                    'characters.status' => true
                )
            )
            ->where('events.event_date', '>', date('Y-m-d'))
            ->get();

        return response(['events' => $events], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getEventModeratorRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $requests = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('roles.name', '!=', 'Модератор мероприятий')
            ->where('roles.name', '!=', 'Участник')
            ->where('characters.event_id', '=', $id)
            ->whereRaw('characters.status IS NULL')
            ->orderBy('characters.created_at')
            ->select(
                'characters.user_id',
                'characters.role_id',
                'characters.comment',
                'users.first_name',
                'users.second_name',
                'users.image',
                'roles.name'
            )
            ->get();

        return response(['requests' => $requests], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteEventModeratorRequest(int $id, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        DB::table('characters')
            ->where(
                array(
                    'user_id' => $request['user_id'],
                    'role_id' => $request['role_id'],
                    'event_id' => $id
                )
            )
            ->update(['status' => false]);

        return response(['message' => 'Запросу отказано!'], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateEventModeratorRequest(int $id, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        DB::table('characters')
            ->where(
                array(
                    'user_id' => $request['user_id'],
                    'role_id' => $request['role_id'],
                    'event_id' => $id
                )
            )
            ->update(['status' => true]);

        $user_role = DB::table('user_role')
            ->where(
                array(
                    'user_id' => $request['user_id'],
                    'role_id' => $request['role_id']
                )
            )
            ->get();
        if (count($user_role) == 0) {
            DB::table('user_role')
                ->insert(
                    array(
                        'user_id' => $request['user_id'],
                        'role_id' => $request['role_id']
                    )
                );
        }

        return response(['message' => 'Запрос одобрен!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getVolunteerRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $events = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('events', 'events.id', '=', 'characters.event_id')
            ->where(
                array(
                    'roles.name' => 'Волонтёр',
                    'characters.user_id' => $user->id,
                    'characters.status' => true
                )
            )
            ->where('events.event_date', '>=', date('Y-m-d'))
            ->get();

        return response(['events' => $events], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getVolunteerRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $users = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('roles.name', '=', 'Участник')
            ->where('characters.event_id', '=', $id)
            ->whereRaw('characters.status IS NULL')
            ->orderBy('characters.created_at')
            ->select(
                'characters.user_id',
                'characters.role_id',
                'users.first_name',
                'users.second_name',
                'users.third_name',
                'users.image'
            )
            ->get();

        return response(['users' => $users], 200);
    }

    /**
     * @param int $user_id
     * @param int $event_id
     */
    public function postUserSkills(int $user_id, int $event_id)
    {
        $array_a = DB::table('event_skill')
            ->select(array('skill_id', 'skill_factor'))
            ->where(array('event_id' => $event_id))
            ->orderBy('skill_id', 'asc')
            ->get()
            ->toArray();
        $array_b = DB::table('user_skill')
            ->select(array('skill_id', 'skill_factor'))
            ->where(array('user_id' => $user_id))
            ->orderBy('skill_id', 'asc')
            ->get()
            ->toArray();

        $pointer_a = 0;
        $pointer_b = 0;
        $limit_a = count($array_a);
        $limit_b = count($array_b);
        while (true) {
            if ($pointer_a == $limit_a && $pointer_b == $limit_b) {
                break;
            }
            if (count($array_b) == 0) {
                $array_b = $array_a;
                break;
            }
            if ($pointer_b == $limit_b) {
                for ($i = $pointer_a; $i < $limit_a; $i++) {
                    array_push($array_b, $array_a[$i]);
                }
                break;
            }
            if (
                $array_a[$pointer_a]->skill_id == $array_b[$pointer_b]->skill_id
            ) {
                $array_b[$pointer_b]->skill_factor =
                    $array_b[$pointer_b]->skill_factor +
                    $array_a[$pointer_a]->skill_factor;
                $pointer_b++;
                $pointer_a++;
            } else if (
                $array_a[$pointer_a]->skill_id < $array_b[$pointer_b]->skill_id
            ) {
                array_push($array_b, $array_a[$pointer_a]);
                $pointer_a++;
            } else if (
                $array_a[$pointer_a]->skill_id > $array_b[$pointer_b]->skill_id
            ) {
                $pointer_b++;
            }
        }
        for ($i = 0; $i < $limit_b; $i++) {
            DB::table('user_skill')
                ->where(array('user_id' => $user_id, 'skill_id' => $array_b[$i]->skill_id))
                ->update(array('skill_factor' => $array_b[$i]->skill_factor));
        }
        for ($i = $limit_b; $i < count($array_b); $i++) {
            DB::table('user_skill')
                ->insert(array(
                    'user_id' => $user_id,
                    'skill_id' => $array_b[$i]->skill_id,
                    'skill_factor' => $array_b[$i]->skill_factor
                ));
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateVolunteerRequest(int $id, Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        DB::table('characters')
            ->where(
                array(
                    'user_id' => $request['user_id'],
                    'role_id' => $request['role_id'],
                    'event_id' => $id
                )
            )
            ->update(['status' => true]);

        $this->postUserSkills($request['user_id'], $id);

        return response(['message' => 'Запрос одобрен!'], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateVolunteerFullRequest(int $id, Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|integer'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $requests = DB::table('characters')
            ->where(
                array(
                    'role_id' => $request['role_id'],
                    'event_id' => $id
                )
            )
            ->whereRaw('status IS NULL')
            ->select('user_id')
            ->get();

        foreach ($requests as $r) {
            $this->postUserSkills($r->user_id, $id);
        }

        DB::table('characters')
            ->where(
                array(
                    'role_id' => $request['role_id'],
                    'event_id' => $id
                )
            )
            ->update(['status' => true]);

        return response(['message' => 'Все запросы одобрены!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getOrganizerRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $events = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('events', 'events.id', '=', 'characters.event_id')
            ->where(
                array(
                    'roles.name' => 'Организатор',
                    'characters.user_id' => $user->id,
                    'characters.status' => true
                )
            )
            ->where('events.event_date', '>=', date('Y-m-d'))
            ->get();

        return response(['events' => $events], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getOrganizerRequest(int $id, Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $requests = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('roles.name', '!=', 'Участник')
            ->where('characters.event_id', '=', $id)
            ->whereRaw('characters.status IS NULL')
            ->orderBy('characters.created_at')
            ->select(
                'characters.user_id',
                'characters.role_id',
                'characters.comment',
                'users.first_name',
                'users.second_name',
                'users.image',
                'roles.name'
            )
            ->get();

        return response(['requests' => $requests], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getSpeakerRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $events = DB::table('characters')
            ->join('roles', 'roles.id', '=', 'characters.role_id')
            ->join('events', 'events.id', '=', 'characters.event_id')
            ->where(
                array(
                    'roles.name' => 'Спикер',
                    'characters.user_id' => $user->id,
                    'characters.status' => true
                )
            )
            ->where('events.event_date', '>=', date('Y-m-d'))
            ->get();

        return response(['events' => $events], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAdminRequests(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 401);
        }

        $users = DB::table('user_role')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->join('users', 'users.id', '=', 'user_role.user_id')
            ->where(
                array(
                    'roles.name' => 'Главный модератор',
                )
            )
            ->select('users.*')
            ->get();

        return response(['users' => $users], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setMainModerator(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|max:255'
        ]);

        $admin = $request->user();
        if ($admin == null) {
            return response(['message' => -1], 401);
        }

        $user = User::where('email', $request['email'])->first();
        if ($user) {

            $role = DB::table('roles')
                ->where('name', '=', 'Главный модератор')
                ->select('id')
                ->first();

            $user_role = DB::table('user_role')
                ->where(
                    array(
                        'user_id' => $user->id,
                        'role_id' => $role->id
                    )
                )
                ->get();

            if (count($user_role) == 0) {
                DB::table('user_role')
                    ->insert(
                        array(
                            'user_id' => $user->id,
                            'role_id' => $role->id
                        )
                    );
            }

            return response(['message' => 'Запрос успешно обработан!'], 200);

        }

        return response(['message' => 'Неверный запрос!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteMainModerator(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer'
        ]);

        $admin = $request->user();
        if ($admin == null) {
            return response(['message' => -1], 401);
        }

        $role = DB::table('roles')
            ->where('name', '=', 'Главный модератор')
            ->select('id')
            ->first();

        $user_role = DB::table('user_role')
            ->where(
                array(
                    'user_id' => $request['user_id'],
                    'role_id' => $role->id
                )
            )
            ->get();

        if (count($user_role)) {
            DB::table('user_role')
                ->where(
                    array(
                        'user_id' => $request['user_id'],
                        'role_id' => $role->id
                    )
                )
                ->delete();
        }

        return response(['message' => 'Успешный запрос!'], 200);
    }

}
