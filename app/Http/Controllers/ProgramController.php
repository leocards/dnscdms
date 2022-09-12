<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\Institute;
use App\Models\Program;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    public $program;
    public $institutes;
    public $accredit;

    public function __construct()
    {
        $this->program = Program::all(['id', 'name', 'description', 'instituteID', 'resolution', 'established']);
        $this->institutes = Institute::all(['id', 'description', 'name']);
        $this->accredit = Accreditation::where('parent', null)->get(['id', 'title', 'set', 'program_id']);
    }   

    public function index()
    {
        return Inertia::render('program', ['programs'=>$this->program, 'accredit'=>$this->accredit]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:programs',
            'description'=>'required|unique:programs',
            'institute'=>'required',
            'resolution'=>'numeric',
        ]);

        $create = new Program();
        $create->name = $request->name;
        $create->description = $request->description;
        $create->instituteID = $request->institute;
        $create->resolution = $request->resolution;
        $create->established = $request->established;
        $program = $create->save();

        if($program){
            return redirect()->back()->with('success', 'New program added');
        }else{
            return redirect()->back()->with('error', 'Unable to add program');
        }

    }

    public function show($program, $id = null)
    {
        Global $crumbs;
        $crumbs = [];
        $parent = $id;
        $officials = [];
        $facultymmbrs = [];

        function getParents($id){
            global $crumbs;
            $parent = Accreditation::where('id', $id)->first(['id', 'title', 'set', 'parent']);
            if($parent != null){
                array_unshift($crumbs, json_decode($parent));
                getParents($parent->parent);
            }
        }

        if($id !== null){
            getParents($id);
        }

        $parent = Accreditation::find($id);

        $instruments = Accreditation::query()
        ->join('programs', 'programs.id', '=', 'accreditations.program_id')
        ->where('accreditations.program_id', $program)->where('parent', $id)
        ->get(['accreditations.id', 'accreditations.set as set', 'programs.name as program', 'programs.id as progId', 
        'accreditations.title as title', 'accreditations.description', 'accreditations.status', 'accreditations.date_survey', 
        'accreditations.category', 'accreditations.parent'])
        ->sortBy([ ['set', 'asc'], ['title', 'asc']]);

        $programs = Program::where('id', $program)->first(['id', 'name', 'instituteId']);

        //get Faculty and Staff
        $programMembers = User::leftjoin('designations as d', 'd.id', '=', 'users.designationId')
        ->where('users.programId', $programs->id)
        ->where('users.instituteId', $programs->instituteId)
        ->orWhere('users.programId', null)
        ->where('users.instituteId', $programs->instituteId)
        ->get(['users.id', 'users.lname', 'users.fname', 'd.title']);

        foreach($programMembers as $user){
            if(strtolower($user->title) == 'dean'){
                array_unshift($officials, json_decode($user));
            }else if(strtolower($user->title) == 'program chair' || strtolower($user->title) == 'chair person'){
                array_push($officials, json_decode($user));
            }
        }

        foreach($programMembers as $user){
            if(strtolower($user->title) != 'dean' ){
                if(strtolower($user->title) != 'program chair' || strtolower($user->title) != 'chair person'){
                    array_push($facultymmbrs, json_decode($user));
                }
            }
        }

        end($crumbs);
        $prevs = prev($crumbs);
        if($prevs === false){$prevs = null;}

        $task = Task::leftjoin('users as u', 'u.id', '=', 'tasks.userId')
        ->where('tasks.programId', $program)->where('tasks.parent', null)->where('tasks.action', null)
        ->get(['tasks.id as taskId', 'tasks.userId', 'tasks.programId', 'tasks.accredId', 'u.id as user', 'u.lname', 'u.fname']);


        return Inertia::render('Programs/programAccredit', 
        ['progInst'=>$instruments, 'program'=>$programs, 'crumbs'=>$crumbs, 'parent'=>$parent, 'prev'=>$prevs, 
        'members'=>$facultymmbrs, 'ofc'=>$officials, 'assigned'=>$task]);
    }

    public function showProgram($id){   

        $view = Program::join('institutes as i', 'i.id', '=', 'programs.instituteID')
        ->where('programs.id', $id)
        ->first(['programs.name', 'programs.description', 'i.name as institute', 'programs.resolution', 'programs.established']);

        $accredited = Accreditation::where('program_id', $id)
        ->where('parent', null)->where('status', 'accredited')
        ->get(['title']);

        $unadccredited =  Accreditation::where('program_id', $id)
        ->where('parent', null)->where('status', null)
        ->get(['title']);

        return response()->json(['view'=>$view, 'accredited'=>$accredited, 'unaccredited'=>$unadccredited]);
    }

    public function getInstitute()
    {
        return response()->json(['institute'=>$this->institutes], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'institute'=>'required',
            'resolution'=>'numeric',
        ]);

        $name = Program::where('name', $request->name)->where('id', '!=', $id)->count();
        $description = Program::where('description', $request->description)->where('id', '!=', $id)->count();
        
        if($name == 0){
            if($description == 0){
                $update = Program::find($id);
                $update->name = $request->name;
                $update->description = $request->description;
                $update->instituteID = $request->institute;
                $update->resolution = $request->resolution;
                $update->established = $request->established;
                $program = $update->save();

                if($program){
                    return redirect()->back()->with('success', 'Changes saved');
                }else{
                    return redirect()->back()->with('error', 'Unable to save changes');
                }
            }else{
                return redirect()->back()->withErrors('Program '.$request->description.' Already Exist!');
            }
        }else{
            return redirect()->back()->withErrors('Program '.$request->name.' Already Exist!');
        }
    }

    public function search($search){
        $searchUser = User::join('designations as d', 'd.id', '=', 'users.designationId')
            ->where('users.fname', 'like', "{$search}%")
            ->orWhere('users.lname', 'like', "{$search}%")
            ->orWhere('users.email', 'like', "{$search}%")
            ->get(['users.id', 'users.fname', 'users.lname', 'd.title']);
        
        
        return response()->json(['users'=>$searchUser]);
    }

    public function searchMemberToAssign($userId, $search)
    {
        $searchUser = User::join('designations as d', 'd.id', '=', 'users.designationId')
        ->where('users.fname', 'like', "{$search}%")->where('users.id', '!=', $userId)
        ->orWhere('users.lname', 'like', "{$search}%")->where('users.id', '!=', $userId)
        ->orWhere('users.email', 'like', "{$search}%")->where('users.id', '!=', $userId)
        ->get(['users.id', 'users.fname', 'users.lname', 'd.title']);

        return response()->json(['users'=>$searchUser]);
    }

    public function assignUser(Request $request){

        $exist = Task::where('userId', $request->user)
        ->where('area', $request->task)
        ->where('programId', $request->program)
        ->count();

        if($exist == 0){
            $assign = Task::create([
                'area' => $request->task,
                'userId' => $request->user,
                'accredId' => $request->task,
                'programId' => $request->program,
            ]);

            if($assign){
                return redirect()->back()->with('success', 'User assigned successfully');
            }else{
                return redirect()->back()->with('error', 'Failed to assign user');
            }
        }else{
            return redirect()->back()->with('error', 'User already assigned');
        }

    }

    public function getUserToAssign($program, $institute){
        $inprogram = User::where('programId', $program)->where('instituteId', $institute)
        ->orWhere('instituteId', $institute)->where('programId', null)
        ->get(['id', 'lname', 'fname'])->sortBy('lname');

        return response()->json(['users'=>$inprogram]);
    }

    public function allProgram () {
        return response()->json(['programs'=>$this->program]);
    }

    public function getAssignedMember($userId, $area){
        $members = Task::join('users as u', 'u.id', '=', 'tasks.userId')
        ->where('tasks.parent', $userId)->where('tasks.area', $area)
        ->get(['tasks.id', 'tasks.userId', 'u.lname', 'u.fname']);

        return response()->json(['users'=>$members], 200);
    }

    public function assignMember(Request $request){
        $exist = Task::where('userId', $request->user)
        ->where('programId', $request->program)
        ->where('parent', $request->parent)
        ->where('role', 'member')
        ->count();

        if($exist === 0){
            $assign = Task::create([
                'userId' => $request->user,
                'area' => $request->area,
                'accredId' => $request->task,
                'parent' => $request->parent,
                'programId' => $request->program,
                'role' => $request->role,
            ]);
            if($assign){
                return back()->with('success', 'User assigned as member');
            }else{
                return back()->with('error', 'Failed to assign user');
            }
        }else{
            return back()->with('error', 'User already a member');
        }
    }

    public function destroy($id)
    {
        //
    }
}
