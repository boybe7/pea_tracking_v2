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
				'actions'=>array('index','update','view','getNotify','gnotify','content','CloseSelected'),
				'users'=>array('*'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public static function gnotify($type=0)
	{
		$current_date = (date("Y")+543).date("-m-d");

		//delete old data
		Yii::app()->db->createCommand("TRUNCATE TABLE notify")->execute(); 


		$user_dept = Yii::app()->user->userdept;

            //Alert before 7 days, until 60 days
        $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7 AND DATEDIFF(pc_garantee_date,'".$current_date."')>-60  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
        
        //insert to notify table
        if(!empty($projectContractData))
        	Yii::app()->db->createCommand("INSERT INTO notify SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7 AND DATEDIFF(pc_garantee_date,'".$current_date."')>-60  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
        

            //Alert before 7 days, until 60 days
            $paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')<=7  AND DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')>-60  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll(); 

            //Alert before 10 days, until 60 days
            $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10 AND  DATEDIFF('".$current_date."',invoice_receive_date)<60  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->queryAll(); 

            if(!empty($paymentOutsourceData))
            {

            	Yii::app()->db->createCommand("INSERT INTO  notify (pj_id,project,contract,alarm_detail,date_end,url,type,update_id) SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
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
            $Criteria->condition = '1000_notify=1';
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


}
