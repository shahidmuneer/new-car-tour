@extends("layout.home")
@section("content")
<style>
h1,h2,h3,h4,h5{
    text-align:left;
}

.calendar .dates-container,.calendar .time-container{
    list-style-type:none;
}
.calendar .time-container{
    border-left: 1px solid #d0d0dc;
    padding-left: 10px;
}
.calendar .time-container .time {
    position:relative;
    padding:6px; 
    border-radius:8px; 
    margin-top:5px;
    border:1px solid #09b0da;
    border-left: 1px solid blue;
    padding-left: 10px;
    user-select:none;
    cursor:pointer;
}

.calendar .time-container .time.active{
background:#09b0da;
color:white;
}
.calendar .dates-container .date{
    position:relative;
    padding:20px; 
    border-radius:8px; 
    border:1px solid #09b0da;
}

.calendar .dates-container .date::after{
    content:"";
    display:none;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
    border-left: 6px solid #09b0da;
    position:absolute;
    right:-11px;
    width:10px; 
    height:10px;
    top:32px;
}

.calendar .dates-container .date.active::after{
    display:block;
}
.calendar .dates-container li{
    max-height: 81px;
    cursor:pointer;
    user-select:none;
    margin-bottom: 10px;

}

.calendar .dates-container .date .month{
    top: -2px;
    font-size: 20px;
}
.calendar .dates-container .date .day{
    top:-61px;
}
.container .dates-container .day-digit{
    font-size:28px;
}
.next,.previous{
    cursor:pointer;
    user-select:none;
}
</style>
    <div class="row" style="padding-top:200px;">
        <div class="container">
            <div class="col col-12">
                <div class="col col-3">
                    <span
                    class="form-number"
                    >
                        5
                    </span>
                </div>
                <!-- <h2 class="highspeed-font">
                    <div class="rectangle"></div>    
                    <div class="lines">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                    </div>
                    SUPERCAR RACETRACK DRIVING EXPERIENCE</h2> -->
                <div class="col col-6"
                style="margin-left: 40px;
                    background: #e9d9d9;
                    padding: 20px;
                    padding-top: 50px;
                    padding-left:130px;
                    margin-bottom:40px;
                    min-height:1120px;"
                >
                <div class="">
                    <div class="">
                   
                    <h1>
                       Checkout
                    </h1>
                    <hr
                    style="width:300px; color:grey!important;"
                    />
                    @if(\Session::has("success"))
                        <div class="alert alert-success">
                                {{\Session::get("success")}}
                        </div>
                    @endif
                    
                    <form action="/stripe-session" method="post" id="stripeForm">
                   <div class="row hidden cart-table">
                        <div class="panel col-lg-6 col-lg-offset-2">
                            <div class="panel-body">
                                <h3 id="dateAndTime"></h3>
                                <table class="table table-stripped ">
                                    <thead>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                    </thead>
                                    <tbody id="cartDetails">
                                        <tr>
                                            <td colspan="3"> Cart is empty </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type='hidden' id='stripeToken' name='stripeToken' value='none'/>
                            <input type="hidden" name="cart" id="cart" value="" />
                                <label>CHOOSE WHO IS DRIVING</label>
                            <div class="form-group  col col-lg-12">
                                <label >
                                <input type="radio" name="driver" value="SELF">
                                I AM DRIVING
                                </label>
                                <label>
                                <input type="radio" name="driver" value="Else">
                                THIS IS FOR SOMEONE ELSE
                                </label>
                            </div>
                            <h2 class="text-center">
                                CONTACT DETAILS
                            </h2>
                            <div class="form-group  col col-lg-2">
                                <label>Title</label>
                                <select class="form-control" name="title">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Miss.">Miss.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Jr.">Jr.</option>
                                </select>
                            </div>
                            
                            <div class="form-group col col-lg-5">
                                <label>First Name</label>
                                <input type="text" name="first_name" placeholder="Enter First Name" class="form-control">
                            </div>
                            <div class="form-group  col col-lg-5">
                                <label>Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control">
                            </div>
                            <div class="form-group col col-lg-6">
                                <label>Email Address</label>
                                <input type="text" name="email" placeholder="Enter Email Address" class="form-control">
                            </div>
                            <div class="form-group col col-lg-6">
                                <label>Phone#</label>
                                <input type="text" name="phone" placeholder="Enter Phone Number" class="form-control">
                            </div>
                            
                            <div class="form-group col col-lg-12">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" placeholder="Enter Date of Birth" class="form-control">
                            </div>
<p class="text-center"><sub>Card Details for Payment</sub></p>
                            <hr/>

                            <div class="form-group col col-lg-12">
                                <label>Card#</label>
                                <input type="text" maxlength="16" placeholder="xxxx xxxx xxxx xxxx " class="form-control card-number">
                            </div>
                            
                            <div class="form-group col col-lg-6">
                                <label>Expiry Date</label>
                                <input type="month"  placeholder="Enter Card Expiry Date" class="form-control card-expiry-date">
                            </div>

                            <div class="form-group col col-lg-6">
                                <label>CVC</label>
                                <input type="password"  maxlength="4" placeholder="Enter Secret Key" class="form-control card-cvc">
                            </div>

                        <div class="col col-lg-12" style="width:100%;">
                            <input type="button" value="Pay Now " class="btn btn-primary" id="submitButton" style="width:50%">
                            <i class="fa fa-spinner fa-spin hidden loading-bar"></i>
                        </div>    
                    </form>
                </div>


                <!-- 7 hour grand rally tour

ii- 7 hour grand rally tour will run from 10 am to 5 pm. 

Grand rally tour happens on 2 times a month and on saturday. 
When a grand tour happen epic tour will not be available. 

Grand tour will be 6 to 7 cars. 

> grand tour single seat > 899.99$
> Two seats for grand tour > 1699.99$ -->
                </div>
           
            </div>
                
                    </div>
    </div>
        
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
$(document).ready(function(){
   let cart=localStorage.getItem("cart")
//    localStorage.removeItem("cart")
   $("#cart").val(cart)
   cartObject=JSON.parse(cart);
   items=""
   $("#dateAndTime").html(cartObject.date+" "+cartObject.time);
   console.log(cartObject)
   if(cartObject!=null){
    $(".cart-table").removeClass("hidden");
   }
    cartObject.formData.forEach((item,index)=>{
        if(item.name=="seats"){
            items+=`<tr><td>Total Seats</td>
            <td>${item.value=='singleSeat'?1:2}</td>
            <td>${item.value=='singleSeat'?cartObject.singleSeat_amount:cartObject.doubleSeat_amount}$</td></tr>`
        }
        if(item.name=="guarrenttee_car" && item.value=="on"){
            items+=`<tr><td>Guarrenttee Lamborghini or Ferrari</td>
            <td>1</td>
            <td>${cartObject.guarrenttee_amount}$</td></tr>`
        }
        if(item.name=="insurance" && item.value=="on"){
            items+=`<tr><td>Insurance</td>
            <td>1</td>
            <td>${cartObject.insurance_amount}$</td></tr>`
        }
        })

    items+=`<tr><th colspan='2'>Total</th><th>${cartObject.totalAmount}$</th></tr>`
    $("#submitButton").val("Pay Now "+cartObject.totalAmount+"$");

   $("#cartDetails").html(items);

   $("#stripeForm #submitButton").on("click",function(e){
    // console.log($("#stripeToken").val())
            $(".loading-bar").removeClass("hidden");
          Stripe.setPublishableKey("pk_test_IpyEEjpi8t6sIFieUEZAz2a8");
          console.log(new Date($('.card-expiry-date').val()).getFullYear());
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: new Date($('.card-expiry-date').val()).getMonth()+1,
            exp_year: new Date($('.card-expiry-date').val()).getFullYear()
          }, stripeResponseHandler);
        })

          function stripeResponseHandler(status, response) {
        
            /* token contains id, last4, and card type */
            var token = response['id'];
            $(".loading-bar").addClass("hidden");
            if(response.error!=undefined){
            //  $.toast({text:response.error.message});
                alert(response.error.message);
             return;
            }
            $("#stripeToken").val(token);
            localStorage.removeItem("cart");
            // console.log($("#stripeToken").val())
            $("#stripeForm").submit();
            
        }
    
   
})

</script>
@endsection