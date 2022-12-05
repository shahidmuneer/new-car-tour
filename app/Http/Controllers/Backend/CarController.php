<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.cars.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modals=\App\Models\Modal::get();
        return view('backend.cars.create')->with([
            "modals"=>$modals
        ]);
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

        $filename = "default.png";
        if ($request->hasFile('image')){
            $file = $request->file("image");
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('uploads/cars/',$filename);
        }
          $car = Car::create($data);
          $car->image = $filename;
          $car->save();


      return redirect()->route('cars.index')->with('success', 'Car  has been added Successfully');
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
        $car = Car::findorfail($id);
        $modals=\App\Models\Modal::get();
        return view('backend.cars.edit', compact('car','modals','id'));
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


        $car = Car::where('id', $id)->update($data);

        if ($car) {
            $car = Car::find($id);
            $car->addAllMediaFromTokens();
            Alert::toast("Car Updated Successfully", 'success');
            return redirect()->route('dailysitreps.index');
        } else {
            Alert::toast('Fail to update daily sitrep', 'error');
            return redirect()->back();
        }
    }
    public function update_cars(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);




        $filename = "default.png";
        if ($request->hasFile('image')){
            $file = $request->file("image");
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('uploads/cars/',$filename);
        }
        $car = Car::where('id', $id)->update($data);



        if ($car) {
            $car = Car::find($id);
            $car->image = $filename;
            $car->save();
            Alert::toast("Car Updated Successfully", 'success');
            return redirect()->route('cars.index');
        } else {
            Alert::toast('Fail to update daily sitrep', 'error');
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
        $car = Car::where('id', $id)->delete();
        if ($car) {
            Alert::toast("cars Deleted Successfully", 'success');
            return redirect()->route('cars.index');
        } else {
            Alert::toast('Fail to delete car', 'error');
            return redirect()->back();
        }
    }
}
