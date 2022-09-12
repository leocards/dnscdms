<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\Instrument;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccreditationController extends Controller
{   
    public $instruments;
    public $program;

    public function __construct()
    {
        $this->program = Program::all(['id',  'description', 'instituteID', 'resolution', 'established']);
        $this->instruments = Instrument::where('action', null)->get(["id", "title", "set", "description", 'parent', 'category']);
    }

    public function index($id = null)
    {

        $accreditations = Accreditation::query()
        ->join('programs', 'programs.id', '=', 'accreditations.program_id')
        ->where('accreditations.parent', $id)
        ->get(['accreditations.id', 'accreditations.set as set', 'programs.name as program', 
        'accreditations.title as title', 'accreditations.description', 'accreditations.status', 
        'accreditations.date_survey', 'accreditations.category', 'accreditations.parent', 'accreditations.program_id'])
        ->sortBy([['title', 'asc'], ['set', 'asc']]);
        
        return Inertia::render('accreditation', ['programs' => $this->program, 'accreditations'=>$accreditations]);
    }

    public function getInstruments()
    {   
        $inst = Instrument::query()
        ->where('parent', null)
        ->where('action', null)
        ->get(["id", "title", "set", "description", 'parent', 'category'])
        ->sortBy(['title', 'asc'],['set', 'asc']);

        return response()->json(['instrument' => $inst]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Global $progId;
        Global $inst;
        $request->validate([
            'title'=> 'required',
            'program'=> 'required',
            'sought'=> 'required',
            'instruments'=> 'required'
        ]);

        $create = new Accreditation();
        $create->title = $request->sought;
        $create->description = $request->title;
        $create->date_survey = $request->date_survey;
        $create->program_id = $request->program;
        $accred = $create->save();

        $progId = $request->program;

        if($accred){
            $accreditation = Accreditation::where('parent', null)
            ->where('title', $request->sought)
            ->where('description', $request->title)
            ->where('program_id', $request->program)
            ->first(['id']);

            function getChilds($unique, $id){
                global $progId;
                $childs = Instrument::where('parent', $id)->where('action', null)->get(["id", "title", "set", "description", 'parent', 'category']);

                if(count($childs) !== 0){
                    foreach ($childs as $child) {
                        $create = new Accreditation();
                        $create->unique = $child->id.''.$unique;
                        $create->title = $child->title;
                        $create->set = $child->set;
                        $create->description = $child->description;
                        $create->parent = $unique;
                        $create->program_id = $progId;
                        $create->category = $child->category;
                        $accred = $create->save();

                        $parent = Accreditation::where('unique', $child->id.''.$unique)->first();

                        if($accred){
                            getChilds($parent->id, $child->id);
                        }
                    }
                }
            }

            foreach ($request->instruments as $id) {
                
                $inst = Instrument::where('id', $id)->where('action', null)->first(['id', 'title', 'set', 'category', 'description']);
                //dd($inst->id);
                if($inst !== null){
                    $creates = new Accreditation();
                    $creates->unique = $inst->id.''.$accreditation->id;
                    $creates->title = $inst->title;
                    $creates->set = $inst->set;
                    $creates->description = $inst->description;
                    $creates->parent = $accreditation->id;
                    $creates->program_id = $request->program;
                    $creates->category = $inst->category;
                    $creates->save();

                    $parent = Accreditation::where('unique', $inst->id.''.$accreditation->id)->first();

                    getChilds($parent->id, $inst->id);
                }
            }

            return redirect()->back()->with('success', 'Created successfully');
        }else{
            return redirect()->back()->with('error', 'Unable to create');
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Accreditation::where('id', $id)->first(['id', 'title', 'description', 'program_id', 'date_survey', 'category']);

        return response()->json(['accred'=>$edit]);
    }

    public function update(Request $request, $id)
    {
        $update = Accreditation::find($id);
        $update->description = $request->title;
        $update->title = $request->sought;
        $update->date_survey = $request->date_survey;

        if($update->program_id === $request->program){
            $update->save();
        }else{
            $update->program_id = $request->program;
            $update->save();
            function recursiveUpdate($ids, $prog){
                $childs = Accreditation::where('parent', $ids)->get();
                if(count($childs) !== 0){
                    foreach ($childs as $child) {
                        $updt = Accreditation::where('id', $child->id)->first();
                        $updt->program_id = $prog;
                        $updt->save();
    
                        recursiveUpdate($updt->id, $prog);
                    }
                }
            }
    
            $arr = Accreditation::where('parent', $id)->get(['id']);
    
            foreach($arr as $inst){
                $accred = Accreditation::where('id', $inst->id)->first();
                $accred->program_id = $request->program;
                $accred->save();
                recursiveUpdate($accred->id, $request->program);
            }
        }

        return redirect()->back()->with('success', 'Changes saved');
    }

    public function destroy($id)
    {
        //
    }
}
