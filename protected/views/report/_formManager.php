
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


$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
/*
$monthBetween = $month_th[$monthEnd]." ".$yearEnd;


$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";



*/

		
	
	echo "<center><div class='header'><b>ช่วงเดือน </b></div></center>";
	
	echo "<table border='1' class='span12' style='margin-left:0px;margin-bottom:20px;'>";
		echo "<tr style='background-color:#F5C27F'>";
		 echo "<td style='text-align:center;width:5%'>ลำดับ</td>";
		 echo "<td style='text-align:center;width:20%'>ช่ื่อ-นามสกุล</td>";
		 echo "<td style='text-align:center;width:20%'>ตำแหน่ง</td>";
		 echo "<td style='text-align:center;width:40%'>โครงการ</td>";
		 echo "<td style='text-align:center;width:10%'>ปีงบประมาณ</td>";

		echo "</tr>";

        $model = Yii::app()->db->createCommand()
                ->select('*')
                ->from('project')
                ->where('pj_manager_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
                ->order("pj_fiscalyear DESC")
                ->queryAll();
       
        $no = 1;        
        foreach ($model as $key => $value) {
           echo "<tr>";
                 echo "<td style='text-align:center;'>".($no++)."</td>";
                 echo "<td style='text-align:left;'>".$value['pj_manager_name']."</td>";
                 echo "<td style='text-align:center;'>ผู้จัดการโครงการ</td>";
                 echo "<td style='text-align:left;'>".$value['pj_name']."</td>";
                 echo "<td style='text-align:center;'>".$value['pj_fiscalyear']."</td>";
           echo "</tr>";
        } 

        $model = Yii::app()->db->createCommand()
                ->select('*')
                ->from('project')
                ->where('pj_director_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
                ->order("pj_fiscalyear DESC")
                ->queryAll();
     
        foreach ($model as $key => $value) {
           echo "<tr>";
                 echo "<td style='text-align:center;'>".($no++)."</td>";
                 echo "<td style='text-align:left;'>".$value['pj_director_name']."</td>";
                 echo "<td style='text-align:center;'>ผู้อำนวยการโครงการ</td>";
                 echo "<td style='text-align:left;'>".$value['pj_name']."</td>";
                 echo "<td style='text-align:center;'>".$value['pj_fiscalyear']."</td>";
           echo "</tr>";
        }               

	echo "</table>";


			
?>