<?php

/**
 * This is the model class for table "az_clinic_details".
 *
 * The followings are the available columns in table 'az_clinic_details':
 * @property integer $clinic_id
 * @property integer $doctor_id
 * @property string $clinic_name
 * @property string $register_no
 * @property integer $opd_consultation_fee
 * @property integer $opd_consultation_discount
 * @property integer $free_opd_perday
 * @property string $free_opd_preferdays
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $area_id
 * @property integer $pincode
 * @property string $country_name
 * @property string $state_name
 * @property string $city_name
 * @property string $area_name
 */
class ClinicDetails extends CActiveRecord
{
    public $service_id;
        public $service_discount,$twentyfour,$latitude,$longitude;
    public $day,$clinic_open_time,$clinic_close_time;
    public $payment_type;
    public $clinic_reg_certificate, $landmark;
    public $alldayopen,$address,$is_open_allday;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_clinic_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('doctor_id', 'required'),
			array('doctor_id, opd_consultation_fee, opd_consultation_discount, free_opd_perday, country_id, state_id, city_id, area_id, pincode', 'numerical', 'integerOnly'=>true),
			array('clinic_name, register_no', 'length', 'max'=>200),
			array('free_opd_preferdays', 'length', 'max'=>500),
			array('country_name, state_name, city_name', 'length', 'max'=>80),
			array('area_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('clinic_id, doctor_id, clinic_name, register_no, opd_consultation_fee, opd_consultation_discount, free_opd_perday, free_opd_preferdays, country_id, state_id, city_id, area_id, pincode, country_name, state_name, city_name, area_name', 'safe', 'on'=>'search'),
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
			'clinic_id' => 'Clinic',
			'doctor_id' => 'Doctor',
			'clinic_name' => 'Clinic Name',
			'register_no' => 'Register No',
                        'service_id'=>'Service',
                        'service_discount'=>'Discount',
			'opd_consultation_fee' => 'Opd Consultation Fee',
			'opd_consultation_discount' => 'Opd Consultation Discount',
			'free_opd_perday' => 'Opd Perday',
			'free_opd_preferdays' => 'Opd Preferdays',
                        'clinic_reg_certificate'=>'clinic reg certificate',
			'country_id' => 'Country',
			'state_id' => 'State',
			'city_id' => 'City',
			'area_id' => 'Area',
			'pincode' => 'Pincode',
			'country_name' => 'Country Name',
			'state_name' => 'State Name',
			'city_name' => 'City Name',
			'area_name' => 'Area Name',
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

		$criteria=new CDbCriteria;
                $criteria->select = "clinic_id,doctor_id,clinic_name,opd_consultation_fee,(select  CONCAT(first_name,' ',last_name) as first_name from az_user_details ud  where ud.user_id = t.doctor_id) as doctor_id";
             

		$criteria->compare('clinic_id',$this->clinic_id);
		
		$criteria->compare('clinic_name',$this->clinic_name,true);
		$criteria->compare('register_no',$this->register_no,true);
		$criteria->compare('opd_consultation_fee',$this->opd_consultation_fee);
		$criteria->compare('opd_consultation_discount',$this->opd_consultation_discount);
		$criteria->compare('free_opd_perday',$this->free_opd_perday);
		$criteria->compare('free_opd_preferdays',$this->free_opd_preferdays,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('area_id',$this->area_id);
		$criteria->compare('pincode',$this->pincode);
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('state_name',$this->state_name,true);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('area_name',$this->area_name,true);
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
	 * @return ClinicDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
