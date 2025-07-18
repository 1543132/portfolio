<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkWithPage;
use App\Models\Page;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdminOrEditor()) {
            $pages = Page::all();
        }else{
            $pages = Auth::user()->pages()->get();
        }
        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create')->with(['model' => new Page()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkWithPage $request)
    {
        Auth::user()->pages()->save(new Page($request->only([
            'title',
            'url',
            'content'
        ])));

        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        if (Auth::user()->cant('update', $page)) {
            return redirect()->route('pages.index');
        }

        return view('admin.pages.edit', ['model' => $page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkWithPage $request, Page $page)
    {
        if (Auth::user()->cant('update', $page)) {
            return redirect()->route('pages.index');
        }

        $page->fill($request->only([
            'title',
            'url',
            'content'
        ]));

        $page->save();

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if (Auth::user()->cant('delete', $page)) {
            return redirect()->route('pages.index');
        }
    }
}
