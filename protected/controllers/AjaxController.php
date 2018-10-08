
<?php
class AjaxController extends Controller {


     public function actionGetProjectList() {        
    
        
       

        $user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
        {

            if( $_POST['workcat_id']!='' && $_POST['year']!='') 
                $data = Project::model()->findAll('pj_work_cat=:id AND pj_fiscalyear=:year', array(':id' => (int) $_POST['workcat_id'],':year'=>(int)$_POST['year']));        
            else if( $_POST['workcat_id']!='' && $_POST['year']=='') 
                $data = Project::model()->findAll('pj_work_cat=:id', array(':id' => (int) $_POST['workcat_id']));        
            else if($_POST['workcat_id']=='' && $_POST['year']!='') 
                $data = Project::model()->findAll(array('join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat','condition'=>'pj_fiscalyear='.(int)$_POST['year'].' AND user.department_id='.$user_dept)); 
            else    
                $data = Project::model()->findAll(array('join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat','condition'=>'user.department_id='.$user_dept));

        }
        else
        {
            if( $_POST['workcat_id']!='' && $_POST['year']!='') 
            $data = Project::model()->findAll('pj_work_cat=:id AND pj_fiscalyear=:year', array(':id' => (int) $_POST['workcat_id'],':year'=>(int)$_POST['year']));        
           else if( $_POST['workcat_id']!='' && $_POST['year']=='') 
            $data = Project::model()->findAll('pj_work_cat=:id', array(':id' => (int) $_POST['workcat_id']));        
           else if($_POST['workcat_id']=='' && $_POST['year']!='') 
            $data = Project::model()->findAll('pj_fiscalyear=:year', array(':year'=>(int)$_POST['year']));        
           else    
            $data = Project::model()->findAll();

         }    
         // header('Content-type: text/plain');
         //   if(isset($_POST["workcat_id"]))
         //     echo "work";
         //   if(isset($_POST["year"]) && $_POST["year"]!='')
         //     echo "year";
                                                 
         // exit;
        
        $data = CHtml::listData($data, 'pj_id', 'pj_name');
        
        if(empty($data))
             echo CHtml::tag('option', array('value' => ''), CHtml::encode(""), true);
        else
             echo CHtml::tag('option', array('value' => ''), CHtml::encode("ทั้งหมด"), true);
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionGetProjectList2() {        
    
        $user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
        {
        
           if( $_POST['workcat_id']!='' && $_POST['year']!='') 
            $data = Project::model()->findAll('pj_work_cat=:id AND pj_fiscalyear=:year', array(':id' => (int) $_POST['workcat_id'],':year'=>(int)$_POST['year']));        
           else if( $_POST['workcat_id']!='' && $_POST['year']=='') 
            $data = Project::model()->findAll('pj_work_cat=:id', array(':id' => (int) $_POST['workcat_id']));        
           else if($_POST['workcat_id']=='' && $_POST['year']!='') 
              $data = Project::model()->findAll(array('join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat','condition'=>'pj_fiscalyear='.(int)$_POST['year'].' AND user.department_id='.$user_dept));        
           else    
            $data = array();
         }
        else
        {

            if( $_POST['workcat_id']!='' && $_POST['year']!='') 
            $data = Project::model()->findAll('pj_work_cat=:id AND pj_fiscalyear=:year', array(':id' => (int) $_POST['workcat_id'],':year'=>(int)$_POST['year']));        
           else if( $_POST['workcat_id']!='' && $_POST['year']=='') 
            $data = Project::model()->findAll('pj_work_cat=:id', array(':id' => (int) $_POST['workcat_id']));        
           else if($_POST['workcat_id']=='' && $_POST['year']!='') 
            $data = Project::model()->findAll('pj_fiscalyear=:year', array(':year'=>(int)$_POST['year']));        
           else    
            $data = array();

        } 



         if(empty($data))
             echo CHtml::tag('option', array('value' => ''), CHtml::encode(""), true);
        else
             echo CHtml::tag('option', array('value' => ''), CHtml::encode("ทั้งหมด"), true);
        $data = CHtml::listData($data, 'pj_id', 'pj_name');
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

       
    }
 
    
    public function actionGetUnit() {        
    //Fetch all city name and id from state_id
        
        $data = Yii::app()->db->createCommand()
                                        ->select('unit,drug_id')
                                        ->from('drug')
                                        ->where('drug_name=:id', array(":id"=>$_POST['drug_id']))
                                        ->queryAll();
    //Passing city id and city name to list data which generates the data suitable for list-based HTML elements
          echo  CHtml::encode($data[0]["unit"].":".$data[0]["drug_id"]);
        // echo CHtml::hiddenField('drug_code',$_POST['drug_id'],array('class'=>'span12','readonly'=>true));
        //  echo CHtml::textField('unit',$data[0]["unit"],array('class'=>'span12','readonly'=>true));
    }
    
    public function actionGetDrug(){
            $request=trim($_GET['term']);
            $type=trim($_GET['type']);
        
            $model=Drug::model()->findAll(array("condition"=>"drug_name like '$request%' and drug_type_id ='$type' "));
            $data=array();
            foreach($model as $get){
                $data[]["label"]=$get->drug_name;
                $data[]["id"]=$get->drug_id;
            }
            $this->layout='empty';
            echo json_encode($data);
        
    }
    
    public function actionGetDiag(){
            $request=trim($_GET['term']);
            $model=  Diagnosis::model()->findAll(array("condition"=>"name like '$request%' order by name"));
            $data=array();
            foreach($model as $get){
                $data[]["label"]=$get->name;
                $data[]["code"]=$get->code;
            }
            $this->layout='empty';
            echo json_encode($data);
        
    }
    
    public function actionGetDiagCode(){
             $data = Yii::app()->db->createCommand()
                                        ->select('code,id')
                                        ->from('diagnosis')
                                        ->where('name=:id', array(":id"=>$_POST['name']))
                                        ->queryAll();
   
          echo  CHtml::encode($data[0]["code"].":".$data[0]["id"]);
        
    }
	
	public function actionGetDrugMethod(){
            $request=trim($_GET['term']);
           
        
            $model=DrugMethod::model()->findAll(array("condition"=>"name like '$request%' "));
            $data=array();
            foreach($model as $get){
                $data[]["label"]=$get->name;
                $data[]["id"]=$get->id;
            }
            $this->layout='empty';
            echo json_encode($data);
        
    }
}
?>