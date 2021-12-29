<?php

namespace App\Http\Controllers;
use Session;
use App\Order;
use App\Dbooking;
use App\Product;
use App\Pprice;
use App\Location;
use App\Addon;
use App\Food;
use App\Beverage;
use App\Bottle;
use App\Coupon;
use App\Setting;
use App\Temporder;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    /**
     * Show the application booking page.
     *
     * @return \Illuminate\Http\Response
    */

    public function index(Request $request)
    {
        Session::put('legacyOrders', []);
        Session::put('legacyOrder.pId', 1);
        $p_ID = Session::get('legacyOrder.pId');
        $rows = Order::orderBy('booking_date', 'asc')->where('booking_date', '>=', date('Y-m-d'))->where('p_id', '=', $p_ID)->where('status', '=', 'Y')->get();
        $product = Product::where('id', '=',$p_ID)->first();
        $locations = Location::orderBy('id', 'asc')->get();
        $foods = Food::orderBy('id', 'asc')->get();
        $beverages = Beverage::orderBy('id', 'asc')->get();
        $bottles = Bottle::orderBy('id', 'asc')->get();
        $settings = Setting::orderBy('id', 'asc')->first();
        $addons = Addon::orderBy('id', 'asc')->get();
        if (Auth::check()) {
            $name= Auth::user()->name;
            $name = explode(" ",$name);
            if (array_key_exists(0,$name)) {
                $fname = $name[0];
            } else {
                $fname = '';
            }
            if (array_key_exists(1,$name)) {
                $lname = $name[1];
            } else {
                $lname = '';
            }
            $email= Auth::user()->email;
            $phone= Auth::user()->phone;
            $phone1 = '';
            $phone2 = '';
            $phone3 = '';
            if(strlen($phone) === 10){
                $phoneArr = str_split($phone,3);
                $phone1 = $phoneArr[0];
                $phone2 = $phoneArr[1];
                $phone3 = $phoneArr[2].$phoneArr[3];
            }
            $userArr = array('fname'=> $fname,'lname'=> $lname,'email'=> $email,'phone'=> $phone, 'phone1' => $phone1, 'phone2'=> $phone2, 'phone3'=> $phone3);
        } else{
            $userArr = array('fname'=> '','lname'=> '','email'=> '','phone'=> '','phone1'=>'','phone2'=>'','phone3'=>'');
        }

        //location dropdown
        $locationsArr = array();
        if (count($locations) > 0) {
            foreach ($locations as $location) {
                $locationsArr[$location->id] = $location->location_name.' (+$'.  $location->price .'.00) ';
            }
        }

        //buffets and tray dropdown
        $buffetsArr = array();
        $traysArr = array();
        if (count($foods) > 0) {
            $buffetsArr[''] = 'SEE OPTIONS & PRICING';
            $traysArr[''] = 'CHOOSE YOUR TRAY';
            foreach ($foods as $food) {
                if($food->type === 'Buffet'){
                    $buffetsArr[$food->id] = $food->food_name.': $'.  $food->price .'/person';
                }else{
                    $traysArr[$food->id] = $food->food_name.': $'.  $food->price .'/tray';
                }
            }
        }

        //bar and bottle dropdown
        $barsArr = array();
        if (count($beverages) > 0) {
            $barsArr[''] = "-- Select your hosted bar --";
            foreach ($beverages as $beverage) {
                $barsArr[$beverage->id] = $beverage->beverage_name.': $'.  $beverage->hprice .'/person (half day)'.', $'.  $beverage->fprice .'/person (full day)';
            }
        }

        //bar and bottle dropdown
        $bottlesArr = array();
        if (count($bottles) > 0) {
            $bottlesArr[''] = "-- Select your bottle --";
            foreach ($bottles as $bottle) {
                $bottlesArr[$bottle->id] = $bottle->bottle_name.': $'.  $bottle->price .'/bottle';
            }
        }

        //addons dropdown
        $addonsArr = array();
        $addonspriceArr = array();
        $adp = 1;
        if (count($addons) > 0) {
            $addonsArr[''] = "-- SELECT --";
            foreach ($addons as $addon) {
                $addonsArr[$addon->id] = $addon->addons_name;
                if($adp === 1){
                    $addonspriceArr[] = "-- SELECT --";
                    $addonspriceArr['half'] = "HALF DAY $".$addon->hprice;
                    $addonspriceArr['full'] = "FULL DAY $".$addon->fprice;
                }
                $adp++;

            }
        }

        //all booked dates
        $bookedDates = array();
        $arrayavailnew = array();
        $arraybooked = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $bookedDates[$row->booking_date][] = $row->booking_time_from.'-'.$row->booking_time_to;
            }
        }

		$rowsab = Dbooking::orderBy('dbooking_date', 'asc')->where('dbooking_date', '>=', date('Y-m-d'))->get();
        if (count($rowsab) > 0) {
            foreach ($rowsab as $row) {
              $bookedDates[$row->dbooking_date][] = $row->dbooking_time_from.'-'.($row->dbooking_time_to);
            }
        }


		$keybooked = '';
        if (count($bookedDates) > 0) {
 		    //check booked time of dates
            foreach($bookedDates as $keybooked => $bookedsot){

                $arrayavail='"0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"';
                $datebooked='false';
                $j=0; foreach ($bookedsot as $key => $value) {

                    $slotbrkdon=explode('-', $value);
                    $strarr='';

                    for($i=$slotbrkdon[0] ; $i<= $slotbrkdon[1];$i++) {
                        $arraybooked[$keybooked][]=$i;
                        $strarr[]='"'.$i.'"';
                    }
                    //+ next 1 hour of current booked time slot
                   # $arraybooked[$keybooked][]=$i; #diabled for some techincal  reason

                    $str='';
                     $str=implode(',', $strarr);
                     ($expld=explode($str, $arrayavail));


                   //  print_r($expld);
                   $arrayavail=str_replace($str,'', $arrayavail);
                    $j++;
               }
                $chkarrbooked=explode(',,', $arrayavail);
				foreach($chkarrbooked as $bkd)
				{  ( $bkdar=explode(',',str_replace('"','',$bkd)));
					if(count($bkdar)>3){  $datebooked='true'; break;}

				}
				   $arrayavailnew[$keybooked][]=$datebooked;

            }
        }
        $disabledDates = array();
        $falseDates = array();
        if (count($arrayavailnew) > 0) {
            foreach ($arrayavailnew as $key => $avail) {

                if ($avail[0] == 'false') {
                   $disabledDates[] = '"'.date('d-m-Y', strtotime($key)).'"';
                   $falseDates[] = $key;
                }
            }
            $disabledDates = implode(', ', $disabledDates);
        }

        $totalTimes= array(0 => "12:00 AM", 1 => "1:00 AM", 2 => "2:00 AM", 3 => "3:00 AM", 4 => "4:00 AM", 5 => "5:00 AM", 6 => "6:00 AM", 7 => "7:00 AM", 8 => "8:00 AM", 9 => "9:00 AM", 10 => "10:00 AM", 11 => "11:00 AM", 12 => "12:00 PM", 13 => "1:00 PM", 14 => "2:00 PM", 15 => "3:00 PM", 16 => "4:00 PM", 17 => "5:00 PM", 18 => "6:00 PM", 19 => "7:00 PM", 20 => "8:00 PM", 21 => "9:00 PM", 22 => "10:00 PM", 23 => "11:00 PM");

        //get all booked time of given date
        $bookedTimes = array();

        $todayDate = date('Y-m-d');
		Session::put('legacyOrders.selectdate', $todayDate);
        if (array_key_exists($todayDate,$arraybooked) && !array_key_exists($todayDate,$falseDates)){
            $bookedTimes = $arraybooked[$todayDate];
        }

        $notifications = Notification::all();

        dd($notifications);


        //Show listing view
        return view('booking', compact('notifications', 'disabledDates', 'bookedTimes', 'totalTimes', 'product', 'locationsArr', 'buffetsArr', 'traysArr', 'barsArr', 'bottlesArr', 'addonsArr','addonspriceArr','settings','userArr'));

    }


    /**
     * Fatch POST booking date start avail times
     *
     * @return \Illuminate\Http\Response
    */
    public function fatchDate(Request $request)
    {     //Get posted form data
        $method = $request->method();
        $p_ID = Session::get('legacyOrder.pId');
        $rows = Order::orderBy('booking_date', 'asc')->orderBy('booking_time_from', 'asc')->where('booking_date', '>=', date('Y-m-d'))->where('status', '=', 'Y')->where('p_id', '=', $p_ID)->get();

        //all booked dates
        $bookedDates = array();
        $arrayavailnew = array();
        $arraybooked = array();
        $keybooked = '';
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $bookedDates[$row->booking_date][] = $row->booking_time_from.'-'.$row->booking_time_to;
            }
        }
		// echo "<pre>";print_r($bookedDates);die;
		 $rowsab = Dbooking::orderBy('dbooking_date', 'asc')->where('dbooking_date', '>=', date('Y-m-d'))->get();
         if (count($rowsab) > 0) {
            foreach ($rowsab as $row) {
              $bookedDates[$row->dbooking_date][] = $row->dbooking_time_from.'-'.($row->dbooking_time_to);
            }
        }
		//echo "<pre>";print_r($bookedDates);die;

        if (count($bookedDates) > 0) {
 		    //check booked time of dates
            foreach($bookedDates as $keybooked => $bookedsot){

                $arrayavail='"0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"';
                $datebooked='false';
                $j=0; foreach ($bookedsot as $key => $value) {

                    $slotbrkdon=explode('-', $value);
                    $strarr='';
                    for($i=$slotbrkdon[0] ; $i<=  $slotbrkdon[1];$i++) {
                        $arraybooked[$keybooked][]=$i;
                        $strarr[]='"'.$i.'"';
                    }
                    //+ next 1 hour of current booked time slot
                    # $arraybooked[$keybooked][]=$i; #diabled for some techincal  reason
					//print_r($arraybooked);
                    $str='';
                     $str=implode(',', $strarr);
                     ($expld=explode($str, $arrayavail));


                   //  print_r($expld);
                   $arrayavail=str_replace($str,'', $arrayavail);
                    $j++;
               }
                $chkarrbooked=explode(',,', $arrayavail);
				foreach($chkarrbooked as $bkd)
				{  ( $bkdar=explode(',',str_replace('"','',$bkd)));
					if(count($bkdar)>3){  $datebooked='true'; break;}

				}
				   $arrayavailnew[$keybooked][]=$datebooked;

            }
        }
        $disabledDates = array();
        $falseDates = array();
        if (count($arrayavailnew) > 0) {
            foreach ($arrayavailnew as $key => $avail) {

                if ($avail[0] == 'false') {
                   $disabledDates[] = '"'.date('d-m-Y', strtotime($key)).'"';
                   $falseDates[] = $key;
                }
            }
            $disabledDates = implode(', ', $disabledDates);
        }

        $totalTimes= array(0 => "12:00 AM", 1 => "1:00 AM", 2 => "2:00 AM", 3 => "3:00 AM", 4 => "4:00 AM", 5 => "5:00 AM", 6 => "6:00 AM", 7 => "7:00 AM", 8 => "8:00 AM", 9 => "9:00 AM", 10 => "10:00 AM", 11 => "11:00 AM", 12 => "12:00 PM", 13 => "1:00 PM", 14 => "2:00 PM", 15 => "3:00 PM", 16 => "4:00 PM", 17 => "5:00 PM", 18 => "6:00 PM", 19 => "7:00 PM", 20 => "8:00 PM", 21 => "9:00 PM", 22 => "10:00 PM", 23 => "11:00 PM");

        //get all booked time of given date
        $bookedTimes = array();
        if ($request->isMethod('post')) {
            $input = $request->input('sdate');
            $input = date('Y-m-d', strtotime($input));
             //echo $input; die;
            if (array_key_exists($input,$arraybooked) && !array_key_exists($input,$falseDates)){
                $bookedTimes = $arraybooked[$input];
            }
            $bTime = '';
            $i = 0;
            foreach( $totalTimes as $key => $totalTime){
                if ( $i == 0) {
                    $bTime .='<ul>';
                }
                if (in_array($key, $bookedTimes)) {
                    $bTime .='<li class="disable">'.$totalTime.'</li>';
                }
                else{
                    $bTime .='<li><a href="javascript:void(0);" data-time="'.$key.'">'.$totalTime.'</a></li>';
                }
                $i++;
                if ( $i == 8) {
                    $bTime .='</ul>';
                    $i = 0;
                }

            }
            if (!empty($bookedTimes)){
               $bookedTime = json_encode($bookedTimes);
            }else{
                $bookedTime = '';
            }
            if ( !Session::has('legacyOrders.booking_info')) {
                Session::put('legacyOrders.selectdate', $input);
				//print( $bTime);
				//print($bookedTime);
				//die;
                return response()->json(['status' => 1, 'bTime' => $bTime, 'bkTime' => $bookedTime ], 200);
            }else{
                return response()->json(['status' => 0], 200);
            }
        }
    }

    /**
     * Fatch POST booking date finsih avail times
     *
     * @return \Illuminate\Http\Response
    */
    public function fetchtime(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $nextDay = $request->input('nextDay');
            $stime = $request->input('stime');
         	$btime = '';
            $keybooked = array();
            Session::put('legacyOrders.nextDay', $nextDay);
            Session::put('legacyOrders.starttime', $stime);
			$selectedDate =   Session::get('legacyOrders.selectdate');
			$selectedDatePast =   Session::get('legacyOrders.selectdate');#to use in last slot checking
			/******************************************************************************/
				#checking time slot for nxt date if nextday==Yes
			/*****************************************************************************/
			if($nextDay=='Yes'){
				$selectedDate 				= 	date('Y-m-d',strtotime($selectedDate)+86400);
			 	$bookedDates				=	array();
        		$arraybooked[$selectedDate] =	array();
				$bookedDatespast 			= 	array();
				$arraybookedpast 			= 	array();
			 	$arraybookedtillselected	=	array();##admin disabled timeslots

				$rowsab = Dbooking::where('dbooking_date', '=', $selectedDate)->get(); #admin blocked time slot
         		if (count($rowsab) > 0) { #if blocked
            		foreach ($rowsab as $row) {
              			$bookedDates[$row->dbooking_date][] = $row->dbooking_time_from.'-'.($row->dbooking_time_to-1); # make array of all bloked time slot
            		}
        		}
				#admindisabled time slot ends
                $p_ID = Session::get('legacyOrder.pId');
				$rows = Order::where('booking_date', '=', $selectedDate)->where('status', '=', 'Y')->where('p_id', '=', $p_ID)->get();
				if (count($rows) > 0) {
            		foreach ($rows as $row) {
              			$bookedDates[$row->booking_date][] = $row->booking_time_from.'-'.($row->booking_time_to);#already booked time slot
            		}
        		}
				//echo count($bookedDates);
				if (count($bookedDates) > 0) {
					//check booked time of dates
					foreach($bookedDates as $keybooked => $bookedsot){

						$arrayavail='"0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"';
						$datebooked='false';
						$j=0;
						foreach ($bookedsot as $key => $value) {

							$slotbrkdon=explode('-', $value);
							$strarr='';
							for($i=$slotbrkdon[0] ; $i<=  $slotbrkdon[1];$i++) {
								$arraybooked[$keybooked][]=$i;
								$strarr[]='"'.$i.'"';
							}
							//+ next 1 hour of current booked time slot
							 # $arraybooked[$keybooked][]=$i; #diabled for some techincal  reason
 							$j++;
						}

						if(@in_array('0',$arraybooked[$keybooked])){ #if first time is disabled by admin or booked, need to show error - can't book this day as over night
							return response()->json(['status' => 3], 200); 	/*desired time not availeable*/break;
						 }
					}
				}

				$stime1=($stime+1)%24;
				$stime2=($stime+2)%24;
			 	$stime3=($stime+3)%24;
				if(@in_array($stime1,$arraybooked[$keybooked]) || @in_array($stime2,$arraybooked[$keybooked])  || @in_array($stime3,$arraybooked[$keybooked])){
                        return response()->json(['status' => 3], 200);
                        /*desired time not availeable*/
                }
				 ##for making all disabled after first occurance of
				 if(count($arraybooked[$selectedDate])>0){
					for($m=$arraybooked[$selectedDate][0];$m< 23;$m++)
					{
						$arraybooked[$selectedDate][]=$m+1;
					}
				}
			 	if($stime1<=1 || $stime2<=1  )
				{

					for($d=0;$d<=$stime2;$d++){$arraybookedtillselected[$selectedDate][]=$d; }
					if( !empty($arraybooked[$selectedDate])){
						$arraybooked[$selectedDate]=  array_unique(array_merge($arraybookedtillselected[$selectedDate],$arraybooked[$selectedDate]));
					}
					else
					{
						$arraybooked[$selectedDate]=$arraybookedtillselected[$selectedDate];
					}
				}
				else #check if all slot avaiiable in fisrt date after selected slot.
				{
				 	$rowsabpast = Dbooking::where('dbooking_date', '=', $selectedDatePast)->get();
					if (count($rowsabpast ) > 0) {
						foreach ($rowsabpast  as $row) {
							$bookedDatespast[$row->dbooking_date][] = $row->dbooking_time_from.'-'.($row->dbooking_time_to);
						}
					}
				#admindisabled time slot ends
                $p_ID = Session::get('legacyOrder.pId');
				$rowspast = Order::where('booking_date', '=', $selectedDatePast)->where('status', '=', 'Y')->where('booking_time_from', '>', $stime)->where('p_id', '=', $p_ID )->get();
				if (count($rowspast) > 0) {
            		foreach ($rowspast as $row) {
              			$bookedDatespast[$row->booking_date][] = $row->booking_time_from.'-'.($row->booking_time_to);
            		}
        		}
					if (count($bookedDatespast) > 0) {
					//check booked time of dates
						foreach($bookedDatespast as $keybooked => $bookedsot){
							$arrayavail='"0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"';
							$datebooked='false';
							$j=0;
							foreach ($bookedsot as $key => $value) {
								$slotbrkdon=explode('-', $value);
								$strarr='';
								for($i=$slotbrkdon[0] ; $i<=  $slotbrkdon[1];$i++) {
									$arraybookedpast[$keybooked][]=$i;
									$strarr[]='"'.$i.'"';
								}
								//+ next 1 hour of current booked time slot
								# $arraybooked[$keybooked][]=$i; #diabled for some techincal  reason
								$j++;
							}
						}
					}
 				 	for($p=$stime;$p<=23;$p++)
					{
						if(@in_array($p,$arraybookedpast[$selectedDatePast])){
                            return response()->json(['status' => 5], 200); break;
                            /*any of slot is not available after selected timeslot*/
						}
					}
				}
				//print_r($arraybooked);
				 ##for making all disabled after first occurance of
				// for($m=$arraybooked[$selectedDate][0];$m< 23;$m++)
				// {
				// 	$arraybooked[$selectedDate][]=$m+1;
				// }

			}
			else{ #if same day booking

				$selectedDate =   date('Y-m-d',strtotime($selectedDate));
			 	$bookedDates=array();
        		$arraybooked = array();
				$arraybookedtillselected=array();
			 	##admin disabled timeslots
				$rowsab = Dbooking::where('dbooking_date', '=', $selectedDate)->get();
         		if (count($rowsab) > 0) {
            		foreach ($rowsab as $row) {
              			$bookedDates[$row->dbooking_date][] = $row->dbooking_time_from.'-'.($row->dbooking_time_to-1);
            		}
        		}
				#admindisabled time slot ends
                $p_ID = Session::get('legacyOrder.pId');
				$rows = Order::where('booking_date', '=', $selectedDate)->where('status', '=', 'Y')->where('p_id', '=', $p_ID )->get();
				if (count($rows) > 0) {
            		foreach ($rows as $row) {
              			$bookedDates[$row->booking_date][] = $row->booking_time_from.'-'.($row->booking_time_to);
            		}
        		} //echo 'asss'.count($bookedDates);die;

				if (count($bookedDates) > 0) {
					//check booked time of dates
					foreach($bookedDates as $keybooked => $bookedsot){
						$arrayavail='"0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"';
						$datebooked='false';
						$j=0;
						foreach ($bookedsot as $key => $value) {
							$slotbrkdon=explode('-', $value);
							$strarr='';
							for($i=$slotbrkdon[0] ; $i<=  $slotbrkdon[1];$i++) {
								$arraybooked[$keybooked][]=$i;
								$strarr[]='"'.$i.'"';
							}
							//+ next 1 hour of current booked time slot
							 # $arraybooked[$keybooked][]=$i; #diabled for some techincal  reason
 							$j++;
						}
					}
				}
				else{

				$arraybooked[$selectedDate]=array();
				}#check all booked and disabled
				#if 3 hour availeable or not
				$stime1=$stime+1;
				$stime2=$stime+2;
				$stime3=$stime+3;

				if(@in_array($stime1,$arraybooked[$selectedDate]) || @in_array($stime2,$arraybooked[$selectedDate]) || @in_array($stime3,$arraybooked[$selectedDate])){
                    return response()->json(['status' => 4], 200);
                    /*desired time not availeable*/
                }

				if(!in_array($stime1,$arraybooked[$selectedDate]) && !in_array($stime2,$arraybooked[$selectedDate])){
					for($d=0;$d<=$stime2;$d++)
					{
						 $arraybookedtillselected[$selectedDate][]=$d;
					}

					for($e=$stime;$e<=23;$e++)
					{
						if(in_array($e,$arraybooked[$selectedDate]))
						{
							for($k=$e;$k<=23;$k++)
							{
								$arraybookedtillselected[$selectedDate][]=$k;
							}
							break;
						}
					}
				}
				if(!empty($arraybookedtillselected[$selectedDate]) && !empty($arraybooked[$selectedDate]))
				{
					$arraybooked[$selectedDate]=  array_unique(array_merge($arraybookedtillselected[$selectedDate],$arraybooked[$selectedDate]));
				}else{
				$arraybooked[$selectedDate]=  array_unique($arraybookedtillselected[$selectedDate]);
				}
			}
	 		//print_r($arraybooked);
			$fTimes = '';
			$totalTimes= array(0 => "12:00 AM", 1 => "1:00 AM", 2 => "2:00 AM", 3 => "3:00 AM", 4 => "4:00 AM", 5 => "5:00 AM", 6 => "6:00 AM", 7 => "7:00 AM", 8 => "8:00 AM", 9 => "9:00 AM", 10 => "10:00 AM", 11 => "11:00 AM", 12 => "12:00 PM", 13 => "1:00 PM", 14 => "2:00 PM", 15 => "3:00 PM", 16 => "4:00 PM", 17 => "5:00 PM", 18 => "6:00 PM", 19 => "7:00 PM", 20 => "8:00 PM", 21 => "9:00 PM", 22 => "10:00 PM", 23 => "11:00 PM");
            $i = 0;
            foreach( $totalTimes as $key => $totalTime){
                if ( $i == 0) {
                    $fTimes .='<ul>';
                }
                if (count($arraybooked) > 0) {
                    if (in_array($key, $arraybooked[$selectedDate])) {
                        $fTimes .='<li class="disable">'.$totalTime.'</li>';
                    }
                    else{
                        $fTimes .='<li><a href="javascript:void(0);" data-time="'.$key.'">'.$totalTime.'</a></li>';
                    }
                 } else{
                    $fTimes .='<li><a href="javascript:void(0);" data-time="'.$key.'">'.$totalTime.'</a></li>';
                }
                $i++;
                if ( $i == 8) {
                    $fTimes .='</ul>';
                    $i = 0;
                }

            }
            return response()->json(['status' => 1, 'fTimes' => $fTimes], 200);
        }
    }

    /**
     * Booking Step 1 -fatch Yacht price
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep1(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $p_ID = Session::get('legacyOrder.pId');
            $bdate = Session::get('legacyOrders.selectdate');
            $nextday = Session::get('legacyOrders.nextDay');
            $stime = Session::get('legacyOrders.starttime');
            $ftime = $request->input('ftime');
            $timehtml = $request->input('timehtml');
            Session::put('legacyOrders.finishtime', $ftime);
            Session::put('legacyOrders.timehtml', $timehtml);
            $product = Product::where('id', '=', $p_ID)->first();
            $pprices =  Pprice::where('p_id', '=', $p_ID)->get();
            $day = strtotime( $bdate );
            $day = date('D', $day);
            $day = strtolower(substr($day,0,2));
            if($nextday=='Yes'){
                $stimes = 24 - $stime;
                $totalHours = $stimes + $ftime;
            }else{
                $totalHours = $ftime-$stime;
            }

            $holidays = array();
            $days = array();
            foreach ($pprices as $pprice) {
                if ($pprice->day =='hd'){
                    $holidays[$pprice->date] = $pprice->price;
                }else{
                    $days[$pprice->day] = $pprice->price;
                }
            }
            if (array_key_exists($bdate, $holidays)) {
                $p_price = $holidays[$bdate];
            } elseif(array_key_exists($day, $days)){
                $p_price = $days[$day];
            } else{
                $p_price = $product->default_price;
            }

            $totalprice = $p_price * $totalHours;
            $totalprices = number_format($totalprice, 2);
            $data = array( 'booking_date' => $bdate, 'start_time' => $stime, 'finish_time' => $ftime, 'p_id' => $p_ID, 'p_price' => $totalprice );
            Session::push('legacyOrders.booking_info', $data);
            Session::put('legacyOrders.stotal', $totalprice);
            return response()->json(['status' => 1, 'totalprice' => $totalprices], 200);
        }
    }

    /**
     * Booking location step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep2(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $slocations = $request->input('sl');
            $slocationsQty = $request->input('slQ');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $slocation = Location::where('id', '=', $slocations)->first();
                if($status === 'add' ){
                    $lprice = $slocation->price + $cTotal;
                    $lprices = number_format($lprice, 2);
                    $lname = $slocation->location_name;
                    $data = array( 'location_id' => $slocations, 'location_name' => $lname, 'location_price' => $slocation->price, 'location_qty' => $slocationsQty );
                    Session::push('legacyOrders.location', $data);
                    Session::put('legacyOrders.stotal', $lprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'lprice' => $lprices, 'lname' => $lname, 'lid' => $slocations, 'lqty' => $slocationsQty], 200);
                } else {
                    $cLocationsArr = $legacyOrders['location'];
                    $lprice = $cTotal - $slocation->price;
                    $lprices = number_format($lprice, 2);
                    foreach ($cLocationsArr as $key => $value) {
                        if($value['location_id'] === $slocations){
                            Session::forget('legacyOrders.location');
                            unset($cLocationsArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.location', $cLocationsArr);
                    Session::put('legacyOrders.stotal', $lprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'lprice' => $lprices ], 200);
                }
            }
        }
    }

    /**
     * Booking buffet step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep3(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $sbuffets = $request->input('sb');
            $sbuffetsQty = $request->input('sbQ');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $sbuffet = Food::where('id', '=', $sbuffets)->first();
                if($status === 'add' ){
                    $bprice = ($sbuffet->price * $sbuffetsQty) + $cTotal;
                    $bprices = number_format($bprice, 2);
                    $bname = $sbuffet->food_name;
                    $data = array( 'buffet_id' => $sbuffets, 'buffet_name' => $bname, 'buffet_price' => ($sbuffet->price * $sbuffetsQty), 'buffet_qty' => $sbuffetsQty, 'buffet_base_price' => $sbuffet->price);
                    if (Session::has('legacyOrders.buffet') && Session::get('legacyOrders.buffet')==='Skip') {
                        Session::forget('legacyOrders.buffet');
                    }
                    Session::push('legacyOrders.buffet', $data);
                    Session::put('legacyOrders.stotal', $bprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'bprice' => $bprices, 'bname' => $bname, 'bid' => $sbuffets, 'bqty' => $sbuffetsQty], 200);
                } else {
                    $cBuffetsArr = $legacyOrders['buffet'];
                    if (($sbuffet->price * $sbuffetsQty) > $cTotal){
                        $bprice = ($sbuffet->price * $sbuffetsQty) - $cTotal;
                    }else{
                        $bprice = $cTotal -($sbuffet->price * $sbuffetsQty);
                    }
                    $bprices = number_format($bprice, 2);
                    foreach ($cBuffetsArr as $key => $value) {
                        if($value['buffet_id'] === $sbuffets){
                            Session::forget('legacyOrders.buffet');
                            unset($cBuffetsArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.buffet', $cBuffetsArr);
                    Session::put('legacyOrders.stotal', $bprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'bprice' => $bprices ], 200);
                }
            }
        }
    }

    /**
     * Booking tray step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep4(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $strays = $request->input('st');
            $straysQty = $request->input('stQ');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $stray = Food::where('id', '=', $strays)->first();
                if($status === 'add' ){
                    $tprice = ($stray->price * $straysQty) + $cTotal;
                    $tprices = number_format($tprice, 2);
                    $tname = $stray->food_name;
                    $data = array( 'tray_id' => $strays, 'tray_name' => $tname, 'tray_price' => ($stray->price * $straysQty), 'tray_qty' => $straysQty, 'tray_base_price' => $stray->price );
                    if (Session::has('legacyOrders.tray') && Session::get('legacyOrders.tray')==='Skip') {
                        Session::forget('legacyOrders.tray');
                    }
                    Session::push('legacyOrders.tray', $data);
                    Session::put('legacyOrders.stotal', $tprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'tprice' => $tprices, 'tname' => $tname, 'tid' => $strays, 'tqty' => $straysQty], 200);
                } else {
                    $cTraysArr = $legacyOrders['tray'];
                    if (($stray->price * $straysQty) > $cTotal){
                        $tprice = ($stray->price * $straysQty) - $cTotal;
                    }else{
                        $tprice = $cTotal - ($stray->price * $straysQty);
                    }
                    $tprices = number_format($tprice, 2);

                    foreach ($cTraysArr as $key => $value) {
                        if($value['tray_id'] === $strays){
                            Session::forget('legacyOrders.tray');
                            unset($cTraysArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.tray', $cTraysArr);
                    Session::put('legacyOrders.stotal', $tprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'tprice' => $tprices ], 200);
                }
            }
        }
    }

    /**
     * Booking bar step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep5(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $sbars = $request->input('sbr');
            $sbarsQty = $request->input('sbrQ');
            $bartenderPrice = $request->input('bartender');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $sbar = Beverage::where('id', '=', $sbars)->first();
                $basePrice = '';
                $baseHPrice = $sbar->hprice;
                $baseFPrice = $sbar->fprice;
                $timeDuration = '';
                if($status === 'add' ){
                    if($bartenderPrice =='bartendhalf'){
                        $brprice = ($sbar->hprice * $sbarsQty) + $cTotal;
                        $sBrprice = ($sbar->hprice * $sbarsQty);
                        $basePrice = $sbar->hprice;
                        $timeDuration = 'Half';
                    }else{
                       $brprice = ($sbar->fprice * $sbarsQty) + $cTotal;
                       $sBrprice = ($sbar->fprice * $sbarsQty);
                       $basePrice = $sbar->fprice;
                       $timeDuration = 'Full';
                    }
                    $brprices = number_format($brprice, 2);

                    $brname = $sbar->beverage_name;
                    $data = array( 'bar_id' => $sbars, 'bar_name' => $brname, 'bar_price' => $sBrprice, 'bar_qty' => $sbarsQty, 'bar_base_price' => $basePrice, 'bar_half' => $baseHPrice, 'bar_full' => $baseFPrice, 'time_duration' => $timeDuration );
                    if (Session::has('legacyOrders.bar') && Session::get('legacyOrders.bar')==='Skip') {
                        Session::forget('legacyOrders.bar');
                    }
                    Session::push('legacyOrders.bar', $data);
                    Session::put('legacyOrders.stotal', $brprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'brprice' => $brprices, 'brname' => $brname, 'brid' => $sbars, 'brqty' => $sbarsQty], 200);
                } else {
                    $cBarsArr = $legacyOrders['bar'];
                    if($bartenderPrice =='bartendhalf'){
                        if (($sbar->hprice * $sbarsQty) > $cTotal){
                            $brprice = ($sbar->hprice * $sbarsQty) - $cTotal;
                        }else{
                            $brprice = $cTotal - ($sbar->hprice * $sbarsQty);
                        }
                    }else{
                        if (($sbar->fprice * $sbarsQty) > $cTotal){
                            $brprice = ($sbar->fprice * $sbarsQty) - $cTotal;
                        }else{
                            $brprice = $cTotal - ($sbar->fprice * $sbarsQty);
                        }
                    }
                    $brprices = number_format($brprice, 2);
                    foreach ($cBarsArr as $key => $value) {
                        if($value['bar_id'] === $sbars){
                            Session::forget('legacyOrders.bar');
                            unset($cBarsArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.bar', $cBarsArr);
                    Session::put('legacyOrders.stotal', $brprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'brprice' => $brprices ], 200);
                }
            }
        }
    }

    /**
     * Booking bottle step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep6(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $sbottles = $request->input('sbt');
            $sbottlesQty = $request->input('sbtQ');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $sbottle = Bottle::where('id', '=', $sbottles)->first();
                if($status === 'add' ){
                    $btprice = ($sbottle->price * $sbottlesQty) + $cTotal;
                    $btname = $sbottle->bottle_name;
                    $btprices = number_format($btprice, 2);
                    $data = array( 'bottle_id' => $sbottles, 'bottle_name' => $btname, 'bottle_price' => ($sbottle->price * $sbottlesQty), 'bottle_qty' => $sbottlesQty, 'bottle_base_price' => $sbottle->price );
                    if (Session::has('legacyOrders.bottle') && Session::get('legacyOrders.bottle')==='Skip') {
                        Session::forget('legacyOrders.bottle');
                    }
                    Session::push('legacyOrders.bottle', $data);
                    Session::put('legacyOrders.stotal', $btprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'btprice' => $btprices, 'btname' => $btname, 'btid' => $sbottles, 'btqty' => $sbottlesQty], 200);
                } else {
                    $cBottlesArr = $legacyOrders['bottle'];
                    if (($sbottle->price * $sbottlesQty) > $cTotal){
                        $btprice = ($sbottle->price * $sbottlesQty) - $cTotal;
                    }else{
                        $btprice = $cTotal - ($sbottle->price * $sbottlesQty);
                    }
                    $btprices = number_format($btprice, 2);
                    foreach ($cBottlesArr as $key => $value) {
                        if($value['bottle_id'] === $sbottles){
                            Session::forget('legacyOrders.bottle');
                            unset($cBottlesArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.bottle', $cBottlesArr);
                    Session::put('legacyOrders.stotal', $btprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'btprice' => $btprices ], 200);
                }
            }
        }
    }

    /**
     * Booking Addone step
     *
     * @return \Illuminate\Http\Response
    */
    public function bookingProcessStep7(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $saddons = $request->input('sad');
            $saddonsQty = $request->input('sadQ');
            if (Session::has('legacyOrders')) {
                $legacyOrders = Session::get('legacyOrders');
                $cTotal = $legacyOrders['stotal'];
                $status = $request->input('status');
                $saddon = Addon::where('id', '=', $saddons)->first();
                $baseHPrice = $saddon->hprice;
                $baseFPrice = $saddon->fprice;
                $timeDuration = '';
                if($status === 'add' ){
                    if ($saddonsQty === 'half'){
                        $adprice = $saddon->hprice + $cTotal;
                        $sadprice = $saddon->hprice;
                        $timeDuration = 'Half';
                    }else{
                        $adprice = $saddon->fprice + $cTotal;
                        $sadprice = $saddon->fprice;
                        $timeDuration = 'Full';
                    }
                    $adprices = number_format($adprice, 2);
                    $adname = $saddon->addons_name;
                    $data = array( 'addon_id' => $saddons, 'addon_name' => $adname, 'addon_price' => $sadprice, 'addon_qty' => $saddonsQty, 'addon_half' => $baseHPrice, 'addon_full' => $baseFPrice, 'time_duration' => $timeDuration );
                    if (Session::has('legacyOrders.addon') && Session::get('legacyOrders.addon')==='Skip') {
                        Session::forget('legacyOrders.addon');
                    }
                    Session::push('legacyOrders.addon', $data);
                    Session::put('legacyOrders.stotal', $adprice);
                    return response()->json(['status' => 1, 'action'=> 'add', 'adprice' => $adprices, 'adname' => $adname, 'adid' => $saddons, 'adqty' => $saddonsQty], 200);
                } else {
                    $cAddonsArr = $legacyOrders['addon'];
                    if ($saddonsQty === 'half'){
                        if ( $saddon->hprice > $cTotal ){
                            $adprice = $saddon->hprice - $cTotal;
                        }else{
                            $adprice = $cTotal - $saddon->hprice;
                        }
                    } else{
                        if ( $saddon->fprice > $cTotal ){
                            $adprice = $saddon->fprice - $cTotal;
                        }else{
                            $adprice = $cTotal - $saddon->fprice;
                        }
                    }
                    $adprices = number_format($adprice, 2);
                    foreach ($cAddonsArr as $key => $value) {
                        if($value['addon_id'] === $saddons){
                            Session::forget('legacyOrders.addon');
                            unset($cAddonsArr[$key]);
                        }
                    }
                    Session::put('legacyOrders.addon', $cAddonsArr);
                    Session::put('legacyOrders.stotal', $adprice);
                    return response()->json(['status' => 1, 'action'=> 'remove', 'adprice' => $adprices ], 200);
                }
            }
        }
    }

    /**
     * Bartender Fee
     *
     * @return \Illuminate\Http\Response
    */
    public function bartenderFee(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $bartender = $request->input('bartender');
            $bartenderqty = $request->input('bartenderqty');
            $action = $request->input('action');
            $settings = Setting::orderBy('id', 'asc')->first();
            if ( $bartender =='bartendhalf' ){
                $bartenderPrice = $settings->hprice;
                $bartenderTime = 'bartendhalf';
            }else {
                $bartenderPrice = $settings->fprice;
                $bartenderTime = 'bartendfull';
            }
            if( $action ==='next' ){
                 if ( !Session::has('legacyOrders.bartenderFee')) {
                    $bartenderPrice = $bartenderPrice*$bartenderqty;
                    Session::put('legacyOrders.bartenderFee', $bartenderPrice);
                    Session::put('legacyOrders.bartenderQty', $bartenderqty);
                    Session::put('legacyOrders.bartenderTime', $bartenderTime);
                    $stotal = Session::get('legacyOrders.stotal') + $bartenderPrice;
                    Session::put('legacyOrders.stotal', $stotal);
                    $stotals = number_format($stotal, 2);
                    return response()->json(['status' => 1, 'stotal' => $stotals ], 200);
                } else if( Session::has('legacyOrders.bartenderFee') && Session::get('legacyOrders.bartenderFee') ===''){
                    $bartenderPrice = $bartenderPrice*$bartenderqty;
                    Session::put('legacyOrders.bartenderFee', $bartenderPrice);
                    Session::put('legacyOrders.bartenderQty', $bartenderqty);
                    Session::put('legacyOrders.bartenderTime', $bartenderTime);
                    $stotal = Session::get('legacyOrders.stotal') + $bartenderPrice;
                    Session::put('legacyOrders.stotal', $stotal);
                    $stotals = number_format($stotal, 2);
                    return response()->json(['status' => 1, 'stotal' => $stotals ], 200);
                } else if( Session::has('legacyOrders.bartenderFee') && Session::get('legacyOrders.bartenderFee') !=''){
                    $cbartenderFee = Session::get('legacyOrders.bartenderFee');
                    $stotal = Session::get('legacyOrders.stotal') - $cbartenderFee;
                    Session::put('legacyOrders.stotal', $stotal);
                    $bartenderPrice = $bartenderPrice*$bartenderqty;
                    Session::put('legacyOrders.bartenderFee', $bartenderPrice);
                    Session::put('legacyOrders.bartenderQty', $bartenderqty);
                    Session::put('legacyOrders.bartenderTime', $bartenderTime);
                    $stotal = Session::get('legacyOrders.stotal') + $bartenderPrice;
                    Session::put('legacyOrders.stotal', $stotal);
                    $stotals = number_format($stotal, 2);
                    return response()->json(['status' => 1, 'stotal' => $stotals ], 200);
                }else{
                    return response()->json(['status' => 2], 200);
                }
            } else{
                if( Session::has('legacyOrders.bartenderFee') && Session::get('legacyOrders.bartenderFee') !=''){
                    $cbartenderFee = Session::get('legacyOrders.bartenderFee');
                    $stotal = Session::get('legacyOrders.stotal') - $cbartenderFee;
                    Session::put('legacyOrders.bartenderFee', '');
                    Session::put('legacyOrders.bartenderQty', '');
                    Session::put('legacyOrders.bartenderTime', '');
                    $stotals = number_format($stotal, 2);
                    return response()->json(['status' => 1, 'stotal' => $stotals ], 200);
                }else{
                    return response()->json(['status' => 2], 200);
                }
            }
        }
    }

    /**
     * Fetch addons price halfday/fullday
     *
     * @return \Illuminate\Http\Response
    */
    public function addonesDDval(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $sAddon = $request->input('sAddon');
            $sAdd  = Addon::where('id', '=', $sAddon)->first();
            return response()->json(['status' => 1, 'sAddonH' => $sAdd->hprice, 'sAddonF' => $sAdd->fprice ], 200);
        }
    }

    /**
     * Show the skipBooking
     *
     * @return \Illuminate\Http\Response
    */
    public function skipBookingStep(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $cstep = $request->input('cstep');
            if($cstep === 'step6'){
                Session::put('legacyOrders.buffet', 'Skip');
                Session::put('legacyOrders.tray', 'Skip');
            } elseif ($cstep === 'step7') {
                Session::put('legacyOrders.bar', 'Skip');
                Session::put('legacyOrders.bottle', 'Skip');
            } elseif ($cstep === 'step8') {
                Session::put('legacyOrders.addon', 'Skip');
            } else {
                # code...
            }
            return response()->json(['status' => 1], 200);
        }
    }


    /**
    * Redeem Coupon function
    *
    * @return \Illuminate\Http\Response
    */
    public function redeemCoupon(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $cCode = $request->input('cCode');
            $cCode  = Coupon::where('coupon_name', '=', $cCode)->first();
            if($cCode){
                $todayDate = date('Y-m-d');
                $cStartDate = $cCode->start_date;
                $cEndDate = $cCode->end_date;
                if ($todayDate >= $cStartDate && $todayDate <= $cEndDate){
                    $cDiscount = $cCode->discount;
                    $legacyOrders = Session::get('legacyOrders');

                    $totalAmount = $legacyOrders['stotal'];
                    $cDiscount = ($cDiscount / 100) * $totalAmount;
                    $cDiscount = round($cDiscount, 2);

                    // $stotal= $legacyOrders['stotal']-$cDiscount;
                    Session::put('legacyOrders.c_id', $cCode->id);
                    Session::put('legacyOrders.discount', $cDiscount);
                    $settings = Setting::orderBy('id', 'asc')->first();
                    $oId = $legacyOrders['orderid'];
                    if ( $settings->tax !='' ){
                        $tax = ($settings->tax / 100) * $totalAmount;
                        $tax = round($tax, 2);
                        $gtotal = ($totalAmount - $cDiscount) + $tax;
                    } else{
                        $gtotal = $totalAmount - $cDiscount;
                    }
                    $stotals = number_format($totalAmount, 2);
                    $gtotals = number_format($gtotal, 2);
                    $cDiscounts = number_format($cDiscount, 2);

                    Session::put('legacyOrders.gtotal', $gtotal);
                    $lastInsertedId = Temporder::where('id', $oId)->update( array('c_id'=> $cCode->id,'discount'=> $cDiscount, 'total' => $gtotal));
                    return response()->json(['status' => 1, 'msg' => 'This coupon code is applied successfully', 'stotal' => number_format($totalAmount, 2), 'total' => $gtotals, 'save' => $cDiscounts, 'tax' => $tax, 'taxper' => $settings->tax], 200);
                }
                return response()->json(['status' => 1, 'msg' => 'This coupon code is invalid or has expired', 'stotal' => '', 'total' => '','save' =>'', 'tax' => '', 'taxper' => ''], 200);
            }else{
                return response()->json(['status' => 1, 'msg' => 'This coupon code is invalid or has expired', 'stotal' => '', 'total' => '','save' =>'', 'tax' => '', 'taxper' => ''], 200);
            }
        }
    }

    /**
     * Save order details in DB
     *
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //Get posted form data
        $method = $request->method();
        if ($request->isMethod('post')) {
            $status = $request->input('status');
            if (Session::has('legacyOrders')) {

                $legacyOrders = Session::get('legacyOrders');
                if( $status === 'N'){
                    $bData = $request->input('bData');
                    $booking_details = json_decode($bData, true);
                    $fname= $booking_details[0]['fname'].' '.$booking_details[0]['lname'];
                    $phone= $booking_details[0]['phone'];
                    $email= $booking_details[0]['email'];
                    $booking_date= $legacyOrders['booking_info'][0]['booking_date'];
                    $sTime= $legacyOrders['booking_info'][0]['start_time'];
                    $fTime= $legacyOrders['booking_info'][0]['finish_time'];
                    $settings = Setting::orderBy('id', 'asc')->first();
                    if (Session::has('legacyOrders.location')) {
                        $locations= serialize($legacyOrders['location']);
                    } else {
                        $locations= '';
                    }
                    if (Session::has('legacyOrders.buffet')) {
                        $buffets= serialize($legacyOrders['buffet']);
                    } else {
                        $buffets= serialize('Skip');
                    }
                    if (Session::has('legacyOrders.tray')) {
                        $trays= serialize($legacyOrders['tray']);
                    } else {
                        $trays= serialize('Skip');
                    }
                    if (Session::has('legacyOrders.bar')) {
                        $bars= serialize($legacyOrders['bar']);
                    } else {
                        $bars= serialize('Skip');
                    }
                    if (Session::has('legacyOrders.bottle')) {
                        $bottles= serialize($legacyOrders['bottle']);
                    } else {
                        $bottles= serialize('Skip');
                    }
                    if (Session::has('legacyOrders.addon')) {
                        $addons= serialize($legacyOrders['addon']);
                    } else {
                        $addons= '';
                    }

                    $stotal= $legacyOrders['stotal'];

                    if ( $settings->tax !='' ){
                        $tax = ($settings->tax / 100) * $stotal;
                        $tax = round($tax, 2);
                        // $tax= $settings->tax;
                    } else{
                        $tax= 0;
                    }

                    if (Session::has('legacyOrders.c_id')) {
                        $c_id= Session::get('legacyOrders.c_id');
                    } else {
                        $c_id= '0';
                    }
                    if (Session::has('legacyOrders.discount')) {
                        $discount= Session::get('legacyOrders.discount');
                    } else {
                        $discount= '0';
                    }
                    $total= ($stotal-$discount)+$tax;
                    Session::put('legacyOrders.gtotal', $total);
                    if (Auth::check()) {
                        $u_id= Auth::user()->id;
                    } else{
                        $u_id= '0';
                    }
                    $p_id= $legacyOrders['booking_info'][0]['p_id'];
                    $nextday = Session::get('legacyOrders.nextDay');
                    if ($nextday =='Yes') {
                        $nextday = 'Y';
                    }else{
                        $nextday = 'N';
                    }
                    $bartenders= serialize(array('bartenderFee'=>Session::get('legacyOrders.bartenderFee'),'bartenderQty'=>Session::get('legacyOrders.bartenderQty'),'bartenderTime'=>Session::get('legacyOrders.bartenderTime')));
                    //Create data to save
                    $createOrder = array(
                        'booking_date' => $booking_date,
                        'booking_time_from' => $sTime,
                        'booking_time_to' => $fTime,
                        'time_html' => Session::get('legacyOrders.timehtml'),
                        'name' => $fname,
                        'phone' => $phone,
                        'email' => $email,
                        'booking_details' => serialize($booking_details),
                        'location_details' => $locations,
                        'buffet_details' => $buffets,
                        'tray_details' => $trays,
                        'bar_details' => $bars,
                        'bottle_details' => $bottles,
                        'bartender_details' => $bartenders,
                        'addon_details' => $addons,
                        'stotal' => $stotal,
                        'total' => $total,
                        'discount' =>$discount,
                        'due' => $total,
                        'tax' => $tax,
                        'c_id' => $c_id,
                        'u_id' => $u_id,
                        'p_id' => $p_id,
                        'status' => $status,
                        'paystatus' => 'N',
                        'paymethod' => 'F',
                        'payadvance' => '0',
                        'paywith' => 'N/A',
                        'payid' => 'N/A',
                        'token' => 'N/A',
                        'payerid' => 'N/A',
                        'cancel_by' => '0',
                        'parent_id' => '0',
                        'next_day' => $nextday
                    );

                    if (Session::has('legacyOrders.orderid')) {
                        $oId = $legacyOrders['orderid'];
                        $nextdate = date('Y-m-d',strtotime($booking_date)+86400);
                        $lastInsertedCId = Session::get('legacyOrders.orderChildId');
                        if ($nextday =='Y' &&  $lastInsertedCId !='') {
                            Temporder::where('id', $oId)->update($createOrder);
                            Temporder::where('id', $oId)->update(array('booking_time_to' => '23'));

                            Temporder::where('id', $lastInsertedCId)->update($createOrder);
                            Temporder::where('id', $lastInsertedCId)->update(array('booking_date' => $nextdate,'booking_time_from' => '0','parent_id' => $lastInsertedId));
                            Session::put('legacyOrders.orderChildId', $lastInsertedCId);
                        } else if ($nextday =='Y' &&  $lastInsertedCId =='') {
                            Temporder::where('id', $oId)->update($createOrder);
                            Temporder::where('id', $oId)->update(array('booking_time_to' => '23'));

                            $lastInsertedCId = Temporder::create($createOrder)->id;
                            Temporder::where('id', $lastInsertedCId)->update(array('booking_date' => $nextdate,'booking_time_from' => '0','parent_id' => $lastInsertedId));
                            Session::put('legacyOrders.orderChildId', $lastInsertedCId);
                        }  else{
                            Temporder::where('id', $oId)->update($createOrder);
                            Session::put('legacyOrders.orderChildId', '');
                        }
                    }else{
                        //Create order
                        $nextdate = date('Y-m-d',strtotime($booking_date)+86400);
                        if ($nextday =='Y') {
                            $lastInsertedId = Temporder::create($createOrder)->id;
                            Temporder::where('id', $lastInsertedId)->update(array('booking_time_to' => '23'));
                            Session::put('legacyOrders.orderid', $lastInsertedId);
                            $lastInsertedCId = Temporder::create($createOrder)->id;
                            Temporder::where('id', $lastInsertedCId)->update(array('booking_date' => $nextdate,'booking_time_from' => '0','parent_id' => $lastInsertedId));
                            Session::put('legacyOrders.orderChildId', $lastInsertedCId);
                        }else{
                            $lastInsertedId = Temporder::create($createOrder)->id;
                            Session::put('legacyOrders.orderid', $lastInsertedId);
                            Session::put('legacyOrders.orderChildId', '');
                        }

                    }
					Session::put('legacyOrders.orderAdded', '');
                    return response()->json(['status' => 1,'total' => $total,'tax' => $tax,'taxper' => $settings->tax], 200);
                } else{
                    return response()->json(['status' => 1,'total' => $total, 'tax' => '', 'taxper' => '','msg' => ''], 200);
                }
            }
        }
    }

    public function checkoutProcess(Request $request){
        $legacyOrders = Session::get('legacyOrders');
        if (Session::has('legacyOrders.orderid') && Auth::check()) {
            $settings = Setting::orderBy('id', 'asc')->first();
            $oId = $legacyOrders['orderid'];
            $entries = Temporder::find($oId);
            return view('checkout', compact('entries', 'settings'));
        } elseif (Session::has('legacyOrders.bookingId') && Auth::check()) {
            $settings = Setting::orderBy('id', 'asc')->first();
            $oId = $legacyOrders['bookingId'];
            $entries = Order::find($oId);
            return view('checkout', compact('entries', 'settings'));
        } else{
            Session::put('legacyOrders.bookingId', '');
            return redirect('/book-now');
        }
    }


    public function userCheckoutProcess(Request $request){
        $method = $request->method();
        if ($request->isMethod('post')) {
            $b_id = $request->input('b_id');
            $currentuserid = Auth::user()->id;
            $cOrder = Order::where('id', '=', $b_id)->where('u_id', '=', $currentuserid)->where('parent_id', '=', 0)->first();
            $due_amount = $cOrder->due; 

            if (!$cOrder) {
                Session::put('legacyOrders.bookingId', '');
                return redirect()->route('user::profile.index')
                    ->with('flash_error', 'No record found.');
            }

            if ( $due_amount < 1 ){
                Session::put('legacyOrders.bookingId', '');
                return redirect()->route('user::profile.index')
                    ->with('flash_error', 'Something went wrong.');
            }

            Session::put('legacyOrders.bookingId', $b_id);
            Session::put('legacyOrders.bookingDue', $due_amount);
            return redirect('/checkout');

        }  else {
            Session::put('legacyOrders.bookingId', '');
            return redirect('/404');
        }

    }
}
