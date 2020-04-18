<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function todo() {
        $todos = Todo::all()->where('archive', 0)->sortByDesc('updated_at')->values(); //have to use values, otherwise no sort;
        return $todos; // send stuff back to the front-end;
    }
    public function archive() {
        $archive = Todo::all()->where('archive', 1)->sortByDesc('updated_at')->values(); //getting the data from database;
        return $archive;
    }
    public function update($id, Request $request) {
        $todo = Todo::findOrFail($id);
        $todo->archive = $request->archive;
        $todo->body = $request->body;
        $todo->save();
    }
    public function delete($id) {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
    public function create(Request $request) {
        $todo = new Todo;
        $todo->body = $request->body;
        $todo->save();
    }
}
