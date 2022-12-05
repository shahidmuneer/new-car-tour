<style>
    .total{
        right: 0;
        margin-top: -80px;
        margin-right: 26px;
        float: right;
        padding-bottom:20px;
    }
</style>
<div class="col col-3 pull-right panel panel-default"
            style="position: fixed;
        right: 170px;
        width:360px;
        top: 15%;
        z-index:0;
        "
        id="bookingPannel"
            >
<div class="panel-heading "  style="background:red; color:white;">
    <h1>Book Now</h1>
</div>


        <div class="panel-body date-time-panel" style="padding-left:0px;">
            <div class="col col-3">
                                    <span
                                    class="form-number" style="padding:7px;"
                                    >
                                        3
                                    </span>
                                </div>

                <div class="col col-lg-12 date-time-panel">
                <p style="padding:10px;">
                    <span class="pull-left previous" >
                    < previous
                    </span>
                    <span class="pull-right next">
                        next >
                    </span>
                </p>
                <hr/>
                </div>   
                <div class="col col-lg-4"  style="padding-left:0px;padding-right:0px;">
                
                        <div class="calendar">
                            <ul class="dates-container">
                                <!-- <li class="date ">
                                    <span class="day-digit">32</span> 
                                    <sub class='month'>Oct</sub> 
                                    <sub class='day'>Sat</sub>
                                </li> -->

                            </ul>
                        </div>
                </div>
            <div class="col col-lg-6" style="padding-left:0px;padding-right:0px;">
                    <div class="calendar">
                            <ul class="time-container">
                            <li>
                                No Record
                            </li>
                            <!-- <li class="time active">
                                    <span class="time-digit">3 </span> 
                                    <sub class='time-nature'>AM</sub> 
                                    to
                                    <span class="time-digit">6 </span> 
                                    <sub class='time-nature'>PM</sub> 
                            </li> -->
                            </ul>
                        </div>
                    </div>   
</div>
                                

            <div class="panel-body seat-panel" style="padding-left:0px;display:none;">
                        <div class="col col-3">
                                                <span
                                                class="form-number pull-left" style="padding:7px;"
                                                >
                                                    4
                                                </span>
                                                <span class="pull-left go-back" style="padding:20px;content-editable=false;cursor:pointer;">
                                < back
                                </span>
                                            </div>

                       
                            
                            <div class="col col-lg-12" style="padding-left:0px;padding-right:0px;">
                            <form id="preCheckoutForm" >
                             
                            <div class="panel-body booked-display"
                            style="overflow-y: scroll;
                                    max-height: 380px;
                                    width: 100%;"
                            >
                           
                              <table class="table table-stripped">

                                        <thead>
                                            
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Slots Selected</td>
                                                <td id="selected_slots">23/01/2023 3AM-6PM</td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                    <div 
                            id="preCheckoutErrors"></div>

                                    <label>Select Seats</label>
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="seats" value="singleSeat">
                                            <img src="/img/single seat.png" style="width:80px;"/>
                                            Single Seat 399$
                                        </label>

                                        <label>
                                            <input type="radio" name="seats" value="doubleSeat">
                                            <img src="/img/double seats.png" style="width:80px;"/>
                                            Double Seat 499$
                                        </label>
                                    </div>

                                    <label>Guarrenttee a ferrari or lamborghini
                                    <label style="width:100%;">
                                        <input type="checkbox" name="guarrenttee_car">
                                        <img src="/img/lamborAndFerrari.png" style="width:90px;">
                                        Cost 50$
                                    </label>

                                    <label style="margin-top:10px;">Purchase Insurance?
                                    <label style="width:100%;">
                                        <input type="checkbox" name="insurance">
                                        Cost 50$
                                    </label>
                                </div>
                                <div class="total">
                               
                                    <h2>
                                       -
                                    </h2>
                                        <sub>Total</sub>
                                </div>
                                <input type="submit" value="Checkout" 
                                id="checkoutButton"
                                class="btn btn-default pull-right" style="background:red;margin-top:10px;">
                            
                        </form>
                            </div>

                        </div>
                </div>


