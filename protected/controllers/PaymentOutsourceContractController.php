<?php

class PaymentOutsourceContractController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','delete','create','update','DeleteSelected'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PaymentOutsourceContract("search");
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PaymentOutsourceContract']))
		{
			$model->attributes = $_POST['PaymentOutsourceContract'];
			$model->detail = $_POST['PaymentOutsourceContract']["detail"];
			$model->invoice_send_date = $_POST['PaymentOutsourceContract']["invoice_send_date"];
			$model->money = str_replace(",", "", $_POST['PaymentOutsourceContract']["money"]);
			//$model->T = $_POST['PaymentOutsourceContract']["T"];
			//$model->B = $_POST['PaymentOutsourceContract']["B"];
			$model->user_create = Yii::app()->user->ID;
			$model->user_update = Yii::app()->user->ID;
			//$model->user_create = Yii::app()->user->ID;
			// $t = $_POST["t_percent"];
			// $a = $_POST["a_percent"];
			

			if($model->save())
			{
				$modelOC = OutsourceContract::model()->FindByPk($model->contract_id);
				// $modelPC->pc_T_percent = $t;
				// $modelPC->pc_A_percent = $a;
				// $modelPC->pc_user_update = Yii::app()->user->ID;
				// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
				// $modelPC->save();
				
				$update = 0;
				if($model->T > $modelOC->oc_T_percent)
				{
					$update = 1;
					$modelOC->oc_T_percent = $model->T;	
				}
				if($model->B > $modelOC->oc_A_percent)
				{
					$update = 1;
					$modelOC->oc_A_percent = $model->B;	
				}
				if($update==1)
				{
					$modelOC->oc_user_update = Yii::app()->user->ID;
				    $modelOC->oc_last_update =  (date("Y")).date("-m-d H:i:s");
				    $modelOC->save();
						
				}

				$this->redirect(array('index'));
			}	
			else
				$model->money = $_POST['PaymentOutsourceContract']["money"];
		}

		$this->render('create',array(
			'model'=>$model
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
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PaymentOutsourceContract']))
		{
			    $model->attributes=$_POST['PaymentOutsourceContract'];
			    $model->money = str_replace(",", "", $_POST['PaymentOutsourceContract']["money"]);
			    //$model->T = $_POST['PaymentOutsourceContract']["T"];
			    //$model->B = $_POST['PaymentOutsourceContract']["B"];
				$model->user_create = Yii::app()->user->ID;
				$model->user_update = Yii::app()->user->ID;
				//$model->user_create = Yii::app()->user->ID;
				// $t = $_POST["t_percent"];
				// $a = $_POST["a_percent"];
				
		

			 	// $modelPC = ProjectContract::model()->FindByPk($model->proj_id);
				// $modelPC->pc_T_percent = $t;
				// $modelPC->pc_A_percent = $a;
				// $modelPC->pc_user_update = Yii::app()->user->ID;
				// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
				// $modelPC->save();
				
				if($model->save())
				{
					
					$modelPC = OutsourceContract::model()->FindByPk($model->contract_id);
					// $modelPC->pc_T_percent = $t;
					// $modelPC->pc_A_percent = $a;
					// $modelPC->pc_user_update = Yii::app()->user->ID;
					// $modelPC->pc_last_update =  (date("Y")).date("-m-d H:i:s");
					// $modelPC->save();
					
					$update = 0;
					if($model->T > $modelPC->oc_T_percent)
					{
						$update = 1;
						$modelPC->oc_T_percent = $model->T;	
					}
					if($model->B > $modelPC->oc_A_percent)
					{
						$update = 1;
						$modelPC->oc_A_percent = $model->B;	
					}
					if($update==1)
					{
						$modelPC->oc_user_update = Yii::app()->user->ID;
					    $modelPC->oc_last_update =  (date("Y")).date("-m-d H:i:s");
					    $modelPC->save();
							
					}
					$this->redirect(array('index'));
				}
		}

		$this->render('update',array(
			'model'=>$model
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
		// $dataProvider=new CActiveDataProvider('PaymentOutsourceContract');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
		$model=new PaymentOutsourceContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentOutsourceContract']))
			$model->attributes=$_GET['PaymentOutsourceContract'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PaymentOutsourceContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentOutsourceContract']))
			$model->attributes=$_GET['PaymentOutsourceContract'];

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
		$model=PaymentOutsourceContract::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-outsource-contract-form')
		{
			echo CActiveForm::validate($model);
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
}
