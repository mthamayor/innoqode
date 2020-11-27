<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created user resource.
     *
     * @param  \Illuminate\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(UserRequest $request)
    {
        $id = User::create([
            'first_name' => ucwords(strtolower($request->first_name)),
            'middle_name' => ucwords(strtolower($request->middle_name)),
            'last_name' => ucwords(strtolower($request->last_name)),
            'username' => $request->username,
            'date_of_birth' => $request->date_of_birth,
        ])->id;

        return response()->json([
            'data' => new UserResource(User::find($id))
        ], 201);
    }

    /**
     * Get a list of paginated users
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Request $request)
    {
        return (UserResource::collection(User::paginate(10)))->response()->setStatusCode(206);
    }

    /**
     * Gets a particular user
     *
     * @param  int  $id id of the model
     * @return \Illuminate\Http\Response
     */
    public function getUser($id)
    {
        return response()->json([
            'data' => new UserResource(User::find($id))
        ], 200);
    }

    /**
     * Update the specified model.
     *
     * @param int $id id of user to be updated
     * @param  \Illuminate\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateUser($id, UpdateUserRequest $request)
    {
        $user = User::find($id);

        if ($request->first_name) {
            $user->first_name = ucwords(strtolower($request->first_name));
        }

        if ($request->last_name) {
            $user->last_name = ucwords(strtolower($request->last_name));
        }

        if ($request->middle_name) {
            $user->middle_name = ucwords(strtolower($request->middle_name));
        }

        if ($request->username) {
            $user->username = $request->username;
        }

        if ($request->date_of_birth) {
            $user->date_of_birth = $request->date_of_birth;
        }

        $user->save();

        return response()->json([
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUser($id)
    {
        User::destroy($id);
        return response()->json([
            'message' => 'User deleted successfully.'
        ], 200);
    }
}
