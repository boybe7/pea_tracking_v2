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
		$model=new PaymentProjectContract("search");
		$t = 0;
		$a = 0;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

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
			

			if($model->save())
			{
				$modelPC = ProjectContract::model()->FindByPk($model->proj_id);
				// $modelPC->pc_T_percent = $t;
				// $modelPC->pc_A_percent = $a;
				// $modelPC->pc_user_update = Yii::app()->user->ID;
				// $modelPC->pc_last_update =  (date("Y")+543).date("-m-d H:i:s");
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
				    $modelPC->pc_last_update =  (date("Y")+543).date("-m-d H:i:s");
				    $modelPC->save();
						
				}

				$this->redirect(array('admin'));
			}	
			else
				$model->money = $_POST['PaymentProjectContract']["money"];
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
				
		

			 	// $modelPC = ProjectContract::model()->FindByPk($model->proj_id);
				// $modelPC->pc_T_percent = $t;
				// $modelPC->pc_A_percent = $a;
				// $modelPC->pc_user_update = Yii::app()->user->ID;
				// $modelPC->pc_last_update =  (date("Y")+543).date("-m-d H:i:s");
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
					// $modelPC->pc_last_update =  (date("Y")+543).date("-m-d H:i:s");
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
					    $modelPC->pc_last_update =  (date("Y")+543).date("-m-d H:i:s");
					    $modelPC->save();
							
					}
					$this->redirect(array('admin'));
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
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $this->loadModel($autoId)->delete();
            }
        }    
    }
}
