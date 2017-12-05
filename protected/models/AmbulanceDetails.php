<?php

/**
 * This is the model class for table "az_ambulance_details".
 *
 * The followings are the available columns in table 'az_ambulance_details':
 * @property integer $id
 * @property integer $ambulance_id
 * @property string $working_day
 * @property string $ex_name
 * @property string $ex_contact_no
 * @property string $vehical_no
 * @property string $vehical_type
 */
class AmbulanceDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_ambulance_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ambulance_id, working_day', 'required'),
			array('ambulance_id', 'numerical', 'integerOnly'=>true),
			array('working_day, ex_name', 'length', 'max'=>150),
			array('ex_contact_no', 'length', 'max'=>20),
			array('vehical_no', 'length', 'max'=>15),
			array('vehical_type', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ambulance_id, working_day, ex_name, ex_contact_no, vehical_no, vehical_type', 'safe', 'on'=>'search'),
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
			'ambulance_id' => 'Ambulance',
			'working_day' => 'Working Day',
			'ex_name' => 'Ex Name',
			'ex_contact_no' => 'Ex Contact No',
			'vehical_no' => 'Vehical No',
			'vehical_type' => 'Vehical Type',
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
		$criteria->compare('ambulance_id',$this->ambulance_id);
		$criteria->compare('working_day',$this->working_day,true);
		$criteria->compare('ex_name',$this->ex_name,true);
		$criteria->compare('ex_contact_no',$this->ex_contact_no,true);
		$criteria->compare('vehical_no',$this->vehical_no,true);
		$criteria->compare('vehical_type',$this->vehical_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AmbulanceDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
