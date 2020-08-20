<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $pj_id
 * @property string $pj_name
 * @property integer $pj_vendor_id
 * @property integer $pj_work_cat
 * @property integer $pj_fiscalyear
 * @property string $pj_date_approved
 * @property integer $pj_user_create
 * @property integer $pj_user_update
 * @property integer $pj_cost
 */
class Project extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $workcat_search;
	public $sumcost = 0;
	public $manager_name;

	private $idCache;


	public function tableName()
	{
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pj_name,pj_status, pj_vendor_id, pj_work_cat, pj_fiscalyear, pj_user_create, pj_user_update,pj_manager_name,pj_manager_position,pj_director_name,pj_director_position', 'required'),
			array('pj_vendor_id, pj_work_cat, pj_fiscalyear, pj_user_create, pj_user_update', 'numerical', 'integerOnly'=>true),
			array('pj_name,pj_manager_name,pj_manager_position,pj_director_name,pj_director_position', 'length', 'max'=>400),
			array('pj_date_approved', 'safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pj_id,pj_status,cost, pj_name,pj_CA, pj_vendor_id, pj_work_cat, pj_fiscalyear, pj_date_approved, pj_user_create, pj_user_update,workcat_search,pj_close,pj_manager_name,pj_manager_position,pj_director_name,pj_director_position', 'safe', 'on'=>'search,create,update'),
		);
	}

	/**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'outsource' => array(self::HAS_MANY, 'OutsourceContract', 'oc_proj_id'),
            'contract' => array(self::HAS_MANY, 'ProjectContract', 'pc_proj_id'),
            'workcat' => array(self::BELONGS_TO, 'WorkCategory', 'pj_work_cat'),
            'user' => array(self::BELONGS_TO, 'User', 'pj_user_create'),

        );
    }

    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pj_id' => 'id project',
			'pj_name' => 'ชื่อโครงการ',
			'pj_vendor_id' => 'บริษัทที่ว่าจ้าง',
			'pj_work_cat' => 'ประเภทงาน',
			'pj_fiscalyear' => 'ปีงบประมาณ',
			'pj_date_approved' => 'วันที่อนุมัติ',
			'pj_user_create' => 'ผู้สร้างโครงการ',
			'pj_user_update' => 'ผู้บันทึก',
			'pj_CA' => 'หมายเลข CA',
			'cost'=> 'วงเงินรวม(ไม่รวมภาษีมูลค่าเพิ่ม)',
			'pj_status'=>'แล้วเสร็จ',
			'pj_close'=>'เลขที่หนังสือปิดโครงการ/วันที่',
			'pj_manager_name'=>'ผู้จัดการโครงการ',
			'pj_manager_position'=>'ตำแหน่ง',
			'pj_director_name'=>'ผู้อำนวยการโครงการ',
			'pj_director_position'=>'ตำแหน่ง'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pj_id',$this->pj_id);
		//$criteria->compare('cost',$this->sumcost);
		$criteria->compare('pj_name',$this->pj_name,true);
		$criteria->compare('pj_vendor_id',$this->pj_vendor_id);
		$criteria->compare('pj_work_cat',$this->pj_work_cat);
		$criteria->compare('pj_fiscalyear',$this->pj_fiscalyear);
		$criteria->compare('pj_date_approved',$this->pj_date_approved,true);
		$criteria->compare('pj_user_create',$this->pj_user_create);
		$criteria->compare('pj_user_update',$this->pj_user_update);
		$criteria->compare('pj_CA',$this->pj_CA,true);
		$criteria->compare('pj_status',$this->pj_status,true);
		$criteria->compare('pj_close',$this->pj_close,true);
		$criteria->compare('workcat.wc_name',$this->workcat_search);
		$user_dept = Yii::app()->user->userdept;
		if(!Yii::app()->user->isExecutive())
		{
			$criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id';
			$criteria->addCondition('user.department_id='.$user_dept);
		}	
		$sort=new CSort;
                $sort->attributes=array(
                        
                        '*',
                        'cost'=>array(
                                'asc'=>'cost DESC',
                                'desc'=>'cost ASC',
                        ),
                );
        $criteria->order = 'pj_fiscalyear DESC,pj_id DESC';        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}

	public function searchManager()
	{
		
		$criteria = new CDbCriteria;
		$searchterm = empty($searchterm) ? trim(Yii::app()->request->getParam('manager_name')) : $searchterm;		    
		$searchterm = htmlspecialchars($searchterm, ENT_QUOTES);
		if (!empty($searchterm)) {
		        $criteria->addCondition(' (t.pj_manager_name like "%' . $searchterm . '%" OR
		              t.pj_director_name like "%' . $searchterm . '%" ) ');
		} 

	
		  
		    return new CActiveDataProvider($this, array(
		        'criteria' => $criteria,
		        'pagination' => array(
		            'pagesize' => 25,
		        )
		    ));

	}


	public function getCost(){
	     	$sum = 0;
	     	foreach($this->getRelated('contract') as $projectCost)
   			{
     			ProjectContract::model()->findByPk($projectCost->pc_id);
     			$sum += $projectCost->pc_cost;
   			}
    		return $sum;
	}

	public function getIncome($dateCon){
	     	$sum = 0;
	     	foreach($this->getRelated('contract') as $ProjectContract)
   			{
     			
     			$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('project_contract','proj_id=pc_id')
                                            ->where("pc_id='$ProjectContract->pc_id' AND bill_date!='' AND bill_date!='0000-00-00' AND bill_date ".$dateCon)
                                            ->queryAll();
                        //echo $pp[0]["sum"];
                $sum += $pp[0]["sum"];
     			
   			}
    		return $sum;
	}

	public function getOutcome($dateCon){
	     	$sum = 0;
	     	//header('Content-type: text/plain');
	     	foreach($this->getRelated('outsource') as $OutsourceContract)
   			{

     			$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_id='$OutsourceContract->oc_id' AND approve_date!='' AND approve_date!='0000-00-00' AND approve_date ".$dateCon)
                                            ->queryAll();
                        //echo $pp[0]["sum"];

                $sum += $pp[0]["sum"];
                  
                //echo($OutsourceContract->oc_id.":".$sum."<br>");                    
                
     			
   			}
   			//exit;
    		return $sum;
	}

	public function getManageCost($dateCon)
	{
			$sum = 0;

	     	//management
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$this->pj_id' AND mc_type!=0 AND mc_date ".$dateCon)
                                            ->queryAll();
                        $sum = $pp[0]["sum"];
   			//exit;
    		return $sum;
	}

	protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->pj_date_approved);
            if(count($str_date)>1)
            	$this->pj_date_approved = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
            
            if($this->pj_date_approved == "00/00/543")
                $this->pj_date_approved = '';

            $this->pj_status =  $this->pj_status==1 ? "อยู่ระหว่างดำเนินการ" : "แล้วเสร็จ";
            	

            foreach($this->getRelated('contract') as $projectCost)
   			{

		 	    $costChange = 0;
		 	    $modelTemps = Yii::app()->db->createCommand()
						                    ->select('*')
						                    ->from('contract_change_history')
						                    ->where('contract_id=:id AND type=1', array(':id'=>$projectCost->pc_id))
						                    ->queryAll();
			    if(!empty($modelTemps))
			    foreach ($modelTemps as $key => $mTemp) {
			    	$costChange += $mTemp['cost'];
			    }
     			
     			$this->sumcost += $projectCost->pc_cost + $costChange;
   			}
    }
    protected function afterSave(){
            parent::afterSave();
            $this->pj_status =  $this->pj_status==1 ? "อยู่ระหว่างดำเนินการ" : "แล้วเสร็จ";
            
            $str_date = explode("-", $this->pj_date_approved);
            if(count($str_date)>1)
            	$this->pj_date_approved = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            
    }
    public function beforeSave()
    {
        if($this->pj_date_approved!="")
        {

            $str_date = explode("/", $this->pj_date_approved);
            if(count($str_date)>1)
            $this->pj_date_approved= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

        }	

        return parent::beforeSave();
   }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeDelete()
	{
	 $this->idCache = $this->pj_id;
	 
	 return parent::beforeDelete();
	}

	public function afterDelete()
	{
		 $criteria = new CDbCriteria(array(
		   'condition' => 'pc_proj_id=:projectId',
		   'params' => array(
		    ':projectId' => $this->idCache),
		  ));
		 
		 $contracts_associated_with_project = ProjectContract::model()->findAll($criteria);
		 
		 foreach ($contracts_associated_with_project as $contract)
		 {
		    $contract->delete();
		 }
		  
		 //ProjectContract::model()->deleteAll("pc_proj_id ='" . $this->idCache . "'");
		 $criteria = new CDbCriteria(array(
		   'condition' => 'oc_proj_id=:projectId',
		   'params' => array(
		    ':projectId' => $this->idCache),
		  ));
		 
		 $contracts_associated_with_project = OutsourceContract::model()->findAll($criteria);
		 
		 foreach ($contracts_associated_with_project as $contract)
		 {
		    $contract->delete();
		 }

		 WorkCode::model()->deleteAll("pj_id ='" . $this->idCache . "'");

		 ManagementCost::model()->deleteAll("mc_proj_id ='" . $this->idCache . "'");

		 
		  
		 // $filename=$this->getImagePath($this->idCache);
		 // if(file_exists($filename))
		 // {
		 //  unlink($filename);
		 // }
		 
		 parent::afterDelete();
	}


}
