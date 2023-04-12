<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Admin\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class TasksApiController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api');
    }

    public function index()
    {
 
        $task = Task::where('created_by_id',auth()->id())->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'task' => $task,
            ]
        ], Response::HTTP_OK);
        
    }
    public function taskEmployee()
    {
        $task = Task::where('department_employees_id',auth()->id())->get();
      
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'task' => $task,
            ]
        ], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $user = Auth::guard('api')->user() ;
        $request['created_by_id']= $user->id;
        $task = Task::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'time' => $task,
            ]
        ], Response::HTTP_OK);

    }

    public function show(Task $task)
    {
        return new TaskResource($task->load(['department', 'project', 'department_employees', 'created_by']));
    }

        public function update(Request $request,Task $task)
        {
            Gate::authorize('update', $task);
            if (auth()->id() == $request->input('department_employees_id')){
                $task->update([
                   'status' => $request->input('status'),
                ]);
            } else{
                $task->update($request->all());
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => [
                    'task' => $task,
                ]
            ], Response::HTTP_ACCEPTED);
        }

    public function destroy(Task $task)
    {
        if (auth()->id() == $task->created_by_id){
            $task->delete();
            return 'Success';
        }
    }
}
