
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

$th_month = array("01"=>"ม.ค.",'02'=>"ก.พ.",'03'=>"มี.ค.",'04'=>"เม.ย.",'05'=>"พ.ค.",'06'=>"มิ.ย.",'07'=>"ก.ค.",'08'=>"ส.ค.",'09'=>"ก.ย.",'10'=>"ต.ค.",'11'=>"พ.ย.",'12'=>"ธ.ค.");
/*
$monthBetween = $month_th[$monthEnd]." ".$yearEnd;


$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";



*/

		
	$start_str = explode("-", $start_date);
    $end_str = explode("-", $end_date);

	echo "<center><div class='header'><b>ช่วงเดือน ".$th_month[$start_str[1]]." ".($start_str[0]+543)." ถึงเดือน ".$th_month[$end_str[1]]." ".($end_str[0]+543)." </b></div></center>";
	
	echo "<table border='1' class='span12' style='margin-left:0px;margin-bottom:20px;'>";
		echo "<tr style='background-color:#F5C27F'>";
		 echo "<td style='text-align:center;width:5%'>ลำดับ</td>";
		 echo "<td style='text-align:center;width:20%'>ช่ื่อ-นามสกุล</td>";
		 echo "<td style='text-align:center;width:10%'>ตำแหน่ง</td>";
		 echo "<td style='text-align:center;width:35%'>โครงการ</td>";
         echo "<td style='text-align:center;width:18%'>ประเภทงาน</td>";
		 echo "<td style='text-align:center;width:7%'>ปีงบประมาณ</td>";

		echo "</tr>";

        $firtQuery = Yii::app()->db->createCommand()
                ->select('pj_name,pj_work_cat,pj_fiscalyear,pj_manager_name')
                ->from('project')
                ->where('pj_manager_name!="" AND pj_manager_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
                ->order("pj_fiscalyear DESC")
                ->queryAll();
        

        $second = Yii::app()->db->createCommand()
                ->select('pj_name,pj_work_cat,pj_fiscalyear,pj_director_name')
                ->from('project')
                ->where('pj_director_name!="" AND pj_director_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
             
                ->order("pj_fiscalyear DESC")
                ->queryAll();

        $result = array_merge($firtQuery, $second);              
        $no = 1; 
       

        function array_orderby()
        {
            $args = func_get_args();
            $data = array_shift($args);
            foreach ($args as $n => $field) {
                if (is_string($field)) {
                    $tmp = array();
                    foreach ($data as $key => $row)
                        $tmp[$key] = $row[$field];
                    $args[$n] = $tmp;
                    }
            }
            $args[] = &$data;
            call_user_func_array('array_multisort', $args);
            return array_pop($args);
        }



        // Pass the array, followed by the column names and sort flags
        $sorted = array_orderby($result, 'pj_fiscalyear', SORT_DESC); 
     
               
        foreach ($sorted as $key => $value) {
           echo "<tr>";
                 echo "<td style='text-align:center;'>".($no++)."</td>";
                 if(isset($value['pj_manager_name']))
                 {
                    echo "<td style='text-align:left;'>".$value['pj_manager_name']."</td>";
                    echo "<td style='text-align:center;'>ผู้จัดการโครงการ</td>";   
                 }
                 else
                 {
                    echo "<td style='text-align:left;'>".$value['pj_director_name']."</td>";
                    echo "<td style='text-align:center;'>ผู้อำนวยโครงการ</td>";
                 }
                 
                 echo "<td style='text-align:left;'>".$value['pj_name']."</td>";
                 echo "<td style='text-align:center;'>".WorkCategory::model()->findByPK($value['pj_work_cat'])->wc_name."</td>";
                 echo "<td style='text-align:center;'>".$value['pj_fiscalyear']."</td>";
           echo "</tr>";
        } 

      

	echo "</table>";


			
?>