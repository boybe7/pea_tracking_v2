<?php

class NotifyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','update','view','getNotify','gnotify','content','CloseSelected','DisableNotify'),
				'users'=>array('*'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public static function gnotify($type=0)
	{
		$current_date = (date("Y")).date("-m-d");
		$user_dept = Yii::app()->user->userdept;

		//set flag_del = 1
		Yii::app()->db->createCommand("UPDATE notify SET flag_del=1")->execute(); 

		//---------seek notify-----------//
		ini_set('max_execution_time', 300);
	
		//1.แจ้งเตือนครบกำหนดค้ำประกันสัญญา
		//Alert before 7 days, until 90 days
        $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญาหลัก' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7 AND DATEDIFF(pc_garantee_date,'".$current_date."')>-90  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 

        // $projectContractData2 =Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,oc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญาจ้างช่วง' as alarm_detail,oc_guarantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, oc_id as update_id FROM outsource_contract oc LEFT JOIN project p ON oc.oc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(oc_guarantee_date,'".$current_date."')<=7 AND DATEDIFF(oc_guarantee_date,'".$current_date."')>-90  AND (oc_guarantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 

        $projectContractData2 =Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,oc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญาจ้างช่วง' as alarm_detail, guarantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, oc_id as update_id FROM guarantee g LEFT JOIN outsource_contract oc ON g.contract_id=oc.oc_id LEFT JOIN project p ON oc.oc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(guarantee_date,'".$current_date."')<=7 AND DATEDIFF(guarantee_date,'".$current_date."')>-90  AND (letter_return='') AND pj_id IS NOT NULL  AND user.department_id='$user_dept'")->queryAll(); 

        //echo "SELECT pj_id, pj_name as project,oc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญาจ้างช่วง' as alarm_detail, guarantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, oc_id as update_id FROM guarantee g LEFT JOIN outsource_contract oc ON g.contract_id=oc.oc_id LEFT JOIN project p ON oc.oc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(guarantee_date,'".$current_date."')<=7 AND DATEDIFF(guarantee_date,'".$current_date."')>-90  AND (letter_return='') AND pj_id IS NOT NULL  AND user.department_id='$user_dept'";

        //2.แจ้งเตือนครบกำหนดชำระเงินของ vendor
        //Alert before 7 days, until 90 days
        $paymentProjectData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของลูกค้า ครั้งที่ 1' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url,'2' as type,pj_id as update_id  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')<=7  AND DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')>-90 AND (invoice_alarm2 IS NULL  OR DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm2
            DAY ),'".$current_date."')>7)  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll();

        $paymentProjectData2=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของลูกค้า ครั้งที่ 2' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm2
            DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url,'2' as type,pj_id as update_id  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm2
            DAY ),'".$current_date."')<=7  AND DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm2
            DAY ),'".$current_date."')>-90  AND (bill_date='' OR bill_date='0000-00-00') AND invoice_alarm2!='' AND user.department_id='$user_dept'")->queryAll();      

	    // echo "SELECT pj_id,pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor ครั้งที่ 2' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm2
     //        DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url,'2' as type,pj_id as update_id  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm2
     //        DAY ),'".$current_date."')<=7  AND DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm2
     //        DAY ),'".$current_date."')>-90  AND (bill_date='' OR bill_date='0000-00-00') AND invoice_alarm2!='' AND user.department_id='$user_dept'";         	

        //3.แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier
        //Alert before 10 days, until 90 days
        $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ผู้รับจ้าง/ผู้ขาย ' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10 AND  DATEDIFF('".$current_date."',invoice_receive_date)<90  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->queryAll(); 

        //4.แจ้งเตือนบันทึกค่ารับรองประจำเดือน
        $mangementCostData1 = array();
        $mangementCostData2 = array();
        $fiscal_year  = date("n") < 10 ? date("Y")+543 : date("Y")+543 +1;
        if(date('d')>=20){

                $month = date("n");
                $number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

                $lastDay = $number."/".$month."/".(date("Y"));

                $Criteria = new CDbCriteria();
                $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
                $Criteria->condition = 'user.department_id = ' . $user_dept.' AND ('.$fiscal_year.' - pj_fiscalyear)<2';
                $Criteria->order = 'pj_fiscalyear ASC';
                $projects = Project::model()->findAll($Criteria);
                
                //print_r($Criteria);
                foreach ($projects as $key => $project) {
                    $pid = $project->pj_id;
                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 

                    //echo(count($records));
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement = array();
                        $mangement["pj_id"] = $pid;
                        $mangement["type"] = 4;
                        $mangement["project"] = $project->pj_name;//.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["update_id"] = $pid;
                        $mangement["url"] = "managementCost/create/".$pid;
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่ารับรองประจำเดือน";
                        $mangementCostData1[] = $mangement;
                    }

                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement = array();
                        $mangement["pj_id"] = $pid;
                        $mangement["type"] = 4;
                        $mangement["project"] = $project->pj_name;//.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["update_id"] = $pid;
                        $mangement["url"] = "managementCost/create/".$pid;
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าใช้จริงประจำเดือน";
                        $mangementCostData2[] = $mangement;

                        
                    }   
                    
                }
                          
                    
            }  


        //5.alert close project
        $Criteria = new CDbCriteria();
            $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
            $Criteria->condition = 'user.department_id = ' . $user_dept.' AND pj_status=1 AND ('.$fiscal_year.' - pj_fiscalyear)<2';
            $projects = Project::model()->findAll($Criteria);
            $closeProjectData = array();
            foreach ($projects as $key => $project) {
            	//---pro_cost--//
				$pj_id = $project->pj_id;
				
				$pj_name = $project->pj_name;

				$sql = "SELECT sum(pc_cost) as sum_total,pc_code FROM project_contract WHERE pc_proj_id='$pj_id'";                  
                $records = Yii::app()->db->createCommand($sql)->queryAll();
                $pc_cost = empty($records) ? 1 : $records[0]['sum_total'];
                $pc_code = empty($records) ? "" : $records[0]['pc_code'];

                $sql = "SELECT sum(money) as sum_total FROM payment_project_contract p LEFT JOIN project_contract o ON p.proj_id=o.pc_id WHERE o.pc_proj_id = '$pj_id'";// AND bill_no !=''  ";                  
	            $records2 = Yii::app()->db->createCommand($sql)->queryAll();
	            $pay_pc = empty($records2) ? 0 : $records2[0]['sum_total'];
              
               

                //---outsource payment------//
                $sql = "SELECT sum(oc_cost) as sum_total FROM outsource_contract WHERE oc_proj_id = '$pj_id' ";                  
	            $records2 = Yii::app()->db->createCommand($sql)->queryAll();
	            $oc_cost = empty($records2) ? 1 : $records2[0]['sum_total'];
	            
				$sql = "SELECT sum(money) as sum_total FROM payment_outsource_contract p LEFT JOIN outsource_contract o ON p.contract_id=o.oc_id WHERE o.oc_proj_id = '$pj_id'";// AND approve_date !=''  ";                  
	            $records2 = Yii::app()->db->createCommand($sql)->queryAll();
	            $pay_oc = empty($records2) ? 0 : $records2[0]['sum_total'];

	            // if($pj_id==267)
	            // {
	            // 	echo $pay_pc.":".$pc_cost."<br>";
	            // 	echo $pay_oc.":".$oc_cost."<br>";
	            // }
	            //------check-------------//
	            if(($pc_cost-$pay_pc==0) && ($oc_cost-$pay_oc==0) )
				{
							
							//Yii::app()->db->createCommand("INSERT INTO  notify (pj_id,project,contract,alarm_detail,date_end,url,type,update_id) VALUES ($pj_id,'$pj_name','$pc_code','แจ้งเตือนดำเนินการปิดงาน','','',5,'')")->execute();
							$mangement = array();
                            $mangement["pj_id"] = $pj_id;
							$mangement["project"] = $pj_name;//.':'.$project->pj_work_cat;
	                        $mangement["contract"] = $pc_code;
	                        $mangement["date_end"] = "";
	                        $mangement["type"] = 5;
	                        $mangement["update_id"] = "";
	                        $mangement["url"] = "project/update/".$pj_id;
	                        $mangement["alarm_detail"] =  "แจ้งเตือนดำเนินการปิดงาน";
	                        $closeProjectData[] = $mangement;

				}
	            
            }

         //6.เตือนของบ .1000
;

         $sql = "SELECT pj_id,pj_name as project, oc_code as contract,'' as date_end, CONCAT('project/update/',pj_id) as url,oc_id as update_id, '6' as type, 'แจ้งเตือนของบ .1000' as alarm_detail  FROM outsource_contract  LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON pj_user_create=user.u_id WHERE notify_1000=1 AND (notify_1000_close IS NULL OR notify_1000_close='') AND user.department_id = '$user_dept' AND pj_status=1 AND (".$fiscal_year."-pj_fiscalyear)<2";                  
	     $notify1000Data = Yii::app()->db->createCommand($sql)->queryAll();
         
        

        //merge all notify data   
        $records=array_merge($projectContractData,$projectContractData2 , $paymentProjectData,$paymentProjectData2,$closeProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2,$notify1000Data); 

        //echo sizeof($closeProjectData);


        //get data from notify table
        $notify_records = Notify::model()->findAll();   

        //check have already notify
        foreach ($records as $key => $value) {
        	$found = 0;
        	//echo $value['date_end']."<br>";
        	foreach ($notify_records as $key => $notify) {
        		if($value['pj_id']==$notify->pj_id && $value['type']==$notify->type )
        		{
        			$found = 1;

        			if(($value['date_end']) > ($notify->date_end))
        			{
        				$notify->date_end = $value['date_end'];
        				$notify->alarm_detail = $value['alarm_detail'];
        				
        			}

        			//set flag_del = 0
        			$notify->flag_del = 0;
        			$notify->url = $value['url'];
        			//update
        			$notify->save();

        			//echo "update";
        			break;
        		}
        	}

        	//insert new notify
        	if(!$found)
        	{
        		$new_rec = new Notify();
        		$new_rec->project = $value['project'];
        		$new_rec->contract = $value['contract'];
        		$new_rec->url = $value['url'];
                if(isset($value['type']))
        		   $new_rec->type = $value['type'];
        		else
        			echo $value['alarm_detail'];
        		$new_rec->pj_id = $value['pj_id'];
        		$new_rec->update_id = $value['update_id'];
        		$new_rec->alarm_detail = $value['alarm_detail'];
        		$new_rec->date_end = $value['date_end'];
        		$new_rec->update_date = (date("Y")).date("-m-d H:i:s");
        		$new_rec->status = 1;
        		$new_rec->flag_del = 0;

        		$new_rec->save();
        	}

        }


        //delete data not notify
        Yii::app()->db->createCommand("DELETE FROM notify WHERE flag_del=1")->execute(); 


		if($type==0)
        {        
        	//return $records;
        	//$sql = "SELECT *  FROM notify  ORDER BY id DESC,pj_id ASC  LIMIT 100";

        	$sql = "SELECT count(id) as amount,type  FROM notify  GROUP BY type ORDER BY type ASC";                  
	        $notifyData = Yii::app()->db->createCommand($sql)->queryAll();
	        return $notifyData;
        }    
        else
        {	
            	if (Yii::app()->request->isAjaxRequest)
			    {    
			    	//echo CJSON::encode(1);
			    	echo CJSON::encode(count($records));
			    }
			    else{
			    	return count($records);
			    }
		}    
		
	}	

	public static function gnotify3($type=0)
	{
		$current_date = (date("Y")).date("-m-d");

		//delete old data
		Yii::app()->db->createCommand("TRUNCATE TABLE notify")->execute(); 


		$user_dept = Yii::app()->user->userdept;

            //Alert before 7 days, until 60 days
        $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7 AND DATEDIFF(pc_garantee_date,'".$current_date."')>-60  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
        
        //insert to notify table
        if(!empty($projectContractData))
        	Yii::app()->db->createCommand("INSERT INTO notify SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7 AND DATEDIFF(pc_garantee_date,'".$current_date."')>-60  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
        

            //Alert before 7 days, until 60 days
            $paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของลูกค้า' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')<=7  AND DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')>-60  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll(); 

            //Alert before 10 days, until 60 days
            $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ ผู้รับจ้าง/ผู้ขาย' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10 AND  DATEDIFF('".$current_date."',invoice_receive_date)<60  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->queryAll(); 

            if(!empty($paymentOutsourceData))
            {

            	Yii::app()->db->createCommand("INSERT INTO  notify (pj_id,project,contract,alarm_detail,date_end,url,type,update_id) SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ผู้รับจ้าง/ผู้ขาย' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10 AND  DATEDIFF('".$current_date."',invoice_receive_date)<60  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->execute(); 
            }


            //alert close project
            $Criteria = new CDbCriteria();
            $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
            $Criteria->condition = 'user.department_id = ' . $user_dept.' AND pj_status=1';
            $projects = Project::model()->findAll($Criteria);
            $closeProjectData = array();
            foreach ($projects as $key => $project) {
            	//---pro_cost--//
				$pj_id = $project->pj_id;
				$pj_name = $project->pj_name;

				$sql = "SELECT pc_cost,pc_id,pc_code FROM project_contract WHERE pc_proj_id='$pj_id' limit 1";                  
                $records = Yii::app()->db->createCommand($sql)->queryAll();

              
                if(!count($records)==0)
                {
                	$pc_cost = $records[0]['pc_cost'];
                	$pc_id = $records[0]['pc_id'];
                	$pc_code = $records[0]['pc_code'];

                	$sql = "SELECT sum(money) as sum_total FROM payment_project_contract WHERE proj_id = '$pc_id' AND bill_no !='' ";                  
                	$records2 = Yii::app()->db->createCommand($sql)->queryAll();
                	if(!count($records2)==0)
                	{
                          $pay_pc = $records2[0]['sum_total']; 
                	}
				
					$sql = "SELECT oc_cost,oc_id FROM outsource_contract WHERE oc_proj_id='$pj_id' limit 1";                  
	                $records = Yii::app()->db->createCommand($sql)->queryAll();

	             
	                if(!count($records)==0)
	                {
	                	$oc_cost = $records[0]['oc_cost'];
	                	$oc_id = $records[0]['oc_id'];
	                	//---pay_pc--//
				
	                	$sql = "SELECT sum(money) as sum_total FROM payment_outsource_contract WHERE contract_id = '$oc_id' AND approve_date !='' ";                  
	                	$records2 = Yii::app()->db->createCommand($sql)->queryAll();
	                	if(!count($records2)==0)
	                	{
	                          $pay_oc = $records2[0]['sum_total']; 
	                	}
						
						if(($pc_cost-$pay_pc==0) && ($oc_cost-$pay_oc==0) )
						{
							
							Yii::app()->db->createCommand("INSERT INTO  notify (pj_id,project,contract,alarm_detail,date_end,url,type,update_id) VALUES ($pj_id,'$pj_name','$pc_code','แจ้งเตือนดำเนินการปิดงาน','','',5,$pj_id)")->execute();

							$mangement["project"] = $pj_name;//.':'.$project->pj_work_cat;
	                        $mangement["contract"] = $pc_code;
	                        $mangement["date_end"] = "";
	                        $mangement["url"] = "";
	                        $mangement["alarm_detail"] =  "แจ้งเตือนดำเนินการปิดงาน";
	                        $closeProjectData[] = $mangement;

						}
	                }

				
                }
				

				
            }


            //---end close project----//

            //alert .1000
            $Criteria = new CDbCriteria();
            $Criteria->join = 'LEFT JOIN project ON pc_proj_id=project.pj_id'; 
            $Criteria->condition = 'notify_1000=1';
            $projects = ProjectContract::model()->findAll($Criteria);




            //--end .10000----//

            if(date('d')>=20){

                $month = date("n");
                $number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

                $lastDay = $number."/".$month."/".(date("Y")+543);

                $Criteria = new CDbCriteria();
                $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
                $Criteria->condition = 'user.department_id = ' . $user_dept;
                $projects = Project::model()->findAll($Criteria);
                $mangementCostData1 = array();
                $mangementCostData2 = array();
                //print_r($Criteria);
                foreach ($projects as $key => $project) {
                    $pid = $project->pj_id;
                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 

                    //echo(count($records));
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement["project"] = $project->pj_name.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["url"] = "managementCost/create";
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่ารับรองประจำเดือน";
                        $mangementCostData1[] = $mangement;
                    }

                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement["project"] = $project->pj_name;//.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["url"] = "managementCost/create";
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าใช้จริงประจำเดือน";
                        $mangementCostData2[] = $mangement;
                    }   
                    
                }
                          
                    

                $records=array_merge($projectContractData , $paymentProjectData,$closeProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2);
            
            }  
            else
               $records=array_merge($projectContractData , $paymentProjectData, $closeProjectData,$paymentOutsourceData);

            if($type==0)
                return $records;
            else
            {	
            	if (Yii::app()->request->isAjaxRequest)
			    {    
			    	//echo CJSON::encode(1);
			    	echo CJSON::encode(count($records));
			    }
			    else{
			    	return count($records);
			    }
			}    
	}




	
	
	public function actionIndex()
	{


		$model=new Notify("search");
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notify']))
			$model->attributes=$_GET['Notify'];

		if (Yii::app()->request->isAjaxRequest)
		{
			
			  
			  if(isset($_GET['project']) && $_GET['project']!="" ) 
			  	$model->project =   $_GET['project'] ;
			  if(isset($_GET['contract']) && $_GET['contract']!="" ) 
			  	$model->contract =   $_GET['contract'] ;
			  if(isset($_GET['alarm_detail']) && $_GET['alarm_detail']!="" ) 
			  	$model->alarm_detail =   $_GET['alarm_detail'] ;
			 
			  if(isset($_GET["date_start"]) && isset($_GET["date_end"]) && $_GET["date_start"]!="" && $_GET["date_end"]!="")
			  {
			  	$model->date_end = $_GET["date_start"]."..".$_GET["date_end"];
			  }

			  if($_GET['ajax']=="notify-grid-garantee")
			  	   $model->type = 1;
			  if($_GET['ajax']=="notify-grid-vendor")
			  	   $model->type = 2;
			  if($_GET['ajax']=="notify-grid-supplier")
			  	   $model->type = 3;
			  if($_GET['ajax']=="notify-grid-manage")
			  	   $model->type = 4;
			  if($_GET['ajax']=="notify-grid-close")
			  	   $model->type = 5;
			  if($_GET['ajax']=="notify-grid-1000")
			  	   $model->type = 6;		   	   	   	   	

			// header('Content-type: text/plain');
			// echo "controller";
	    	// print_r($model);
	    	// exit;
		}
		else{
			$this->gnotify();
		}

			

		$this->render('index',array(
			'model'=>$model//,'records'=>$this->gnotify()
		));
	}

	public function actionContent()
	{
		
		
		$this->render('_content',array(
			
		));
	}

	 protected function gridDateRender($data,$row)
     {
 

         $date = '';
         $str_date = explode("-", $data["date_end"]);
         if(count($str_date)>1)
            $date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);

         return $date;    
    }       

     protected function gridProjectRender($data,$row)
     {
 		$model =Yii::app()->db->createCommand("SELECT * FROM project LEFT JOIN work_category ON pj_work_cat=wc_id  WHERE pj_id=".$data['pj_id'])->queryAll(); 
         return $model[0]['pj_fiscalyear']." : ".$model[0]['wc_name']." ".$data['project'];    
    } 

	
	public function actionGetNotify()
	{
		$current_date = (date("Y")+543).date("-m-d");

		//print_r("SELECT * FROM payment_project_contract WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
		//DAY ),'".$current_date."')<7  AND (bill_date='' OR bill_date='0000-00-00')");
		$projectContractData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pc_id) as url FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7  AND (pc_garantee_end='')")->queryAll(); 

		$user_dept = Yii::app()->user->userdept;
		$paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
		DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
		DAY ),'".$current_date."')<=7  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll(); 

		if(Yii::app()->user->isAdmin())
		{
			$paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
		DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
		DAY ),'".$current_date."')<=7  AND (bill_date='' OR bill_date='0000-00-00')")->queryAll(); 

		}

		$paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
		DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10  AND (approve_date='' OR approve_date='0000-00-00')")->queryAll(); 

		
		
        if(date('d')>=20){

        	$month = date("n");
        	$number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

        	$lastDay = $number."/".$month."/".(date("Y")+543);


        	$projects = Project::model()->findAll();
        	$mangementCostData1 = array();
        	$mangementCostData2 = array();

        	foreach ($projects as $key => $project) {
        		$pid = $project->pj_id;
        		$sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid'";
	            
	        	$records = Yii::app()->db->createCommand($sql)->queryAll(); 
	        	if(count($records)==0)
	        	{
	        		//$mProj = Project::model()->findbyPk($);
	        		$mangement["project"] = $project->pj_name;
	        		$mangement["contract"] = "";
	        		$mangement["date_end"] = $lastDay;
	        		$mangement["url"] = "managementCost/create";
	        		$mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าบริหารโครงการ ส่วนค่ารับรองประจำเดือน";
	        		$mangementCostData1[] = $mangement;
	        	}

	        	$sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid'";
	            
	        	$records = Yii::app()->db->createCommand($sql)->queryAll(); 
	        	if(count($records)==0)
	        	{
	        		//$mProj = Project::model()->findbyPk($);
	        		$mangement["project"] = $project->pj_name;
	        		$mangement["contract"] = "";
	        		$mangement["date_end"] = $lastDay;
	        		$mangement["url"] = "managementCost/create";
	        		$mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าบริหารโครงการ ส่วนค่าใช้จริงประจำเดือน";
	        		$mangementCostData2[] = $mangement;
	        	}	
	            
        	}
	        	      
	        	

        	$records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2);
		
        }  
        else
		   $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData);
		
		 //header('Content-type: text/plain');
		 //                         		 print_r($records);                    
		 //                         	     exit;	

		if (Yii::app()->request->isAjaxRequest)
	    {    
	    	//echo CJSON::encode(1);
	    	echo CJSON::encode(count($records));
	    }
	    else{
	    	return count($records);
	    }

	}

	public function loadModel($id)
	{
		$model=Notify::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionCloseSelected()
    {
    	$autoIdAll = $_POST['selectedID'];
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $pjModel = Project::model()->findbyPk($this->loadModel($autoId)->pj_id);
                $pjModel->pj_status = 0;
                $pjModel->save();
            }
        }    
    }

    public function actionDisableNotify()
    {
    	$autoIdAll = $_POST['selectedID'];
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $pjModel = ProjectContract::model()->findbyPk($this->loadModel($autoId)->update_id);
                $pjModel->notify_1000 = 0;
                $pjModel->save();
            }
        }    
    }


}
