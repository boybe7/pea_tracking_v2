<?php

/**
 * This is the model class for table "guarantee".
 *
 * The followings are the available columns in table 'guarantee':
 * @property integer $id
 * @property string $guarantee_no
 * @property integer $contract_id
 * @property string $letter_confirm
 * @property string $cost
 * @property string $guarantee_date
 * @property string $letter_return
 */
class Guarantee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'guarantee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guarantee_no, contract_id,cost, guarantee_date', 'required'),
			array('contract_id', 'numerical', 'integerOnly'=>true),
			array('guarantee_no, letter_confirm', 'length', 'max'=>200),
			array('cost', 'length', 'max'=>15),
			array('letter_return', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, guarantee_no, contract_id, letter_confirm, cost, guarantee_date, letter_return', 'safe', 'on'=>'search'),
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
			'guarantee_no' => 'หนังสือค้ำประกันสัญญา',
			'contract_id' => 'สัญญา',
			'letter_confirm' => 'หนังสือยืนยันค้ำประกันสัญญา',
			'cost' => 'วงเงินค้ำประกัน',
			'guarantee_date' => 'วันที่ครบกำหนดประกันสัญญา',
			'letter_return' => 'เลขที่บันทึกส่งคืนหนังสือค้ำประกันส่งกองการเงิน/วันที่',
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
		$criteria->compare('guarantee_no',$this->guarantee_no,true);
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('letter_confirm',$this->letter_confirm,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('guarantee_date',$this->guarantee_date,true);
		$criteria->compare('letter_return',$this->letter_return,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Guarantee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->guarantee_date);
            if(count($str_date)>1)
            	$this->guarantee_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);

            if($this->guarantee_date == "00/00/0000")
                $this->guarantee_date = '-';
   
    }
    protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->guarantee_date);
            if(count($str_date)>1)
            	$this->guarantee_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            
    }
    public function beforeSave()
    {
        if($this->guarantee_date!="")
        {

            $str_date = explode("/", $this->guarantee_date);
            if(count($str_date)>1)
            $this->guarantee_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

        }	

        return parent::beforeSave();
   }

	public function searchByContractID($cid) {

		$criteria=new CDbCriteria;
		$criteria->select = '*';
		$criteria->condition = "contract_id='$cid'";
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
