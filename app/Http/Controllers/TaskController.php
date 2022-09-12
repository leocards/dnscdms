<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct()
    {
    }
    
    public function index($name = null, $id = null)
    {   
        $assigned = Task::join('accreditations as a', 'a.id', '=', 'tasks.accredId')
        ->rightjoin('programs as p', 'p.id', '=', 'tasks.programId')
        ->where('tasks.userId', session()->get('userId'))
        ->get(['tasks.id', 'p.name as program',
        'tasks.parent', 'tasks.dueDate', 'tasks.dueTime', 'a.title', 'a.set', 'a.parent as accredParent', 'a.description', 'a.category']);



        return Inertia::render('task', ['Tasks'=>$assigned]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
