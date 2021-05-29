<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use Carbon\Carbon;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Bouncer;

class UsersController extends Controller
{
    public function index(Bouncer $bouncer)
    {
        $roles = $abilities = $bouncer->role()->get();

        return view('users', compact('roles'));
    }

    public function table(Bouncer $bouncer)
    {
        return DataTables::of(User::all())->setTransformer(function ($value) use ($bouncer) {
            $role_name = User::find($value->id)->roles()->get();

            return [
                'id'            => $value->id,
                'name'          => $value->name,
                'email'          => $value->email,
                'created_at'    => Carbon::parse($value->created_at)->format('F j, Y'),
                'role_name'     => !isset($role_name[0]['name']) ?: $role_name[0]['name'],
                'role_title'    => !isset($role_name[0]['title']) ?: $role_name[0]['title'],
            ];
        })->make(true);
    }

    public function assignRole(Request $request, Bouncer $bouncer)
    {
        User::find($request->id)->roles()->detach();
        User::find($request->id)->assign($request->role_name);

        return ['success' => true];
    }

    public function create()
    {
        return view('users-form');
    }

    public function store(UsersStoreRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'tos'      => 'agree',
            'password' => Hash::make($request->password),
            'business_id' => auth()->user()->business_id,
        ]);

        $user->assign('user');

        return ['success' => true];
    }

    public function show($id)
    {
        return view('users-form', ['overview' => User::query()->where('id', $id)->get(), 'id' => $id]);
    }

    public function update(UsersUpdateRequest $request)
    {
        User::where('id', $request->id)->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return ['success' => true];
    }

    public function resetPass(Request $request)
    {
        User::where('id', $request->id)->update([
            'password' => Hash::make('secret'),
        ]);

        return ['success' => true];
    }

    public function destroy($id)
    {
        User::destroy($id);

        return ['success' => true];
    }
}
