<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstrumentController extends Controller
{
    private $instrument;
    private $parent;

    public function __construct()
    {
        $this->instrument = Instrument::query()
        ->where('parent', null)
        ->where('action', null)
        ->get(["id", "title", "set", "description", 'parent', 'category'])
        ->sortBy(['set', 'asc'], ['title', 'asc']);
    }

    public function index($child = null)
    {
        $instrument = $this->instrument;
        $parent = $child;
        Global $crumbs;
        $crumbs = [];

        function getParents($id){
            global $crumbs;
            $parent = Instrument::where('id', $id)->first(['id', 'title', 'set', 'parent']);
            
            if($parent != null){
                array_unshift($crumbs, json_decode($parent));
                getParents($parent->parent);
            }
        }

        if($child != null){ 
            getParents($child);
            
            $instrument = Instrument::where('parent', $child)
            ->where('action', null)
            ->orderBy('title', 'ASC')
            ->orderBy('set', 'ASC')
            ->get(["id", "title", "set", "description", 'parent', 'category']);

            $parent = Instrument::find($child);
        }

        return Inertia::render('instruments', ['instruments'=>$instrument, 'parent'=>$parent, 'crumbs'=>$crumbs]);
    }

    public function getInstruments($id)
    {   
        $child = Instrument::where('parent', $id)->where('action', null)->get();
        return response()->json(['childrens'=>$child]);
    }

    public function store(Request $request)
    {
        if(isset($request->categoryDir)){

            $exist = Instrument::where('parent', $request->parent)
            ->where('category', $request->categoryDir['id'])
            ->where('action', null)
            ->count();

            if($exist == 0){
                $create = new Instrument();
                $create->title = $request->categoryDir['title'];
                $create->description = $request->categoryDir['description'];
                $create->parent = $request->parent;
                $create->category = $request->categoryDir['id'];
                $inst = $create->save();

                if($inst){
                    return redirect()->back()->with('success', 'New category added');
                }else{
                    return redirect()->back()->with('success', 'Unable to save category');
                }
            }else{
                return redirect()->back()->with('error', 'Category already exist');
            }


        }else{
            $request->validate([
                "name"=>"required"
            ]);

            if($request->category != null){
                $request->validate([
                    "set"=>"required"
                ]);
            }
    
            $exist = Instrument::where('parent', $request->parent)
            ->where('title', $request->name)
            ->where('set', $request->set)
            ->where('action', null)
            ->count();
    
            if($exist === 0){
                $create = new Instrument();
                $create->title = $request->name;
                $create->set = $request->set;
                $create->description = $request->description;
                $create->parent = $request->parent;
                $create->category = $request->category;
                $instrument = $create->save();
        
                if($instrument){
                    return redirect()->back()->with('success', 'New instrument added');
                }else{
                    return redirect()->back()->with('success', 'Unable to save instrument');
                }
            }else{
                return redirect()->back()->withErrors('Instrument name already exist!');
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $exist = Instrument::where('id', $id)->where('action', null)->count();
        if($exist === 0){
            return redirect()->back()->with('error', 'Can\'t find the instrument.');
        }else{
            return response()->json(['instrument'=>Instrument::where('id', $id)->where('action', null)->first()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name"=>"required"
        ]);

        $exist = Instrument::where('parent', $request->parent)
        ->where('title', $request->name)
        ->where('set', $request->set)
        ->where('description', $request->description)
        ->where('action', null)
        ->where('id', '!=', $id)->count();

        if($exist === 0){
            $update = Instrument::find($id);
            $update->title = $request->name;
            $update->set = $request->set;
            $update->description = $request->description;
            $update->parent = $request->parent;
            $instrument = $update->save();

            if($instrument){
                return redirect()->back()->with('success', 'Updated successfully!');
            }else{
                return redirect()->back()->with('error', 'Unable to save changes');
            }
        }else{
            return redirect()->back()->withErrors('Instrument name and set already exist!');
        }

    }

    public function destroy($id)
    {
        $remove = Instrument::where('id', $id)->update(['action'=>'remove']);
        if($remove){
            return redirect()->back()->with('success', 'Removed successfully');
        }
    }
}
