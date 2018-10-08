<?php
$this->breadcrumbs=array(
	'Progress Report ',
	
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
                <th rowspan="2">ลำดับ</th>
                <th rowspan="2">โครงการ</th>
                <th rowspan="2">รายละเอียดงาน</th>
                <th rowspan="2">เลขที่สัญญา</th>
                <th rowspan="2">วันที่ลงนามสัญญา</th>
                <th colspan="8">รายรับ</th>
                <th rowspan="2">ชื่อบริษัทจ้างช่วง</th>
                <th rowspan="2">รายละเอียดงาน</th>
                <th rowspan="2">เลขที่สัญญา</th>
                <th rowspan="2">วันที่ลงนามสัญญา</th>
                <th rowspan="2">วันที่ครบกำหนด</th>
                <th rowspan="2">วันที่รับรองงบ</th>
                <th colspan="7">วงเงินช่วง</th>
                <th colspan="3">ค่าบริหารโครงการ</th>
                <th rowspan="2">วงเงินที่คาดว่าจะได้รับ</th>
              </tr>
              <tr>
              	<th>วงเงินตามสัญญา</th>
                <th>รายการ</th>
                <th>ได้รับเงิน</th>
                <th>คงเหลือเรียกเก็บเงิน</th>
                <th>เลขที่ใบแจ้งหนี้</th>
                <th>เลขที่ใบเสร็จรับเงิน</th>
                <th>T%</th>
                <th>A%</th>

                <th>ตามสัญญา</th>
                <th>รายการ</th>
                <th>จ่ายเงิน</th>
                <th>อนุมัติจ่าย</th>
                <th>คงเหลือจ่ายเงิน</th>
                <th>T%</th>
                <th>B%</th>

				<th>ประมาณการ</th>
                <th>ค่ารับรอง</th>
                <th>ใช้จริง</th>

              </tr>  
            </thead>
            <tbody>
                <tr style="line-height: 0px">
                    <td style="padding-top:0px;padding-bottom:0px;"></td>
                    <!-- Project-->
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:60px;padding-right:60px;padding-top:0px;padding-bottom:0px;"></td>
					<!-- Project Contract-->                    
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;"></td>

					<!-- Outsource Contract-->
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:150px;padding-right:150px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:60px;padding-right:60px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:60px;padding-right:60px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;"></td>

                    <!-- Management Cost-->
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    <td style="padding-left:50px;padding-right:50px;padding-top:0px;padding-bottom:0px;"></td>
                    

                    <td style="padding-left:80px;padding-right:80px;padding-top:0px;padding-bottom:0px;"></td>
                    
                </tr>
                <?php
                //fiscalyear
                $fiscalyear = array();
                foreach ($model as $key => $value) {
                	if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                	   $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                

                }

                //print_r($model);

                asort($fiscalyear);
                foreach ($fiscalyear as $key => $value) {
                	$data = explode("/", $value);
                	$year = $data[0];
                	$cat = $data[1];

                	$mWorkCat = WorkCategory::model()->findByPk($cat);

                	//echo $mWorkCat->wc_name;
                	echo "<tr>";
                	for ($i=0; $i < 30; $i++) { 
                		if($i==1)
                			echo "<td style='background-color:#EBF8A4'>ปี ".$year." ".$mWorkCat->wc_name."</td>";
                		else
                		    echo "<td style='background-color:#EBF8A4'></td>";			
                	}
                	echo "</tr>";
                	
                	//echo $year.":".$cat;
                	$index = 1;
                	foreach ($model as $key => $pj) {
                	  if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                	  {	
                		
                	  	
                			//project contract
	                	 $Criteria = new CDbCriteria();
	                     $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	                	 $pcs = ProjectContract::model()->findAll($Criteria);
	                	 
	                	 $k = 0;
	                	 foreach ($pcs as $key => $pc) {
	                	  		# code...
	                	  		
	                		echo "<tr>";
	                		    if($k==0)
	                		    {
		                			echo "<td>".$index."</td>";
		                			echo "<td>".$pj->pj_name."<br>";
		                			//workcode
		                			$Criteria = new CDbCriteria();
		                            $Criteria->condition = "pj_id='$pj->pj_id'";
		                			$workcodes = WorkCode::model()->findAll($Criteria);
		                			foreach ($workcodes as $key => $wc) {
		                				echo $wc->code."<br>";
		                			}

		                			echo "</td>";
								}
								else{
									echo "<td></td><td></td>";
								}
								//print_r($pcs);
		                	  	echo "<td>".$pc->pc_details."<br><br>";
                                if(!empty($pc->pc_guarantee))
                                	echo "-หนังสือค้ำประกัน ".$pc->pc_guarantee."<br>";
                                if(!empty($pc->pc_garantee_end))
                                	echo "-เลขที่บันทึกส่งกองการเงิน ".$pc->pc_garantee_end."<br>";
                                if(!empty($pc->pc_PO))
                                {
                                    $pc->pc_PO = str_replace("PO", "", $pc->pc_PO);
                                    echo "-PO ".$pc->pc_PO."<br>";
                                }	
		                	  	echo "</td>";

                                echo "<td style='text-align:center'>".$pc->pc_code."</td>";
                                
                                echo "<td style='text-align:center'>".renderDate($pc->pc_sign_date)."<br><br>";
                                echo "<u>ครบกำหนด</u><br>";
                                echo renderDate($pc->pc_end_date);
                                echo "</td>";

                                echo "<td style='text-align:right'>".number_format($pc->pc_cost,2)."</td>";

                                //project payment
                                $Criteria = new CDbCriteria();
                                $Criteria->condition = "proj_id='$pc->pc_id'";
                                $paymentProjs = PaymentProjectContract::model()->findAll($Criteria);
                                echo "<td>";
                                foreach ($paymentProjs as $key => $pay) {
                                    echo $pay->detail."<br><br><br><br>";
                                }
                                echo "</td>";
                                echo "<td style='text-align:right'>";
                                foreach ($paymentProjs as $key => $pay) {
                                    echo $pay->money."<br><br><br><br>";
                                }
                                echo "</td>";

                                echo "</td>";
                                echo "<td style='text-align:right'>";
                                foreach ($paymentProjs as $key => $pay) {
                                    $pay->money = str_replace(",", "", $pay->money);
                                    echo number_format($pc->pc_cost - $pay->money,2)."<br><br><br><br>";
                                }
                                echo "</td>";

                                echo "</td>";
                                echo "<td >";
                                foreach ($paymentProjs as $key => $pay) {
                                   
                                    echo $pay->invoice_no." ".renderDate($pay->invoice_date)."<br><br><br><br>";
                                }
                                echo "</td>";

		                	  	//$pcs = array_shift($pcs);
	                			

	                		echo "</tr>";

	                		$k++;
	                	}	

                		$index++;
                	  } 	
                	}

                }
                //workcat	


                ?>
            </tbody>
        </table>
