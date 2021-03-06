<?php

class ManagementCostController extends Controller
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
				'actions'=>array('admin','delete','create','createPayReal','createPayCon','update','DeleteSelected'),
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
	public function actionCreate($id="")
	{
		$model=new ManagementCost("search");

		if($id!="")
			$model->mc_proj_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagementCost']))
		{
			$model->attributes=$_POST['ManagementCost'];

			
			$model->mc_user_update = Yii::app()->user->ID;
			if(empty($_POST['ManagementCost']['mc_date']))
			     $model->mc_date = (date("Y")).date("-m-d");	
			$model->mc_type = 1;

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,'id'=>$id
		));
	}

	public function actionCreatePayReal($id)
	{
		$model=new ManagementCost("search");
		$model->mc_type = 2;
		$model->mc_proj_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagementCost']))
		{
			$model->attributes=$_POST['ManagementCost'];

			$model->mc_date = (date("Y")).date("-m-d");
			$model->mc_user_update = Yii::app()->user->ID;

			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('createByNotify',array(
			'model'=>$model
		));
	}

	public function actionCreatePayCon($id)
	{
		$model=new ManagementCost("search");
		$model->mc_type = 1;
		$model->mc_proj_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagementCost']))
		{
			$model->attributes=$_POST['ManagementCost'];

			$model->mc_date = (date("Y")).date("-m-d");
			$model->mc_user_update = Yii::app()->user->ID;

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('createByNotify',array(
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
		//$model2=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagementCost']))
		{
			$model->attributes=$_POST['ManagementCost'];
			
			$model->mc_requester = $_POST['ManagementCost']['mc_requester'];
			$model->mc_letter_approve = $_POST['ManagementCost']['mc_letter_approve'];
			$model->mc_letter_request = $_POST['ManagementCost']['mc_letter_request'];
			$model->mc_approve_cost = $_POST['ManagementCost']['mc_approve_cost'];
			$model->mc_approver = $_POST['ManagementCost']['mc_approver'];
		
			if($model->save())
				$this->redirect(array('index'));
		}
		else{
			$model->mc_approve_cost = number_format($model->mc_approve_cost,2);
			$model->mc_cost = number_format($model->mc_cost,2);
		}

		$this->render('update',array(
			'model'=>$model,
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
		$model=new ManagementCost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ManagementCost']))
			$model->attributes=$_GET['ManagementCost'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ManagementCost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ManagementCost']))
			$model->attributes=$_GET['ManagementCost'];

		$this->render('admin',array(
			'model'=>$model,
		));
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ManagementCost::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='management-cost-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
