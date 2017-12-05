<?php

/**
 * This is the model class for table "az_treatment_details".
 *
 * The followings are the available columns in table 'az_treatment_details':
 * @property integer $treatment_id
 * @property integer $appointment_id
 * @property integer $patient_id
 * @property string $symptoms
 * @property string $treatment
 * @property integer $created_by
 * @property string $created_date
 */
class TreatmentDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_treatment_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('appointment_id, patient_id, symptoms, treatment, created_by, created_date', 'required'),
			array('appointment_id, patient_id, created_by', 'numerical', 'integerOnly'=>true),
			array('symptoms, treatment', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('treatment_id, appointment_id, patient_id, symptoms, treatment, created_by, created_date', 'safe', 'on'=>'search'),
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
			'treatment_id' => 'Treatment',
			'appointment_id' => 'Appointment',
			'patient_id' => 'Patient',
			'symptoms' => 'Symptoms',
			'treatment' => 'Treatment',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
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

		$criteria->compare('treatment_id',$this->treatment_id);
		$criteria->compare('appointment_id',$this->appointment_id);
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('symptoms',$this->symptoms,true);
		$criteria->compare('treatment',$this->treatment,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TreatmentDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
