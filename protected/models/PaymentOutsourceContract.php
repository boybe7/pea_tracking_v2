<?php

/**
 * This is the model class for table "payment_outsource_contract".
 *
 * The followings are the available columns in table 'payment_outsource_contract':
 * @property integer $id
 * @property integer $contract_id
 * @property string $detail
 * @property double $money
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $approve_date
 * @property integer $user_create
 * @property integer $user_update
 * @property string $last_update
 */
class PaymentOutsourceContract extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_outsource_contract';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contract_id, money, invoice_receive_date, invoice_no', 'required'),
			array('contract_id, user_create, user_update', 'numerical', 'integerOnly'=>true),
			array('money', 'numerical'),
			array('invoice_no', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,approve_by, contract_id, invoice_receive_date,invoice_send_date,T,B, detail, money, invoice_no, approve_date, user_create, user_update, last_update', 'safe', 'on'=>'search,create,update'),
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
			'contract_id' => 'สัญญา',
			'detail' => 'รายการ',
			'money' => 'จ่ายเงิน',
			'invoice_no' => 'เลขที่ใบแจ้งหนี้',
			'invoice_receive_date' => 'วันที่ได้รับใบแจ้งหนี้',
			'invoice_send_date' => 'วันที่ออกใบแจ้งหนี้',
			'approve_date' => 'วันที่อนุมัติจ่าย',
			'user_create' => 'User Create',
			'user_update' => 'User Update',
			'last_update' => 'Last Update',
			'T'=>'%ความก้าวหน้าด้านเทคนิค (T)',
			'B'=>'%ความก้าวหน้าการจ่ายเงิน (B)',
			'T%'=>'T%',
			'B%'=>'B%',
			'bill_no/date'=>'เลขที่ใบเสร็จรับเงิน/วันที่ได้รับ',
			'invoice_no/date'=>'เลขที่ใบแจ้งหนี้/วันที่ได้รับ',
			'approve_by'=>'อนุมัติโดย'
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
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('invoice_receive_date',$this->invoice_receive_date,true);
		$criteria->compare('invoice_send_date',$this->invoice_send_date,true);
		$criteria->compare('approve_date',$this->approve_date,true);
		$criteria->compare('user_create',$this->user_create);
		$criteria->compare('user_update',$this->user_update);
		$criteria->compare('last_update',$this->last_update,true);
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
        $sort->defaultOrder = 'invoice_receive_date asc';


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentOutsourceContract the static model class
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
		  

        $str_date = explode("/", $this->invoice_send_date);
        if(count($str_date)>1)
        	$this->invoice_send_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        $str_date = explode("/", $this->invoice_receive_date);
        if(count($str_date)>1)
        	$this->invoice_receive_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];

        $str_date = explode("/", $this->approve_date);
        if(count($str_date)>1)
        	$this->approve_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        return parent::beforeSave();
   }

   public function beforeFind()
    {
          

        $str_date = explode("/", $this->invoice_send_date);
        if(count($str_date)>1)
        	$this->invoice_send_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        $str_date = explode("/", $this->invoice_receive_date);
        if(count($str_date)>1)
        	$this->invoice_receive_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];

        $str_date = explode("/", $this->approve_date);
        if(count($str_date)>1)
        	$this->approve_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->invoice_send_date);
            if(count($str_date)>1)
            	$this->invoice_send_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);

            $str_date = explode("-", $this->invoice_receive_date);
            if(count($str_date)>1)
            	$this->invoice_receive_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
             $str_date = explode("-", $this->approve_date);
            if(count($str_date)>1)
            	$this->approve_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            //$this->visit_date=date('Y/m/d', strtotime(str_replace("-", "", $this->visit_date)));       
    }

	protected function afterFind(){
            parent::afterFind();
            $this->money = number_format($this->money,2);
            $str_date = explode("-", $this->invoice_send_date);
            if($this->invoice_send_date=='0000-00-00')
            	$this->invoice_send_date = '';
            else if(count($str_date)>1)
            	$this->invoice_send_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            $str_date = explode("-", $this->invoice_receive_date);
            if($this->invoice_receive_date=='0000-00-00')
            	$this->invoice_receive_date = '';
            else if(count($str_date)>1)
            	$this->invoice_receive_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            $str_date = explode("-", $this->approve_date);
            if($this->approve_date=='0000-00-00')
            	$this->approve_date = '';
            else if(count($str_date)>1)
            	$this->approve_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
     }
}
