<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings');
    }

    public function changePass(ChangePassRequest $request)
    {
        User::query()->where('id', auth()->id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return ['success' => true];
    }

    public function deleteAccount(DeleteAccountRequest $request)
    {
        User::destroy(auth()->id());

        return redirect('/');
    }

    public function update($setting, Request $request)
    {
        User::where('id', $setting)->update([
            'name'  => $request->name,
        ]);

        return redirect()->route('settings.index');
    }
}
