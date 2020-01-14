<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EditController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMainInfo(Request $request)
    {
        $this->validate($request, [
            'first_name' => array(
                'required',
                'string',
                'max:255',
                'regex:/[А-Яа-я]+/is'
            ),
            'second_name' => array(
                'required',
                'string',
                'max:255',
                'regex:/[А-Яа-я]+/is'
            ),
            'third_name' => array(
                'nullable',
                'string',
                'max:255',
                'regex:/[А-Яа-я]+/is'
            ),
            'sex' => 'required|integer',
            'birth_date' => 'nullable'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        $user->first_name = $request['first_name'];
        $user->second_name = $request['second_name'];
        $user->third_name = $request['third_name'];
        $user->sex = $request['sex'];
        $user->birth_date = $request['birth_date'];
        $user->save();

        return response(
            [
                'message' => 'Данные успешно обновлены!',
                'first_name' => $user->first_name,
                'second_name' => $user->second_name,
                'third_name' => $user->third_name,
                'sex' => $user->sex,
                'birth_date' => $user->birth_date
            ],
        200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateContacts(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }

        if ($user->email != $request['email'] && $user->phone_number != $request['phone_number']) {
            $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => array(
                    'required',
                    'unique:users',
                    'regex:/\+[7][\b\d\b]{10}/is',
                    'max:12'
                )
            ]);

            $user->email = $request['email'];
            $user->email_verified_at = null;
            $user->phone_number = $request['phone_number'];
            $user->save();

            return response([
                'message' => 'Email и номер телефона обновлены!',
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone_number' => $user->phone_number
            ], 200);
        } else if ($user->email == $request['email'] && $user->phone_number != $request['phone_number']) {
            $this->validate($request, [
                'phone_number' => array(
                    'required',
                    'unique:users',
                    'regex:/\+[7][\b\d\b]{10}/is',
                    'max:12'
                ),
            ]);

            $user->phone_number = $request['phone_number'];
            $user->save();

            return response([
                'message' => 'Номер телефона обновлён!',
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone_number' => $user->phone_number
            ], 200);
        } else if ($user->email != $request['email'] && $user->phone_number == $request['phone_number']) {
            $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            $user->email = $request['email'];
            $user->email_verified_at = null;
            $user->save();

            return response([
                'message' => 'Email обновлён!',
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone_number' => $user->phone_number
            ], 200);
        } else {
            return response([
                'message' => 'Нет данных для обновления',
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone_number' => $user->phone_number
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'image' => 'required'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        $user->image = $request['image'];
        $user->save();

        return response([
            'message' => 'Фотография профиля обновлена!',
            'image' => $user->image
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBio(Request $request)
    {
        $this->validate($request, [
            'specialization' => 'nullable|string',
            'info' => 'nullable|string'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        $user->specialization = $request['specialization'];
        $user->info = $request['info'];
        $user->save();

        return response([
            'message' => 'Информация о себе обновлена!',
            'info' => $user->info,
            'specialization' => $user->specialization
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verifyEmail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email'
        ]);

        $message = Hash::make($request['email']);
        $data = array(
            'name' => $request['name'],
            'message' => $message
        );

        Mail::to($request['email'])->send(new SendMail($data));

        return response(['message' => 'Проверьте почту, на неё был выслан код!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        if (Hash::check($user->email, $request['email'])) {
            $user->email_verified_at = date('Y-m-d h:i:s');
            return response([
                'message' => 'Email подтверждён успешно!',
                'email_verified_at' => $user->email_verified_at
            ], 200);
        }
        return response(['message' => 'Неверный код!'], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getTopics(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }

        $topics = DB::table('topics')
            ->leftJoin('user_topic', function ($join) use ($user) {
                $join->on('topics.id', '=', 'user_topic.topic_id')
                    ->where('user_topic.user_id', '=', $user->id);
            })
            ->orderBy('topics.id', 'asc')
            ->select('topics.id', 'topics.name', 'user_topic.topic_id')
            ->get();

        return response(['topics' => $topics], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateTopics(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        $arrayRequest = $request['topics'];
        $arrayDB = DB::table('user_topic')
            ->select(array('topic_id'))
            ->where(array('user_id' => $user->id))
            ->get();

        //TODO: converting to colection [ 2, 5, 9] from [{...},{...},...]
        $tmp = array();
        foreach ($arrayRequest as $item) {
            if ($item['topic_id'] != null) {
                array_push($tmp, (int)$item['id']);
            }
        }
        $collectionRequest = collect($tmp);

        $tmpDB = array();
        foreach ($arrayDB as $item) {
            array_push($tmpDB, $item->topic_id);
        }
        $collectionDB = collect($tmpDB);

        $insertItems = $collectionRequest->diff($collectionDB);
        $deleteItems = $collectionDB->diff($collectionRequest);

        foreach ($deleteItems as $item) {
            DB::table('user_topic')
                ->where(array(
                    array('user_id', '=', $user->id),
                    array('topic_id', '=', $item)
                ))
                ->delete();
        }

        foreach ($insertItems as $item) {
            DB::table('user_topic')
                ->insert(array('user_id' => $user->id, 'topic_id' => $item));
        }

        return response([
            'message' => 'Ваши интересы обновлены!',
            'topics' => $collectionRequest->all()
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAllow(Request $request)
    {
        $this->validate($request, [
            'allow_status' => 'nullable|boolean'
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        $user->allow_status = $request['allow_status'];
        $user->save();

        if ($user->allow_status) {
            return response([
                'message' => 'Вы подписались на рассылку обновлений нашей платформы!',
                'allow_status' => $user->allow_status
            ], 200);
        }
        return response([
            'message' => 'Вы отписались от рассылки обновлений нашей платформы!',
            'allow_status' => $user->allow_status
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
            'new_password_confirmation' => 'required|string|min:8',
        ]);

        $user = $request->user();
        if ($user == null) {
            return response(['message' => -1], 200);
        }
        if (Hash::check($request['old_password'], $user->password)) {
            if ($request['new_password'] == $request['new_password_confirmation']) {
                $user->password = Hash::make($request['new_password']);
                return response(['message' => 'Вы успешно изменили пароль!'], 200);
            } else {
                return response(['message' => 'Пароли не схожи, повторите запрос!'], 200);
            }
        } else {
            return response(['message' => 'Ваш старый пароль не совпадает с введённым!'], 200);
        }
    }
}
