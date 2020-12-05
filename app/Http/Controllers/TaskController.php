<?php

namespace App\Http\Controllers;

use App\Http\Model\TaskModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $data = json_decode(current(config('guahao')),true)['data'];

        $task_list = TaskModel::all();

        return view('welcome', ['data' => json_encode($data), 'task_list' => $task_list]);
    }
    public function add(Request $request)
    {
        $filter = $request->except(['_token']);
        $filter['hospital_id'] = 1;
        TaskModel::create($filter);
        return redirect()->action('TaskController@index');
    }
}
