<?php

namespace App\Http\Controllers;

use App\Models\Permission as ModelsPermission;
use App\Models\Role as ModelsRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class rolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role=ModelsRole::all();
        $permission=ModelsPermission::all();
        return view('Menu.AccessManagement.roleManagement',compact('role','permission'));
    }

    public function fetchPermission(Request $request){

        $data['permission']=ModelsRole::fetchPermission($request->role);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            ModelsRole::create(['name'=>$request->nama]);
            return redirect('/AccessManagement')->with(["success"=>"Data Role Berhasil Ditambahkan"]);

        } catch (\Throwable $th) {
            return redirect('/AccessManagement')->with(["error"=>$th->getMessage()]);
        }
    }

    public function storePermission(Request $request){
       try {
           $permission= new ModelsPermission();
           $permission->name=$request->nama;
           $permission->save();
           return redirect('/AccessManagement')->with(["success"=>"Data Permission Berhasil Ditambahkan"]);
       } catch (\Throwable $th) {
        return redirect('/AccessManagement')->with(["error"=>$th->getMessage()]);
       }
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
            $role=ModelsRole::findOrFail($request->role);
            $role->syncPermissions($request->permissions);
            return redirect('/AccessManagement')->with(["success"=>"Permission Berhasil Ditambahkan Pada ".$role->name]);

        } catch (\Throwable $th) {
            return redirect('/AccessManagement')->with(["error"=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
