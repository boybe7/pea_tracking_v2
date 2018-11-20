<style type="text/css">
	hr {

		margin: 0px 0px; 
	}

	.header {
		font-weight: bold;
		font-size: 20px;
	}

</style>
<div class="alert alert-danger" role="alert"><h4>รายการแจ้งเตือน</h4></div>


<?php


$current_date = (date("Y")+543).date("-m-d");

//print_r("SELECT * FROM payment_project_contract WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
//DAY ),'".$current_date."')<7  AND (bill_date='' OR bill_date='0000-00-00')");

$user_dept = Yii::app()->user->userdept;

        
        // if(Yii::app()->user->isAdmin())
        // {
        //     $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7  AND (pc_garantee_end='')")->queryAll(); 

        //     $paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
        //          DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id   WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
        //         DAY ),'".$current_date."')<=7  AND (bill_date='' OR bill_date='0000-00-00')")->queryAll(); 

        //     $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
        //     DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10  AND (approve_date='' OR approve_date='0000-00-00')")->queryAll(); 

        //     if(date('d')>=20){

        //         $month = date("n");
        //         $number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

        //         $lastDay = $number."/".$month."/".(date("Y")+543);


        //         $projects = Project::model()->findAll();
        //         $mangementCostData1 = array();
        //         $mangementCostData2 = array();
        //         //echo count($projects);
        //         foreach ($projects as $key => $project) {
        //             $pid = $project->pj_id;
        //             $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid'";
                    
        //             $records = Yii::app()->db->createCommand($sql)->queryAll(); 
        //             if(count($records)==0)
        //             {
        //                 //$mProj = Project::model()->findbyPk($);
        //                 $mangement["project"] = $project->pj_name;
        //                 $mangement["contract"] = "";
        //                 $mangement["date_end"] = $lastDay;
        //                 $mangement["url"] = "managementCost/create";
        //                 $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่ารับรองประจำเดือน";
        //                 $mangementCostData1[] = $mangement;
        //             }

        //             $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid'";
                    
        //             $records = Yii::app()->db->createCommand($sql)->queryAll(); 
        //             if(count($records)==0)
        //             {
        //                 //$mProj = Project::model()->findbyPk($);
        //                 $mangement["project"] = $project->pj_name;
        //                 $mangement["contract"] = "";
        //                 $mangement["date_end"] = $lastDay;
        //                 $mangement["url"] = "managementCost/create";
        //                 $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าใช้จริงประจำเดือน";
        //                 $mangementCostData2[] = $mangement;
        //             }   
                    
        //         }
                          
                    

        //         $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2);
            
        //     }  
        //     else
        //        $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData);
            
        // }
        // else{
            // $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, CONCAT(pj_name,':',pj_work_cat) as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
            
            // $paymentProjectData=Yii::app()->db->createCommand("SELECT CONCAT(pj_name,':',pj_work_cat) as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
            // DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            // DAY ),'".$current_date."')<=7  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll(); 
    
            // $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,CONCAT(pj_name,':',pj_work_cat) as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            // DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->queryAll(); 


            // if(date('d')>=20){

            //     $month = date("n");
            //     $number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

            //     $lastDay = $number."/".$month."/".(date("Y")+543);

            //     $Criteria = new CDbCriteria();
            //     $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
            //     $Criteria->condition = 'user.department_id = ' . $user_dept;
            //     $projects = Project::model()->findAll($Criteria);
            //     $mangementCostData1 = array();
            //     $mangementCostData2 = array();
            //     //print_r($Criteria);
            //     foreach ($projects as $key => $project) {
            //         $pid = $project->pj_id;
            //         $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid' limit 1";
                    
            //         $records = Yii::app()->db->createCommand($sql)->queryAll(); 

            //         //echo(count($records));
            //         if(count($records)==0)
            //         {
            //             //$mProj = Project::model()->findbyPk($);
            //             $mangement["project"] = $project->pj_name.':'.$project->pj_work_cat;
            //             $mangement["contract"] = "";
            //             $mangement["date_end"] = $lastDay;
            //             $mangement["url"] = "managementCost/create";
            //             $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่ารับรองประจำเดือน";
            //             $mangementCostData1[] = $mangement;
            //         }

            //         $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid' limit 1";
                    
            //         $records = Yii::app()->db->createCommand($sql)->queryAll(); 
            //         if(count($records)==0)
            //         {
            //             //$mProj = Project::model()->findbyPk($);
            //             $mangement["project"] = $project->pj_name.':'.$project->pj_work_cat;
            //             $mangement["contract"] = "";
            //             $mangement["date_end"] = $lastDay;
            //             $mangement["url"] = "managementCost/create";
            //             $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าใช้จริงประจำเดือน";
            //             $mangementCostData2[] = $mangement;
            //         }   
                    
            //     }
                          
                    

            //     $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2);
            
            // }  
            // else
            //    $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData);
         
        //} end user
         
$process = Yii::app()->createController('Notify'); //create instance of controller
$records = $process[0]->gnotify(); //call function       
$projData = array();
foreach ($records as $key => $value) {

     $index = $value["project"];//array_search($value["pj_id"],$projData, true); 
     $projData[$index][] = $value;

}

// print_r($projData);

foreach ($projData as $key => $value) {
    $key_a = explode(":", $key);
    //echo $key_a[0];
    if(sizeof($key_a)>1)
    {
        $wc = WorkCategory::model()->findByPk($key_a[1]);
       echo "<div class='header'>".$wc->wc_name." : โครงการ ".$key_a[0] ."</div><hr>";
    }
    else{
       echo "<div class='header'>โครงการ ".$key_a[0] ."</div><hr>";   
    }
        
	foreach ($value as $key => $value2) {
       if($value2["contract"]=='')
        echo "ค่าบริหารโครงการ : <font color='red'>".$value2["alarm_detail"]."</font><br>";
       else 
		echo "สัญญา ".$value2["contract"]." : <font color='red'>".$value2["alarm_detail"]."</font><br>";
	}
	echo "<br>";
}



//echo count($records);
$provAll = new CArrayDataProvider($records,
    array(
    	'keyField'=>false,  //don't have 'id' column
        'sort' => array( //optional and sortring
            'attributes' => array(
                'project', 
                'contract',
                'date_end',
                'alarm_detail',
            ),
        ),
        'pagination' => array('pageSize' => 10) //optional add a pagination
    )
);


  ?>
