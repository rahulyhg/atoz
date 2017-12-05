<?php

/**
 * This is the model class for table "az_doctor_experience".
 *
 * The followings are the available columns in table 'az_doctor_experience':
 * @property integer $id
 * @property integer $doctor_id
 * @property string $work_from
 * @property string $work_to
 * @property string $doctor_role
 * @property integer $city_name
 */
class DoctorExperience extends CActiveRecord
{
    public $clinic_Hospital_Name,$clinic_name,$ex_clinic_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_doctor_experience';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('doctor_id, work_from, work_to', 'required'),
			array('doctor_id', 'numerical', 'integerOnly'=>true),
			array('work_from, work_to', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, doctor_id, work_from, work_to, doctor_role', 'safe', 'on'=>'search'),
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
			'doctor_id' => 'Doctor',
			'work_from' => 'Work From',
			'work_to' => 'Work To',
			'doctor_role' => 'Doctor Role',
			'city_name' => 'City',
                        'ex_clinic_name' => 'Clinic/Hospital Name'
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
	public function search($doctorid)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
//echo $doctorid;exit;
		$criteria=new CDbCriteria;
               
                  $criteria->select = "id,work_from,work_to,(select  CONCAT(first_name,' ',last_name) as first_name from az_user_details ud  where ud.user_id = t.doctor_id) as doctor_id";
		$criteria->compare('id',$this->id);
		
		$criteria->compare('work_from',$this->work_from,true);
		$criteria->compare('work_to',$this->work_to,true);
//		$criteria->compare('doctor_role',$this->doctor_role,true);
//		$criteria->compare('city_name',$this->city_name,true);
               
                if ($this->doctor_id){
              $criteria->addCondition("doctor_id in(select doctor_id from az_user_details where first_name like '%" . $this->doctor_id . "%')");
                  
                 }
                 $criteria->addCondition("doctor_id = $doctorid");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DoctorExperience the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
