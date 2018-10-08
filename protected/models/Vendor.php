<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property integer $v_id
 * @property string $v_name
 * @property string $v_address
 * @property integer $v_tax_id
 * @property string $v_tel
 * @property string $v_contractor
 */
class Vendor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
    public $type_id;
    

	public function tableName()
	{
		return 'vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('v_name,type', 'required'),
			array('v_tax_id', 'numerical', 'integerOnly'=>true),
			//array('v_tax_id', 'length', 'min'=>13,'max'=>13,'tooLong'=>"{attribute} ต้องมี 13 ตัวเลข.",'tooShort'=>"{attribute} ต้องมี 13 ตัวเลข"),
		
			array('v_name', 'length', 'max'=>200),
			array('v_tel', 'length', 'max'=>25),
			array('v_contractor', 'length', 'max'=>100),
			 array('v_tax_id', 'unique',"message"=>"ข้อมูลซ้ำ",'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('v_id, v_name, v_address, v_tax_id, v_tel, v_contractor,type,v_BP', 'safe', 'on'=>'search'),
		);
	}

	

	public function beforeSave()
    {
    	    

            return parent::beforeSave();
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
		$bp_label ='หมายเลข BP';
		if($this->type_id==1)
		$bp_label = 'หมายเลข Vendor';
		return array(
			'v_id' => 'id คู่สัญญา',
			'v_name' => 'ชื่อบริษัท',
			'v_address' => 'ที่อยู่',
			'v_tax_id' => 'เลขประจำตัวผู้เสียภาษี',
			'v_tel' => 'เบอร์โทรติดต่อ',
			'v_contractor' => 'ชื่อผู้ติดต่อ',
			'v_BP' => $bp_label,
			'type' => 'ประเภทคู่สัญญา',
		);
	}

	public function behaviors()  {
    	return array( 'CCompare'); // <-- and other behaviors your model may have
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

		$criteria->compare('v_id',$this->v_id);
		$criteria->compare('v_name',$this->v_name,true);
		$criteria->compare('v_address',$this->v_address,true);
		$criteria->compare('v_tax_id',$this->v_tax_id);
		$criteria->compare('v_tel',$this->v_tel,true);
		$criteria->compare('v_contractor',$this->v_contractor,true);
		$criteria->compare('v_BP',$this->v_BP,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
