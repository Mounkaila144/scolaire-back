<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return  User::all();


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $User= User::find($id);

        Return response()->json($User);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = [];
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
            ]
        ]);
        $data["name"] = $request->name;
        $data["username"] = $request->username;
        $data["role"] = $request->role;
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }


    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->input(["data"]);
        $d = [];
        foreach ($data as $id) {
            $d[] = User::findOrFail($id);
        }

        foreach ($d as $user) {
            if ($user) {
                $user->delete();
            } else {
                return response()->json("eureur");
            }
        }
        return response()->json("sucess");
    }

}
