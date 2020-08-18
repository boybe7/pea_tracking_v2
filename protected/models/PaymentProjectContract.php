<?php

/**
 * This is the model class for table "payment_project_contract".
 *
 * The followings are the available columns in table 'payment_project_contract':
 * @property integer $id
 * @property integer $proj_id
 * @property string $detail
 * @property double $money
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $bill_no
 * @property string $bill_date
 * @property integer $user_create
 * @property integer $user_update
 * @property string $last_update
 */
class PaymentProjectContract extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_project_contract';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('proj_id,invoice_alarm, invoice_no, invoice_date, user_create, user_update', 'required'),
			array('proj_id, user_create, user_update,T,A', 'numerical', 'integerOnly'=>true),
			array('money,invoice_alarm,invoice_alarm2', 'numerical'),
			array('invoice_no, bill_no', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, proj_id,T,A, detail,invoice_alarm,invoice_alarm2, money, invoice_no, invoice_date, bill_no, bill_date, user_create, user_update, last_update,fine_amount', 'safe', 'on'=>'search,update,delete'),
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
			'id' => 'id',
			'proj_id' => 'สัญญาโครงการ',
			'detail' => 'รายการ',
			'money' => 'ได้รับเงิน',
			'invoice_no' => 'เลขที่ใบแจ้งหนี้',
			'invoice_date' => 'วันที่ออกใบแจ้งหนี้',
			'invoice_alarm' => 'ชำระเงินภายใน (วัน) ครั้งที่ 1',
			'invoice_alarm2' => 'ชำระเงินภายใน (วัน) ครั้งที่ 2',
			'bill_no' => 'เลขที่ใบเสร็จรับเงิน',
			'bill_date' => 'วันที่ได้รับใบเสร็จรับเงิน',
			'user_create' => 'User Create',
			'user_update' => 'User Update',
			'last_update' => 'Last Update',
			'T'=>'%ความก้าวหน้าด้านเทคนิค (T)',
			'A'=>'%ความก้าวหน้าการเรียกเก็บเงิน (A)',
			'T%'=>'T%',
			'A%'=>'A%',
			'bill_no/date'=>'เลขที่ใบเสร็จรับเงิน/วันที่ได้รับ',
			'invoice_no/date'=>'เลขที่ใบแจ้งหนี้/วันที่ได้รับ',
			'fine_amount'=>'ค่าปรับ'
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
		$criteria->compare('proj_id',$this->proj_id);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('bill_date',$this->bill_date,true);
		$criteria->compare('user_create',$this->user_create);
		$criteria->compare('user_update',$this->user_update);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('T',$this->T);
		$criteria->compare('A',$this->A);
		$user_dept = Yii::app()->user->userdept;
		if(!Yii::app()->user->isExecutive())
		{
			$criteria->join = 'LEFT JOIN user ON user_create=user.u_id';
			$criteria->addCondition('user.department_id='.$user_dept);
		}	

		$sort = new CSort();
        $sort->attributes = array(
           
            '*', // this adds all of the other columns as sortable
        );

        $sort->defaultOrder = 'invoice_date asc';


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentProjectContract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
         if($this->money!="")
		 {
		     $this->money = str_replace(",", "", $this->money); 
		 }
		  

        $str_date = explode("/", $this->invoice_date);
        if(count($str_date)>1)
        	$this->invoice_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        $str_date = explode("/", $this->bill_date);
        if(count($str_date)>1)
        	$this->bill_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->invoice_date);
            if(count($str_date)>1)
            	$this->invoice_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
             $str_date = explode("-", $this->bill_date);
            if(count($str_date)>1)
            	$this->bill_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            //$this->visit_date=date('Y/m/d', strtotime(str_replace("-", "", $this->visit_date)));       
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->invoice_date);
        if(count($str_date)>1)
        	$this->invoice_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        $str_date = explode("/", $this->bill_date);
        if(count($str_date)>1)
        	$this->bill_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
            $this->money = number_format($this->money,2);

            $str_date = explode("-", $this->invoice_date);
            if($this->invoice_date=='0000-00-00')
            	$this->invoice_date = '';
            else if(count($str_date)>1)
            	$this->invoice_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
            
            $str_date = explode("-", $this->bill_date);
            if($this->bill_date=='0000-00-00')
            	$this->bill_date = '';
            else if(count($str_date)>1)
            	$this->bill_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
     }
}
