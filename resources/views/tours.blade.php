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
                        2
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
                    margin-bottom:40px;"
                >
                <div class="container">
                    <div class="row ">
                   
                    <h1>
                       {{$package->duration}} Epic Tour Experience
                    </h1>
                    <hr
                    style="width:300px; color:grey!important;"
                    />

                    <img src="https://supercarexperiences.ca/wp-content/uploads/2021/05/2.jpg"
                    style="width:500px; margin:20px;"
                    >


                    <hr
                    style="width:300px;"
                    />

                    <h2> #1 Tour in the world </h2>
                    <h3>Duration</h3>
                    <p>{{$package->duration}}</p>

                    <h2>Prices</h2>
                    <h3>Single Seat</h3>
                    <p>{{$package->single_seat_price}} $ </p>
                    <h3>Two Seat</h3>
                    <p>{{$package->double_seat_price}} $</p>
                    
                    <h2>Timings</h2>

                    @foreach(explode(",",$package->available_times) as $key=>$timings)
                            <p>{{$timings}}</p>
                    @endforeach

                    
                    <h2>Cars</h2>
                    <p>{{$package->number_of_cars}}</p>
                    
                    <h2>About</h2>
                    <p>{!! $package->about !!}</p>
                    
                    <h2>Highlights</h2>
                   
                    <p>{!! $package->highlights !!}</p>

                    <h2>Your fleet</h2>
                    <p>Lamborghini</p>
                    <p>Mustang</p>
                    <p>Lamborghini</p>
                    <p>Lamborghini</p>
                    <p>Lamborghini</p>
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
                
            @include("components.book")
                    </div>
    </div>
<script>
let dates="";
let totalDates=4;
let date = moment();
let activeDate=date.format("YYYY/M/D");
let activeTime="";
let totalAmount=0;
var element = document.querySelector("#bookingPannel");

// Define how much of the element is shown before something happens.
var scrollClipHeight = 0 /* Whatever number value you want... */;

// Function to change an element's CSS when it is scrolled in.
const doSomething = function doSomething() {

    /** When the window vertical scroll position plus the
     *   window's inner height has reached the
     *   top position of your element.
    */
    if (
           (window.innerHeight + window.scrollY) - (scrollClipHeight || 0) >= 
           element.getBoundingClientRect().scrollTop
    ){
        // Generally, something is meant to happen here.
        element.style = "position:fixed;top:12%;right: 170px;width:360px;"
    }
};

// Call the function without an event occurring.
// doSomething();

// Call the function when the 'window' scrolls.
// addEventListener("scroll", doSomething, false)
// alert(today.format("ddd"))
// alert(today.format("MMM"))
// alert(today.format("D"))
for(let i=0;i<totalDates;i++){
    // dates.push(date.format("ll"))

    dates+=`<li class='date ${i==0?"active":""}' date='${date.format("YYYY/M/D")}'>
                    <span class='day-digit'>${date.format("D")}</span> 
                    <sub class='month'>${date.format('MMM')}</sub> 
                    <sub class='day'>${date.format("ddd")}</sub>
                </li>`;
    date=date.add("1","day")
}

$("body .dates-container").html(dates)
$(document).ready(function(){
    $("body .next").on("click",function(){
        $("body .dates-container").html("")
        dates="";
            for(let i=0;i<totalDates;i++){
            // dates.push(date.format("ll"))
            dates+=`<li class='date' date='${date.format("YYYY/M/D")}'>
                            <span class='day-digit'>${date.format("D")}</span> 
                            <sub class='month'>${date.format('MMM')}</sub> 
                            <sub class='day'>${date.format("ddd")}</sub>
                        </li>`;
            date=date.add("1","day")
        }
        
        $("body .dates-container").html(dates)
    })

    $("body .previous").on("click",function(){
        $("body .dates-container").html("")
        dates="";
        date=date.subtract(totalDates*2,"day");

            for(let i=0;i<totalDates;i++){
            // dates.push(date.format("ll"))
                dates+=`<li class='date ' date='${date.format("YYYY/M/D")}'>
                                <span class='day-digit'>${date.format("D")}</span> 
                                <sub class='month'>${date.format('MMM')}</sub> 
                                <sub class='day'>${date.format("ddd")}</sub>
                            </li>`;
                date=date.add("1","day")
            }
            $("body .dates-container").html(dates)
    })
    
    $(".total h2").html(totalAmount+"$")
    let gurranttee_car=false;
    let insurance=false;
    let insurance_amount={{$package->insurance_price??0}}
    let guarrenttee_amount={{$package->guarranttee_car_price??0}}
    let singleSeat_amount={{$package->single_seat_price??0}}
    let doubleSeat_amount={{$package->double_seat_price??0}}
    $("body input[name=seats]").on("change",function(e){
        totalAmount=0;
        if(insurance){
                totalAmount+=insurance_amount;
            }
        if(gurranttee_car){
                totalAmount+=guarrenttee_amount;
            }
        if(e.target.value=="singleSeat"){
          
            totalAmount+=singleSeat_amount;
        }else if(e.target.value=="doubleSeat"){
            
            totalAmount+=doubleSeat_amount;
        }
        
        $(".total h2").html(totalAmount+"$")

    })
    $("body input[name=guarrenttee_car]").on("change",function(e){

        if($(this).is(":checked")){
            
            console.log(guarrenttee_amount)
            gurranttee_car=true;
                totalAmount+=guarrenttee_amount;
            }else{
                if(gurranttee_car==true){
                    totalAmount-=guarrenttee_amount;
                }
                gurranttee_car=false;
            }
            $(".total h2").html(totalAmount+"$");
    })
    
    $("body input[name=insurance]").on("change",function(e){
            if($(this).is(":checked")){
                insurance=true;
                totalAmount+=insurance_amount;
            }else{
                if(insurance==true){
                    totalAmount-=insurance_amount;
                }
                insurance=false;
            }
            $(".total h2").html(totalAmount+"$");
    })

    $(document).on("click","body .dates-container .date",function(){
        $("body .dates-container .date").removeClass("active")
        $(this).addClass("active")
    })

    $(document).on("click","body .dates-container .date",function(){
        $("body .dates-container .date").removeClass("active")
        $(this).addClass("active")
        let date=$(this).attr("date")
        $("body .time-container").html("<i class='fa fa-spinner fa-spin'></i>")
        if(date!=activeDate){
            activeDate=date;
            fetchTimes();
        }
    })

    $(document).on("click","body .time-container .time",function(){
        $("body .time-container .time").removeClass("active")
        $(this).addClass("active")
        $("body .date-time-panel").css({"display":"none"})
        $("body .seat-panel").css({"display":"block"})
        activeTime=$(this).attr("time")
        $("#selected_slots").html(activeDate+" "+activeTime)
    })
    $(document).on("click","body .go-back",function(){
        $("body .date-time-panel").css({"display":"block"})
        $("body .seat-panel").css({"display":"none"})
    })

    $("#preCheckoutForm").submit(function(e){
        e.preventDefault();
        let formData=$(this).serializeArray();
        $("#preCheckoutErrors").html("")
        if(formData[0]==undefined){
            $("#preCheckoutErrors").html(`<ul class='alert alert-warning' >
            <li>Kindly select number of seats</li>
            </ul>`)
            return;
        }
        let data={
            date:activeDate,
            time:activeTime,
            formData:formData,
            package_id:"{{$package->id}}",
            totalAmount:totalAmount,
            insurance_amount,
            guarrenttee_amount,
            singleSeat_amount,
            doubleSeat_amount
        }
        let cart=JSON.stringify(data)
        localStorage.setItem("cart",cart)
        window.location.href="/checkout"
    })



    function fetchTimes(){
    let timesData="";
        $.ajax({
        type: "GET",
        url: "/api/get-available-slots",
        data: {
            title:"epic tour",
            date:activeDate
        },
        cache: false,
        success: function(data){
        data.forEach((element)=>{
            let times=element.split("to")
                // dates.push(date.format("ll"))

                timesData+=`<li class="time" date="${activeDate}" time="${element}">
                                        <span class="time-digit">${times[0]}</span> 
                                        <sub class='time-nature'></sub> 
                                        to
                                        <span class="time-digit">${times[1]}</span> 
                                        <sub class='time-nature'></sub> 
                                </li>`;
                })
                
                $("body .time-container").html(timesData)
        }
        });
    }
    fetchTimes();
})

</script>
@endsection