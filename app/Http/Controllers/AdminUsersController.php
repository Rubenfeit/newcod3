<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRequest;
use App\Role;
use App\User;
use App\photo;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $roles = Role::lists('name', 'id')->all();

            return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(trim($request->password)==''){

            $input = $request->except('password');

        }else{

            $input = $request->all();

            $input['password'] = bcrypt($request->password);

        }

       // $file = $request->photo_id;


      if($file = $request->file('photo_id')){
          $name = time().$file->getClientOriginalName(); //tempo de criaçao mais nome originam da foto
          $file -> move('images', $name); //move para a pasta imagens a fotografia, se a pasta nao existe cria uma
          $photo =photo::create(['file' => $name]); // envia a foto para a bdd e recuperamos todos os atributos da foto (id, nome, updated e created)
          $input['photo_id'] = $photo -> id; // o input sao todas as informaçoes para meter na tabela users

    }

    $input['password'] = bcrypt($request->password); //encriptaçao pass

    User::create($input); //criaçao user
        return redirect('/admin/users');



        //User::create($request->all());

      //  return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {

        $user = User::findOrFail($id);

        if(trim($request->password)==''){

            $input = $request->except('password');

        }else{

            $input = $request->all();

            $input['password'] = bcrypt($request->password);
        }



        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file -> move('images', $name);

            $photo = photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;

        }

        $input['password'] = bcrypt($request->password);

        $user->update($input);

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('admin.users.destroy');
    }
}
