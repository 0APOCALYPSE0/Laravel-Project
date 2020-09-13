<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Post::orderBy('id', 'DESC')->where('post_type', 'page')->get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.page.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thumbanil' => 'required',
            'title' => 'required|unique:posts',
            'details' => 'required',
            'category_id' => 'required'
        ], [
            'thumbanil.required' => 'Enter thumbnail Url',
            'title.required' => 'Enter title',
            'title.unique' => 'Title is already exist',
            'details.required' => 'Enter details',
            'category.required' => 'Select categories'
        ]);

        $page = new Post();
        $page->user_id = Auth::id();
        $page->thumbanil = $request->thumbanil;
        $page->title = $request->title;
        $page->slug = str_slug($request->title);
        $page->sub_title = $request->sub_title;
        $page->details = $request->details;
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->save();

        $page->categories()->sync($request->category_id, false);

        Session::flash('message', 'Page created successfully');
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $page)
    {
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.page.edit', compact('categories', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $page)
    {
        $this->validate($request, [
            'thumbanil' => 'required',
            'title' => 'required|unique:posts,title,'. $page->id,
            'details' => 'required',
            'category_id' => 'required'
        ], [
            'thumbanil.required' => 'Enter thumbnail Url',
            'title.required' => 'Enter title',
            'title.unique' => 'Title is already exist',
            'details.required' => 'Enter details',
            'category.required' => 'Select categories'
        ]);

        $page->user_id = Auth::id();
        $page->thumbanil = $request->thumbanil;
        $page->title = $request->title;
        $page->slug = str_slug($request->title);
        $page->sub_title = $request->sub_title;
        $page->details = $request->details;
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->save();

        $page->categories()->sync($request->category_id, false);

        Session::flash('message', 'Page updated successfully');
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $page)
    {
        $page->delete();
        Session::flash('delete-message',"Page deleted successfully.");
        return redirect()->route('pages.index');
    }
}
