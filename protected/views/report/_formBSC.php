
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

	//$fiscal_year  = date("n") < 10 ? date("Y")+543 : date("Y")+543 +1;
	
	echo "<center><div class='header'><b>ข้อมูลด้านการให้บริการ วันที่ ".renderDate($date_start)." ถึงวันที่ ".renderDate($date_end)." (วงเงินไม่รวมภาษีมูลค่าเพิ่ม)</b></div></center>";
	echo "<br>";
	
	$Criteria = new CDbCriteria();
	$dateStr = explode("/", $date_start);
	$date_start = $dateStr[2]."-".$dateStr[1]."-".$dateStr[0];
	$dateStr = explode("/", $date_end);
	$date_end = $dateStr[2]."-".$dateStr[1]."-".$dateStr[0];


	$Criteria->join = 'LEFT JOIN project_contract ON pc_proj_id=pj_id'; 
	$Criteria->condition = " (pc_end_date >= '$date_start' AND pc_sign_date<='$date_end') OR (pc_sign_date <= '$date_end' AND pc_end_date>='$date_start') AND (pc_sign_date!='0000-00-00' AND pc_end_date='0000-00-00') GROUP BY pj_id ";// AND pj_status=1";

	//echo  " (pc_end_date >= '$date_start' AND pc_sign_date<='$date_end') OR (pc_sign_date <= '$date_end' AND pc_end_date>='$date_start') AND (pc_sign_date!='0000-00-00' AND pc_end_date='0000-00-00')  ";
	$Criteria->order = 'pj_fiscalyear DESC, pj_date_approved DESC';
	$projects = Project::model()->findAll($Criteria);



	echo "<table border='1' class='span12' style='margin-left:0px;'>";
		echo "<tr>";
		 echo "<td  style='font-weight: bold;text-align:center;width:5%;background-color: #ddd;'>ลำดับ</td>";
		 echo "<td  style='font-weight: bold;text-align:center;width:25%;background-color: #ddd;'>โครงการ/ผู้ว่าจ้าง</td>";
		 echo "<td  style='font-weight: bold;text-align:center;width:40%;background-color: #ddd;'>รายละเอียดงาน</td>";
		 echo "<td style='font-weight: bold;text-align:center;width:10%;background-color: #ddd;'>วงเงินตามสัญญา<br>(ไม่รวม VAT)</td>";
		 echo "<td style='font-weight: bold;text-align:center;width:10%;background-color: #ddd;'>กำไรขั้นต้น (บาท)</td>";		 
		 echo "<td style='font-weight: bold;text-align:center;width:10%;background-color: #ddd;'>คิดเป็นร้อยละ</td>";
		
		echo "</tr>";

		$i=1;
		$proj_cost_total = 0;
		$income_total = 0;
		$year = 0;
		

		foreach ($projects as $key => $proj) {
			if($year!=$proj->pj_fiscalyear)
			{
				$year = $proj->pj_fiscalyear;
				echo "<tr><td colspan=6 height=30><b> ปีงบประมาณ ".$year."</b></td></tr>";
			}
			echo "<tr>";
				echo "<td style='text-align:center;' height=30>".$i."</td>";
				echo "<td style='' height=30>".$proj->pj_name.":".$proj->pj_id."</td>";
				//project contract
				$pcData=Yii::app()->db->createCommand("SELECT sum(pc_cost) as proj_cost,pc_details FROM project_contract WHERE pc_proj_id='$proj->pj_id'")->queryAll(); 
				
				$incomeData=Yii::app()->db->createCommand("SELECT sum(cost) as income FROM project_contract c LEFT JOIN contract_approve_history a ON pc_id=contract_id WHERE pc_proj_id='$proj->pj_id' AND type=1 AND detail LIKE '%กำไร%' AND dateApprove BETWEEN '$date_start' AND '$date_end' ")->queryAll();

				if($proj->pj_id==281)
				echo "SELECT sum(cost) as income FROM project_contract c LEFT JOIN contract_approve_history a ON pc_id=contract_id WHERE pc_proj_id='$proj->pj_id' AND type=1 AND detail LIKE '%กำไร%' AND dateApprove BETWEEN '$date_start' AND '$date_end' ";

				$proj_cost_total += $pcData[0]['proj_cost'];
				$income_total += $incomeData[0]['income'];

				
				echo "<td style=''>".$pcData[0]['pc_details']."</td>";
				echo "<td style='text-align:right;'>".number_format($pcData[0]['proj_cost'],2)."</td>";
				

				echo "<td style='text-align:right;'>".number_format($incomeData[0]['income'],2)."</td>";
				$percent = $pcData[0]['proj_cost']==0 ? 0: ($incomeData[0]['income']/$pcData[0]['proj_cost'])*100;
				echo "<td style='text-align:right;'>".number_format($percent,2)."</td>";
			echo "</tr>";

			$i++;
		}

		
		echo "<tr>";
		 
		 echo "<td colspan=3 style='text-align:center;width:70%' height=30>รวมเป็นเงิน</td>";
		 echo "<td style='text-align:right;width:10%'>".number_format($proj_cost_total,2)."</td>";
		 echo "<td style='text-align:right;width:10%'>".number_format($income_total,2)."</td>";	
		 $percent = $proj_cost_total==0 ? 0: ($income_total/$proj_cost_total)*100;	 
		 echo "<td style='text-align:right;'>".number_format($percent,2)."</td>";
		
		echo "</tr>";

	echo "</table>";
		
?>