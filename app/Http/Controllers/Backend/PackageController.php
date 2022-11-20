<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Car;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('backend.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cars=Car::get();
        return view('backend.packages.create')
                ->with(["cars"=>$cars]);

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

          $package = Package::create($data);

      return redirect()->route('packages.index')->with('success', 'Package  has been added Successfully');




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::findorfail($id);

        return view('backend.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
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
      

        $package = Package::where('id', $id)->update($data);

        if ($package) {
            $package = Package::find($id);
            $package->addAllMediaFromTokens();
            Alert::toast("Package Updated Successfully", 'success');
            return redirect()->route('packages.index');
        } else {
            Alert::toast('Fail to update Package', 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::where('id', $id)->delete();
        if ($package) {
            Alert::toast("Package Deleted Successfully", 'success');
            return redirect()->route('packages.index');
        } else {
            Alert::toast('Fail to delete Package', 'error');
            return redirect()->back();
        }
    }
}
