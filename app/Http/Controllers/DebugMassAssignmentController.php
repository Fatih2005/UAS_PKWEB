<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class DebugMassAssignmentController extends Controller
{
    public function store(Request $request)
    {
        // Same vulnerable pattern as real TodoController@store
        $data = array_merge(
            $request->except('_token', 'attachment'),
            ['user_id' => Auth::id()]
        );

        $todo = Todo::create($data);

        return response()->json([
            'ok' => true,
            'data' => $todo->toArray(),
        ]);
    }
}
