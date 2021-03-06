<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
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
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => array(
                'required',
                'unique:users',
                'regex:/\+[7][\b\d\b]{10}/is',
                'max:12'
            ),
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',
            'sex' => 'required|integer',
            'birth_date' => 'nullable'
        ]);

        if ($request['password'] == $request['password_confirmation']) {
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

            return response(['Successfully registered!'], 201);
        } else {
            return response(['Wrong password confirmation.'], 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean'
        ]);

        $user = User::where('email', $request['email'])->first();

        if ($user) {
            if (Hash::check($request['password'], $user->password)) {

                $tokenResult = $user->createToken('ErhuCchwl4bN7uifHOmUR9CM56QE374jQi9bsQqc');
                $token = $tokenResult->token;

                if ($request['remember_me']) {
                    $token->expires_at = Carbon::now()->addMinutes(30);
                }

                $token->save();

                $roles = DB::table('user_role')
                    ->join('roles', 'user_role.role_id', '=', 'roles.id')
                    ->where('user_role.user_id', '=', $user->id)
                    ->where('roles.name', '!=', 'Участник')
                    ->orderBy('roles.id')
                    ->select('roles.id', 'roles.name')
                    ->get();
                $dashboard_access = count($roles) == 0 ? 0 : 1;

                return response([
                    'dashboard_access' => $dashboard_access,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                    'now_datetime' => date('Y-m-d h:i:s'),
                    'user' => $user
                ], 200);
            } else {
                return response(['Wrong password'], 401);
            }
        } else {
            return response(['Wrong data'], 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(['Successfully logged out!'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response($request->user(), 200);
    }
}
