<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstituteController extends Controller
{

    public function index()
    {
        $deans = [];
        $users = User::leftjoin('designations as d', 'd.id', '=', 'users.designationId')
        ->get(['users.id', 'users.lname', 'users.fname', 'users.instituteId', 'd.title']);

        foreach ($users as $dean) {
            if(strtolower($dean->title) == 'dean'){
                array_push($deans, json_decode($dean));
            }
        }


        return Inertia::render('institute', ['institutes'=> Institute::all(['id', 'name', 'description', 'established', 'Dean']),
        'deans'=>$deans]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name'=>'required|unique:institutes',
            'description'=>'required|unique:institutes',
            'established'=>'date',
        ]);

        $create = new Institute();
        $create->name = $request->name;
        $create->description = $request->description;
        $create->Dean = $request->dean;
        $create->established = $request->established;
        $inst = $create->save();

        if($inst){
            return redirect()->back()->with('success', 'New institute added');
        }else{
            return redirect()->back()->with('error', 'Unable to add institute');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'established'=>'date',
        ]);

        $ifExist = Institute::where('id', '!=', $id)->where('description', $request->description)
                    ->orWhere('name', $request->name)->where('id', '!=', $id)->count();
        
        if($ifExist === 0){
            $update = Institute::find($id);
            $update->name = $request->name;
            $update->description = $request->description;
            $update->Dean = $request->dean;
            $update->established = $request->established;
            $inst = $update->save();

            if($inst){
                return redirect()->back()->with('success', 'Changes saved');
            }else{
                return redirect()->back()->with('error', 'Unable to save changes');
            }
        }else{
            return redirect()->back()->withErrors('Institute already exist');
        }

    }

}
