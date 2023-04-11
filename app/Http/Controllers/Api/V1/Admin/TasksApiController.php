<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Admin\TaskResource;
use App\Models\Task;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TasksApiController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api');
    }

    public function index()
    {
        if($user = Auth::guard('api')->user())
        {
            $userid = $user->id;
            $task = Task::where('created_by_id',$userid)->get();
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'task' => $task,
            ]
        ], Response::HTTP_OK);
        
        // abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new TaskResource(Task::with(['department', 'project', 'department_employees', 'created_by'])->get());
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

        // $task = Task::create($request->all());

        // return (new TaskResource($task))
        //     ->response()
        //     ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        // abort_if(Gate::denies('task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskResource($task->load(['department', 'project', 'department_employees', 'created_by']));
    }
//     public function update(Request $request,Task $task)
// {
//     $user = Auth::guard('api')->user();
//     // $task = Task::findOrFail($task);                
//     dd($request['created_by_id']);

    
//     if ($request['created_by_id'] == $user->id) {
//         $task = Task::where('id',$request->id)->first();
//         $task->update($request->all());
//     } elseif ($request['department_employees_id'] == $user->id) {
//         $task = Task::where('id',$request->id)->first();
//         $task->update(['status' => $request->input('status')]);
//     } else {
//         return response()->json([
//             'status' => false,
//             'message' => 'Unauthorized',
//         ], Response::HTTP_UNAUTHORIZED);
//     }

//     return response()->json([
//         'status' => true,
//         'message' => 'Success',
//         'data' => [
//             'task' => $task,
//         ]
//     ], Response::HTTP_OK);
// }
    // public function update(Request $request ,$id)
    // {
    //     $user = Auth::guard('api')->user();
    //     // $taskId = $request->id;
    
    //     $task = Task::findOrFail($id);
    //     if ($task->created_by_id == $user->id) {
    //         $task->update($request->all());
    
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Success',
    //             'data' => [
    //                 'task' => $task,
    //             ]
    //         ], Response::HTTP_OK);
    //     } elseif ($task->department_employees_id == $user->id) {
    //         $task->update($request['status']);
    
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Success',
    //             'data' => [
    //                 'task' => $task,
    //             ]
    //         ], Response::HTTP_OK);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Unauthorized',
    //         ], Response::HTTP_UNAUTHORIZED);
    //     }
    // }

    public function update(Request $request ,Task $task)
    {
            $user = Auth::guard('api')->user();
            if($request['created_by_id'] = $user->id){
            $task = Task::where('id',$request->id)->first();
            $task->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => [
                    'task' => $task,
                ]
            ], Response::HTTP_ACCEPTED);}
            elseif($request['department_employees_id'] = $user->id){
            $task = Task::where('id',$request->id)->first();
            $task->update(['status' => $request->input('status')]);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => [
                    'task' => $task,
                ]
            ], Response::HTTP_ACCEPTED);}


    }
        // Task::where('department_employees_id','=', auth('api')->user()->id)->get()

    public function destroy(Task $task)
    {
        $user = Auth::guard('api')->user() ;
        $userid = $user->id;
        if ($userid){
        $task->delete();
        return 'Success';
        }

    }
}
