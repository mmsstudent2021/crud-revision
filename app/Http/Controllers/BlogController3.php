<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;

class BlogController3 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $blogs = Blog::when(request('keyword'),function ($q){
        $keyword = request("keyword");
        $q->where("title","like","%$keyword%")
            ->orWhere("description","like","%$keyword%");
    })->paginate(10)->withQueryString();
//        $blogs=Blog::where("id",1)->paginate(10)->through(function ($blog){
//            $blog->title = strtoupper($blog->title);
//            $blog->user_id = rand(1,45);
//            return $blog;
//        });
//        dd($blogs->isEmpty());
//        return $blogs;
//        dd($blogs);
        return view('blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {


//        $blog = new Blog();
//        $blog->title = $request->title;
//        $blog->description = $request->description;
//        $blog->save();

        Blog::create([
            "title" => $request->title,
            "description" => $request->description
        ]);

//        Blog::create($request->all());

        return redirect()->route('blog.index')->with("status","New Post is created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return $blog;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {


        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->update();

        return redirect()->route("blog.index")->with("status","Post is Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')->with("status","New Post is deleted");
    }
}
