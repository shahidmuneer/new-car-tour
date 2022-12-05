<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    
        return view('form');

    }


    public function tour($tourType)
    {    
        $package=\App\Models\Package::where("title",str_replace("-"," ",$tourType))->first();
        
        if(empty($package)){
            route()->redirect("/");
        }
        return view('tours')
                    ->with(["package"=>$package]);

    }

    public function availableSlots(Request $request)
    {
        $package=\App\Models\Package::where("title",$request->title)
                                    ->first();

        $package_id=$package->id;
        $array=[];
        $timings=explode(",",$package->available_times);
        foreach($timings as $time){
            $booking=\App\Models\UserBooking::where("booking_date",$request->input("date"))
                                            ->where("package_id",$package_id)
                                            ->where("booking_time",$time)
                                            ->count();
            if($booking<$package->available_slots){
                array_push($array,$time);
            }
        }
        
        return response()->json($array);
    }

    public function checkout(Request $request){

        return view("checkout");
    }

    public function initializeStripe(Request $request){
       \Stripe\Stripe::setApiKey('sk_test_aIneytUcpMEuSjuCXbtB6Twu');
        $cart=json_decode($request->input("cart"));
        
        $order=[];
        foreach($cart->formData as $key=>$item){
            if(!empty($item->name)){
                $order[$item->name]=$item->value;
            }
            else{
                $order[$key]=$item;
            }
        }
        $cart->formData=$order;
        $package=\App\Models\Package::find($cart->package_id);
        $TotalPrice=0;

       if($cart->formData["seats"]=="singleSeat"){
          $TotalPrice=(int)$package->single_seat_price;
       }else if($cart->formData["seats"]=="doubleSeat"){
          $TotalPrice=(int)$package->double_seat_price;    
       }
       if(!empty($cart->formData["guarrenttee_car"])  && $cart->formData["guarrenttee_car"]=="on"){
          $TotalPrice+=(int)$package->guarrenttee_car_price;
       }
       
       if(!empty($cart->formData["insurance"]) && $cart->formData["insurance"]=="on"){
          $TotalPrice+=(int)$package->insurance_price;
       }
        $YOUR_DOMAIN = 'http://localhost:8000';
        $stripe = new \Stripe\StripeClient('sk_test_aIneytUcpMEuSjuCXbtB6Twu');
        \Stripe\Stripe::setApiKey("sk_test_aIneytUcpMEuSjuCXbtB6Twu");
        \Stripe\Charge::create ([
            "amount" => $TotalPrice*100,
            "currency" => "cad",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com." 
        ]);
  
        \Session::flash('success', 'Payment successful!');
        return back();
        // $product=$stripe->products->create(
        //     [
        //       'name' => $cart->formData["seats"]
        //     ] 
        // );
          
    //     $price=$stripe->prices->create(
    //         [
    //           'product' => $product,
    //           'unit_amount' =>$TotalPrice,
    //           'currency' => 'usd'
    //         ]
    //       );
    //     $checkout_session = \Stripe\Checkout\Session::create([
    //     'line_items' => [[
    //         # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    //         'price' => $price,
    //         'quantity' => 1,
    //     ]],
    //     'mode' => 'payment',
    //     'success_url' => $YOUR_DOMAIN . '/payment-success',
    //     'cancel_url' => $YOUR_DOMAIN . '/payment-cancelled',
    //     ]);
    //     $request->session()->put("data",json_encode([
    //         'title' => $request->input("title"),
    //         'for' => $request->input("driver"),
    //         'first_name' => $request->input("first_name"),
    //         'last_name' => $request->input("last_name"),
    //         'email' => $request->input("email"),
    //         'phone' => $request->input("phone"),
    //         'dob' => $request->input("dob"),
    //         "cart"=>$request->input("cart"),
    //         "price"=>$TotalPrice,
    //         "payment_intent"=>$checkout_session->payment_intent
    // ]));
    //     // header("HTTP/1.1 303 See Other");
    //     // // echo $checkout_session->url;
    //     // header("Location: " . $checkout_session->url);
    //     return redirect()->to($checkout_session->url);
    }
    
    public function stripeSuccess(Request $request)
    {

        $stripe = new \Stripe\StripeClient(
            'sk_test_aIneytUcpMEuSjuCXbtB6Twu'
        );
          
        $data=$request->session()->get("data");
        $data=json_decode($data);
        $payment=$stripe->paymentIntents->capture(
            $data->payment_intent,
            []
          );
        dd($payment);
    }
}
