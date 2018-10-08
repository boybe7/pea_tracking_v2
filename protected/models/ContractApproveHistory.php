<?php

/**
 * This is the model class for table "contract_approve_history".
 *
 * The followings are the available columns in table 'contract_approve_history':
 * @property integer $id
 * @property integer $contract_id
 * @property string $detail
 * @property string $dateApprove
 * @property string $approveBy
 * @property double $cost
 * @property string $timeSpend
 */
class ContractApproveHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contract_approve_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contract_id', 'required'),
			array('contract_id', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('detail', 'length', 'max'=>500),
			array('approveBy, timeSpend', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type,contract_id, detail, dateApprove, approveBy, cost, timeSpend,last_update', 'safe', 'on'=>'search,create,update'),
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
			'contract_id' => 'เลขที่สัญญา',
			'detail' => 'รายละเอียด',
			'dateApprove' => 'วันที่อนุมัติ',
			'approveBy' => 'อนุมัติโดย',
			'cost' => 'วงเงิน/เป็นเงินเพิ่ม',
			'timeSpend' => 'ระยะเวลาแล้วเสร็จ/ระยะเลาขอขยาย',
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
	public function searchByContractID($cid,$type) {

		$criteria=new CDbCriteria;
		$criteria->select = '*';
		//$criteria->join = 'JOIN foodType food ON foodtype = food.foodtype '; 
		$criteria->condition = "contract_id='$cid' AND type='$type' ";
		//$criteria->group = 'foodtype ';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('dateApprove',$this->dateApprove,true);
		$criteria->compare('approveBy',$this->approveBy,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('timeSpend',$this->timeSpend,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->dateApprove);
            if(count($str_date)>1)
            	$this->dateApprove = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
   
    }
    protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->dateApprove);
            if(count($str_date)>1)
            	$this->dateApprove = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            
    }
    public function beforeSave()
    {
        if($this->dateApprove!="")
        {

            $str_date = explode("/", $this->dateApprove);
            if(count($str_date)>1)
            $this->dateApprove= $str_date[2]."-".$str_date[1]."-".$str_date[0];

        }	

        return parent::beforeSave();
   }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractApproveHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
