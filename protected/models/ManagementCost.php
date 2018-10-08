<?php

/**
 * This is the model class for table "management_cost".
 *
 * The followings are the available columns in table 'management_cost':
 * @property integer $mc_id
 * @property integer $mc_proj_id
 * @property integer $mc_type
 * @property string $mc_detail
 * @property double $mc_cost
 * @property string $mc_date
 * @property integer $mc_user_update
 */
class ManagementCost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'management_cost';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mc_proj_id, mc_type, mc_cost, mc_date, mc_user_update', 'required'),
			array('mc_proj_id, mc_type, mc_user_update', 'numerical', 'integerOnly'=>true),
			array('mc_cost', 'numerical'),
			array('mc_detail', 'length', 'max'=>400),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mc_id,mc_in_project, mc_proj_id, mc_type, mc_detail, mc_cost, mc_date, mc_user_update', 'safe', 'on'=>'search'),
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
			'mc_id' => 'id ',
			'mc_proj_id' => 'โครงการ',
			'mc_type' => 'ประเภท',//' [1 ประมาณการ, 2 ค่ารับรอง, 3 ใช้จริง]',
			'mc_detail' => 'รายการ',
			'mc_cost' => 'ค่าใช้จ่าย(บาท)',
			'mc_date' => 'วันที่ใช้จ่าย',
			'mc_user_update' => 'ผู้บันทึก',
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

		$criteria->compare('mc_id',$this->mc_id);
		$criteria->compare('mc_proj_id',$this->mc_proj_id);
		$criteria->compare('mc_type',$this->mc_type);
		$criteria->compare('mc_detail',$this->mc_detail,true);
		$criteria->compare('mc_cost',$this->mc_cost);
		$criteria->compare('mc_date',$this->mc_date,true);
		$criteria->compare('mc_user_update',$this->mc_user_update);
		$user_dept = Yii::app()->user->userdept;
		if(!Yii::app()->user->isExecutive())
		{
			$criteria->join = 'LEFT JOIN user ON mc_user_update=user.u_id';
			$criteria->addCondition('user.department_id='.$user_dept);
		}	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mc_id',$this->mc_id);
		$criteria->compare('mc_proj_id',$this->mc_proj_id);
		$criteria->compare('mc_type',$this->mc_type);
		$criteria->compare('mc_detail',$this->mc_detail,true);
		$criteria->compare('mc_cost',$this->mc_cost);
		$criteria->compare('mc_date',$this->mc_date,true);
		$criteria->compare('mc_user_update',$this->mc_user_update);
		$user_dept = Yii::app()->user->userdept;
		if(!Yii::app()->user->isExecutive())
		{
			$criteria->join = 'LEFT JOIN user ON mc_user_update=user.u_id';
			$criteria->addCondition('user.department_id='.$user_dept);
			$criteria->addCondition('mc_type!=0');
		}	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterFind(){
            parent::afterFind();

            switch ($this->mc_type) {
            	case 0:
            		$this->mc_type = "ประมาณการ";
            		break;
            	case 1:
            		$this->mc_type = "ค่ารับรอง";
            		break;
            	case 2:
            		$this->mc_type = "ค่าใช้จ่ายบริหารโครงการ";
            		break;	
            	case 3:
            		$this->mc_type = "ค่าใช้จ่ายด้านบุคลากร";
            		break;	
            	default:
            		# code...
            		break;
            }

    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ManagementCost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
