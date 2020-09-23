<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, DeleteRequest, UpdateRequest, LoginRequest};
use App\Exceptions\{ApiValidationException, ModelNotFoundException};
use App\User;


class UserController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * create
     *
     * @param  \App\Http\Requests\User\CreateRequest  $request
     * @return mixed
     */
    protected function create(CreateRequest $request)
    {
        $data = $request->validated();

        User::create([
            'account' => $data['account'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->apiSuccess([
            'IsOK' => true
        ], Response::HTTP_CREATED);
    }

    /**
     * update
     *
     * @param  \App\Http\Requests\User\UpdateRequest  $request
     * @return mixed
     */
    protected function update(UpdateRequest $request)
    {
        $data = $request->validated();

        if ($user = User::find($data['account'])) {
            //user update password
            $user->password = Hash::make($data['password']);
            $user->save();

            return response()->apiSuccess([
                'IsOK' => true
            ], Response::HTTP_OK);
        }

        throw new ModelNotFoundException('帳號不存在', 3);

    }

    /**
     * delete
     *
     * @param  \App\Http\Requests\User\DeleteRequest  $request
     * @return mixed
     */
    protected function delete(DeleteRequest $request)
    {
        $data = $request->validated();

        if ($user = User::find($data['account'])) {
            $user->delete();
            return response()->apiSuccess([
                'IsOK' => true
            ], Response::HTTP_OK);
        }

        //account 
        throw new ModelNotFoundException('帳號不存在', 3);

    }

    /**
     * login
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @return mixed
     */
    protected function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt(['account' => $data['account'], 'password' => $data['password']])) {
            return response()->apiSuccess(null, Response::HTTP_OK);
        }

        // Login Failed
        throw new ApiValidationException('Login Failed', 2);
    }
}
