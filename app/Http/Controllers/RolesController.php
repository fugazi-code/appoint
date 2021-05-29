<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Silber\Bouncer\Bouncer;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{

    public function index()
    {
        return view('roles');
    }

    public function table()
    {
        return DataTables::of(Role::all())->setTransformer(function ($value) {
            return [
                'id'            => $value->id,
                'name'          => $value->name,
                'title'          => $value->title,
                'created_at'    => Carbon::parse($value->created_at)->format('F j, Y')
            ];
        })->make(true);
    }

    public function store(StoreRoleRequest $request, Bouncer $bouncer)
    {
        $bouncer->role()->firstOrCreate([
            'name'  => strtolower($request->role_name),
            'title' => strtolower($request->role_name),
        ]);

        return ['success' => true];
    }

    public function abilities($name, Bouncer $bouncer)
    {
        $abilities = $bouncer->role()->where('name', $name)->get()[0]->getAbilities()->pluck('name');

        return view('abilities', compact('name', 'abilities'));
    }

    public function saveAbilities(Request $request, Bouncer $bouncer)
    {
        $bouncer->sync($request->name)->abilities([]);

        foreach($request->roles as $value){
            $bouncer->allow($request->name)->to($value);
        }

        return ['sucess' => true];
    }
}
