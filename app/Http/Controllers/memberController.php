<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class memberController extends Controller
{
    public function index()
    {
        $user=User::where('deleted',false)->get();
        $roles=Role::all();
        return view('Menu.Member.member',compact('user','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Form.memberInput');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->name=$request->fullname;
            $user->email=$request->email;
            $user->jabatan=$request->job_title;
            $user->password=$request->password;
            $user->save();
            $user->syncRoles($request->role);
            return redirect('/Member')->with(["success"=>"Data Member Berhasil Ditambahkan"]);
        } catch (\Throwable $th) {
            return redirect('/Member')->with(["error"=>$th->getMessage()]);
        }


    }

    public function fetchUserRole(Request $request){
        $data['userRole']=User::findUserRole($request->idUser);
        $data['roles']=Role::all();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $user = User::findOrFail($request->idUser);
            $user->syncRoles($request->role);
            return redirect('/Member')->with(["success"=>"Data Member Berhasil di Update"]);

        } catch (\Throwable $th) {
            return redirect('/Member')->with(["error"=>$th->getMessage()]);
        }
    }



    function profile(){

        $roles=Role::all();
        return view('auth.profile',compact('roles'));

    }

    function bio(Request $request)
    {
        try {
            //code...
            User::where("id", $request->id)->update([
                "name" => $request->nama,
                "email" => $request->email,
                "jabatan" => $request->jabatan,
                // "password" => $request->password,
            ]);
            return redirect('/Profile')->with(["success"=>"Data Profil Berhasil Di Update"]);
        } catch (\Throwable $th) {
            return redirect('/Profile')->with(["error"=>$th->getMessage()]);
        }

    }

    function account(Request $request)
    {
        User::where("id", $request->id)->update([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role,
            // "password" => $request->password,
        ]);
        return redirect('/Profile');
    }

    function destroy(Request $request){
        try {
            User::where('id',$request->idUser)->update([
                'deleted'=>true,
                'password'=>"",
                'email'=>rand(1,299902)."@"."failed.com"
            ]);
            return redirect()->back()->with(['success'=>"Data Member Berhasil Dihapus"]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error'=>$th->getMessage()]);
        }
    }
}
