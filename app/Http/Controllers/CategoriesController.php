<?php

namespace App\Http\Controllers;

// to make category model
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\categories\CreateCategoryRequest;
use App\Http\Requests\categories\UpdateCategoriesRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // send all categories with view
       return view('categories.index')->with('categories',Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
// revmoed valdiate function and replace requst with certain custom one

            // create a category and give it name of requst
            // which is dangrous cause safer to make instance
            // used staticly
            Category::create([
                'name' => $request->name
            ]);
            session()->flash('success','Category Created');
// cleaner code that route categories
            return redirect(route('categories.index'));
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
    // link category model
    public function edit(Category $category)
    {
        return view('categories.create')->with('category',$category);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriesRequest $request,Category $category)
    {
        $category->update(['name'=>$request->name]);
        session()->flash('success','Category Updated');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->posts->count() > 0) {
            session()->flash('error','Category cant delete cause of existing posts');
            return redirect()->back();
        }else {
            $category->delete();   
            session()->flash('success','Category deleted');
            return redirect(route('categories.index'));
        }
    }
}
