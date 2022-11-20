<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PackagePrice;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PackagePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.packageprice.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.packageprice.create');

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

          $packagePrice = PackagePrice::create($data);

      return redirect()->route('packageprice.index')->with('success', 'Package  has been added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackagePrice  $packagePrice
     * @return \Illuminate\Http\Response
     */
    public function show(PackagePrice $packagePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackagePrice  $packagePrice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packagePrice = PackagePrice::find($id);

        return view('backend.packageprice.edit', compact('packagePrice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PackagePrice  $packagePrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

        ]);
        
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
      

        $packagePrice = PackagePrice::where('id', $id)->update($data);

        if ($packagePrice) {
            $packagePrice = PackagePrice::find($id);
            $packagePrice->addAllMediaFromTokens();
            Alert::toast("PackagePriceUpdated Successfully", 'success');
            return redirect()->route('packageprice.index');
        } else {
            Alert::toast('Fail to update PackagePrice' , 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackagePrice  $packagePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packagePrice = PackagePrice::where('id', $id)->delete();
        if ($packagePrice) {
            Alert::toast("Package Price Deleted Successfully", 'success');
            return redirect()->route('packageprice.index');
        } else {
            Alert::toast('Fail to delete Package Price', 'error');
            return redirect()->back();
        }
    }
}
