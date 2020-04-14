<?php

namespace App\Http\Controllers\User;

use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     *
     */
    public function create()
    {
        //
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;
        $user = User::create($data);
        return response()->json(['data' => $user], Response::HTTP_OK);
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];
        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('addmin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field', Response::HTTP_CONFLICT);
            }
            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->showOne($user);
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('The account has been verified successfully');
    }

    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', Response::HTTP_CONFLICT);
        }
//        retry(5, function () use ($user) {
//            Mail::to($user)->send(new UserCreated($user));
//        }, 100);
        return $this->showMessage('The verification email has been resend');
    }
}
