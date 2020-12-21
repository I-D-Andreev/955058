<?php

namespace App\Http\Controllers;

use DB;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Number of posts displayed per page.
     */
    private $postsPerPage = 15;

    /**
     * Require authentication to browse posts.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('apiComments');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('posts')->paginate($this->postsPerPage);
        return view('posts.index', ['posts'=> $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'title' => 'required|unique:posts|max:150',
            'title' => 'required|max:150',
            'text' => 'required',
        ]);
        
        $post = new Post;
        $post->title = $validatedData['title'];
        $post->text = $validatedData['text'];
        $post->user_id = Auth::id();
        $post->save();
        
        return redirect()->route('posts.show', ['id'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function apiComments($id){
        return Post::findOrFail($id)->comments->load('author');
    }
}
