<?php

namespace App\Http\Controllers;

use App\Models\TodoCategory;
use Illuminate\Http\Request;

class TodoCategoryController extends Controller
{
    public function index()
    {
        $categories = TodoCategory::all();
        return view('todo-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('todo-categories.create');
    }

    public function store(Request $request)
    {
        TodoCategory::create($request->all());
        return redirect()->route('todo-categories.index');
    }

    public function edit(TodoCategory $todoCategory)
    {
        return view('todo-categories.edit', compact('todoCategory'));
    }

    public function update(Request $request, TodoCategory $todoCategory)
    {
        $todoCategory->update($request->all());
        return redirect()->route('todo-categories.index');
    }

    public function destroy(TodoCategory $todoCategory)
    {
        $todoCategory->delete();
        return redirect()->route('todo-categories.index');
    }
}
