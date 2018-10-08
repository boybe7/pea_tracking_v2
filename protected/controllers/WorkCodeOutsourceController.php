<?php

class WorkCodeOutsourceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('create','update','updateTemp','createPO','createPOTemp','deleteTemp','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'expression'=>'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreatePO($id)
	{
		 $model=new WorkCodeOutsource("search");

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		if(isset($_POST['WorkCodeOutsource']))
		{
			$model->attributes=$_POST['WorkCodeOutsource'];
			$model->contract_id = $id;			
			if (Yii::app()->request->isAjaxRequest)
	        {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_form', array('model'=>$model,'index'=>$id), true)));
	                
	            exit;
				        
	        }		
			

		}

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model,'index'=>$id), true)));
            exit;               
        }

		$this->renderPartial('_form',array('model'=>$model,'index'=>$id));
	}


	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WorkCodeOutsource;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkCodeOutsource']))
		{
			$model->attributes=$_POST['WorkCodeOutsource'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['WorkCodeOutsource']))
		{
			$model->attributes=$_POST['WorkCodeOutsource'];
			//$model->last_update =  (date("Y")+543).date("-m-d H:i:s");
			if (Yii::app()->request->isAjaxRequest)
	         {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_form', array('model'=>$model), true)));
	                
	            exit;
			}	        
	        	//$this->redirect(array('admin'));

		}

		$this->renderPartial('_form',array('model'=>$model));
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

	public function actionDeleteTemp($id)
	{
		$model = WorkcodeOutsourceTemp::model()->findByPk($id);
		$model->delete();

	}

	public function actionCreatePOTemp($id)
	{
	

		 $model=new WorkCodeOutsourceTemp("search");

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		if(isset($_POST['WorkCodeOutsource']))
		{
			$model->attributes=$_POST['WorkCodeOutsource'];
			$model->contract_id = $id;
			$model->u_id = Yii::app()->user->ID;
			
			if (Yii::app()->request->isAjaxRequest)
	        {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_form', array('model'=>$model,'index'=>$id), true)));
	                
	            exit;
				        
	        }		
			else
			  if($model->save())
				$this->redirect(array('admin'));

		}

		if(isset($_POST['WorkCodeOutsourceTemp']))
		{
			$model->attributes=$_POST['WorkCodeOutsourceTemp'];
			$model->contract_id = $id;
			$model->u_id = Yii::app()->user->ID;
			
			if (Yii::app()->request->isAjaxRequest)
	        {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_form', array('model'=>$model,'index'=>$id), true)));
	                
	            exit;
				        
	        }		
			else
			  if($model->save())
				$this->redirect(array('admin'));

		}


		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model,'index'=>$id), true)));
            exit;               
        }

		$this->renderPartial('_form',array('model'=>$model,'index'=>$id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('WorkCodeOutsource');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionUpdateTemp($id)
	{
		$model=WorkCodeOutsourceTemp::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkCodeOutsourceTemp']))
		{
			$model->attributes=$_POST['WorkCodeOutsourceTemp'];
			//$model->contract_id = $id;
			$model->u_id = Yii::app()->user->ID;
            //$model->type = 1;
			 if (Yii::app()->request->isAjaxRequest)
	         {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	            {	
	            	
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_form', array('model'=>$model), true)));
	            }    
	            exit;
			}	        
	        	//$this->redirect(array('admin'));

		}

		$this->renderPartial('_form',array('model'=>$model));

	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WorkCodeOutsource('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WorkCodeOutsource']))
			$model->attributes=$_GET['WorkCodeOutsource'];

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
		$model=WorkCodeOutsource::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='work-code-outsource-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
