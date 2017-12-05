<?php

/**
 * This is the model class for table "az_user_details".
 *
 * The followings are the available columns in table 'az_user_details':
 * @property integer $user_id
 * @property integer $role_id
 * @property string $profile_image
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $birth_date
 * @property string $age
 * @property string $blood_group
 * @property string $mobile
 * @property string $password
 * @property string $apt_contact_no_1
 * @property string $apt_contact_no_2
 * @property string $email_1
 * @property string $email_2
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $city_id
 * @property integer $area_id
 * @property integer $pincode
 * @property string $country_name
 * @property string $state_name
 * @property string $city_name
 * @property string $area_name
 * @property integer $experience
 * @property integer $doctor_fees
 * @property string $hospital_name
 * @property string $type_of_hospital
 * @property string $hospital_registration_no
 * @property string $hos_establishment
 * @property string $hos_validity
 * @property string $type_of_establishment
 * @property integer $total_no_of_bed
 * @property string $emergency_no_1
 * @property string $emergency_no_2
 * @property string $ambulance_no_1
 * @property string $ambulance_no_2
 * @property string $tollfree_no_1
 * @property string $tollfree_no_2
 * @property string $landline_1
 * @property string $landline_2
 * @property string $take_home
 * @property string $blood_bank_no
 * @property string $payment_type
 * @property string $longitude
 * @property string $latitude
 * @property string $hospital_open_time
 * @property string $hospital_close_time
 * @property string $description
 * @property string $coordinator_name_1
 * @property string $coordinator_name_2
 * @property string $coordinator_mobile_1
 * @property string $coordinator_mobile_2
 * @property string $coordinator_email_1
 * @property string $coordinator_email_2
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 * @property integer $is_active
 */
class UserDetails extends CActiveRecord {

    public $patient_type, $services, $service_id, $is_open_allday, $landmark, $address, $discount, $twentyfour, $userservice, $registraiondoc, $otherdoc, $parent_hosp_id,$doctor_registration_no, $speciality, $doctordegree, $doctorspeciality, $degree, $speciality_name, $company_name, $vip_role, $other_est_type, $opd_consultation_fee, $clinic_name, $clinic_address, $clinic_id, $emergency, $sub_speciality, $clinic_eve_open_time, $clinic_eve_close_time, $amenities, $doctorname,$rolename,$user_otp,$fees,$opd_no,$free_opd_perday,$confirm_password,$tmp_file,$corporate_discount,$bld_donor_consent;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'az_user_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mobile, password', 'required'),
            array('role_id, country_id, state_id, city_id, area_id, pincode, experience, doctor_fees, total_no_of_bed, created_by, updated_by, is_active', 'numerical', 'integerOnly' => true),
            array('profile_image, type_of_establishment, coordinator_email_1, coordinator_email_2', 'length', 'max' => 150),
            array('first_name, last_name, hospital_registration_no,longitude, latitude', 'length', 'max' => 50),
            //array('profile_image', 'file', 'types'=>'jpg, gif, png','allowEmpty'=>true),
            array('payment_type','length', 'max' =>400),
            array('gender', 'length', 'max' => 6),
            array('age, area_name, hospital_name, type_of_hospital', 'length', 'max' => 100),
            array('blood_group, take_home', 'length', 'max' => 3),
            array('mobile, apt_contact_no_1, apt_contact_no_2, emergency_no_1, emergency_no_2, ambulance_no_1, ambulance_no_2, tollfree_no_1, tollfree_no_2, landline_1, landline_2, blood_bank_no, coordinator_mobile_1, coordinator_mobile_2', 'length', 'max' => 20),
            array('email_1, email_2', 'length', 'max' => 200),
            array('country_name, state_name, city_name', 'length', 'max' => 80),
            array('description', 'length', 'max' => 800),
            array('coordinator_name_1, coordinator_name_2', 'length', 'max' => 400),
            array('birth_date, hos_establishment, hos_validity, hospital_open_time, hospital_close_time, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, role_id, profile_image, first_name, last_name, gender, birth_date, age, blood_group, mobile, password, apt_contact_no_1, apt_contact_no_2, email_1, email_2, country_id, state_id, city_id, area_id, pincode, country_name, state_name, city_name, area_name, experience, doctor_fees, hospital_name, type_of_hospital, hospital_registration_no, hos_establishment, hos_validity, type_of_establishment, total_no_of_bed, emergency_no_1, emergency_no_2, ambulance_no_1, ambulance_no_2, tollfree_no_1, tollfree_no_2, landline_1, landline_2, take_home, blood_bank_no, payment_type, longitude, latitude, hospital_open_time, hospital_close_time, description, coordinator_name_1, coordinator_name_2, coordinator_mobile_1, coordinator_mobile_2, coordinator_email_1, coordinator_email_2, created_date, created_by, updated_date, updated_by, is_active', 'safe', 'on' => 'search'),
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
            'user_id' => 'User',
            'role_id' => 'Role',
            'profile_image' => 'Profile Image',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'age' => 'Age',
            'blood_group' => 'Blood Group',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'apt_contact_no_1' => 'Apt Contact No 1',
            'apt_contact_no_2' => 'Apt Contact No 2',
            'email_1' => 'Email 1',
            'email_2' => 'Email 2',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'area_id' => 'Area',
            'pincode' => 'Pincode',
            'country_name' => 'Country Name',
            'state_name' => 'State Name',
            'city_name' => 'City Name',
            'area_name' => 'Area Name',
            'experience' => 'Experience',
            'doctor_fees' => 'Doctor Fees',
            'hospital_name' => 'Hospital Name',
            'type_of_hospital' => 'Type Of Hospital',
            'hospital_registration_no' => 'Hospital Registration No',
            'hos_establishment' => 'Hos Establishment',
            'hos_validity' => 'Hos Validity',
            'type_of_establishment' => 'Type Of Establishment',
            'total_no_of_bed' => 'Total No Of Bed',
            'emergency_no_1' => 'Emergency No 1',
            'emergency_no_2' => 'Emergency No 2',
            'ambulance_no_1' => 'Ambulance No 1',
            'ambulance_no_2' => 'Ambulance No 2',
            'tollfree_no_1' => 'Tollfree No 1',
            'tollfree_no_2' => 'Tollfree No 2',
            'landline_1' => 'Landline 1',
            'landline_2' => 'Landline 2',
            'take_home' => 'Take Home',
            'blood_bank_no' => 'Blood Bank No',
            'payment_type' => 'Payment Type',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'hospital_open_time' => 'Hospital Open Time',
            'hospital_close_time' => 'Hospital Close Time',
            'description' => 'Description',
            'coordinator_name_1' => 'Coordinator Name 1',
            'coordinator_name_2' => 'Coordinator Name 2',
            'coordinator_mobile_1' => 'Coordinator Mobile 1',
            'coordinator_mobile_2' => 'Coordinator Mobile 2',
            'coordinator_email_1' => 'Coordinator Email 1',
            'coordinator_email_2' => 'Coordinator Email 2',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
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
    public function search($doctorType = "clinic") {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $isactive = 1;
        $criteria->select = " user_id, CONCAT(first_name,' ',last_name) as first_name, mobile,email_1,is_active, (SELECT GROUP_CONCAT(spm.speciality_name) FROM az_speciality_user_mapping spm WHERE spm.user_id = t.user_id) as speciality,apt_contact_no_1,opd_no";
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('is_active', $this->is_active, true);
        
        $criteria->compare('profile_image', $this->profile_image, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('apt_contact_no_1', $this->apt_contact_no_1, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('pincode', $this->pincode);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('area_name', $this->area_name, true);
        $criteria->compare('experience', $this->experience);
        $criteria->compare('doctor_fees', $this->doctor_fees);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('type_of_hospital', $this->type_of_hospital, true);
        $criteria->compare('type_of_establishment', $this->type_of_establishment, true);
        $criteria->compare('total_no_of_bed', $this->total_no_of_bed);
         $criteria->compare('opd_no', $this->opd_no);
        if($doctorType == "clinic") {
            $criteria->addCondition("parent_hosp_id is null or parent_hosp_id = 0");
        }else{
            $criteria->compare('parent_hosp_id', $this->parent_hosp_id);
        }
         
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
    
    public function searchCororate(){
        $criteria = new CDbCriteria;
        $isactive = 1;
        $criteria->select = " user_id, CONCAT(first_name,' ',last_name) as first_name, company_name,mobile,email_1,is_active, (SELECT GROUP_CONCAT(spm.speciality_name) "
                . "FROM az_speciality_user_mapping spm "
                . "WHERE spm.user_id = t.user_id) as speciality";
        
         $criteria->compare('user_id', $this->user_id);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('profile_image', $this->profile_image, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);

         $criteria->addCondition("is_active = $isactive AND patient_type = 'Corporate' and role_id=11");
         
         
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
      public function searchCorporateList($id){
        $criteria = new CDbCriteria;
        $isactive = 1;
        $criteria->select = " user_id, CONCAT(first_name,' ',last_name) as first_name, company_name,mobile,email_1,is_active, (SELECT GROUP_CONCAT(spm.speciality_name) "
                . "FROM az_speciality_user_mapping spm "
                . "WHERE spm.user_id = t.user_id) as speciality";
        
         $criteria->compare('user_id', $this->user_id);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('profile_image', $this->profile_image, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);

         $criteria->addCondition("is_active = $isactive AND patient_type = 'Corporate' and role_id=4 and parent_hosp_id = $id ");
         
         
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function searchPathology() {
        $isactive = 1;
        $criteria = new CDbCriteria;
        $criteria->select = " user_id,first_name,last_name,hospital_name, mobile,hospital_registration_no,is_active";

        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
          $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function searchHospial() {
         $isactive = 1;
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = " user_id, hospital_name, mobile,email_1,type_of_hospital,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('apt_contact_no_1', $this->apt_contact_no_1, true);
        $criteria->compare('apt_contact_no_2', $this->apt_contact_no_2, true);
        $criteria->compare('email_1', $this->email_1, true);
        $criteria->compare('email_2', $this->email_2, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('pincode', $this->pincode);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('type_of_hospital', $this->type_of_hospital, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        $criteria->compare('is_active', $this->is_active);
         $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchbloodbank($roleid) {
        $isactive = 1;
        $criteria = new CDbCriteria;
        $criteria->select = " role_id,user_id,first_name,last_name,email_1,email_2,hospital_name, mobile,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email_1', $this->email_1, true);
        $criteria->compare('email_2', $this->email_2, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
        $criteria->addCondition("role_id = $roleid");
        $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function getHospitalDoctor($hospitalId) {
      //echo $hospitalId;
        $criteria = new CDbCriteria;
        $criteria->select = "t.user_id,t.role_id,first_name,last_name,parent_hosp_id,doctor_fees,sub_speciality,apt_contact_no_1,is_active,mobile,free_opd_perday,GROUP_CONCAT(sm.speciality_name) as speciality_name";
        $criteria->join = "JOIN az_speciality_user_mapping sm ON sm.user_id=t.user_id";
        $criteria->group = "t.user_id";
        $criteria->addCondition("parent_hosp_id = ".$hospitalId. " and role_id = 3 and is_active = 1 ");
        if (!empty($this->doctorname)) {
            $criteria->addCondition("CONCAT(t.first_name,' ',t.last_name) LIKE '%" . $this->doctorname . "%'");
        }
        if (!empty($this->apt_contact_no_1)) {
            $criteria->addCondition("t.apt_contact_no_1 LIKE '%" . $this->apt_contact_no_1 . "%'");
        }
        if (!empty($this->speciality)) {
            $criteria->addCondition("sm.speciality_name LIKE '%" . $this->speciality . "%'");
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
           
            'pagination' => array(
                'pageSize' => 10
            ),
        ));
    }
 public function addHospitalServices($hospitalId)
 {
      $criteria = new CDbCriteria;
        $criteria->select = "t.user_id,t.role_id,first_name,last_name,parent_hosp_id,hospital_name,apt_contact_no_1,is_active,mobile,(SELECT role_name FROM az_role_master d WHERE d.role_id = t.role_id) as rolename";
       $criteria->addCondition("parent_hosp_id = $hospitalId AND role_id BETWEEN 6 AND 9");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'first_name ASC',
            ),
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
 }
 public function searchambulance($roleid)
 {
    
         $isactive = 1;
        $criteria = new CDbCriteria;
        $criteria->select = " role_id,user_id,first_name,last_name,hospital_name,company_name,type_of_hospital,mobile,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('type_of_hospital', $this->type_of_hospital, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
        $criteria->addCondition("role_id = $roleid");
        $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
 }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function ActiveStatus($active_status, $userid) {
        $checked = "";
        if ($active_status == "1") {
            $checked = " checked ";
        }
        echo '<input type="hidden" name="userid" value="' . $userid . '"><label class="switch"><input type="checkbox" name="active_status"  value="" onclick="js:testFun(' . $userid . ',this);" ' . $checked . '><div class="slider round"></div></label>';
    }
    public function searcInhospial()
    {
         $isactive = 0;
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = " user_id, hospital_name, mobile,email_1,type_of_hospital,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('apt_contact_no_1', $this->apt_contact_no_1, true);
        $criteria->compare('apt_contact_no_2', $this->apt_contact_no_2, true);
        $criteria->compare('email_1', $this->email_1, true);
        $criteria->compare('email_2', $this->email_2, true);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('pincode', $this->pincode);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('type_of_hospital', $this->type_of_hospital, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        $criteria->compare('is_active', $this->is_active);
         $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        )); 
    }
    public function searchInactivePathology()
    {
             $isactive = 0;
        $criteria = new CDbCriteria;
        $criteria->select = " user_id,first_name,last_name,hospital_name, mobile,hospital_registration_no,is_active";

        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
          $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
       public function searchinactivebloodbank($roleid) {
         $isactive = 0;
        $criteria = new CDbCriteria;
        $criteria->select = " role_id,user_id,first_name,last_name,email_1,email_2,hospital_name, mobile,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email_1', $this->email_1, true);
        $criteria->compare('email_2', $this->email_2, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
        $criteria->addCondition("role_id = $roleid");
        $criteria->addCondition("is_active = $isactive");
      
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
     public function searchInactiveambulance($roleid)
 {
    
         $isactive = 0;
        $criteria = new CDbCriteria;
        $criteria->select = " role_id,user_id,first_name,last_name,hospital_name,company_name,type_of_hospital,mobile,hospital_registration_no,is_active";
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('type_of_hospital', $this->type_of_hospital, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('hospital_name', $this->hospital_name, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('hospital_registration_no', $this->hospital_registration_no, true);
        //echo "<pre>";print_r($criteria);echo "</pre>";
        $criteria->addCondition("role_id = $roleid");
        $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
 }
 public function searchInactivePatient()
 {
          $criteria = new CDbCriteria;
        $isactive = 0;
        $criteria->select = " user_id, CONCAT(first_name,' ',last_name) as first_name, mobile,email_1,is_active, (SELECT GROUP_CONCAT(spm.speciality_name) FROM az_speciality_user_mapping spm WHERE spm.user_id = t.user_id) as speciality";
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('profile_image', $this->profile_image, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('age', $this->age, true);
        $criteria->compare('blood_group', $this->blood_group, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('password', $this->password, true);

        $criteria->compare('email_1', $this->email_1, true);
        $criteria->compare('email_2', $this->email_2, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('area_id', $this->area_id);
        $criteria->compare('pincode', $this->pincode);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('area_name', $this->area_name, true);
        $criteria->compare('experience', $this->experience);
        $criteria->compare('doctor_fees', $this->doctor_fees);
        $criteria->compare('hospital_name', $this->hospital_name, true);       
        $criteria->compare('take_home', $this->take_home, true);
        $criteria->compare('blood_bank_no', $this->blood_bank_no, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('coordinator_name_1', $this->coordinator_name_1, true);
        $criteria->compare('coordinator_name_2', $this->coordinator_name_2, true);
        $criteria->compare('coordinator_mobile_1', $this->coordinator_mobile_1, true);
        $criteria->compare('coordinator_mobile_2', $this->coordinator_mobile_2, true);
        $criteria->compare('coordinator_email_1', $this->coordinator_email_1, true);
        $criteria->compare('coordinator_email_2', $this->coordinator_email_2, true);
        $criteria->compare('is_active', $this->is_active);
         $criteria->addCondition("is_active = $isactive");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
}
