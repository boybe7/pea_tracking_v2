
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
	//project contract
	$Criteria = new CDbCriteria();
	$Criteria->condition = "pc_proj_id='$pj->pj_id'";
	$pcs = ProjectContract::model()->findAll($Criteria);
	
	//$workcat = Workcat::model()->findByPk($pj->pj_work_cat);

	echo "<center><div class='header'><b>โครงการ".$pcs[0]->pc_details."<br>ให้ ".$pj->pj_name."</b></div></center>";
	echo "<br><table border='0' class='span12' style='margin-left:0px;'>";
	echo   "<tr><td colspan='4' style='background-color:#eeeeee;text-align:center'>ส่วนผู้ว่าจ้าง : ".$pj->pj_name."</td></tr>";
	foreach ($pcs as $key => $pc) {
		echo   "<tr><td width='30%'>ใบสั่งจ้างเลขที่ : ".$pc->pc_code."</td><td width='30%'>วันที่เริ่มในสัญญา : ".renderDate($pc->pc_sign_date)."</td><td width='50%' colspan=2>วันที่สิ้นสุดในสัญญา : ".renderDate($pc->pc_end_date)."</td></tr>";
	
	}
	//workcode
	$Criteria = new CDbCriteria();
	$Criteria->condition = "pj_id='$pj->pj_id'";
	$wcs = WorkCode::model()->findAll($Criteria);
	// print_r($wcs);
	echo   "<tr style='vertical-align:top'><td >หมายเลขงาน : ";

	$i=0;
	foreach ($wcs as $key => $wc) {
		if($i==0)  
		  echo $wc->code."<br>";
		else
		  echo "<span style='padding-left:82px;'>".$wc->code."</span><br>";	
		$i++;
	}
	echo "</td>";
	echo "<td width='30%'>แจ้งจัดสรรงบ กปง./กซข./กฟจ. : ";
	$i=0;
	foreach ($pcs as $key => $pc) {
	    if($i==0)  
		  echo $pc->pc_name_request."<br>";
		else
		  echo "<span style='padding-left:182px;'>".$pc->pc_name_request."</span><br>";	
		$i++;	
	}	
	echo "</td>";
	echo "<td width='25%'>เลขที่ส่ง / ลว. : ";
	$i=0;
	$sum_pc_cost = 0;
	foreach ($pcs as $key => $pc) {
	    
		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
		                				///print_r($changeHists);
                                        //echo $pp[0]["sum"];    

		$pcCost =$pc->pc_cost + $pp[0]["sum"];

		$sum_pc_cost += $pcCost;

	    if($i==0)  
		  echo $pc->pc_code_request."<br>";
		else
		  echo "<span style='padding-left:182px;'>".$pc->pc_code_request."</span><br>";	
		$i++;	
	}	
	echo "</td>";
	echo "<td width='15%'>วงเงิน : ".number_format($sum_pc_cost,2)."</td>";
	echo "</tr>";


	echo "</table>";

	echo "<table border='1' class='span12' style='margin-left:0px;'>";
		echo "<tr>";
		 echo "<td rowspan=2 style='text-align:center;width:5%'>ที่</td>";
		 echo "<td colspan=4 style='text-align:center;width:55%'>ด้านการดำเนินการโครงการ</td>";
		 echo "<td colspan=4 style='text-align:center;width:40%'>ด้านการเงิน</td>";
		echo "</tr>";
		echo "<tr>";
		 echo "<td style='text-align:center;width:25%'>รายละเอียด</td>";
		 echo "<td style='text-align:center;width:10%'>อนุมัติโดย/<br>ลงวันที่</td>";
		 echo "<td style='text-align:center;width:10%'>วงเงิน/<br>เป็นเงินเพิ่ม</td>";
		 echo "<td style='text-align:center;width:10%'>ระยะเวลาแล้วเสร็จ/<br>ระยะเวลาขอขยาย</td>";
		 
		 echo "<td style='text-align:center;width:10%'>ชำระเงินงวดที่</td>";
		 echo "<td style='text-align:center;width:10%'>ใบแจ้งหนี้/<br>ลงวันที่</td>";
		 echo "<td style='text-align:center;width:10%'>ใบเสร็จเลขที่/<br>ลงวันที่</td>";
		 echo "<td style='text-align:center;width:10%'>วงเงิน</td>";
			
		echo "</tr>";

		
		$data_approve = array();
		$data_payment = array();
		$i =0;
		foreach ($pcs as $key => $pc) {
			$approve = Yii::app()->db->createCommand()
                            ->select('detail,approveBy,dateApprove,cost,timeSpend')
                            ->from('contract_approve_history')
                            ->where("contract_id='$pc->pc_id' AND type=1")
                            ->queryAll();
            //print_r($data_approve);                
            if($i==0)
              $data_approve = $approve;
            else	
              array_merge($data_approve,$approve);    
            //print_r($data_approve);            

            $payment = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('payment_project_contract')
                            ->where("proj_id='$pc->pc_id'")
                            ->queryAll();                
            if($i==0)
              $data_payment = $payment;
            else	
              array_merge($data_payment,$payment);               
            $i++;
		}



		$sum_pay = 0;
		for ($i=0; $i < 5; $i++) { 
			echo "<tr>";
                if(!empty($data_approve[$i])) 
               	{
               		echo "<td style='text-align:center'>".($i+1)."</td>";
               		echo "<td >".$data_approve[$i]["detail"]."</td>";
               		echo "<td style='text-align:center'>".$data_approve[$i]["approveBy"]."<br>".renderDate2($data_approve[$i]["dateApprove"])."</td>";
               		echo "<td style='text-align:right'>".number_format($data_approve[$i]["cost"],2)."</td>";
               		echo "<td >".$data_approve[$i]["timeSpend"]."</td>";
               	}
               	else
               	{
               		echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
               	}	


               	 if(!empty($data_payment[$i])) 
               	{
               		
               		echo "<td >".$data_payment[$i]["detail"]."</td>";
               		echo "<td style='text-align:center'>".$data_payment[$i]["invoice_no"]."<br>".renderDate2($data_payment[$i]["invoice_date"])."</td>";
               		echo "<td style='text-align:center'>".$data_payment[$i]["bill_no"]."<br>".renderDate2($data_payment[$i]["bill_date"])."</td>";
               		echo "<td style='text-align:right'>".number_format($data_payment[$i]["money"],2)."</td>";

               		if($data_payment[$i]["bill_no"]!=""){
               			$sum_pay += $data_payment[$i]["money"];
               		}
               	}
               	else
               	{
               		if($i!=4)
               		   echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
               		else
               		{
               			$remain = $sum_pc_cost - $sum_pay;
               			echo "<td colspan=3 style='text-align:center'>คงเหลือ</td><td style='text-align:right'>".number_format($remain,2)."</td>";
               		}
               	}	
			echo "</tr>";
		}

	echo "</table>";

	//----------outsource---------------------//

	$Criteria = new CDbCriteria();
	$Criteria->condition = "oc_proj_id='$pj->pj_id'";
	$ocs = OutsourceContract::model()->findAll($Criteria);


	$index = 0;
	foreach ($ocs as $key => $oc) {
	        $index++;
	        $vendor = Vendor::model()->findByPk($oc->oc_vendor_id);	
			
	        $sum_oc_cost = 0;
			$pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(cost) as sum')
		                                            ->from('contract_change_history')
		                                            ->where("contract_id='$oc->oc_id' AND type=2")
		                                            ->queryAll();
				                				///print_r($changeHists);
		    $oc->oc_cost = str_replace(",", "", $oc->oc_cost);    

			$sum_oc_cost =$oc->oc_cost + $pp[0]["sum"];

			echo "<br><table border='0' class='span12' style='margin-left:0px;margin-top:15px;'>";
			echo   "<tr><td colspan='4' style='background-color:#eeeeee;text-align:center'>ส่วนผู้รับจ้าง รายที่ ".$index." : ".$vendor->v_name."</td></tr>";
			echo   "<tr><td width='30%'>สัญญาจ้างเลขที่ : ".$oc->oc_code."</td><td width='25%'>วันที่เริ่มในสัญญา : ".renderDate($oc->oc_sign_date)."</td><td width='25%'>วันที่สิ้นสุดในสัญญา : ".renderDate($oc->oc_end_date)."</td><td width='30%' style='text-align:right'>วงเงิน : ".number_format($sum_oc_cost,2)."</td></tr>";
			
			//po
			$Criteria = new CDbCriteria();
			$Criteria->condition = "contract_id='$oc->oc_id'";
			$pos = WorkCodeOutsource::model()->findAll($Criteria);
			
			//print_r($pos);
			
			$index2 = 1;
			foreach ($pos as $key => $po) {
			echo "<tr>";	
				echo "<td>".$index2.". PO เลขที่ : ".$po->PO."</td>";
				echo "<td colspan=2> เลขที่ส่งแจ้งรับรองงบ กปง. : ".$po->letter."</td>";
				echo "<td style='text-align:right'> เป็นเงิน : ".number_format($po->money,2)."</td>";
			echo "</tr>";
			   $index2++;
			}
			

			// print_r($wcs);
					
		
			//echo "</tr>";


			echo "</table>";

			echo "<table border='1' class='span12' style='margin-left:0px;'>";
				echo "<tr>";
				 echo "<td rowspan=2 style='text-align:center;width:5%'>ที่</td>";
				 echo "<td colspan=4 style='text-align:center;width:55%'>ด้านการดำเนินการโครงการ</td>";
				 echo "<td colspan=4 style='text-align:center;width:40%'>ด้านการเงิน</td>";
				echo "</tr>";
				echo "<tr>";
				 echo "<td style='text-align:center;width:25%'>รายละเอียด</td>";
				 echo "<td style='text-align:center;width:10%'>อนุมัติโดย/<br>ลงวันที่</td>";
				 echo "<td style='text-align:center;width:10%'>วงเงิน/<br>เป็นเงินเพิ่ม</td>";
				 echo "<td style='text-align:center;width:10%'>ระยะเวลาแล้วเสร็จ/<br>ระยะเวลาขอขยาย</td>";
				 
				 echo "<td style='text-align:center;width:10%'>ชำระเงินงวดที่</td>";
				 echo "<td style='text-align:center;width:10%'>อนุมัติโดย</td>";
				 echo "<td style='text-align:center;width:10%'>วัน/เดือน/ปี</td>";
				 echo "<td style='text-align:center;width:10%'>วงเงิน</td>";
					
				echo "</tr>";

				
				$data_approve = Yii::app()->db->createCommand()
		                            ->select('detail,approveBy,dateApprove,cost,timeSpend')
		                            ->from('contract_approve_history')
		                            ->where("contract_id='$oc->oc_id' AND type=2")
		                            ->queryAll();
		        
		        $data_payment = Yii::app()->db->createCommand()
		                            ->select('*')
		                            ->from('payment_outsource_contract')
		                            ->where("contract_id='$oc->oc_id'")
		                            ->queryAll();                
		        //print_r($data_payment);

				$sum_pay = 0;
				for ($i=0; $i < 5; $i++) { 
					echo "<tr>";
		                if(!empty($data_approve[$i])) 
		               	{
		               		echo "<td style='text-align:center'>".($i+1)."</td>";
		               		echo "<td >".$data_approve[$i]["detail"]."</td>";
		               		echo "<td style='text-align:center'>".$data_approve[$i]["approveBy"]."<br>".renderDate2($data_approve[$i]["dateApprove"])."</td>";
		               		echo "<td style='text-align:right'>".number_format($data_approve[$i]["cost"],2)."</td>";
		               		echo "<td >".$data_approve[$i]["timeSpend"]."</td>";
		               	}
		               	else
		               	{
		               		echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
		               	}	


		               	 if(!empty($data_payment[$i])) 
		               	{
		               		
		               		echo "<td >".$data_payment[$i]["detail"]."</td>";

		               		echo "<td style='text-align:center'>".$data_payment[$i]["approve_by"]."</td>";
		               		echo "<td style='text-align:center'>".renderDate2($data_payment[$i]["approve_date"])."</td>";
		               		echo "<td style='text-align:right'>".number_format($data_payment[$i]["money"],2)."</td>";

		               		if($data_payment[$i]["approve_date"]!=""){
		               			$sum_pay += $data_payment[$i]["money"];
		               		}
		               	}
		               	else
		               	{
		               		if($i!=4)
		               		   echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
		               		else
		               		{
		               			//echo $sum_oc_cost;
		               			$remain = $sum_oc_cost - $sum_pay;
		               			echo "<td colspan=3 style='text-align:center'>คงเหลือ</td><td style='text-align:right'>".number_format($remain,2)."</td>";
		               		}
		               	}	
					echo "</tr>";
				}

			echo "</table><br>";
	}		
?>