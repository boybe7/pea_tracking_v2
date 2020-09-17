<?php

class PaymentProjectContractController extends Controller
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
				'actions'=>array('index','view','print','mail','export'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','delete','cancel','create','update','DeleteSelected','createReference','updateReference','deleteReference','updateReferenceTemp','deleteReferenceTemp'),
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


	    $renderDate = $d." ".$th_month[$mi]." ".$yi;
	    if($renderDate==0)
	        $renderDate = "";   

	    return $renderDate;             
	}
	public function actionExport($id)
    {
    	
		   Yii::import('ext.phpexcel.XPHPExcel');    
		   $objPHPExcel= XPHPExcel::createPHPExcel();
		   $objReader = PHPExcel_IOFactory::createReader('Excel2007');
           $objPHPExcel = $objReader->load("report/templateInvoice.xlsx");

		    $title = new PHPExcel_Style();
		    $title->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,     
			            'bold'=>true,         
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			          
			            
			    ));
		    $header = new PHPExcel_Style();
			$header->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'64ED74')
			        ),
			            
			    ));

			$header2 = new PHPExcel_Style();
			$header2->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'F7E672')
			        ),
			            
			    ));

			$detail = new PHPExcel_Style();
			$detail->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			             'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'top'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)			            
			    ));
			$detail_tb = new PHPExcel_Style();
			$detail_tb->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'top'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));


			$model = $this->loadModel($id);

			$vendor = Vendor::model()->findByPK(ProjectContract::model()->findByPK($model->proj_id)->pc_vendor_id);
			$project = Project::model()->findByPK(ProjectContract::model()->findByPK($model->proj_id)->pc_proj_id);
			$vendor_name = empty($vendor) ?"" : $vendor->v_name;

			//กำหนดชำระภายใน
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1',$model->pay_day);
			//CA
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2',$project->pj_CA);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2',"  ".$model->invoice_no);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3',"  ".$this->renderDate($model->invoice_date));

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7',$vendor_name);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8',$model->address);
			
			$ref_model = PaymentDocRefer::model()->findAll('payment_id =:id', array(':id' =>$model->id));
    
	        $row = 9;
	        $no = 0;
	        foreach ($ref_model as $key => $value) {
	           
	            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,$value->detail);	            
	            $row++;
	            $no++;
	        }

	        $objPHPExcel->getActiveSheet()->removeRow($row,$no);

	        $row = $row + 3;
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,$model->detail);
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,$model->money);

	        $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':E'.($row+3))->getNumberFormat()->setFormatCode('#,##0.00');
	        $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':E'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	 

	        $row = $row + 6;
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,'(.............'.$model->signed_name.'.............)');
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($row+1),'ตำแหน่ง.............'.$model->signed_position.'.............');
	        if($model->act_instead)
	        {
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($row+2),'ปฏิบัติหน้าที่แทน ผวก.');
	              
	        }

		    ob_end_clean();
			ob_start();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="invoice_.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,  'Excel2007');
			$objWriter->save('php://output');  //
			// Yii::app()->end(); 

			$xlsData = ob_get_contents();
			//ob_end_clean();
			$response =  array(
		        'op' => 'ok',
		        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		    );

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

	public function actionMail()
	{
		$this->render('mail',array(
			
		));
	}

	public function actionCreateReference()
	{
		if(!empty($_POST["payment_id"]) || $_POST["payment_id"]!="0")
		{
			$model=new PaymentDocRefer("search");
			$model->payment_id = $_POST["payment_id"];
			$model->detail = $_POST["detail"];
			$model->save();
	
		}
		else
		{
			$model=new PaymentDocReferTemp("search");
			$model->user_id = Yii::app()->user->ID;
			$model->detail = $_POST["detail"];
			$model->save();
		}
		
	}

	public function actionUpdateReference()
    {
	    $es = new EditableSaver('PaymentDocRefer');
	    try {
	    	$es->update();
	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
    }

    public function actionDeleteReference($id)
	{

		$model=PaymentDocRefer::model()->findByPk($id);
		
		$model->delete();

	}

	public function actionUpdateReferenceTemp()
    {
	    $es = new EditableSaver('PaymentDocReferTemp');
	    try {
	    	$es->update();
	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
    }

    public function actionDeleteReferenceTemp($id)
	{

		$model=PaymentDocReferTemp::model()->findByPk($id);
		
		$model->delete();

	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PaymentProjectContract("search");
		$t = 0;
		$a = 0;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//running invoice_no
                  $year = date('Y');
                  $sql = 'SELECT MAX(no) as max_no FROM payment_project_contract WHERE  YEAR(invoice_date)='.$year;
                  $command = Yii::app()->db->createCommand($sql);
                  $result = $command->queryAll();
                  $max_no = $result[0]['max_no']+1;
                  $year_th = $year+543;
                  $no_str = $max_no;
                  if($max_no<10)
                  {
                     $no_str = "00".$max_no;
                  }
                  else if($max_no<100)
                  {
                     $no_str = "0".$max_no;
                  }
                
        
                  $model->invoice_no = "กบศ.".substr($year_th, -2)."-".$no_str;



		if(isset($_POST['PaymentProjectContract']))
		{
			$model->attributes = $_POST['PaymentProjectContract'];
			$model->detail = $_POST['PaymentProjectContract']["detail"];
			$model->bill_date = $_POST['PaymentProjectContract']["bill_date"];
			$model->money = str_replace(",", "", $_POST['PaymentProjectContract']["money"]);

			$model->user_create = Yii::app()->user->ID;
			$model->user_update = Yii::app()->user->ID;
			//$model->user_create = Yii::app()->user->ID;
			// $t = $_POST["t_percent"];
			// $a = $_POST["a_percent"];
			$transaction=Yii::app()->db->beginTransaction();
			try {

				//running invoice_no
                  $year = date('Y');
                  $sql = 'SELECT MAX(no) as max_no FROM payment_project_contract WHERE  YEAR(invoice_date)='.$year;
                  $command = Yii::app()->db->createCommand($sql);
                  $result = $command->queryAll();
                  $max_no = $result[0]['max_no']+1;
                  $year_th = $year+543;
                  $no_str = $max_no;
                  if($max_no<10)
                  {
                     $no_str = "00".$max_no;
                  }
                  else if($max_no<100)
                  {
                     $no_str = "0".$max_no;
                  }
                
        
                  $model->invoice_no = "กบศ.".substr($year_th, -2)."-".$no_str;
                  $model->no = $max_no;


				if($model->save())
				{
					$modelPC = ProjectContract::model()->FindByPk($model->proj_id);
					// $modelPC->pc_T_percent = $t;
					// $modelPC->pc_A_percent = $a;
					// $modelPC->pc_user_update = Yii::app()->user->ID;
					// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
					// $modelPC->save();
					
					$update = 0;
					if($model->T > $modelPC->pc_T_percent)
					{
						$update = 1;
						$modelPC->pc_T_percent = $model->T;	
					}
					if($model->A > $modelPC->pc_A_percent)
					{
						$update = 1;
						$modelPC->pc_A_percent = $model->A;	
					}
					if($update==1)
					{
						$modelPC->pc_user_update = Yii::app()->user->ID;
					    $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
					    $modelPC->save();
							
					}

					$saveOK = true;
					if(isset($_POST['PaymentType']))
					{
						$pid = 1;
						foreach ($_POST['PaymentType'] as $key => $value) {
							$pay_detail = new PaymentDetail;
							$pay_detail->cost = str_replace(",", "",$value);
							$pay_detail->payment_type_id = $pid;
							$pay_detail->payment_id = $model->id;
							
							if(!$pay_detail->save())
								$saveOK = false;
							
							$pid++;
							
						}
					}		

					if($saveOK)
					   $transaction->commit();
				
					$this->redirect(array('index'));
				}	
				else
					$model->money = $_POST['PaymentProjectContract']["money"];


			}
			catch(Exception $e)
	 		{
	 			$transaction->rollBack();
	 			Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
			}	 
		}

		$this->render('create',array(
			'model'=>$model,'t'=>$t,'a'=>$a
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$t = ProjectContract::model()->FindByPk($model->proj_id)->pc_T_percent;
		$a = ProjectContract::model()->FindByPk($model->proj_id)->pc_A_percent;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PaymentProjectContract']))
		{
			    $model->attributes=$_POST['PaymentProjectContract'];
			    $model->money = str_replace(",", "", $_POST['PaymentProjectContract']["money"]);

				$model->user_create = Yii::app()->user->ID;
				$model->user_update = Yii::app()->user->ID;
				//$model->user_create = Yii::app()->user->ID;
				// $t = $_POST["t_percent"];
				// $a = $_POST["a_percent"];
				//header('Content-type: text/plain');
				if(isset($_POST['PaymentType']))
				{
					$pid = 1;
					foreach ($_POST['PaymentType'] as $key => $value) {
						
						$payment = PaymentDetail::model()->findAll('payment_id =:id AND payment_type_id=:type', array(':id' =>$id,':type'=>$pid));
						if(!empty($payment))
						{
							$payment[0]->cost = str_replace(",", "",$value);
							$payment[0]->save();	
							//print_r($payment[0]);
						}
						else
						{
							$payment = new PaymentDetail;
							$payment->payment_id = $id;
							$payment->payment_type_id = $pid;
							$payment->cost = str_replace(",", "",$value);
							$payment->save();	
						}
						
						$pid++;
						//echo $value."<br>";
					}
				}		
				//exit;

			 	// $modelPC = ProjectContract::model()->FindByPk($model->proj_id);
				// $modelPC->pc_T_percent = $t;
				// $modelPC->pc_A_percent = $a;
				// $modelPC->pc_user_update = Yii::app()->user->ID;
				// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
				// $modelPC->save();
				
				if($model->save())
				{
					//header('Content-type: text/plain');
                    //          print_r($model);                    
                    //       	  exit;
					$modelPC = ProjectContract::model()->FindByPk($model->proj_id);
					// $modelPC->pc_T_percent = $t;
					// $modelPC->pc_A_percent = $a;
					// $modelPC->pc_user_update = Yii::app()->user->ID;
					// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
					// $modelPC->save();
					
					$update = 0;
					if($model->T > $modelPC->pc_T_percent)
					{
						$update = 1;
						$modelPC->pc_T_percent = $model->T;	
					}
					if($model->A > $modelPC->pc_A_percent)
					{
						$update = 1;
						$modelPC->pc_A_percent = $model->A;	
					}
					if($update==1)
					{
						$modelPC->pc_user_update = Yii::app()->user->ID;
					    $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
					    $modelPC->save();
							
					}
					$this->redirect(array('index'));
				}
		}

		$this->render('update',array(
			'model'=>$model,'t'=>$t,'a'=>$a
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

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('PaymentProjectContract');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));

		$model=new PaymentProjectContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentProjectContract']))
			$model->attributes=$_GET['PaymentProjectContract'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PaymentProjectContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentProjectContract']))
			$model->attributes=$_GET['PaymentProjectContract'];

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
		$model=PaymentProjectContract::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-project-contract-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeleteSelected()
    {
    	$autoIdAll = $_POST['selectedID'];
    	//header('Content-type: text/plain');
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                //$this->loadModel($autoId)->delete();
            		
                $model = $this->loadModel($autoId);
                $model->money = str_replace(",", "", $model->money); 
                $model->flag_delete = 1;
                $model->save();
                print_r($model);
               
            }
        }    

        // exit;
    }

    public function actionCancel($id)
	{
		
			$model=$this->loadModel($id);
			$model->flag_delete = 1;
			$model->note = $_GET["note"];
			
			$model->save();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
	}


     public function actionPrint($id)
    {
        	
	    
	    $model = $this->loadModel($id);
	    

        $this->renderPartial('_formPDF', array(
            'model' => $model,
            'display' => 'block',
        ), false, true);

        
    }
}
