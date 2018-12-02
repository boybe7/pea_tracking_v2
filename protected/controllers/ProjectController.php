<?php

class ProjectController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','getProject','getMProject','createOutsource','update','loadOutsourceByAjax','loadContractByAjax','loadContractByAjaxTemp','loadOutsourceByAjaxTemp','DeleteSelected','closeSelected'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression'=>'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionGetProject(){
            $request=trim($_GET['term']);
                    
            //$models=Project::model()->findAll(array("condition"=>"pj_name like '$request%' AND pj_status=1"));
            $Criteria = new CDbCriteria();
			$user_dept = Yii::app()->user->userdept;
			$Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id';
			$Criteria->condition = "pj_name like '$request%' AND pj_status=1 AND department_id='$user_dept'";
			$models = Project::model()->findAll($Criteria);
            $data=array();
            foreach($models as $model){
                
               	$workcat = WorkCategory::model()->FindByPk($model->pj_work_cat);


               	$sql = "SELECT SUM(pc_cost) as sum FROM Project_Contract WHERE pc_proj_id='$model->pj_id'";
          		$command = Yii::app()->db->createCommand($sql);
          		$result = $command->queryAll();

          		$cost_total = 0;
          		if(count($result))
                    $cost_total = $result[0]["sum"]; 

                $data[] = array(
                        'id'=>$model['pj_id'],
                        'label'=>$workcat->wc_name." ปี ".$model->pj_fiscalyear.":".$model['pj_name'],//." ".$modelVendor->v_name,
                        'cost'=>number_format($cost_total,2)
                );

            }
            $this->layout='empty';
            echo json_encode($data);
        
    }

    public function actionGetMProject(){
            $request=trim($_GET['term']);

            

           // header('Content-type: text/plain');
           //                    print_r($search_str);                    
            //               	  exit;
                    
            //$models=Project::model()->findAll(array("condition"=>"pj_name like '%$request%' AND pj_status=1"));
            $Criteria = new CDbCriteria();
			$user_dept = Yii::app()->user->userdept;
			$Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id';

			//search by fiscal_year and pj_name
            $search_str = preg_split('/\s+/', $request, -1, PREG_SPLIT_NO_EMPTY);
            if(sizeof($search_str)==2)
			{
				$Criteria->condition = "(pj_fiscalyear LIKE '%$search_str[0]%' OR pj_name LIKE '%$search_str[0]%') AND (pj_fiscalyear LIKE '%$search_str[1]%' OR pj_name LIKE '%$search_str[1]%') AND pj_status=1 AND department_id='$user_dept'";
			}
			else
				$Criteria->condition = "(pj_name like '%$request%' OR pj_fiscalyear LIKE '%$request%') AND pj_status=1 AND department_id='$user_dept'";

			$Criteria->order = "pj_fiscalyear desc";
			
			$models = Project::model()->findAll($Criteria);

            $data=array();
            foreach($models as $model){
                
               	$workcat = WorkCategory::model()->FindByPk($model->pj_work_cat);


               	$sql = "SELECT SUM(mc_cost) as sum FROM management_cost WHERE mc_proj_id='$model->pj_id' AND mc_type=0";
          		$command = Yii::app()->db->createCommand($sql);
          		$result = $command->queryAll();

          		$cost_total = 0;
          		if(count($result))
                    $cost_total = $result[0]["sum"]; 

                $result = Yii::app()->db->createCommand()
                        ->select('SUM(mc_cost) as sum')
                        ->from('management_cost')
                        ->where('mc_proj_id=:id AND mc_type!=0', array(':id'=>$model->pj_id))
                        ->queryAll();
                $pay_total = 0;
          		if(count($result))
                    $pay_total = $result[0]["sum"];         

                $remain = $cost_total - $pay_total;
                //$remain = 22;
                $data[] = array(
                        'id'=>$model['pj_id'],
                        'label'=>$workcat->wc_name." ปี ".$model->pj_fiscalyear.":".$model['pj_name'],//." ".$modelVendor->v_name,
                        'cost'=>number_format($cost_total,2),
                        'pay'=>number_format($pay_total,2),
                        'remain'=>number_format($remain,2),
                );

            }
            $this->layout='empty';
            echo json_encode($data);
        
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreateOutsource($id)
	{
		$modelOutsource = array();
		$modelContract = array();
		$modelContractOld = array();
		$model = new OutsourceContract;
		//$modelOutsource = new OutsourceContract;
		$numContracts = 1;
		array_push($modelOutsource, $model);
		//array_push($modelOutsource, new OutsourceContract);
		//array_push($modelOutsource, new OutsourceContract);
		//$modelOutsource = $this->getContracts();

		if(isset($_POST['OutsourceContract']))
		{
			$modelOutsources = array();
			$modelOutsource = array();
      //       $numContracts = $_POST['num'];
		    // for($i=1;$i<$numContracts+1;$i++)
		    // {
		    //     //if(isset($_POST['OutsourceContract'][$i]))
		    //     //{
		    //         $contracts = new OutsourceContract;
		    //         $contracts->attributes = $_POST['OutsourceContract'][$i];
		    //         //$contracts->oc_cost = Yii::app()->format->unformatNumber($_POST['OutsourceContract'][$i]['oc_cost']);
		    //         $contracts->oc_proj_id = $id;
		    //         $contracts->oc_sign_date = $_POST['OutsourceContract'][$i]["oc_sign_date"];//$_POST[$i."_oc_end_date"];
		    //         $contracts->oc_end_date = $_POST['OutsourceContract'][$i]["oc_end_date"];
		    //         $contracts->oc_approve_date = $_POST['OutsourceContract'][$i]["oc_approve_date"];
		    //         array_push($modelOutsource, $contracts);
		    //         //$contracts->validate();
		    //         $contracts->save();
		    //     //}
		    // }

		    $modelOutsources = $_POST['OutsourceContract'];
		    $transaction=Yii::app()->db->beginTransaction();
		    try {
			            
		    			$index = 1;
		    			$saveOK = 1;
			            foreach ($modelOutsources as $c => $outsource) 
		 				{
		 				     //print_r($contract);
		 					
		 					 
		 				     $modelC = new OutsourceContract("search");
		 				     $modelC->attributes = $outsource;
		 				     $modelC->oc_sign_date = $outsource["oc_sign_date"];
		 				     $modelC->oc_approve_date = $outsource["oc_approve_date"];
		 				     $modelC->oc_insurance_start = $outsource["oc_insurance_start"];
		 				     $modelC->oc_insurance_end = $outsource["oc_insurance_end"];
		 				    
		 				     //$modelC->pc_id = "";
		 				     $modelC->oc_proj_id = $id;

		 				     $modelC->oc_last_update = (date("Y")+543).date("-m-d H:i:s");
				    		 $modelC->oc_user_update = Yii::app()->user->ID;
				    		 $modelC->oc_user_create = Yii::app()->user->ID;
				    		  
				    		  //header('Content-type: text/plain');
                              // print_r($modelC);                    
                           	  //exit;
				    		 //array_push($modelOutsource, $modelC); 


		 				    
		 				     if($modelC->save())
		 				     {
		 				     	
		 				     	$modelTemps = Yii::app()->db->createCommand()
						                    ->select('*')
						                    ->from('contract_change_history_temp')
						                    ->where('contract_id=:id AND type=2 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
						                    ->queryAll();
						        foreach ($modelTemps as $key => $mTemp) {

						        // header('Content-type: text/plain');
              //             		print_r($modelC);                    
              //             	    exit;
                                        $modelApprove = new ContractChangeHistory("search");
                                        $modelApprove->attributes = $mTemp;
                                        
                                        $modelApprove->id = "";
                                        $modelApprove->contract_id = $modelC->oc_id;
                                        $modelApprove->type = 2;
                                        
                                        if($modelApprove->save())
                                           $msg =  "successful";
                                        else{
                                           $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				            	   $saveOK = 0;
                                        }   	
						        }
								
								//save contract PO
								 	        		 $modelTemps = Yii::app()->db->createCommand()
											                    ->select('*')
											                    ->from('work_code_outsource_temp')
											                    ->where('contract_id=:id AND  u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
											                    ->queryAll();
											        foreach ($modelTemps as $key => $mTemp) {

					                                        $modelChange = new WorkCodeOutsource("search");
					                                        $modelChange->attributes = $mTemp;
					                                        $modelChange->id = '';
					                                        $modelChange->contract_id = $modelC->oc_id;
					                                        
					                                        
					                                        if($modelChange->save())
					                                        {
					                                            $msg =  "successful";
					                                            $mt = WorkCodeOutsourceTemp::model()->findByPk($mTemp['id']);
					                                            $mt->delete();
					                                        }	                                          
					                                        else{
					                                           $modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
							 				            	   $saveOK = 0;

					                                        }   	
											        }         


		 				     	//$saveOK = true;
		 				     	$modelTemps = Yii::app()->db->createCommand()
						                    ->select('*')
						                    ->from('contract_approve_history_temp')
						                    ->where('contract_id=:id AND type=2 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
						                    ->queryAll();
						        foreach ($modelTemps as $key => $mTemp) {

						        // header('Content-type: text/plain');
              //             		print_r($modelC);                    
              //             	    exit;
                                        $modelApprove = new ContractApproveHistory("search");
                                        $modelApprove->attributes = $mTemp;
                                        $modelApprove->dateApprove = $mTemp['dateApprove'];
                                        $modelApprove->id = "";
                                        $modelApprove->contract_id = $modelC->oc_id;
                                        $modelApprove->type = 2;
                                        
                                        if($modelApprove->save())
                                           $msg =  "successful";
                                        else{
                                           $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				            	   $saveOK = 0;
                                        }   	
						        }            
		 				     	//$modelTemp = ContractApproveHistoryTemp::model()->findByAttributes(array('contract_id'=>$contract['pc_id']));
		 				     	
		 				     }else{
		 				     	$saveOK = 0;	
		 				     	$model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ '.$index.'" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 						
		 				     	// if($contract["pc_id"]!="")
		 				     	//   $modelC->pc_id = $contract["pc_id"];
		 				     	// else
		 				     	//   $modelC->pc_id = 1;	
		 				     }

		 				     $index++;

		 				      array_push($modelOutsource, $modelC); 
		 				    	
		 				}
		 				 
		 				$numContracts = $index-1;  

		 				if($saveOK==1)
		 				{
		 					$transaction->commit();
		 					$this->redirect(array('index'));	

		 					//$this->redirect(array('createOutsource', 'id' => $model->pj_id));
		 					// header('Content-type: text/plain');
        //                 		//print_r($modelC);
        //                 		echo "save".$saveOK;
        //                 	exit;
		 				}   	
		 				else
		 				{
		 					$transaction->rollBack();
		 					//$modelOutsource = $modelContractOld;
		 				    //$model->addError('contract', 'กรุณากรอกข้อมูล "สัญญา" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				}

			}
			catch(Exception $e)
	 		{
	 				$transaction->rollBack();	
	 				$model->addError('Outsource', 'Error occured while saving outsorces.');
	 				Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
	 		}         

			// $valid=true;
	  //       foreach($modelOutsource as $i=>$item)
	  //       {
	  //           if(isset($_POST['OutsourceContract'][$i]))
	  //               $item->attributes=$_POST['OutsourceContract'][$i];
	  //           $valid=$item->validate() && $valid;
	  //       }
		}
		else
        {
        	if (!Yii::app()->request->isAjaxRequest)	
			{
			  Yii::app()->db->createCommand('DELETE FROM contract_approve_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
			  Yii::app()->db->createCommand('DELETE FROM contract_change_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
			  Yii::app()->db->createCommand('DELETE FROM work_code_outsource_temp WHERE u_id='.Yii::app()->user->ID)->execute();
			 	
			}
			  // Yii::app()->db->createCommand('TRUNCATE contract_approve_history_temp')->execute();
			
        }

		$this->render('create2',array(
			'model'=>$this->loadModel($id),'outsource'=>$modelOutsource,'numContracts'=>$numContracts,'modelValidate'=>$model
		));
	}

	public function getContracts() {
        // Create an empty list of records
        $items = array();
 
        // Iterate over each item from the submitted form
        if (isset($_POST['OutsourceContract'])) {
            foreach ($_POST['OutsourceContract'] as $item) {
                // If item id is available, read the record from database 
                if ( array_key_exists('id', $item) ){
                    $items[] = OutsourceContract::model()->findByPk($item['id']);
                }
                // Otherwise create a new record
                else {
                    $items[] = new OutsourceContract();
                }
            }
        }
        
        return $items;
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		$model = new Project;
		$workcodes = "";
		$modelContract = array();
		$modelContractOld = array();
		$numContracts = 1;
		$modelPC = new ProjectContract;
		array_push($modelContract, $modelPC);
		
		// $query = "DROP TABLE if exists contract_approve_history_temp;";
	 //    $query = "CREATE TEMPORARY TABLE contract_approve_history_temp  AS (SELECT * FROM contract_approve_history WHERE 1=2);";
		// Yii::app()->db->createCommand($query)->execute();

		if(isset($_POST['Project']))
		{
			
			$model->attributes = $_POST['Project'];
			$model->pj_CA = $_POST['Project']['pj_CA'];

			if (isset($_POST['ProjectContract']))
            {
                $model->contract = $_POST['ProjectContract'];                         
                $transaction=Yii::app()->db->beginTransaction();
		    	try {
			        //$model->attributes = $_POST['Project'];
			        $model->pj_user_create = Yii::app()->user->ID;
				    $model->pj_user_update = Yii::app()->user->ID;
				
				    $model->pj_name = $_POST["pj_vendor_id"];

				    $model->pj_status = 1;

                //header('Content-type: text/plain');
				    $workcodes = $_POST['workCode'];
	    	        $workCodeArray = explode(",", $_POST['workCode']);

	    	        foreach ($model->contract as $contracts => $contract) 
		 			{
		 				     //print_r($contract);
		 					 
		 				     $modelC = new ProjectContract;
		 				     $modelC->attributes = $contract;
		 				     $modelC->pc_details = $contract["pc_details"];
		 				     $modelC->pc_sign_date = $contract["pc_sign_date"];
		 				     $modelC->pc_PO = $contract["pc_PO"];
		 				     //$modelC->pc_vendor_id = $model->pj_vendor_id;

		 				     array_push($modelContractOld, $modelC);
		 			}	
 				
 				//print_r($model->contract); 
				    if ($model->save()) {


				    	//save expect management cost
                        $modelMCost = new ManagementCost("search");
                        $modelMCost->mc_type = 0;
                        $modelMCost->mc_proj_id = $model->pj_id;
                        $modelMCost->mc_cost = $_POST["expect_cost1"];
                        $modelMCost->mc_detail = "เงินประมาณการค่าใช้จ่ายในการบริหารโครงการ";
                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
				        $modelMCost->mc_user_update = Yii::app()->user->ID; 
				        $modelMCost->mc_in_project = 1;
                        
                        if(!$modelMCost->save())
                        {
                        	
                        }
                        $modelMCost = new ManagementCost("search");
                        $modelMCost->mc_type = 0;
                        $modelMCost->mc_proj_id = $model->pj_id;
                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
				        $modelMCost->mc_user_update = Yii::app()->user->ID; 
                        $modelMCost->mc_cost = $_POST["expect_cost2"];
                        $modelMCost->mc_detail = "เงินประมาณการค่าใช้จ่ายด้านบุคลากร";
                        $modelMCost->mc_in_project = 2;
                        $modelMCost->save();

                        $modelMCost = new ManagementCost("search");
                        $modelMCost->mc_type = 0;
                        $modelMCost->mc_proj_id = $model->pj_id;
                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
				        $modelMCost->mc_user_update = Yii::app()->user->ID; 
                        $modelMCost->mc_cost = $_POST["expect_cost3"];
                        $modelMCost->mc_detail = "เงินประมาณการค่ารับรอง";
                        $modelMCost->mc_in_project = 3;
                        $modelMCost->save();

				    	//end

				    	foreach ($workCodeArray as $key => $value) {
			        		$wk = new WorkCode;
			         		$wk->code = $value;
			        		$wk->pj_id = $model->pj_id;
			        		
			        		$wk->save();	
		 	        	}
				    	$saveOK = 1;
				    	$index = 1;

		 				foreach ($model->contract as $contracts => $contract) 
		 				{
		 				     //print_r($contract);
		 					 
		 				     $modelC = new ProjectContract;
		 				     $modelC->attributes = $contract;
		 				     $modelC->pc_details = $contract["pc_details"];
		 				     $modelC->pc_sign_date = $contract["pc_sign_date"];
		 				     $modelC->pc_PO = $contract["pc_PO"];
		 				     //$modelC->pc_vendor_id = $model->pj_vendor_id;

		 				     array_push($modelContractOld, $modelC);
		 				     //$modelC->pc_id = "";
		 				     $modelC->pc_proj_id = $model->pj_id;

		 				     

		 				     $modelC->pc_last_update = (date("Y")+543).date("-m-d H:i:s");
				    		 $modelC->pc_user_update = Yii::app()->user->ID;

		 				    
		 				     if($modelC->save())
		 				     {
		 				     	//$saveOK = true;
		 				     	$modelTemps = Yii::app()->db->createCommand()
						                    ->select('*')
						                    ->from('contract_approve_history_temp')
						                    ->where('contract_id=:id AND type=1 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
						                    ->queryAll();
						        foreach ($modelTemps as $key => $mTemp) {

						        // header('Content-type: text/plain');
              //             		print_r($modelC);                    
              //             	    exit;
                                        $modelApprove = new ContractApproveHistory;
                                        $modelApprove->attributes = $mTemp;
                                        $modelApprove->dateApprove = $mTemp['dateApprove'];
                                        $modelApprove->id = "";
                                        $modelApprove->contract_id = $modelC->pc_id;
                                        $modelApprove->type = 1;
                                        
                                        if($modelApprove->save())
                                           $msg =  "successful";
                                        else{
                                           $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				            	   $saveOK = 0;
                                        }   	
						        }            
		 				     	//$modelTemp = ContractApproveHistoryTemp::model()->findByAttributes(array('contract_id'=>$contract['pc_id']));
		 				     	
		 				     	$modelTemps = Yii::app()->db->createCommand()
						                    ->select('*')
						                    ->from('contract_change_history_temp')
						                    ->where('contract_id=:id AND type=1 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
						                    ->queryAll();
						        foreach ($modelTemps as $key => $mTemp) {

                                        $modelApprove = new ContractChangeHistory;
                                        $modelApprove->attributes = $mTemp;
                                        $modelApprove->id = '';
                                        $modelApprove->contract_id = $modelC->pc_id;
                                        $modelApprove->type = 1;
                                        
                                        if($modelApprove->save())
                                        {
                                            $msg =  "successful";
                                            $mt = ContractChangeHistoryTemp::model()->findByPk($mTemp['id']);
                                            $mt->delete();
                                        }	                                          
                                        else{
                                           $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				            	   $saveOK = 0;
                                        }   	
						        }            
		 				     	
		 				     }else{
		 				     	$saveOK = 0;	
		 				     	if($contract["pc_id"]!="")
		 				     	  $modelC->pc_id = $contract["pc_id"];
		 				     	else
		 				     	  $modelC->pc_id = 1;	
		 				     }

		 				     $index++;

		 				      array_push($modelContract, $modelC); 
		 				    	
		 				}
		 				 
		 				

		 				if($saveOK==1)
		 				{
		 					$transaction->commit();
		 					//$this->redirect(array('index'));
		 					$this->redirect(array('createOutsource', 'id' => $model->pj_id));
		 					// header('Content-type: text/plain');
        //                 		//print_r($modelC);
        //                 		echo "save".$saveOK;
        //                 	exit;
		 				}   	
		 				else
		 				{
		 					$transaction->rollBack();
		 					$modelContract = $modelContractOld;
		 				    $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญา" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
		 				}

		 			}
		 			else
		 			{	
		 				$transaction->rollBack();
		 				$modelContract = $modelContractOld;
		 				//$model->addError('contract', 'Error occured while saving contracts.');
		 			}	 
	 			}
	 			catch(Exception $e)
	 			{
	 				$transaction->rollBack();	
	 				$model->addError('contract', 'Error occured while saving contracts.');
	 				Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
	 			}                         

 				//exit;
            }

           //  if ($model->saveWithRelated('contract'))
           //  {
           //  	$workcodes = $_POST['workCode'];
	 	        // $workCodeArray = explode(",", $_POST['workCode']);
	 	        // foreach ($workCodeArray as $key => $value) 
	 	        // {
	 	        // 		$wk = new WorkCode;
	 	        //  		$wk->code = $value;
	 	        // 		$wk->pj_id = $model->pj_id;
		        		
	 	        // 		$wk->save();	
	 	        // }
           //  }
           //  else
           //      $model->addError('contract', 'Error occured while saving contracts.');

			// $modelContract = array();
   //          $numContracts = $_POST['num'];
		 //    for($i=1;$i<$numContracts+1;$i++)
		 //    {
		 //        //if(isset($_POST['OutsourceContract'][$i]))
		 //        //{
		 //            $contracts = new ProjectContract;
		 //            $contracts->attributes = $_POST['ProjectContract'][$i];
		 //            $contracts->pj_user_create = Yii::app()->user->ID;
		 //            $contracts->pj_update_create = Yii::app()->user->ID;
		 //            $contracts->pj_name = $_POST["pj_vendor_id"];
		 //            $contracts->oc_proj_id = $id;
		 //            $contracts->pc_sign_date = $_POST['OutsourceContract'][$i]["pc_sign_date"];//$_POST[$i."_oc_end_date"];
		 //            $contracts->pc_details = $_POST['OutsourceContract'][$i]["pc_details"];
		 //            array_push($modelContract, $contracts);
		 //            //$contracts->validate();
		 //            $contracts->save();
		 //        //}
		 //    }

			// $valid=true;
	  //       foreach($modelOutsource as $i=>$item)
	  //       {
	  //           if(isset($_POST['OutsourceContract'][$i]))
	  //               $item->attributes=$_POST['OutsourceContract'][$i];
	  //           $valid=$item->validate() && $valid;
	  //       }
		}
		else{
		 
		 if (!Yii::app()->request->isAjaxRequest)	
		 {
		 	 Yii::app()->db->createCommand('DELETE FROM contract_approve_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
		 	 Yii::app()->db->createCommand('DELETE FROM contract_change_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
		
		 }	
		 //Yii::app()->db->createCommand('TRUNCATE contract_approve_history_temp')->execute();
				
			$modelPC->pc_id = 1;
     		//array_push($modelContract, $modelPC);


		
		}

		
		 $this->render('create', array(
            'model' => $model,'contract'=>$modelContract,'workcodes'=>$workcodes,'numContracts'=>$numContracts
        ));
	}

	// public function actionCreate()
	// {
	// 	$model=new Project;
	// 	$modelContract = new ProjectContract;
	// 	$modelContract2 = new ProjectContract;
	// 	$modelContract3 = new ProjectContract;
	// 	$modelContract4 = new ProjectContract;
	// 	$modelContract5 = new ProjectContract;
	// 	$modelWorkCode = new WorkCode;
	// 	$modelOutsource = new OutsourceContract;

	// 	$workcodes = "";
	// 	//array_push($workcodes, new WorkCode);

	// 	$activeTab  = 1;	
	// 	$numContracts = 1;
        
	// 	// Uncomment the following line if AJAX validation is needed
	// 	// $this->performAjaxValidation($model);

	// 	if(isset($_POST['Project']))
	// 	{
			
	// 		$numContracts = $_POST["numContract"];
	// 		$transaction=Yii::app()->db->beginTransaction();
	// 	    try {
	// 	        $model->attributes = $_POST['Project'];
	// 	        $model->pj_user_create = Yii::app()->user->ID;
	// 		    $model->pj_user_update = Yii::app()->user->ID;
			
	// 		    $model->pj_name = $_POST["pj_vendor_id"];
	// 		    if(isset($_POST['ProjectContract'][0]))
	// 	        {
	// 	         	$modelContract->attributes = $_POST['ProjectContract'][0];
	// 	         	$modelContract->pc_sign_date = $_POST['ProjectContract'][0]["pc_sign_date"];
	// 	         	$modelContract->pc_details = $_POST['ProjectContract'][0]["pc_details"];
	// 	        } 	
	// 	        if($numContracts>1 && isset($_POST['ProjectContract'][1]))
	// 	        { 
	// 	        	$modelContract2->attributes = $_POST['ProjectContract'][1];
	// 	        	$modelContract2->pc_sign_date = $_POST['ProjectContract'][1]["pc_sign_date"];
	// 	         	$modelContract2->pc_details = $_POST['ProjectContract'][1]["pc_details"];
	// 	        	//$numContracts++;
	// 	        }	
	// 	        if($numContracts>2 && isset($_POST['ProjectContract'][2]))
	// 	        { 
	// 	        	$modelContract3->attributes = $_POST['ProjectContract'][2];
	// 	        	$modelContract3->pc_sign_date = $_POST['ProjectContract'][2]["pc_sign_date"];
	// 	         	$modelContract3->pc_details = $_POST['ProjectContract'][2]["pc_details"];
	// 	        	//$numContracts++;
	// 	        }
	// 	        if($numContracts>3 && isset($_POST['ProjectContract'][3]))
	// 	        { 
	// 	        	$modelContract4->attributes = $_POST['ProjectContract'][3];
	// 	        	$modelContract4->pc_sign_date = $_POST['ProjectContract'][3]["pc_sign_date"];
	// 	         	$modelContract4->pc_details = $_POST['ProjectContract'][3]["pc_details"];
	// 	        	//$numContracts++;
	// 	        }
	// 	        if($numContracts>4 && isset($_POST['ProjectContract'][4]))
	// 	        { 
	// 	        	$modelContract5->attributes = $_POST['ProjectContract'][4];
	// 	        	$modelContract5->pc_sign_date = $_POST['ProjectContract'][4]["pc_sign_date"];
	// 	         	$modelContract5->pc_details = $_POST['ProjectContract'][4]["pc_details"];
	// 	        	//$numContracts++;
	// 	        }
	// 	        $workcodes = $_POST['workCode'];
	// 	        $workCodeArray = explode(",", $_POST['workCode']);
			    			    	
	// 	        if ($model->save()) {

		        	
	// 	        	foreach ($workCodeArray as $key => $value) {
	// 	        		$wk = new WorkCode;
	// 	         		$wk->code = $value;
	// 	        		$wk->pj_id = $model->pj_id;
		        		
	// 	        		$wk->save();	
	// 	        	}
		        	
	// 	        	switch ($numContracts) {
	// 	        		case 2:
	// 	        			$modelContract->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract2->pc_proj_id = $model->pj_id;
		        		    
	// 	        			if  ( $modelContract->save() && $modelContract2->save()) {
	// 				                $transaction->commit();
	// 				                //$this->redirect(array('view', 'id' => $model->pj_id));
	// 				                $activeTab = 2;
	// 				            }
	// 	        			break;
	// 	        		case 3:
	// 	        			$modelContract->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract2->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract3->pc_proj_id = $model->pj_id;
		        		    
	// 	        			if  ( $modelContract->save() && $modelContract2->save() && $modelContract3->save()) {
	// 				                $transaction->commit();
	// 				                //$this->redirect(array('view', 'id' => $model->pj_id));
	// 				                $activeTab = 2;
	// 				            }
	// 	        			break;
	// 	        		case 4:
	// 	        			$modelContract->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract2->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract3->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract4->pc_proj_id = $model->pj_id;
		        		    

	// 	        			if  ( $modelContract->save() && $modelContract2->save() && $modelContract3->save() && $modelContract4->save()) {
	// 				                $transaction->commit();
	// 				                //$this->redirect(array('view', 'id' => $model->pj_id));
	// 				                $activeTab = 2;
	// 				            }
	// 	        			break;
	// 	        		case 5:
	// 	        		    $modelContract->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract2->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract3->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract4->pc_proj_id = $model->pj_id;
	// 	        		    $modelContract5->pc_proj_id = $model->pj_id;

	// 	        			if  ( $modelContract->save() && $modelContract2->save() && $modelContract3->save() && $modelContract4->save() && $modelContract5->save()) {
	// 				                $transaction->commit();
	// 				                //$this->redirect(array('view', 'id' => $model->pj_id));
	// 				                $activeTab = 2;
	// 				            }
	// 	        			break;
		        		
	// 	        		default:
	// 	        		    $modelContract->pc_proj_id = $model->pj_id;
	// 	        			if  ( $modelContract->save()) {
	// 				                $activeTab = 2;
	// 				                $transaction->commit();
	// 				                $this->redirect(array('create2', 'id' => $model->pj_id));
					    
	// 				            }
	// 	        			break;
	// 	        	}
		            
		            
	// 	        }
	// 	        else   //something went wrong...
	// 	           $transaction->rollBack();
	// 	    }
	// 	    catch(Exception $e) { // an exception is raised if a query fails
	// 	        //something was really wrong - exception!
	// 	        $transaction->rollBack();
	// 	        Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	// 	        //you should do sth with this exception (at least log it or show on page)
	// 	        Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	// 	    }
	// 	}

	// 	$this->render('create',array(
	// 		'model'=>$model,'outsource'=>$modelOutsource,'activeTab'=>$activeTab,'workcodes'=>$workcodes,'numContracts'=>$numContracts,'modelContract'=>$modelContract,'modelContract2'=>$modelContract2,'modelContract3'=>$modelContract3,'modelContract4'=>$modelContract4,'modelContract5'=>$modelContract5
			
	// 	));
	// }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$modelProj = $this->loadModel($id);

		$modelOutsourceVal = new OutsourceContract;

		$modelContract = array();
		$modelContractOld = array();
		$numContracts = 1;
		$tab = 1; //default at project contract, tab=2 is outsource contract
		
		$modelOutsource = array();

		//header('Content-type: text/plain');
		//	                        print_r($modelProj);
			                        
		//	                        exit;
		
		$numContracts = 1;
		$clearSession = true;
		if(isset($_POST['Project']))
		{
				
			$clearSession = false; 
			$transaction=Yii::app()->db->beginTransaction();

		    try {

		    		//save expect management cost
		    		if(isset($_POST["expect_cost1"]) && $_POST["expect_cost1"]!='')
		    		{
		    			$Criteria = new CDbCriteria();
             			$Criteria->condition = "mc_proj_id='$id' AND mc_type=0 AND mc_in_project=1";
             			$modelMCost = ManagementCost::model()->findAll($Criteria);
             			if(!empty($modelMCost))
             			{
             				$modelMCost[0]->mc_cost = $_POST["expect_cost1"];                        
	                        $modelMCost[0]->mc_date = (date("Y")+543).date("-m-d");

	                        $modelMCost[0]->mc_type = 0;
					        $modelMCost[0]->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost[0]->save();	
             			}
             			else{
             				$modelMCost = new ManagementCost("search");
             				$modelMCost->mc_cost = $_POST["expect_cost1"];                        
	                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
	                        $modelMCost->mc_type = 0;
	                        $modelMCost->mc_proj_id = $id;
	                        $modelMCost->mc_in_project = 1;
					        $modelMCost->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost->save();
	                        // header('Content-type: text/plain');
	                        // print_r($modelMCost);
	                        // exit;

             			}                       
                        
                    }
                        // header('Content-type: text/plain');
		                //          		print_r($modelMCost[0]);                    
		                //          	    exit;
                    if(isset($_POST["expect_cost2"])&& $_POST["expect_cost2"]!='')
		    		{    
                        $Criteria = new CDbCriteria();
             			$Criteria->condition = "mc_proj_id='$id' AND mc_type=0 AND mc_in_project=2";
             			$modelMCost = ManagementCost::model()->findAll($Criteria);                       
                        if(!empty($modelMCost))
             			{
             				$modelMCost[0]->mc_cost = $_POST["expect_cost2"];                        
	                        $modelMCost[0]->mc_date = (date("Y")+543).date("-m-d");
	                        $modelMCost[0]->mc_type = 0;
					        $modelMCost[0]->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost[0]->save();	
             			}
             			else{
             				$modelMCost = new ManagementCost("search");
             				$modelMCost->mc_cost = $_POST["expect_cost2"];                        
	                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
	                        $modelMCost->mc_type = 0;
	                        $modelMCost->mc_proj_id = $id;
	                        $modelMCost->mc_in_project = 2;
					        $modelMCost->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost->save();
             			}
                    }    

                    if(isset($_POST["expect_cost3"])&& $_POST["expect_cost3"]!='')
		    		{    
                        $Criteria = new CDbCriteria();
             			$Criteria->condition = "mc_proj_id='$id' AND mc_type=0 AND mc_in_project=3";
             			$modelMCost = ManagementCost::model()->findAll($Criteria);                       
                        if(!empty($modelMCost))
             			{
             				$modelMCost[0]->mc_cost = $_POST["expect_cost3"];                        
	                        $modelMCost[0]->mc_date = (date("Y")+543).date("-m-d");
	                        $modelMCost[0]->mc_type = 0;
					        $modelMCost[0]->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost[0]->save();	
             			}
             			else{
             				$modelMCost = new ManagementCost("search");
             				$modelMCost->mc_cost = $_POST["expect_cost3"];                        
	                        $modelMCost->mc_date = (date("Y")+543).date("-m-d");
	                        $modelMCost->mc_type = 0;
	                        $modelMCost->mc_proj_id = $id;
	                        $modelMCost->mc_in_project = 3;
					        $modelMCost->mc_user_update = Yii::app()->user->ID; 				        
	                        $modelMCost->save();
             			}
                    }    
				    	//end


		    	
			    	$modelProj->attributes = $_POST["Project"];
			    	$modelProj->pj_CA = $_POST["Project"]["pj_CA"];
			    	$modelProj->pj_name = $_POST["pj_vendor_id"];
			    	$modelProj->pj_status = empty($_POST['Project']['pj_close']) ? 1 : 0;	
			    	 // header('Content-type: text/plain');
	        //                  print_r($modelProj);
	        //                  	exit;
			    	if($modelProj->save())
			    		$msg = "successful";
			    	else{
			    			 //header('Content-type: text/plain');
	                         //print_r($modelProj);
	                         //	exit;

			    	}

			     $index = 1;	
			     $savePC = true;
			     if(isset($_POST['ProjectContract']))
			     {
			        
			     	foreach( $_POST['ProjectContract'] as $value ) {
							
							$modelPC = ProjectContract::model()->FindByPk($value["pc_id"]);
							

							if(empty($modelPC))
							{
								 //new contract
								 $modelPC = new ProjectContract("search");
								 //$modelPC->attributes = $value;
								 $modelPC->setAttributes($value);
								 $modelPC->pc_last_update = (date("Y")+543).date("-m-d H:i:s");
						    	 $modelPC->pc_user_update = Yii::app()->user->ID;
						    	 $modelPC->pc_proj_id = $id;
								        //header('Content-type: text/plain');
		                          		//print_r($modelPC);                    
		                          	    //exit;
		                         
						    	 if($modelPC->save())
								{

										 //save contract change history
					 	        		 $modelTemps = Yii::app()->db->createCommand()
								                    ->select('*')
								                    ->from('contract_change_history_temp')
								                    ->where('contract_id=:id AND type=1 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
								                    ->queryAll();
								        foreach ($modelTemps as $key => $mTemp) {

		                                        $modelChange = new ContractChangeHistory("search");
		                                        $modelChange->attributes = $mTemp;
		                                        $modelChange->id = '';
		                                        $modelChange->contract_id = $modelPC->pc_id;
		                                        $modelChange->type = 1;
		                                        
		                                        if($modelChange->save())
		                                        {
		                                            $msg =  "successful";
		                                            $mt = ContractChangeHistoryTemp::model()->findByPk($mTemp['id']);
		                                            $mt->delete();
		                                        }	                                          
		                                        else{
		                                           $model->addError('contract', 'xxxกรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
				 				            	   $savePC = false;

		                                        }   	
								        }            



					 	        		 //save approve change history
					 	        		 $modelTemps = Yii::app()->db->createCommand()
								                    ->select('*')
								                    ->from('contract_approve_history_temp')
								                    ->where('contract_id=:id AND type=1 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
								                    ->queryAll();
								        foreach ($modelTemps as $key => $mTemp) {

								        // header('Content-type: text/plain');
		              //             		print_r($modelC);                    
		              //             	    exit;
		                                        $modelApprove = new ContractApproveHistory("search");
		                                        $modelApprove->attributes = $mTemp;
		                                        $modelApprove->dateApprove = $mTemp['dateApprove'];
		                                        $modelApprove->id = "";
		                                        $modelApprove->contract_id = $modelPC->pc_id;
		                                        $modelApprove->type = 1;
		                                        
		                                        if($modelApprove->save())
		                                           $msg =  "successful";
		                                        else{
		                                           $model->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
				 				            	   $savePC = false;
		                                        }   	
								        }            
		 				     	

								}	
								else{
										$modelProj->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ '.$index.'" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
										$savePC = false;

										 //header('Content-type: text/plain');
		                          		 //print_r($modelPC);                    
		                          	     //exit;	
								}
			 	        		array_push($modelContract, $modelPC);

			 	        		
		 				     	
								 
							}
							else //old contracts
							{
									$modelPC->attributes = $value;



									//check difference
									//1.project contract
									$difference = 0;
									foreach ($value as $key => $new) {

										if($new!=$modelPC[$key])
											$difference = 1;
										
									}
									//2.get last_update in change
									$modelCostHist = Yii::app()->db->createCommand()
								                        ->select('max(last_update) as max')
								                        ->from('contract_change_history')
								                        ->where('contract_id=:id', array(':id'=>$value["pc_id"]))
								                        ->queryAll();
								                        
								    $change_lastUpdate = $modelCostHist[0]["max"];                    

								    
									//3.get last_update in approve
									$modelApproveHist = Yii::app()->db->createCommand()
								                        ->select('max(last_update) as max')
								                        ->from('contract_approve_history')
								                        ->where('contract_id=:id', array(':id'=>$value["pc_id"]))
								                        ->queryAll();
								    $approve_lastUpdate = $modelApproveHist[0]["max"];  

								    //4.compare last_update in change and approve 
								    $last_update_relate = $approve_lastUpdate > $change_lastUpdate ? $approve_lastUpdate: $change_lastUpdate;

								    //5.compare with contract last_update
								    $datedif = "no";
								    if($last_update_relate > $modelPC->pc_last_update)
								    {
								    	$difference = 1;
								    	$datedif = "yes";
								    } 


										
									// header('Content-type: text/plain');
			      //                   print_r($modelProj);
			                        
			      //                   exit;

									if($difference==1)
									{
										$modelPC->pc_last_update = (date("Y")+543).date("-m-d H:i:s");
						    			$modelPC->pc_user_update = Yii::app()->user->ID;
									}

									if($modelPC->save())
									{
									// header('Content-type: text/plain');
	                        		// print_r($modelPC);
	                         		//exit;
									}	
									else{
										$modelProj->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ '.$index.'" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
										$savePC = false;

									}
			 	        			array_push($modelContract, $modelPC);
			 	        	
							}
			 	        	
							
							$index++;
				        		
			 	        	
					}

			     }
			    
			    if($savePC)
			    	   $tab = 2;	

	               if(isset($_POST['wk']))
	               {
	               		WorkCode::model()->deleteAll("pj_id ='" . $id . "'");
					 	foreach( $_POST['wk'] as $value ) {
							$wk = new WorkCode;
							$wk->code = $value;
			 	        	$wk->pj_id = $id;
				        		
			 	        	$wk->save();	
					 	}

	               }	


	              

				$transaction->commit();
				$this->redirect(array('index'));

			}
			catch(Exception $e)
	 		{
	 			$transaction->rollBack();
	 			Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
			}	 

		}
		

		if(isset($_POST['OutsourceContract']))
		{
				
					$tab = 2;
					$clearSession = false;
					$saveOC = true;

				 //------outsource-----------//
	             	$transaction=Yii::app()->db->beginTransaction();

				    try {
  							$index = 1;
							foreach( $_POST['OutsourceContract'] as $value ) {
										
									
										if(empty($value["oc_id"]))
										{
											 //new contract
											 $modelOC = new OutsourceContract("search");
											 //$modelPC->attributes = $value;
											 $modelOC->setAttributes($value);
											 $modelOC->oc_last_update = (date("Y")+543).date("-m-d H:i:s");
									    	 $modelOC->oc_user_create = Yii::app()->user->ID;
									    	 $modelOC->oc_user_update = Yii::app()->user->ID;
									    	 $modelOC->oc_proj_id = $id;
											        //header('Content-type: text/plain');
					                          		//print_r($modelOC);                    
					                          	    //exit;
					                         array_push($modelOutsource, $modelOC);
									    	 if($modelOC->save())
											{

													 //save contract change history
								 	        		 $modelTemps = Yii::app()->db->createCommand()
											                    ->select('*')
											                    ->from('contract_change_history_temp')
											                    ->where('contract_id=:id AND type=2 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
											                    ->queryAll();
											        foreach ($modelTemps as $key => $mTemp) {

					                                        $modelChange = new ContractChangeHistory("search");
					                                        $modelChange->attributes = $mTemp;
					                                        $modelChange->id = '';
					                                        $modelChange->contract_id = $modelOC->oc_id;
					                                        $modelChange->type = 2;
					                                        
					                                        if($modelChange->save())
					                                        {
					                                            $msg =  "successful";
					                                            $mt = ContractChangeHistoryTemp::model()->findByPk($mTemp['id']);
					                                            $mt->delete();
					                                        }	                                          
					                                        else{
					                                           $modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
							 				            	   $saveOC = false;

					                                        }   	
											        }            
											        //save contract PO
								 	        		 $modelTemps = Yii::app()->db->createCommand()
											                    ->select('*')
											                    ->from('work_code_outsource_temp')
											                    ->where('contract_id=:id AND  u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
											                    ->queryAll();
											        foreach ($modelTemps as $key => $mTemp) {

					                                        $modelChange = new WorkCodeOutsource("search");
					                                        $modelChange->attributes = $mTemp;
					                                        $modelChange->id = '';
					                                        $modelChange->contract_id = $modelOC->oc_id;
					                                        
					                                        
					                                        if($modelChange->save())
					                                        {
					                                            $msg =  "successful";
					                                            $mt = WorkCodeOutsourceTemp::model()->findByPk($mTemp['id']);
					                                            $mt->delete();
					                                        }	                                          
					                                        else{
					                                           $modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
							 				            	   $saveOC = false;

					                                        }   	
											        }         

								 	        		 //save approve change history
								 	        		 $modelTemps = Yii::app()->db->createCommand()
											                    ->select('*')
											                    ->from('contract_approve_history_temp')
											                    ->where('contract_id=:id AND type=2 AND u_id=:user', array(':id'=>$index,':user'=>Yii::app()->user->ID))
											                    ->queryAll();
											        foreach ($modelTemps as $key => $mTemp) {

											        // header('Content-type: text/plain');
					              //             		print_r($modelC);                    
					              //             	    exit;
					                                        $modelApprove = new ContractApproveHistory("search");
					                                        $modelApprove->attributes = $mTemp;
					                                        $modelApprove->id = '';
					                                        $modelApprove->dateApprove = $mTemp['dateApprove'];
					                                        //$modelApprove->id = "";
					                                        $modelApprove->contract_id = $modelOC->oc_id;
					                                        $modelApprove->type = 2;
					                                        
					                                        if($modelApprove->save())
					                                           $msg =  "successful";
					                                        else{
					                                           $modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ "'.$index.' ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
							 				            	   $saveOC = false;
					                                        }   	
											        }            
					 				     	

											}	
											else{
													$modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ '.$index.'" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
													$saveOC = false;

													 //header('Content-type: text/plain');
					                          		 //print_r($modelOC);                    
					                          	     //exit;	
											}
						 	        		
						 	        		
					 				     	//header('Content-type: text/plain');
					                        //  		 print_r($modelOC);                    
					                        //  	     exit;
											
 
										}
										else //old contracts
										{
												$modelOC = OutsourceContract::model()->FindByPk($value["oc_id"]);
										
												$modelOC->attributes = $value;
												$modelOC->oc_sign_date = $value["oc_sign_date"];
												$modelOC->oc_approve_date = $value["oc_approve_date"];
												$modelOC->oc_insurance_start = $value["oc_insurance_start"];
												$modelOC->oc_insurance_end = $value["oc_insurance_end"];
												$modelOC->oc_guarantee_date = $value["oc_guarantee_date"];
												$modelOC->oc_guarantee_end = $value["oc_guarantee_end"];
												if(isset($value["notify_1000"]))
													$modelOC->notify_1000 = $value["notify_1000"];
												if(isset($value["notify_1000_close"]))
													$modelOC->notify_1000_close = $value["notify_1000_close"];

													 // header('Content-type: text/plain');
						        //                 print_r($modelOC);
						                        
						        //                 exit;

												//check difference
												//1.project contract
												$difference = 0;
												foreach ($value as $key => $new) {

													if($new!=$modelOC[$key])
														$difference = 1;
													
												}
												//2.get last_update in change
												$modelCostHist = Yii::app()->db->createCommand()
											                        ->select('max(last_update) as max')
											                        ->from('contract_change_history')
											                        ->where('contract_id=:id', array(':id'=>$value["oc_id"]))
											                        ->queryAll();
											                        
											    $change_lastUpdate = $modelCostHist[0]["max"];                    

											    
												//3.get last_update in approve
												$modelApproveHist = Yii::app()->db->createCommand()
											                        ->select('max(last_update) as max')
											                        ->from('contract_approve_history')
											                        ->where('contract_id=:id', array(':id'=>$value["oc_id"]))
											                        ->queryAll();
											    $approve_lastUpdate = $modelApproveHist[0]["max"];  

											    //4.compare last_update in change and approve 
											    $last_update_relate = $approve_lastUpdate > $change_lastUpdate ? $approve_lastUpdate: $change_lastUpdate;

											    //5.compare with contract last_update
											    $datedif = "no";
											    if($last_update_relate > $modelOC->oc_last_update)
											    {
											    	$difference = 1;
											    	$datedif = "yes";
											    } 


													
												// header('Content-type: text/plain');
						      //                   print_r($modelOC);
						                        
						      //                   exit;

												if($difference==1)
												{
													$modelOC->oc_last_update = (date("Y")+543).date("-m-d H:i:s");
									    			$modelOC->oc_user_update = Yii::app()->user->ID;
												}
												array_push($modelOutsource, $modelOC);

												if($modelOC->save())
												{
													
												}	
												else{
													$modelOutsourceVal->addError('contract', 'กรุณากรอกข้อมูล "สัญญาที่ '.$index.'" ในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน.');		
													$saveOC = false;

												}
						 	        			
						 	        	
										}
						 	        	
										
										$index++;
							        		
						 	        	
								}


							  if($saveOC){

						        $transaction->commit();
								$this->redirect(array('index'));
							  }
							
						}
						catch(Exception $e)
				 		{
				 			$transaction->rollBack();
				 			Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
				 	        	//you should do sth with this exception (at least log it or show on page)
				 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
				 
						}	 
				
					
		}
		else{
			 
			if (!Yii::app()->request->isAjaxRequest)	
		 	{
		 		 Yii::app()->db->createCommand('DELETE FROM contract_approve_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
		 	 	 Yii::app()->db->createCommand('DELETE FROM contract_change_history_temp WHERE u_id='.Yii::app()->user->ID)->execute();
		         Yii::app()->db->createCommand('DELETE FROM work_code_outsource_temp WHERE u_id='.Yii::app()->user->ID)->execute();
		         
		 	}		

			$project_contract = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('project_contract')
                        ->where('pc_proj_id=:id', array(':id'=>$id))
                        ->queryAll();

            if(!empty($project_contract))
            {    
               
                foreach ($project_contract as $key => $value) {

                    $modelPC =new ProjectContract("search");
                    $modelPC->attributes = $value;
                    $str_date = explode("-", $value["pc_sign_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_sign_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                    $str_date = explode("-", $value["pc_end_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_end_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  $str_date = explode("-", $value["pc_garantee_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_garantee_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);

						//header('Content-type: text/plain');
					    //                      		 print_r($modelPC);                    
					    //                      	     exit;
											

                    $modelPC->pc_last_update = $value["pc_last_update"];
                    $modelPC->pc_details = $value["pc_details"];
                    $modelPC->pc_id = $value["pc_id"];
                    //cal %A
					//sum income;
                    $data = Yii::app()->db->createCommand()
										->select('sum(money) as sum')
										->from('payment_project_contract')
										->where('proj_id=:id AND (bill_date!="" AND bill_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
										->queryAll();
											                        
					$sum_income = $data[0]["sum"];

					 $data = Yii::app()->db->createCommand()
										->select('sum(cost) as sum')
										->from('contract_change_history')
										->where('contract_id=:id  AND type=1', array(':id'=>$modelPC->pc_id))
										->queryAll();
											                        
					$change = $data[0]["sum"];      

					// $data = Yii::app()->db->createCommand()
					// 					->select('sum(money) as sum')
					// 					->from('payment_outsource_contract')
					// 					->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
					// 					->queryAll();
											                        
					// $sum_payment = $data[0]["sum"];  
					$cost = $modelPC->pc_cost + $change;
					$modelPC->pc_A_percent =number_format((1 - ($cost - $sum_income)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);

					//end cal 
                    $modelPC->pc_cost = number_format($modelPC->pc_cost,2);
                    array_push($modelContract, $modelPC);
                 
                }
            }

            $outsource_contract = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('outsource_contract')
                        ->where('oc_proj_id=:id', array(':id'=>$id))
                        ->queryAll();

            if(!empty($outsource_contract))
            {    
               
                foreach ($outsource_contract as $key => $value) {

                    $modelOC =new OutsourceContract("search");

                    $modelOC->attributes = $value;
                    $str_date = explode("-", $value["oc_sign_date"]);
                    if(count($str_date)>1)
                      $modelOC->oc_sign_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  	if($value["oc_sign_date"]=="0000-00-00")
                  	  $modelOC->oc_sign_date = "";		
                    $str_date = explode("-", $value["oc_end_date"]);
                    if(count($str_date)>1)
                      $modelOC->oc_end_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  	if($value["oc_end_date"]=="0000-00-00")
                  	  $modelOC->oc_end_date = "";
                    $modelOC->oc_last_update = $value["oc_last_update"];

                    
                    $str_date = explode("-", $value["oc_approve_date"]);
                    if(count($str_date)>1)
                      $modelOC->oc_approve_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  	$str_date = explode("-", $value["oc_insurance_start"]);
                    if(count($str_date)>1)
                      $modelOC->oc_insurance_start = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  	$str_date = explode("-", $value["oc_insurance_end"]);
                    if(count($str_date)>1)
                      $modelOC->oc_insurance_end = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                  	
                    if($value["oc_insurance_end"]=="0000-00-00")
                  	  $modelOC->oc_insurance_end = "";	
                  	if($value["oc_insurance_start"]=="0000-00-00")
                  	  $modelOC->oc_insurance_start = "";	
                  	if($value["oc_approve_date"]=="0000-00-00")
                  	  $modelOC->oc_approve_date = "";	
                   
                    $modelOC->oc_id = $value["oc_id"];

                    //cal %A
					//sum income;

					 $data = Yii::app()->db->createCommand()
										->select('sum(cost) as sum')
										->from('contract_change_history')
										->where('contract_id=:id  AND type=2', array(':id'=>$modelOC->oc_id))
										->queryAll();
											                        
					$change = $data[0]["sum"];      

					$data = Yii::app()->db->createCommand()
										->select('sum(money) as sum')
										->from('payment_outsource_contract')
										->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelOC->oc_id))
										->queryAll();
											                        
					$sum_payment = $data[0]["sum"];  
					$cost = $modelOC->oc_cost + $change;
					$modelOC->oc_A_percent =number_format((1 - ($cost - $sum_payment)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);

					//end cal 

                    $modelOC->oc_cost = number_format($modelOC->oc_cost,2);


                    array_push($modelOutsource, $modelOC);
                 
                }
            }
            else{
            	array_push($modelOutsource, new OutsourceContract);
            }
              
		}


		$this->render('update',array(
			'model'=>$modelProj,'clearSession'=>$clearSession,'modelOC'=>$modelOutsourceVal,'contracts'=>$modelContract,'outsource'=>$modelOutsource,'tab'=>$tab,'numContracts'=>$numContracts
		));
            
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			//delete projectContracts
			//ProjectContract::model()->deleteAll("pc_proj_id ='" . $id . "'");

			//delete workcodes
			//ProjectContract::model()->deleteAll("pc_proj_id ='" . $id . "'");


			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Project');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model,$modelContract)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate(array($model,$modelContract));
			Yii::app()->end();
		}
	}


	public function actionDeleteSelected()
    {
    	$autoIdAll = $_POST['selectedID'];
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $this->loadModel($autoId)->delete();
            }
        }    
    }

    public function actionCloseSelected()
    {
    	$autoIdAll = $_POST['selectedID'];
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $pjModel = $this->loadModel($autoId);
                $pjModel->pj_status = 0;
                $pjModel->save();
            }
        }    
    }

	public function actionLoadOutsourceByAjax($index)
    {
        $model = new OutsourceContract;

        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        $this->renderPartial('//outsourceContract/_formUpdateTemp', array(
            'model' => $model,
            'index' => $index,
            'display' => 'block',
        ), false, true);

        
    }
    public function actionLoadContractByAjax($index)
    {
        $model = new ProjectContract;
        //$model->pc_id = $index;
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        $this->renderPartial('//ProjectContract/_form', array(
            'model' => $model,
            'index' => $index,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionLoadContractByAjaxTemp($index)
    {
        $model = new ProjectContract;
        //$model->pc_id = $index;
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        $this->renderPartial('//ProjectContract/_formUpdateTemp2', array(
            'model' => $model,
            'index' => $index,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionLoadOutsourceByAjaxTemp($index)
    {
        $model = new OutsourceContract;
        //$model->pc_id = $index;
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        $this->renderPartial('//OutsourceContract/_formUpdateTemp', array(
            'model' => $model,
            'index' => $index,
            'display' => 'block',
        ), false, true);

        
    }

  
  
}
