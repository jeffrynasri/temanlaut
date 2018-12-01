<?php

namespace App\Http\Controllers;

use App\Dermaga;
use Illuminate\Http\Request;

class DermagaController extends Controller
{

    public function showAllDermagas()
    {
        return response()->json(Dermaga::all());
    }

    public function showOneDermaga($id)
    {
        return response()->json(Dermaga::find($id));
    }

    public function create(Request $request)
    {
        $author = Dermaga::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $author = Dermaga::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Dermaga::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}