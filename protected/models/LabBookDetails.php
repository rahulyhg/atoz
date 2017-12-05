<?php

/**
 * This is the model class for table "az_lab_book_details".
 *
 * The followings are the available columns in table 'az_lab_book_details':
 * @property integer $book_id
 * @property integer $patient_id
 * @property integer $role_id
 * @property integer $center_id
 * @property string $relation
 * @property string $other_relation_dis
 * @property string $full_name
 * @property string $mobile_no
 * @property integer $patient_age
 * @property string $service_name
 * @property string $discription_doc
 * @property string $collect_home
 * @property integer $pincode
 * @property integer $country_id
 * @property string $country_name
 * @property integer $state_id
 * @property string $state_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $area_id
 * @property string $area_name
 * @property string $landmark
 * @property string $address
 * @property string $created_date
 * @property string $updated_date
 */
class LabBookDetails extends CActiveRecord {

    public $total_charges, $payamtpay, $status, $blood_group, $no_of_unit, $doctor_fees, $hospital_name, $discount, $appointment_date, $appointment_time, $parent_hosp_id, $query_bookid;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'az_lab_book_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, role_id, center_id, relation, full_name, mobile_no, patient_age', 'required'),
            array('patient_id, role_id, center_id, pincode, country_id, state_id, city_id, area_id', 'numerical', 'integerOnly' => true),
            array('relation', 'length', 'max' => 50),
            array('other_relation_dis, service_name, country_name, state_name, city_name, area_name', 'length', 'max' => 100),
            array('full_name, discription_doc, landmark, address', 'length', 'max' => 150),
            array('mobile_no', 'length', 'max' => 20),
            array('collect_home', 'length', 'max' => 10),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('book_id, patient_id, role_id, center_id, relation, other_relation_dis, full_name, mobile_no, patient_age, service_name, discription_doc, collect_home, pincode, country_id, country_name, state_id, state_name, city_id, city_name, area_id, area_name, landmark, address, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'book_id' => 'Book',
            'patient_id' => 'Patient',
            'role_id' => 'Role',
            'center_id' => 'Center',
            'relation' => 'Relation',
            'other_relation_dis' => 'Other Relation Dis',
            'full_name' => 'Full Name',
            'mobile_no' => 'Mobile No',
            'patient_age' => 'Patient Age',
            'service_name' => 'Service',
            'discription_doc' => 'Doctor Provided Prescription',
            'collect_home' => 'Collect Home',
            'pincode' => 'Pincode',
            'country_id' => 'Country',
            'country_name' => 'Country Name',
            'state_id' => 'State',
            'state_name' => 'State Name',
            'city_id' => 'City',
            'city_name' => 'City Name',
            'area_id' => 'Area',
            'area_name' => 'Area Name',
            'landmark' => 'Landmark',
            'address' => 'Address',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('center_id', $this->center_id);
        $criteria->compare('relation', $this->relation, true);
        $criteria->compare('other_relation_dis', $this->other_relation_dis, true);
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('mobile_no', $this->mobile_no, true);
        $criteria->compare('patient_age', $this->patient_age);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('discription_doc', $this->discription_doc, true);
        $criteria->compare('collect_home', $this->collect_home, true);
        $criteria->compare('pincode', $this->pincode);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('area_name', $this->area_name, true);
        $criteria->compare('landmark', $this->landmark, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLabAppointment($centerid) {
        // echo $centerid;exit;

        $criteria = new CDbCriteria;
        $criteria->select = "t.role_id,t.patient_id,t.book_id,t.total_charges,t.center_id,t.full_name,mobile_no,ud.hospital_name,patient_age,collect_home,discription_doc,status,(SELECT sum(ap.payment_amt) FROM az_appointment_payment_table ap WHERE ap.appointment_id = t.book_id) as payamtpay,ud.doctor_fees,discount";
        //  $criteria->select = "t.*";
        $criteria->join = "LEFT JOIN az_user_details ud ON ud.user_id = t.center_id";
        $criteria->addCondition("center_id = $centerid");

        if (!empty($this->full_name)) {
            $criteria->addCondition("full_name LIKE '%" . $this->full_name . "%'Or t.mobile_no='" . $this->full_name . "'");
        }
        $criteria->addCondition("center_id = $centerid");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
    }

    public function getPatientRequest($id) {
        $criteria = new CDbCriteria;
        $criteria->select = "full_name,hospital_name,patient_age , date(t.created_date)as created_date";
        $criteria->join = "LEFT JOIN az_user_details ud ON ud.user_id = t.center_id";
        $criteria->addCondition("patient_id = $id");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function getHospitalLabAppointment($hospitalid) {

        $criteria = new CDbCriteria;
        $criteria->select = "ud.hospital_name,t.full_name,t.mobile_no,center_id, appointment_date,book_id";
        $criteria->addCondition("ud.parent_hosp_id = $hospitalid and ud.role_id IN(6,7,8,9) and ud.is_active =1");
        $criteria->join = "LEFT JOIN az_user_details ud ON ud.user_id = t.center_id";
        $criteria->compare('status', $this->status, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LabBookDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
