<?php

namespace App\Http\Controllers;

use App\Exceptions\FieldsException;
use App\Helpers\Lang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request, [
            'name' => 'required|between:3,50',
            'last_name_1' => 'required|between:3,50',
            'last_name_2' => 'nullable|string',
            'email' => 'required|email|unique:users|between:10,50',
            'password' => 'required|string|min:6',
            'need_change_password' => 'boolean',
        ]);

        $user = User::create(array_merge(
            $validator,
            ['password' => bcrypt($request->password)],
        ));

        $user = User::where('user_id', $user->user_id)->first();
        return $this->response($user, 201);
    }

    public function list(Request $request)
    {
        $query = $this->validator($request, [
            'is_root' => 'boolean',
            'order' => 'string',
            'date_from' => 'date',
            'date_to' => 'date',
        ]);

        $users = User::where(array_merge(['archived' => false]));

        $users = $this->globalFilter($query, $users, 'user_id');

        if (array_key_exists('is_root', $query)) {
            $users = $users->where('is_root', $query['is_root']);
        }

        return $this->response($users->paginate(12), 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::where(['archived' => false, 'user_id' => $id]);
        if (! $user) {
            return $this->response(Lang::get('api.user_not_found'), 404);
        }

        return $this->response($user, 200);
    }

    public function update($id, Request $request)
    {
        try {
            $validator = $this->validator($request, [
                'name' => 'between:3,50',
                'last_name_1' => 'between:3,50',
                'last_name_2' => 'nullable|between:2,50',
                'email' => 'email|between:10,50',
                'password' => 'string|min:6',
                'need_change_password' => 'boolean',
            ]);
            $validated = $validator;
            if ($request->password) {
                if (Hash::check($request->password, $request->user->password)) {
                    return $this->response(Lang::get('api.password_same'), 422);
                }
                $validated = array_merge($validated, ['password' => bcrypt($request->password)]);
            }
            $user = User::where(['user_id' => $id, 'archived' => false])->first();

            if (! $user) {
                return $this->response(Lang::get('api.user_not_found'), 404);
            }

            $user = User::where('user_id', $id)->first();

            return $this->response($user, 200);
        } catch (Throwable $exception) {
            switch ($exception->getCode()) {
                case 23000:
                    throw new FieldsException(['email' => [Lang::get('validation.unique', ['attribute' => 'email'])]]);
            }

            throw $exception;
        }
    }

    public function delete($id, Request $request)
    {
        $user = User::where(['archived' => false, 'user_id' => $id])->first();

        if (! $user) {
            return $this->response(Lang::get('api.user_not_found'), 404);
        }

        $user->email = $user->email.'.archived.'.$user->user_id;
        $user->archived = true;
        $user->save();

        return $this->response(Lang::get('api.user_deleted'), 200);
    }

    public function updateRoot(Request $request, $id)
    {
        $validator = $this->validator($request, [
            'is_root' => 'required|boolean',
        ]);

        User::find($id)->update(array_merge(
            $validator,
        ));
        $user = User::where('user_id', $id)->first();

        return $this->response($user, 200);
    }
}
