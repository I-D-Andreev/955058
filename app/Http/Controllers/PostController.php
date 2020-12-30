<?php

namespace App\Http\Controllers;

use DB;
use App\Post;
use App\Tag;
use App\User;
use App\Notifications\NewComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Twitter;

class PostController extends Controller
{
    /**
     * Number of posts displayed per page.
     */
    private $postsPerPage = 10;

    /**
     * Require authentication to browse posts.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate($this->postsPerPage);
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

        $validatedData = $this->validateData($request);

        $post = new Post;
        $post->title = $validatedData['title'];
        $post->text = $validatedData['text'];
        $post->user_id = Auth::id();
        $post->save();

        $tagNames = $request->input('tags', []);
        $this->attachTags($post, $tagNames);

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
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
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
        $post = Post::findOrFail($id);

        if($post->user_id != Auth::id()){
            abort(403);
        }


        $validatedData = $this->validateData($request);
        
        $post->title = $validatedData['title'];
        $post->text = $validatedData['text'];
        $post->save();

        $post->tags()->detach();

        $tagNames = $request->input('tags', []);
        $this->attachTags($post, $tagNames);

        return redirect()->route('posts.show', ['id'=>$post->id]);
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

    public function uploadImage(Request $request){
        if($request->hasFile('upload')) {
            $saveFolder = "images";

            $originalFullName = $request->file('upload')->getClientOriginalName();
            
            $replaceCharacters = [" ", "/", "\\"];
            $fileName = str_replace($replaceCharacters, "", pathinfo($originalFullName, PATHINFO_FILENAME));
            $fileExtension = pathinfo($originalFullName, PATHINFO_EXTENSION);
            
            $safeFileName = $fileName.'_'.time().'.'.$fileExtension;
            $request->file('upload')->move(public_path($saveFolder), $safeFileName);


            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset($saveFolder.'/'.$safeFileName); 

            echo "<script> window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
        }
    }

    private function attachTags(Post $post, $tagNames){
        foreach($tagNames as $tagName){
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->syncWithoutDetaching($tag->id);
        }
    }

    private function validateData(Request $request){
        return $request->validate([
            'title' => 'required|max:150',
            'text' => 'required',
        ]);
    }
}
