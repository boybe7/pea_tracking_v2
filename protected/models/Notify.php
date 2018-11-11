<?php

/**
 * This is the model class for table "notify".
 *
 * The followings are the available columns in table 'notify':
 * @property integer $id
 * @property string $project
 * @property string $contract
 * @property string $detail
 * @property string $date_end
 * @property string $url
 */
class Notify extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notify';
	}

	public function getNotify()
	{
		$current_date = (date("Y")+543).date("-m-d");

		$user_dept = Yii::app()->user->userdept;
	    $projectContractData=Yii::app()->db->createCommand("SELECT pj_id, pj_name as project,pc_code as contract,'แจ้งเตือนครบกำหนดค้ำประกันสัญญา' as alarm_detail,pc_garantee_date as date_end, CONCAT('project/update/',pj_id) as url,'1' as type, pc_id as update_id FROM project_contract pc LEFT JOIN project p ON pc.pc_proj_id=p.pj_id LEFT JOIN user ON p.pj_user_create=user.u_id WHERE DATEDIFF(pc_garantee_date,'".$current_date."')<=7  AND (pc_garantee_end='')  AND user.department_id='$user_dept'")->queryAll(); 
            
            $paymentProjectData=Yii::app()->db->createCommand("SELECT pj_name as project,pc_code as contract, 'ccแจ้งเตือนครบกำหนดชำระเงินของ vendor' as alarm_detail,DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ) as date_end, CONCAT('paymentProjectContract/update/',id) as url  FROM payment_project_contract pay_p LEFT JOIN project_contract ON pay_p.proj_id=pc_id LEFT JOIN project ON pc_proj_id=pj_id LEFT JOIN user ON project.pj_user_create=user.u_id  WHERE DATEDIFF(DATE_ADD( invoice_date, INTERVAL invoice_alarm
            DAY ),'".$current_date."')<=7  AND (bill_date='' OR bill_date='0000-00-00') AND user.department_id='$user_dept'")->queryAll(); 
    
            $paymentOutsourceData=Yii::app()->db->createCommand("SELECT pj_id,pj_name as project,oc_code as contract, 'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier' as alarm_detail,DATE_ADD( invoice_receive_date, INTERVAL 10
            DAY ) as date_end, CONCAT('paymentOutsourceContract/update/',id) as url,'3' as type, id as update_id FROM payment_outsource_contract pay_p LEFT JOIN outsource_contract ON pay_p.contract_id=oc_id LEFT JOIN project ON oc_proj_id=pj_id  LEFT JOIN user ON project.pj_user_create=user.u_id WHERE DATEDIFF('".$current_date."',invoice_receive_date)>=10  AND (approve_date='' OR approve_date='0000-00-00')  AND user.department_id='$user_dept'")->queryAll(); 


            if(date('d')>=20){

                $month = date("n");
                $number = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

                $lastDay = $number."/".$month."/".(date("Y")+543);

                $Criteria = new CDbCriteria();
                $Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id'; 
                $Criteria->condition = 'user.department_id = ' . $user_dept;
                $projects = Project::model()->findAll($Criteria);
                $mangementCostData1 = array();
                $mangementCostData2 = array();
                //print_r($Criteria);
                foreach ($projects as $key => $project) {
                    $pid = $project->pj_id;
                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=1 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 

                    //echo(count($records));
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement["project"] = $project->pj_name;//.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["url"] = "managementCost/create";
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่ารับรองประจำเดือน";
                        $mangementCostData1[] = $mangement;
                    }

                    $sql = "SELECT * FROM management_cost  WHERE '$month'=MONTH(mc_date)  AND mc_type=2 AND mc_proj_id='$pid' limit 1";
                    
                    $records = Yii::app()->db->createCommand($sql)->queryAll(); 
                    if(count($records)==0)
                    {
                        //$mProj = Project::model()->findbyPk($);
                        $mangement["project"] = $project->pj_name;//.':'.$project->pj_work_cat;
                        $mangement["contract"] = "";
                        $mangement["date_end"] = $lastDay;
                        $mangement["url"] = "managementCost/create";
                        $mangement["alarm_detail"] =  "แจ้งเตือนบันทึกค่าใช้จริงประจำเดือน";
                        $mangementCostData2[] = $mangement;
                    }   
                    
                }
                          
                    

                $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData,$mangementCostData1,$mangementCostData2);
            
            }  
            else
               $records=array_merge($projectContractData , $paymentProjectData, $paymentOutsourceData);
         
		
		return count($records);

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('project, contract, alarm_detail, date_end, url', 'required'),
			array('project, contract', 'length', 'max'=>700),
			array('url', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project, contract, alarm_detail, date_end, url,type', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'project' => 'โครงการ',
			'contract' => 'สัญญา',
			'alarm_detail' => 'ประเภทการเตือน',
			'date_end' => 'วันที่ครบกำหนด',
			'url' => 'link update',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('project',$this->project,true);
		$criteria->compare('contract',$this->contract,true);
		$criteria->compare('alarm_detail',$this->alarm_detail,true);
		//$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('url',$this->url,true);
		 // header('Content-type: text/plain');
	  //   print_r($this);
	  //   exit;
		
		if ( stripos( $this->date_end, '..') )
	    {
	        $range = explode( '..', $this->date_end );
	        $date_str = explode("/", $range[0]);
	        $range[0] = $date_str[2]."-".$date_str[1]."-".$date_str[0];
	        $date_str = explode("/", $range[1]);
	        $range[1] = $date_str[2]."-".$date_str[1]."-".$date_str[0];

	        $criteria->compare('date_end','>='.$range[0]);
	        $criteria->compare('date_end','<='.$range[1]);

	     
	      


	    }
	    else {
	    	
	    	$date_str = explode("/", $this->date_end);

	    	if(sizeof($date_str)==3)
	        	$this->date_end = $date_str[2]."-".$date_str[1]."-".$date_str[0];
	   
	    	$criteria->compare('date_end',$this->date_end);
	    }

		$sort = new CSort;
        $sort->defaultOrder = 'date_end ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>$sort,'pagination'=>array(
                        'pageSize'=>5,
                ),
		));
	}

	public function searchByType($type="")
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('project',$this->project,true);
		$criteria->compare('contract',$this->contract,true);
		$criteria->compare('alarm_detail',$this->alarm_detail,true);
		$criteria->compare('type',$type,true);
		$criteria->compare('url',$this->url,true);

		 // header('Content-type: text/plain');
	  //    print_r($this);
	  //    exit;

		if ( stripos( $this->date_end, '..') )
	    {
	        $range = explode( '..', $this->date_end );
	        $date_str = explode("/", $range[0]);
	        $range[0] = $date_str[2]."-".$date_str[1]."-".$date_str[0];
	        $date_str = explode("/", $range[1]);
	        $range[1] = $date_str[2]."-".$date_str[1]."-".$date_str[0];

	        $criteria->compare('date_end','>='.$range[0]);
	        $criteria->compare('date_end','<='.$range[1]);

	     
	    


	    }
	    else {
	    	$date_str = explode("/", $this->date_end);

	    	if(sizeof($date_str)==3)
	        	$this->date_end = $date_str[2]."-".$date_str[1]."-".$date_str[0];
	    	$criteria->compare('date_end',$this->date_end);
	    }

		$sort = new CSort;
        $sort->defaultOrder = 'date_end ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>$sort
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notify the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
