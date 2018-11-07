<?php

class OutsourceContractController extends Controller
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
				'actions'=>array('create','update','GetContract','delete'),
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

	public function actionGetContract(){
            $request=trim($_GET['term']);
                    
            //$models=OutsourceContract::model()->findAll(array("condition"=>"oc_code like '$request%'"));
            $Criteria = new CDbCriteria();
			$user_dept = Yii::app()->user->userdept;
			$Criteria->join = 'LEFT JOIN project ON oc_proj_id=project.pj_id LEFT JOIN user ON oc_user_create=user.u_id  LEFT JOIN vendor ON oc_vendor_id=vendor.v_id';
			//$Criteria->condition = "(oc_code like '$request%') AND department_id='$user_dept'";

			$search_str = preg_split('/\s+/', $request, -1, PREG_SPLIT_NO_EMPTY);
            if(sizeof($search_str)==2)
			{
				$Criteria->condition = "(pj_fiscalyear LIKE '%$search_str[0]%' OR vendor.v_name LIKE '%$search_str[0]%') AND (pj_fiscalyear LIKE '%$search_str[1]%' OR vendor.v_name LIKE '%$search_str[1]%') AND  department_id='$user_dept'";
			}
			else
				$Criteria->condition = "(pj_fiscalyear LIKE '%$request%' OR oc_code like '%$request%' OR vendor.v_name like '%$request%') AND department_id='$user_dept'";
			$models = OutsourceContract::model()->findAll($Criteria);

            $data=array();
            foreach($models as $model){
                //$data[]["label"]=$get->v_name;
                //$data[]["id"]=$get->v_id;
                
                $modelVendor = Vendor::model()->FindByPk($model['oc_vendor_id']);
                $modelProject = Project::model()->FindByPk($model['oc_proj_id']);

                $data2 = Yii::app()->db->createCommand()
										->select('sum(cost) as sum')
										->from('contract_change_history')
										->where('contract_id=:id AND type=2', array(':id'=>$model['oc_id']))
										->queryAll();
											                        
				$change = $data2[0]["sum"]; 
                
                // header('Content-type: text/plain');
                //              print_r($model["oc_cost"]);                    
                //  exit;
                $oc_cost = str_replace(",", "", $model['oc_cost']) + $change;
                $data[] = array(
                        'id'=>$model['oc_id'],
                        'label'=>'ปี '.$modelProject->pj_fiscalyear.":".$model['oc_code'].' '.$modelVendor->v_name,
                        'cost'=>number_format($oc_cost,2)
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OutsourceContract;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OutsourceContract']))
		{
			$model->attributes=$_POST['OutsourceContract'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->oc_id));
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

		if(isset($_POST['OutsourceContract']))
		{
			$model->attributes=$_POST['OutsourceContract'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->oc_id));
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
		if (Yii::app()->request->isAjaxRequest)
	    {
	           
	            if($this->loadModel($id)->delete())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure'));
	                
	            exit;
				        
	   }		

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
		$dataProvider=new CActiveDataProvider('OutsourceContract');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OutsourceContract('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OutsourceContract']))
			$model->attributes=$_GET['OutsourceContract'];

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
		$model=OutsourceContract::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='outsource-contract-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
