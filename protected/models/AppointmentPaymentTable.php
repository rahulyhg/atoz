<?php

/**
 * This is the model class for table "az_appointment_payment_table".
 *
 * The followings are the available columns in table 'az_appointment_payment_table':
 * @property integer $payment_id
 * @property string $payment_amt
 * @property integer $patient_id
 * @property integer $user_id
 * @property string $user_type
 * @property string $created_date
 */
class AppointmentPaymentTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
            public $aptid;
	public function tableName()
	{
		return 'az_appointment_payment_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_amt, patient_id, user_id, user_type, created_date', 'required'),
			array('patient_id, user_id', 'numerical', 'integerOnly'=>true),
			array('payment_amt, user_type', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('payment_id, payment_amt, patient_id, user_id, user_type, created_date', 'safe', 'on'=>'search'),
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
			'payment_id' => 'Payment',
			'payment_amt' => 'Payment Amt',
			'patient_id' => 'Patient',
			'user_id' => 'User',
			'user_type' => 'User Type',
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

		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('payment_amt',$this->payment_amt,true);
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_type',$this->user_type,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
//        public function getPatientRequest($id){
//            echo $id;
//            $criteria = new CDbCriteria;
//            $criteria->addCondition("patient_id = $id");
//            return new CActiveDataProvider($this, array(
//                'criteria' => $criteria
//            ));
//        }
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppointmentPaymentTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
