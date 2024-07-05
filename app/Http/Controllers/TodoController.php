<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoCategory;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $todos = DB::table('todos')
        //             ->join('todo_categories', 'todos.todo_category_id', '=', 'todo_categories.id')
        //             ->join('users', 'todos.user_id', '=', 'users.id')
        //             ->get();
        $todos = Todo::join('todo_categories', 'todo_categories.id', '=', 'todos.todo_category_id')
            ->join('users', 'users.id', '=', 'todos.user_id')
            ->select(
                'users.*',
                'todo_categories.*',
                'todos.id as todo_id',
                'todos.todo_category_id',
                'todos.user_id',
                'todos.title',
                'todos.description',
                )
            ->get();
        // dd($todos);
        return view('todo.todo', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $todocategories = TodoCategory::where('user_id', 1)->get();
        // dd($todocategories); //var_dump(); die;
        return view('todo.create', compact('todocategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $value = [
            'todo_category_id' => $request->todo_category_id,
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ];

        Todo::create($value);
        return redirect('todo');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todocategories = TodoCategory::where('user_id', Auth::user()->id)->get();
        
        return view('todo.edit', compact('todo', 'todocategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'todo_category_id' => 'required|exists:todo_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $todo = Todo::findOrFail($id);
        $todo->todo_category_id = $request->input('todo_category_id');
        $todo->title = $request->input('title');
        $todo->description = $request->input('description');
        $todo->save();
    
        return redirect()->route('todo.index')->with('success', 'Todo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
    $todo->delete();

    return redirect()->route('todo.index')->with('success', 'Todo deleted successfully');
    }
}
