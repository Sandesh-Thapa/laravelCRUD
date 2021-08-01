<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all tasks
        //$tasks = Task::latest()->paginate(10);
       //$tasks = Task::all();
       $tasks = DB::table('tasks')->paginate(10);
       $latest_tasks = Task::latest()->take(10)->get();
       $completed_task_count = Task::where('completed','=','1')->count();
       $incomplete_task_count = Task::where('completed','=','0')->count();
       $total = Task::all()->count();

       return view('task.index', [
           'tasks' => $tasks,
           'latest' => $latest_tasks,
           'complete' => $completed_task_count,
           'incomplete' => $incomplete_task_count,
           'total' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks|max:50|min:2',
        ]);

        $task = new Task;
        $task->title = $request->all()["title"];
        $task->completed = false;
        $task->save();

        return redirect('/tasks');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->title = $request->all()["title"];
        if (isset($request->all()["completed"])){
            $task->completed = true;
        }else{
            $task->completed = false;
        }
        $task->update();

        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $task = Task::find($id);
        if ($task){
            $task->delete();
            // redirect
            return redirect('/tasks');
        }
        // redirect
        return redirect('/tasks');
    }
}
