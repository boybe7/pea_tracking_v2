<?php

class OutsourceSubcontractController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreateTemp($id)
	{
	

		 $model=new OutsourceSubcontractTemp;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		if(isset($_POST['OutsourceSubcontractTemp']))
		{
			$model->attributes=$_POST['OutsourceSubcontractTemp'];
			$model->oc_id = $id;
			$model->u_id = Yii::app()->user->ID;
		
			if (Yii::app()->request->isAjaxRequest)
	        {
	           
	            if($model->save())
	            	 echo CJSON::encode(array(
	                'status'=>'success'
	                ));
	            else
	                echo CJSON::encode(array(
	                'status'=>'failure','div'=>$this->renderPartial('_formTemp', array('model'=>$model,'index'=>$id), true)));
	                
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
                'div'=>$this->renderPartial('_formTemp', array('model'=>$model,'index'=>$id), true)));
            exit;               
        }

		$this->renderPartial('_formTemp',array('model'=>$model,'index'=>$id));
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}