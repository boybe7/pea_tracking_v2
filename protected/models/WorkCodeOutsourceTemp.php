<?php

/**
 * This is the model class for table "work_code_outsource_temp".
 *
 * The followings are the available columns in table 'work_code_outsource_temp':
 * @property integer $id
 * @property string $PO
 * @property integer $contract_id
 * @property string $letter
 * @property double $money
 * @property integer $u_id
 */
class WorkCodeOutsourceTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'work_code_outsource_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PO, contract_id', 'required'),
			array('contract_id, u_id', 'numerical', 'integerOnly'=>true),
			array('money', 'numerical'),
			array('PO, letter', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, PO, contract_id, letter, money, u_id', 'safe', 'on'=>'search'),
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
			'PO' => 'เลขที่ PO',
			'contract_id' => 'id สัญญา',
			'letter' => 'เลขที่ส่งแจ้งรับรองงบ กปง.',
			'money' => 'จำนวนเงิน',
			'u_id' => 'U',
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
		$criteria->compare('PO',$this->PO,true);
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('letter',$this->letter,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('u_id',$this->u_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByUser($cid,$uid) {

		$criteria=new CDbCriteria;
		$criteria->select = '*';
		//$criteria->join = 'JOIN foodType food ON foodtype = food.foodtype '; 
		$criteria->condition = "contract_id='$cid' AND u_id='$uid'";
		//$criteria->group = 'foodtype ';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkCodeOutsourceTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
