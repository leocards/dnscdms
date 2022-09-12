<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Institute;
use App\Models\Member;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    private $users;
    private $institute;
    private $program;
    private $designation;
    public function __construct()
    {
        $this->users = User::all('id', 'lname', 'fname', 'email', 'image');
        $this->institute = Institute::all('id', 'name', 'description');
        $this->program = Program::all('id', 'name', 'instituteID', 'description');
        $this->designation = Designation::all('id', 'title');
    }

    public function index()
    {
        return Inertia::render('user', 
        ['users'=>$this->users, 'institutes'=>$this->institute, 'programs'=>$this->program, 'designations'=>$this->designation]);
    }

    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:users',
            'institute'=>'required',
            'designation'=>'required',
            'password'=>'required',
            'confirm_password'=>'required',
        ]);

        if($request->password != $request->confirm_password){
            return redirect()->back()->withErrors('Password not match');
        }else{
            $create = new User();
            $create->lname = $request->lname;
            $create->fname = $request->fname;
            $create->email = $request->email;
            $create->password = Hash::make($request->password);
            $create->designationId = $request->designation;
            $create->instituteId = $request->institute;
            $create->programId = $request->program;
            $user = $create->save();

            if($user){
                return redirect()->route('user')->with("success", "New user added");
            }else{
                return redirect()->route('user')->with("error", "Unable to add user");
            }
        }
    }

    public function store_designation(Request $request)
    {
        $request->validate([
            'title'=>'required|unique:designations'
        ]);

        $create = new Designation();
        $create->title = $request->title;
        $create->save();
    }

    public function show($id)
    {
        $users = User::join('institutes as i', 'i.id', '=', 'users.instituteId')
        ->leftjoin('programs as p', 'p.id', '=', 'users.programId')
        ->leftjoin('designations as d', 'd.id', '=', 'users.designationId')
        ->where('users.id', $id)
        ->first(['users.lname', 'users.fname', 'users.email', 'd.title', 'i.name as institute', 'p.name as program']);

        return response()->json(['user'=>$users]);
    }

    public function edit($id)
    {
        $user = User::where('id', $id)
        ->first(['id', 'lname', 'fname', 'email', 'designationId', 'instituteId', 'programId']);

        return  response()->json(['user'=>$user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'institute'=>'required',
            'designation'=>'required',
        ]);

        $exist = User::where('id', '!=', $id)->where('email', $request->email)->count();

        if($exist === 0){
            $update = User::find($id);
            $update->lname = $request->lname; 
            $update->fname = $request->fname; 
            $update->email = $request->email; 
            $update->designationId = $request->designation;
            $update->instituteId = $request->institute;
            $update->programId = $request->program;
            $user = $update->save(); 
    
            if($user){
                return redirect()->back()->with('success', 'Changes saved');
            }else{
                return redirect()->back()->with('success', 'Unable to save changes');
            }
        }else{
            $request->validate([
                'email'=>'required|email|unique:users',
            ]);
        }

    }

    public function update_designation(Request $request, $id)
    {
        $request->validate([
            'title'=>'required'
        ]);

        $exist = Designation::where('id', '!=', $id)->where('title', $request->title)->count();

        if($exist === 0){
            $update = Designation::find($id);
            $update->title = $request->title;
            $update->save();
            return redirect()->route('user')->with('success', "Updated Successfully!");
        }else{
            return redirect()->route('user')->with("error", "Title already exist!");
        }

    }

    public function destroy($id)
    {
        //
    }
}
