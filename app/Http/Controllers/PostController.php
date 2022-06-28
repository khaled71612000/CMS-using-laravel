<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Requests\Posts\CreatePostsRequest;

class PostController extends Controller
{


    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only('create','store');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // every time a post is created return all categories
        return view('posts.create')->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //upload image to storage
        $image = $request->image->store('posts','public');
        // create the post
      $post=  Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$image,
            'user_id' => auth()->user()->id,
            'content'=>$request->content,
            'published_at'=>$request->published_at,
            // name of select html is category
            'category_id' => $request->category,
        ]);


        if($request->tags) {
            // attach tags selected on front end with post as array
            $post->tags()->attach($request->tags);
        }
        
        // flash message
        session()->flash('success','created post');
        // redirect user
        return redirect(route('posts.index'));
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
    public function edit(Post $post)
    {
        return view('posts.create') -> with('post',$post)->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title','description','published_at','content']);
        // check for new image
        if ($request->hasFile('image')){
                    // upload

                    $image = $request->image->store('posts','public');
                    // delete old

           $post->deleteImage();

            $data['image']=$image;
        } 

        if($request->tags){
            // check tags in update if its attatcehd 
            // if not atteachted tags will leave them
            $post->tags()->sync($request->tags);
        }
            // update attribute
            $post->update($data);
        
        // flash
        session()->flash('success','Post Updated');
        // redirect
        return redirect(route('posts.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if couldnt find just show 404
        // ('id','LIKE',$id) or greater or less than
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();

        if($post->trashed()) {
            Storage::delete($post->image);
            $post->forceDelete();
        }else{
            $post->delete();
        }
        session()->flash('success','Trashed post');
        return redirect(route('posts.index'));


    }
    // dispaly a list of all trahsed posts
    public function trashed()
    {
        // only trashed posts not all 
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts',$trashed);
    }

    public function restore ( $id) {
        // cause post deleted u cant fetch it so find it where trashed
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();

        $post->restore();
        session()->flash('success','restored post');
        return redirect(route('posts.index'));
        }
}
