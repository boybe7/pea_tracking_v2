<?php

/**
 * This is the model class for table "contract_change_history_temp".
 *
 * The followings are the available columns in table 'contract_change_history_temp':
 * @property integer $id
 * @property string $ref_no
 * @property string $detail
 * @property double $cost
 * @property integer $type
 */
class ContractChangeHistoryTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contract_change_history_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cost, type,u_id,contract_id', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('ref_no', 'length', 'max'=>255),
			array('detail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,u_id, ref_no, detail, cost, type,contract_id', 'safe', 'on'=>'search'),
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
			'ref_no' => 'เลขที่หนังสืออ้างอิง',
			'detail' => 'รายละเอียด',
			'cost' => 'จำนวนเงินเพิ่ม/ลด',
			'type' => 'ประเภทสัญญา',
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
		$criteria->compare('ref_no',$this->ref_no,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractChangeHistoryTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchByUser($cid,$type,$uid) {

		$criteria=new CDbCriteria;
		$criteria->select = '*';
		//$criteria->join = 'JOIN foodType food ON foodtype = food.foodtype '; 
		$criteria->condition = "contract_id='$cid' AND type='$type' AND u_id='$uid'";
		//$criteria->group = 'foodtype ';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
