
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

			$Criteria = new CDbCriteria();
			$Criteria->join = 'LEFT JOIN project ON mc_proj_id=pj_id'; 
			$Criteria->condition = "mc_type=1 AND mc_proj_id=".$pj_id;
			$Criteria->order = "mc_date ASC";
			$model_cost = ManagementCost::model()->findAll($Criteria);

			$Criteria = new CDbCriteria();
			$Criteria->join = 'LEFT JOIN project ON pc_proj_id=pj_id'; 
			$Criteria->condition = "pc_proj_id=".$pj_id;
			$model_pc = ProjectContract::model()->findAll($Criteria);
			//print_r($model_pc);

			$Criteria = new CDbCriteria();
			$Criteria->join = 'LEFT JOIN project ON mc_proj_id=pj_id'; 
			$Criteria->condition = "mc_in_project=3 AND mc_proj_id=".$pj_id;
			$model_cost_pj = ManagementCost::model()->findAll($Criteria);
			//echo $pj_id;
			$management_cost_pj = empty($model_cost_pj) ? 0 : $model_cost_pj[0]->mc_cost;
			
		

	echo "<br><br><center><div class='header'><b>ค่ารับรองโครงการ ".$model_pc[0]->pc_details."</b></div></center>";
	echo "<center><div class='header'><b>ตามอนุมัติ รผก.(ย) อนุมัติหลักการค่ารับรองเป็นเงิน ".number_format($management_cost_pj,2)." บาท</b></div></center>";

	

	echo "<br><br><table border='1' class='span12' style='margin-left:0px;'>";
		echo "<tr>";
		 echo "<td rowspan=2 style='text-align:center;width:5%'>ลำดับที่</td>";
		 echo "<td rowspan=2 style='text-align:center;width:10%'>ผู้ขออนุมัติเบิก</td>";
		 echo "<td rowspan=2 style='text-align:center;width:20%'>บันทึกขออนุมัติค่ารับรอง<br>
อนุมัติ เลขที่.../ลว........</td>";
		 echo "<td colspan=2 style='text-align:center;width:26%'>บันทึกขออนุมัติเบิกค่าใช้จ่ายรับรอง</td>";
		 echo "<td rowspan=2 style='text-align:center;width:10%'>อนุมัติเป็นเงิน</td>";
		 echo "<td rowspan=2 style='text-align:center;width:10%'>เบิกจริงเป็นเงิน</td>";
		 echo "<td rowspan=2 style='text-align:center;width:10%'>คงเหลือปัจจุบัน</td>";
		echo "</tr>";
		echo "<tr>";
		 echo "<td style='text-align:center;width:13%'>อนุมัติ เลขที่.../ลว........</td>";
		 echo "<td style='text-align:center;width:13%'>ผู้อนุมัติ (ผู้อำนวยการโครงการ)</td>";
		 
			
		echo "</tr>";

		
		 $remain_cost = $management_cost_pj;
		 $no =1;  
	        foreach($model_cost as $model)
	        {
         
	            if($model->mc_cost!=0)
	              $remain_cost -= $model->mc_cost;
	        	else
	        	  $remain_cost -= $model->mc_approve_cost; 		
	        	echo "<tr>";
	        		echo "<td style='text-align:center;'>".$no."</td>";
	        		echo "<td style='text-align:center;'>".$model->mc_requester."</td>";
	        		echo "<td style='text-align:center;'>".$model->mc_letter_request."</td>";
	        		echo "<td style='text-align:center;'>".$model->mc_letter_approve."</td>";
	        		echo "<td style='text-align:center;'>".$model->mc_approver."</td>";
	        		echo "<td style='text-align:center;'>".number_format($model->mc_approve_cost,2)."</td>";
	        		echo "<td style='text-align:center;'>".number_format($model->mc_cost,2)."</td>";
	        		echo "<td style='text-align:center;'>".number_format($remain_cost,2)."</td>";
	        	echo "</tr>";
	        	$no++;
	        }

	echo "</table>";

	
	
?>