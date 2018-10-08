
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

$monthBetween = $month_th[$monthEnd]." ".$yearEnd;


$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";

//check year
///if($yearEnd>$yearBegin)


//echo $monthCondition;

$maxPayment = 6;
$sumPayPCAll = 0;
$sumPayOCAll = 0;
foreach ($model as $key => $pj) {
		
	
	echo "<center><div class='header'><b>สรุปรายได้/ค่าใช้จ่าย <br>".$pj->pj_name."<br>ประจำเดือน ".$monthBetween."</b></div></center>";
	
	echo "<table border='1' class='span12' style='margin-left:0px;margin-bottom:20px;'>";
		echo "<tr style='background-color:#F5C27F'>";
		 echo "<td style='text-align:center;width:15%'>วดป.<br>ใบเสร็จรับเงิน</td>";
		 echo "<td style='text-align:center;width:20%'>รายการ</td>";
		 echo "<td style='text-align:center;width:20%'>จำนวนเงิน</td>";
		 echo "<td style='text-align:center;width:15%'>วดป.<br>อนุมัติรับเงิน</td>";
		 echo "<td style='text-align:center;width:20%'>รายการ</td>";
		 echo "<td style='text-align:center;width:20%'>รายจ่าย</td>";
		echo "</tr>";

						//project contract
	    				$Criteria = new CDbCriteria();
	                     $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	                	 $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         $pay_pc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(bill_date) as year')
                                            ->from('payment_project_contract')
                                            ->join('project_contract p', 'proj_id=p.pc_id')
                                            ->where("p.pc_proj_id='$pj->pj_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition)
                                            ->group("YEAR(bill_date)")
                                            ->queryAll();
                        
                        //$m_sum = $pp[0]["sum"];

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);
                         $maxContract = $nPC < $nOC ? $nOC : $nPC ;
                         $pj_rowspan = $maxContract * $maxPayment;

                          $pay_oc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(approve_date) as year')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract o', 'contract_id=o.oc_id')
                                            ->where("o.oc_proj_id='$pj->pj_id' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date ".$monthCondition)
                                            ->group("YEAR(approve_date)")
                                            ->queryAll();
                        

                         //management
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=2 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum1 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum2 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=3 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum3 = $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost) as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=1")
                                            ->queryAll();
                        $m_plan1 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=2")
                                            ->queryAll();
                        $m_plan2 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=3")
                                            ->queryAll();
                        $m_plan3 = $pp[0]["mc_cost"];


                        //echo $m_sum;   

        $iPC = 0;
        $iOC = 0;
        
        $iPayOC = 0;
        $iPayPC = 0;
        //echo count($pcs);
        $sumPayPCAll = 0;
        for ($i=0; $i < $pj_rowspan; $i++) 
        { 
        	echo '<tr>';
			if($i%$maxPayment==0)
        	{
        		$paymentOC = array();
        		//$paymentPC = array();
        		$sumPayOCAll = 0;
        		
        	}
        	//draw PC
        	if(!empty($pcs[$iPC]))
        	{
        		$pc = $pcs[$iPC];
        		
        		$vendor = Vendor::model()->findByPk($pc->pc_vendor_id);
        		//print_r($vendor);
        		//echo "<br>";
				if($i%$maxPayment==0)
	        	{
	        		$sumPayPC = 0;	
	        		$iPC++;
	        		if($nPC==1)
						echo '<td>วงเงินสัญญา</td><td></td>';
					else if(!empty($vendor))
						echo '<td colspan="2">'.$vendor->v_name.'</td>';
					$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
                    $costPC = $pp[0]["sum"] + $pc->pc_cost;                        
					echo '<td align="right">'.number_format($costPC,2).'</td>';

					$Criteria = new CDbCriteria();
                	$Criteria->condition = "proj_id='$pc->pc_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition;
                	$payment = PaymentProjectContract::model()->findAll($Criteria);



                	//echo("bill_date ".$monthCondition);

                	$iPayPC = 0;
	        	}
	        	else{

		        		//draw payment
		        	if(!empty($payment[$iPayPC]))
		        	{

		        		echo '<td align="center">'.renderDate($payment[$iPayPC]->bill_date).'</td>';
		        		echo '<td >'.$payment[$iPayPC]->detail.'</td>';
		        		$money = str_replace(",", "", $payment[$iPayPC]->money);
		        		$sumPayPC += $money;
		        		echo '<td align="right">'.number_format($money,2).'</td>';
		        		 $iPayPC++;
		        	}
	                else{
		        		
	                	if($i%$maxPayment==$maxPayment-1 && $i<=$iPC*$maxPayment)
		        		{	
		        			echo '<td>&nbsp;</td><td align="center" style="color:red"><u>คงเหลือค้างรับ</u></td>';
		        		    ///echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
		        		
		        		    $rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
		        		    $sumPayPCAll += $sumPayPC;
		        		    echo '<td align="right" style="color:red"><u>'.$rm.'</u></td>';
		        		}
		        		else
		        		     echo '<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>';	
		        		
		
		        	}
	        	}
               
        	}
        	else
        	{
	        			//draw payment
		        	if(!empty($payment[$iPayPC]))
		        	{

		        		echo '<td align="center">'.renderDate($payment[$iPayPC]->bill_date).'</td>';
		        		echo '<td >'.$payment[$iPayPC]->detail.'</td>';
		        		$money = str_replace(",", "", $payment[$iPayPC]->money);
		        		$sumPayPC += $money;
		        		echo '<td align="right">'.number_format($money,2).'</td>';
		        		$iPayPC++;
		        	}
		        	else{
		        		
		        		if($i%$maxPayment==$maxPayment-1 && $i<=$iPC*$maxPayment)
		        		{	
		        			echo '<td>&nbsp;</td><td align="center" style="color:red"><u>คงเหลือค้างรับ</u></td>';
		        		    //echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
		        			$rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
		        			$sumPayPCAll += $sumPayPC;
		        		    echo '<td align="right" style="color:red"><u>'.$rm.'</u></td>';
		        		}
		        		else	
		        		   echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
		        	}
	                
	        }



        	//draw OC


			if(!empty($ocs[$iOC]))
        	{
        		$oc = $ocs[$iOC];
        		$vendor = Vendor::model()->findByPk($oc->oc_vendor_id);


				if($i%$maxPayment==0)
	        	{
	        		$iOC++;
	        		$sumPayOC = 0;

					echo '<td colspan="2">&nbsp;'.$vendor->v_name.'</td>';
					$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll();
                    $costOC = $pp[0]["sum"] + str_replace(",", "", $oc->oc_cost);                        
					echo '<td align="right">'.number_format($costOC,2).'</td>';

					$Criteria = new CDbCriteria();
                	$Criteria->condition = "contract_id='$oc->oc_id' AND approve_date!='' AND approve_date ".$monthCondition;
                	$paymentOC = PaymentOutsourceContract::model()->findAll($Criteria);
                	//echo(count($paymentOC));
                	//echo "contract_id='$oc->oc_id' AND approve_date!='' AND approve_date ".$monthCondition;
                	//print_r($paymentOC);
                	$iPayOC = 0;
	        	}
	        	else{

		        		//draw payment
		        	if(!empty($paymentOC[$iPayOC]))
		        	{
		        		
		        		echo '<td align="center">'.renderDate($paymentOC[$iPayOC]->approve_date).'</td>';
		        		echo '<td >'.$paymentOC[$iPayOC]->detail.'</td>';
		        		$money = str_replace(",", "", $paymentOC[$iPayOC]->money);
		        		$sumPayOC += $money;
		        		echo '<td align="right">'.number_format($money,2).'</td>';
		        		$iPayOC++;
		        	}
		        	else{
		        		if($i%$maxPayment==$maxPayment-1 && $i<=$iOC*$maxPayment)
		        		{	
		        			echo '<td>&nbsp;</td><td align="center" style="color:red"><u>ค้างจ่าย</u></td>';
		        		    //echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
		        			$rm = $costOC-$sumPayOC==0 ? "-": number_format($costOC-$sumPayOC,2);
		        			$sumPayOCAll += $sumPayOC;
		        		    echo '<td align="right" style="color:red"><u>'.$rm.'</u></td>';
		        		}
		        		else	
		        		   echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';	
		        		
		
		        	}
	                
	        	}
		    
        	}
        	else{
        			if(!empty($paymentOC[$iPayOC]))
		        	{
		        		///print_r($paymentOC);
		        		echo '<td align="center">'.renderDate($paymentOC[$iPayOC]->approve_date).'</td>';
		        		echo '<td >'.$paymentOC[$iPayOC]->detail.'</td>';
		        		$money = str_replace(",", "", $paymentOC[$iPayOC]->money);
		        		$sumPayOC += $money;
		        		echo '<td align="right">'.number_format($money,2).'</td>';
		        		$iPayOC++;
		        	}
		        	else{
		        		if($i%$maxPayment==$maxPayment-1 && $i<=$iOC*$maxPayment)
		        		{	
		        			echo '<td>&nbsp;</td><td align="center" style="color:red"><u>ค้างจ่าย</u></td>';
		        		    //echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
		        			$rm = $costOC-$sumPayOC==0 ? "-": number_format($costOC-$sumPayOC,2);
		        			$sumPayOCAll += $sumPayOC;
		        		    echo '<td align="right" style="color:red"><u>'.$rm.'</u></td>';
		        		}
		        		else	
		        		   echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
		        	}
	                
				
			    	
        	}   


        		
			echo '</tr>';
	                 	
        }                 
        //summary project

        //echo count($pay_pc);
        $max = count($pay_pc) < count($pay_oc) ? count($pay_oc): count($pay_pc);
        for ($i=0; $i < $max; $i++) { 
        	echo '<tr style="background-color:#D7A8F7">';
        	if(!empty($pay_pc[$i]))
        	{	
	        	if($pay_pc[$i]["year"]==$yearEnd)
	        	  echo '<td colspan="2">รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
	         	else
	         	  echo '<td colspan="2">รวมรายรับ ณ เดือน ธันวาคม '.$pay_pc[$i]["year"].'</td>';
	         	
	         	echo '<td align="right">'.number_format($pay_pc[$i]["sum"],2).'</td>';
	        }
	        else{
	        	echo '<td colspan="2"></td><td></td>';	
	        } 			
	        if(!empty($pay_oc[$i]))
        	{	
	        	if($pay_oc[$i]["year"]==$yearEnd)
	        	  echo '<td colspan="2">รวมรายจ่าย ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
	         	else
	         	  echo '<td colspan="2">รวมรายจ่าย ณ เดือน ธันวาคม '.$pay_oc[$i]["year"].'</td>';

	         	echo '<td align="right">'.number_format($pay_oc[$i]["sum"],2).'</td>';
	        }
	        else{
	        	echo '<td colspan="2"></td><td></td>';	
	        }
         	
        	echo '</tr>';
        
        }
        // echo '<tr style="background-color:#D7A8F7">';
        // 	echo '<td colspan="2">รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
        //  	echo '<td align="right">'.number_format($sumPayPCAll,2).'</td>';
        //  	echo '<td colspan="2">รวมรายจ่าย ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
        //  	echo '<td align="right">'.number_format($sumPayOCAll,2).'</td>';
        // echo '</tr>';
         echo '<tr style="background-color:#D7A8F7">';
        	echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';
         	
         	echo '<td colspan="2">ค่าบริหารโครงการ ('.number_format($m_plan1,2).')</td>';
         	echo '<td align="right">'.number_format($m_sum1,2).'</td>';
        echo '</tr>';
        echo '<tr style="background-color:#D7A8F7">';
        	echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';
         	
         	echo '<td colspan="2">ค่ารับรอง ('.number_format($m_plan2,2).')</td>';
         	echo '<td align="right">'.number_format($m_sum2,2).'</td>';
        echo '</tr>';
        echo '<tr style="background-color:#D7A8F7">';
        	echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';
         	
         	echo '<td colspan="2">ค่าบุคลากร ('.number_format($m_plan3,2).')</td>';
         	echo '<td align="right">'.number_format($m_sum3,2).'</td>';
        echo '</tr>';
         echo '<tr style="background-color:#D7A8F7">';
        	echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';echo '<td>&nbsp;</td>';
         	echo '<td colspan="2"><b>กำไร/ขาดทุน</b></td>';
         	echo '<td align="right"><b>'.number_format($sumPayPCAll-$sumPayOCAll-$m_sum1-$m_sum2-$m_sum3,2).'<b></td>';
        echo '</tr>';
	echo "</table>";
}

			
?>