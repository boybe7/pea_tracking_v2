<?php
$this->breadcrumbs=array(
	'สรุปงานรายรับ-รายจ่ายงานโครงการ ',
	
);


?>

<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}

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

    $renderDate = $d." ".$th_month[$mi]." ".substr($yi,2);
    if($renderDate==0)
        $renderDate = "";   

    return $renderDate;             
}
?>

</style>

        <table class="table table-bordered reportTable">
        
            <thead>
              <tr> 
                <th width="20px" rowspan="2">ลำดับ</th>
                <th width="200px" rowspan="2">ชื่อโครงการ</th>
                <th width="100px" rowspan="2">วงเงินตามสัญญา</th>
                <th width="100px" rowspan="2">รายรับ</th>
                <th width="100px" rowspan="2">ยอดรับคงเหลือ</th>
                <th width="150px" rowspan="2">ชื่อผู้รับจ้าง</th>
                <th width="100px" rowspan="2">วงเงินตามสัญญาจ้างช่วง</th>
                <th width="100px" rowspan="2">รายจ่าย</th>
                <th width="100px" rowspan="2">ยอดจ่ายคงเหลือ</th>
                <th width="100px"  rowspan="2">ประมาณการค่าบริหารโครงการ</th>
                <th colspan="3">รายจ่ายที่เกิดขึ้นจริง</th>
                </tr>
              <tr>
              	
                <th width="100px">ค่าบริหารโครงการ</th>
                <th width="100px">ค่ารับรอง</th>
                <th width="100px">คงเหลือ</th>
               
              </tr>  
            </thead>
            <tbody>
               <tr style="line-height: 0px">
                    <td style="padding-top:0px;padding-bottom:0px;"></td>
                    <!-- Project-->
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                 
                </tr>
                <?php
                //fiscalyear
                $fiscalyear = array();

                foreach ($model as $key => $value) {
                	
                	//print_r($value);
                	if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                	   $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                

                }

                //print_r($model);
                //summary all
                $sumall_pc_cost = 0;
                $sumall_pc_receive = 0;
                         
                $sumall_oc_cost = 0;
                $sumall_oc_receive = 0;
                       
                $sumall_m_real = 0;
                $sumall_m_type1 = 0;
                $sumall_m_expect = 0;
                asort($fiscalyear);
                foreach ($fiscalyear as $key => $value) {
                	$data = explode("/", $value);
                	$year = $data[0];
                	$cat = $data[1];

                	$mWorkCat = WorkCategory::model()->findByPk($cat);

                	//echo $mWorkCat->wc_name;
                	echo "<tr>";
                	
                	echo "<td style='background-color:#EBF8A4' colspan='13'> ".$mWorkCat->wc_name."</td>";
                	
                	echo "</tr>";
                	
                	//echo $year.":".$cat;

	                $maxPayment = 5;
                	$index = 1;

                	 //summary
                         $sum_pc_cost = 0;
                         $sum_pc_receive = 0;
                         
                         $sum_oc_cost = 0;
                         $sum_oc_receive = 0;
                       
                         $sum_m_real = 0;
                         $sum_m_type1 = 0;
                         $sum_m_expect = 0;
                       

                	foreach ($model as $key => $pj) {
                	  
                      //echo $cat.",".$pj->pj_work_cat."<br>";
                        
                      if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                	  {	
                		
                	  	//if($cat==2)
                        //    echo $pj->pj_name;
                		//project contract
	                	 $Criteria = new CDbCriteria();
	                     $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	                	 $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(pc_cost) as sum')
                                            ->from('project_contract')
                                            ->where("pc_proj_id='$pj->pj_id'")
                                            ->queryAll();  
                        $pcCostAll = $pp[0]["sum"];                     
                        foreach ($pcs as $key => $pc) {
                            $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll(); 
                            $pcCostAll += $pp2[0]["sum"];                 
                         } 
                         
                                                                                
                            

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);

                         //management cost
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0";
                        $m_plan = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1 ";
                        $m_real = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=1";
                        $m_type1 = ManagementCost::model()->findAll($Criteria);

                        

                        //end

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0")
                                            ->queryAll();
                        $sum_m_expect += $pp[0]["sum"];
                        $m_expect_sum = $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1")
                                            ->queryAll();
                        $m_type1_sum = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1")
                                            ->queryAll();
                        $m_real_sum = $pp[0]["sum"];

                        $sum_m_real += $m_real_sum;
                        $sum_m_type1 += $m_type1_sum;
                        //profit
                        //1.income
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('project_contract','proj_id=pc_id')
                                            ->where("pc_proj_id='$pj->pj_id' AND bill_no!=''")
                                            ->queryAll();
                        //echo $pp[0]["sum"];
                        $income = $pp[0]["sum"];
                        
                        //1.outcome
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_proj_id='$pj->pj_id'")
                                            ->queryAll();                    
                        $outcome = $pp[0]["sum"];                    
                      



                         $maxContract = $nOC==0? 1:$nOC;

                         $pj_rowspan = $maxContract ;

                        
                        

                         //end

                         $iPC = 0;
                         $iOC = 0;
                         $pcCost = 0;
                         $ocCost = 0;
                        for ($i=0; $i <$pj_rowspan ; $i++) { 
                            
                            echo "<tr id='row".$i."'>";
                            	//draw project detail
                            	if($i==0)
                            	{
                            		echo "<td >".$index."</td>";
		                			echo "<td >".$pj->pj_name."</td>";
                                    //draw PC
                                    echo "<td style='text-align:right' >".number_format($pcCostAll,2)."</td>";
                                    $sum_pc_cost += $pcCostAll;
                                    $sum_pc_receive += $income;
                                    $income1 = $income==0 ? '-' : number_format($income,2);
                                    echo "<td style='text-align:right' >".$income1."</td>";
                                    
                                    echo "<td style='text-align:right' >".number_format($pcCostAll-$income,2)."</td>";
                            	}
                                else{
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                }

                                //draw OC
                                if(!empty($ocs[$i]))
                                {
                                    $oc = $ocs[$i];
                                    $vendor = Vendor::model()->findByPk($oc->oc_vendor_id);
                                    echo "<td>".$vendor->v_name."</td>";

                                    $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll(); 
                                    $ocCostAll =str_replace(",", "", $oc->oc_cost) + $pp2[0]["sum"];                 
                                    echo "<td style='text-align:right'>".number_format($ocCostAll,2)."</td>";
                                    $sum_oc_cost += $ocCostAll;

                                    $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->where("contract_id='$oc->oc_id' AND approve_date!=''")
                                            ->queryAll();                    
                                    $outcomeOC = $pp[0]["sum"];   
                                    $sum_oc_receive += $outcome; 
                                    $outcomeOC1 = $outcomeOC==0 ? '-' : number_format($outcomeOC,2);
                                    echo "<td style='text-align:right'>".$outcomeOC1."</td>";
                                    echo "<td style='text-align:right'>".number_format($ocCostAll-$outcomeOC,2)."</td>";
                                    

                                }else{
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";

                                }

                                if($i==0)
                                {
                                    
                                    $expect = $m_expect_sum==0 ? "-" : number_format($m_expect_sum,2);
                                    $real = $m_real_sum==0 ? "-" : number_format($m_real_sum,2);
                                    $type1 = $m_type1_sum==0 ? "-" : number_format($m_type1_sum,2);
                                    echo "<td style='text-align:right' >".$expect."</td>";
                                    echo "<td style='text-align:right' >".$real."</td>";
                                    echo "<td style='text-align:right' >".$type1."</td>";
                                    $rm =($m_expect_sum - $m_type1_sum - $m_real_sum)==0 ? "-" : number_format($m_expect_sum - $m_type1_sum - $m_real_sum,2);
                                    echo "<td style='text-align:right' >".$rm."</td>";
                                }
                                else{
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                 
                                }    
                           echo "</tr>"; 


	                	 
	                	 
	                	}	

                		$index++;
                	  } 	
                                
                            
                                    
                                	
                	}//end project   
                	
                	//summary
        			 
                	echo "<tr>";
                	//summary
                                    echo "<td colspan=2 style='text-align:center'>รวม</td>";
                                    if($sum_pc_cost!=0)
                                     echo "<td style='text-align:right' >".number_format($sum_pc_cost,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";   
                                    if($sum_pc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sum_pc_receive,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                    if($sum_pc_cost-$sum_pc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sum_pc_cost-$sum_pc_receive,2)."</td>";
                                    else
                                      echo "<td style='text-align:right' >-</td>";    
                                    echo "<td></td>";
                                    if($sum_oc_cost!=0)
                                    echo "<td style='text-align:right' >".number_format($sum_oc_cost,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                    if($sum_oc_receive!=0)
                                    echo "<td style='text-align:right' >".number_format($sum_oc_receive,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                   
                                    if($sum_oc_cost-$sum_oc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sum_oc_cost-$sum_oc_receive,2)."</td>";
                                    else
                                      echo "<td style='text-align:right' >-</td>"; 
                                    $sum_expect = $sum_m_expect==0 ? "-": number_format($sum_m_expect,2);
                                    echo "<td style='text-align:right' >".$sum_expect."</td>";
                                    $sum_real = $sum_m_real==0 ? "-": number_format($sum_m_real,2);
                                    echo "<td style='text-align:right' >".$sum_real."</td>";
                                    $sum_type1 = $sum_m_type1==0 ? "-": number_format($sum_m_type1,2);
                                    echo "<td style='text-align:right' >".$sum_type1."</td>";
                                    $sum_rm = $sum_m_expect - $sum_m_real - $sum_m_type1==0 ? "-": number_format($sum_m_expect - $sum_m_real - $sum_m_type1,2);
                                    echo "<td style='text-align:right' >".$sum_rm."</td>";
                                   //summary all
                                $sumall_pc_cost += $sum_pc_cost;
                                $sumall_pc_receive += $sum_pc_receive;
                                         
                                $sumall_oc_cost += $sum_oc_cost;
                                $sumall_oc_receive += $sum_oc_receive;
                                       
                                $sumall_m_real += $sum_m_real;
                                $sumall_m_type1 += $sum_m_type1;
                                $sumall_m_expect += $sum_m_expect;

                	echo "</tr>";


                }
                //workcat	
                echo "<tr style='background-color:#FAB237'>";
                    //summary
                                    echo "<td colspan=2 style='text-align:center'>รวมทั้งหมด</td>";
                                    if($sumall_pc_cost!=0)
                                     echo "<td style='text-align:right' >".number_format($sumall_pc_cost,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";   
                                    if($sumall_pc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sumall_pc_receive,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                    if($sumall_pc_cost-$sumall_pc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sumall_pc_cost-$sumall_pc_receive,2)."</td>";
                                    else
                                      echo "<td style='text-align:right' >-</td>";    
                                    echo "<td></td>";
                                    if($sumall_oc_cost!=0)
                                    echo "<td style='text-align:right' >".number_format($sumall_oc_cost,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                    if($sumall_oc_receive!=0)
                                    echo "<td style='text-align:right' >".number_format($sumall_oc_receive,2)."</td>";
                                    else
                                     echo "<td style='text-align:right' >-</td>";  
                                   
                                    if($sumall_oc_cost-$sumall_oc_receive!=0)
                                     echo "<td style='text-align:right' >".number_format($sumall_oc_cost-$sumall_oc_receive,2)."</td>";
                                    else
                                      echo "<td style='text-align:right' >-</td>"; 
                                    $sum_expect = $sumall_m_expect==0 ? "-": number_format($sumall_m_expect,2);
                                    echo "<td style='text-align:right' >".$sum_expect."</td>";
                                    $sum_real = $sumall_m_real==0 ? "-": number_format($sumall_m_real,2);
                                    echo "<td style='text-align:right' >".$sum_real."</td>";
                                    $sum_type1 = $sumall_m_type1==0 ? "-": number_format($sumall_m_type1,2);
                                    echo "<td style='text-align:right' >".$sum_type1."</td>";
                                    $sum_rm = $sumall_m_expect - $sumall_m_real - $sumall_m_type1==0 ? "-": number_format($sumall_m_expect - $sumall_m_real - $sumall_m_type1,2);
                                    echo "<td style='text-align:right' >".$sum_rm."</td>";
                    echo "</tr>";

                ?>
            </tbody>
        </table>
