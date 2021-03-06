<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        // $users = DB::table('users')->get();
        $users = User::all();

        $title = 'Listado de usuarios';


        return view('users.index', compact('title', 'users'));

    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password'=>['required','alpha_num','between:6,20']

        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo Email es obligatorio',
            'email.unique' => 'Ya existe un usuario con ese email',
            'email.email'=>'El Email debe tener un formato adecuado : sucorrec@example.com',
            'password.required'=>'La contraseña es obligatoria',
            'password.alpha_num' => 'La contraseña debe tener solo caracteres alfanumericos',
            'password.between'=> 'La contraseña debe estar entre 6 y 20 caracteres'
        ]);

        User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
       return view('users.edit',['user' =>$user]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name'=>'required',
            'email'=>['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'=>'',
        ]);
        if($data['password'] != null)
        {
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $user->update($data);

        return redirect()->route('users.show',['user'=>$user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
       return redirect()->route('users.index');
    }
}

//
