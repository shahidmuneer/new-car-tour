<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Validator;




class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.categories.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
   
          ]);

          $data= $request->all();
          unset($data['_token']);
          $catrgory = Category::create($data);

      return redirect()->route('category.index')->with('success', 'Category  has been added Successfully');

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
    public function edit($id)
    {
        $category = Category::find($id);

        return view('backend.catrgories.edit', compact('catrgory'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',

        ]);
        
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
      

        $category = Category::where('id', $id)->update($data);

        if ($catrgory) {
            $category = Category::find($id);
            Alert::toast("Catrgory Updated Successfully", 'success');
            return redirect()->route('Catrgories.index');
        } else {
            Alert::toast('Fail to update Catrgory', 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $category = Category::where('id', $id)->delete();
        // dd($category);
        if ($category) {
            $category = Category::find($id);
            Alert::toast("Category Deleted Successfully", 'success');
            return redirect()->route('categories.index');
        } else {
            Alert::toast('Fail to delete Category', 'error');
            return redirect()->back();
        }
    }
}
