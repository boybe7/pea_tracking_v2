
<?php
function renderDate($value)
{
    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $dates = explode("/", $value);
    $d=0;
    $mi = 0;
    $yi = 0;
    foreach ($dates as $key => $value) {
         $d++;
         if($d==2)
            $mi = $value;
         if($d==3)
            $yi = $value;
    }
    if(substr($mi, 0,1)==0)
        $mi = substr($mi, 1);
    if(substr($dates[0], 0,1)==0)
        $d = substr($dates[0], 1);
    else
    	$d = $dates[0];

    $renderDate = $d." ".$th_month[$mi]." ".$yi;
    if($renderDate==0)
        $renderDate = "";   

    return $renderDate;             
}

function renderDate2($value)
{
    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $dates = explode("-", $value);
    $d=0;
    $mi = 0;
    $yi = 0;
    foreach ($dates as $key => $value) {
         $d++;
         if($d==2)
            $mi = $value;
         if($d==1)
            $yi = $value;
    }
    if(substr($mi, 0,1)==0)
        $mi = substr($mi, 1);
    if(substr($dates[2], 0,1)==0)
        $d = substr($dates[2], 1);
    else
    	$d = $dates[2];

    $renderDate = $d." ".$th_month[$mi]." ".$yi;
    if($renderDate==0)
        $renderDate = "";   

    return $renderDate;             
}

$pj = $model;
$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

if($monthBegin==$monthEnd && $yearBegin==$yearEnd)
    $monthBetween = $month_th[$monthBegin]." ".$yearBegin;
else if($yearBegin==$yearEnd)
	$monthBetween = $month_th[$monthBegin]."-".$month_th[$monthEnd]." ".$yearEnd;
else
    $monthBetween = $month_th[$monthBegin]." ".$yearBegin."-".$month_th[$monthEnd]." ".$yearEnd;

$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthBegin2 = $monthBegin<10 ? "0".$monthBegin : $monthBegin;
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;
$dayBegin = $yearBegin."-".$monthBegin2."-"."01";

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " BETWEEN '".$dayBegin."' AND '".$dayEnd."'";

//echo $monthCondition;

	
	echo "<center><div style='font-weight:900;font-size:16px;'><b>ฝ่ายบริการวิศวกรรม การไฟฟ้าส่วนภูมิภาค<br>งบกำไรขาดทุน<br>ช่วงเดือน ".$monthBetween."</b></div></center>";
	
	echo "<table border='0' class='span12' style='margin-left:0px;margin-bottom:20px;'>";
		echo "<tr style='font-weight:bold;'>";
		 echo "<td style='text-align:center;width:5%'></td>";
		 echo "<td style='text-align:center;width:40%'></td>";
		 echo "<td style='text-align:center;width:20%'></td>";
		 echo "<td style='text-align:center;width:5%'></td>";
		 echo "<td style='text-align:center;width:20%;font-weight:900;font-size:15px;'>จำนวนเงิน (บาท)</td>";
		 echo "<td style='text-align:center;width:10%;font-weight:900;font-size:15px;'>หมายเหตุ</td>";
		echo "</tr>";
		echo "<tr style='font-weight:900;font-size:15px;'>";
		 echo "<td colspan='6'>รายได้ :</td>";

		echo "</tr>";

		 //tsd กองบริการวิศวกรรมระบบส่ง
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='0' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $tsd_sum = $pp[0]["sum"];
		
		 //msd กองบริการบำรุงรักษา
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='1' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $msd_sum = $pp[0]["sum"];

         //dsd กองบริการวิศวกรรมระบบจำหน่าย
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='2' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $dsd_sum = $pp[0]["sum"];
		
			 
         echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>รายได้จากกองบริการวิศวกรรมระบบส่ง</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($tsd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>1</td>";
		  echo "</tr>";
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>รายได้จากกองบริการบำรุงรักษา</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($msd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>2</td>";
		  echo "</tr>";
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>รายได้จากกองบริการวิศวกรรมระบบจำหน่าย</td>";
			 echo "<td style='text-align:right;width:20%;border-bottom:1px solid black'>".number_format($dsd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 $income = $dsd_sum+$tsd_sum+$msd_sum;
			 echo "<td style='text-align:right;width:20%;border-bottom:1px solid black'>".number_format($dsd_sum+$tsd_sum+$msd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:10%'>3</td>";
		  echo "</tr>";	


		  echo "<tr style='font-weight:900;font-size:15px;'>";
		 echo "<td colspan='6'>หักค่าใช้จ่าย :</td>";

		echo "</tr>";

		 //tsd กองบริการวิศวกรรมระบบส่ง
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='0' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $tsd_sum = $pp[0]["sum"];
		
		 //msd กองบริการบำรุงรักษา
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='1' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $msd_sum = $pp[0]["sum"];

         //dsd กองบริการวิศวกรรมระบบจำหน่าย
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='2' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $dsd_sum = $pp[0]["sum"];
		
			 
         echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าจ้างเหมา-กองบริการวิศวกรรมระบบส่ง</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($tsd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>1</td>";
		  echo "</tr>";
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าจ้างเหมา-กองบริการบำรุงรักษา</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($msd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>2</td>";
		  echo "</tr>";
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าจ้างเหมา-กองบริการวิศวกรรมระบบจำหน่าย</td>";
			 echo "<td style='text-align:right;width:20%;'>".number_format($dsd_sum,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:right;width:20%;'></td>";
			 echo "<td style='text-align:center;width:10%'>3</td>";
		  echo "</tr>";	


		  				// $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=1 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
        //                 $m_type1_tsd = $pp[0]["sum"];                    

        //                 $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=2 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
                      
        //                 $m_real_tsd = $pp[0]["sum"];
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='0' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_tsd = $pp[0]["sum"];
                        
                        $m_tsd = $m_real_tsd;// + $m_type1_tsd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_msd = $pp[0]["sum"];                    

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=2 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                      
                        // $m_real_msd = $pp[0]["sum"];
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='1' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_msd = $pp[0]["sum"];

                        $m_msd = $m_real_msd;// + $m_type1_msd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='2' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_dsd = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='2' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_dsd = $pp[0]["sum"];
                        $m_dsd = $m_real_dsd;// + $m_type1_dsd;
          $tsd_sap = 0;
          $msd_sap = 0;
          $dsd_sap = 0;

          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=0 AND year=".$yearEnd)
                                            ->queryAll();
         
          if(count($pp)>0)
             $tsd_sap = $pp[0]["cost"];
          
          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=1 AND year=".$yearEnd)
                                            ->queryAll();
          if(count($pp)>0)
             $msd_sap = $pp[0]["cost"];
          
          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=2 AND year=".$yearEnd)
                                            ->queryAll();
          if(count($pp)>0)
             $dsd_sap = $pp[0]["cost"];
          

          echo "<tr>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบส่ง</td>";
             echo "<td style='text-align:right;width:20%'>".number_format($m_tsd,2)."</td>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:center;width:20%'></td>";
             echo "<td style='text-align:center;width:10%'>1</td>";
          echo "</tr>";
          echo "<tr>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการดำเนินงาน-กองบริการบำรุงรักษา</td>";
             echo "<td style='text-align:right;width:20%'>".number_format($m_msd,2)."</td>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:center;width:20%'></td>";
             echo "<td style='text-align:center;width:10%'>2</td>";
          echo "</tr>";
                       
          echo "<tr>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบจำหน่าย</td>";
             echo "<td style='text-align:right;width:20%;'>".number_format($m_dsd,2)."</td>";
             echo "<td style='text-align:center;width:5%'></td>";
             echo "<td style='text-align:center;width:20%'></td>";
             echo "<td style='text-align:center;width:10%'>3</td>";
          echo "</tr>";
                        

          echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบส่ง</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($tsd_sap,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>1</td>";
		  echo "</tr>";
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการบริหารงาน-กองบริการบำรุงรักษา</td>";
			 echo "<td style='text-align:right;width:20%'>".number_format($msd_sap,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:center;width:20%'></td>";
			 echo "<td style='text-align:center;width:10%'>2</td>";
		  echo "</tr>";
		               
		  echo "<tr>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 echo "<td style='text-align:left;width:40%'>ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบจำหน่าย</td>";
			 echo "<td style='text-align:right;width:20%;border-bottom:1px solid black'>".number_format($dsd_sap,2)."</td>";
			 echo "<td style='text-align:center;width:5%'></td>";
			 $outcome = $dsd_sap+$tsd_sap+$msd_sap+$dsd_sum+$tsd_sum+$msd_sum+$m_tsd+$m_msd+$m_dsd;
			 echo "<td style='text-align:right;width:20%;border-bottom:1px solid black'>".number_format($outcome,2)."</td>";
			 echo "<td style='text-align:center;width:10%'>3</td>";
		  echo "</tr>";
		  echo "<tr >";
			 echo "<td colspan='4' style='font-weight:900;font-size:15px;'>กำไรสุทธิ</td>";
             echo "<td style='text-align:right;width:20%;'><p style='border-bottom-style: double;'>".number_format($income - $outcome,2)."</p></td>";
			 echo "<td style='text-align:center;width:10%'></td>";
		  echo "</tr>";	

	echo "</table>";


			
?>