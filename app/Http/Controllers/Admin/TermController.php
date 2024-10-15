<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $term = Term::first();
        return view('admin.terms.index', compact('term'));
    }

  
    public function edit(Term $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $term->content = $request->input('content');

        return tp_route('admin.terms.index')->with('flash_message', '利用規約を編集しました。');
    }


}
