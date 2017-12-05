<?php

/**
 * This is the model class for table "az_patient_appointment_details".
 *
 * The followings are the available columns in table 'az_patient_appointment_details':
 * @property integer $appointment_id
 * @property integer $patient_id
 * @property integer $doctor_hospital_id
 * @property string $time
 * @property string $appointment_date
 * @property string $day
 * @property string $type_of_visit
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 */
class PatientAppointmentDetails extends CActiveRecord {

    public $first_name, $last_name, $speciality, $address, $description, $is_clinic, $doctorname, $mobile, $payamtpay, $docfee, $pid, $from, $patient_mobile, $promo_id, $clinic_name, $patient_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'az_patient_appointment_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_id, hospital_id, time, day, type_of_visit,appointment_date,patient_mobile,patient_name,doc_fees', 'required'),
            array('patient_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('day', 'length', 'max' => 50),
            array('type_of_visit', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('patient_name, appointment_date', 'safe', 'on' => 'search'),
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
            'appointment_id' => 'Appointment',
            'patient_id' => 'Patient Name',
            'patient_mobile' => 'Patient Mobile',
            'doctor_id' => 'Doctor Name',
            'hospital_id' => 'Hospital Name',
            'time' => 'Time',
            'appointment_date' => 'Appointment Date',
            'day' => 'Day',
            'type_of_visit' => 'Type Of Visit',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'docfee' => 'Doctor Fee'
        );
    }
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('first_name', $this->first_name, true);
        return new CActiveDataProvider('Post', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'first_name ASC',
            ),
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
    }

    public function getDoctorAppointment($doctorId) {

        $criteria = new CDbCriteria;
        $criteria->select = "t.hospital_id,u.role_id,t.appointment_date,t.time,t.day, t.type_of_visit,t.doc_fees,t.patient_id,t.doctor_id,t.appointment_id,(SELECT sum(ap.payment_amt) FROM az_appointment_payment_table ap WHERE ap.appointment_id = t.appointment_id) as payamtpay,(SELECT clinic_name from az_clinic_details where clinic_id= t.hospital_id and is_clinic = 'Y') as clinic_name,t.patient_mobile,t.patient_name";
        $criteria->join = "LEFT JOIN az_user_details u ON u.user_id = t.patient_id";
        $criteria->order = "t.appointment_date ASC";

        if (!empty($this->first_name)) {
            $criteria->addCondition("t.patient_name LIKE '%" . $this->first_name . "%' Or t.patient_mobile='" . $this->first_name . "'");
        }
//            if(!empty($this->mobile)) {
//                $criteria->addCondition("u.mobile LIKE '%".$this->patient_mobile."%'");
//            }
        $criteria->addCondition("doctor_id = $doctorId");
        $criteria->order = "appointment_date Asc";
        //echo "name->".$this->first_name;print_r($criteria);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'appointment_id ASC',
            ),
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
    }

    public function getHospitalAppointment($hospitalId) {

        $criteria = new CDbCriteria;
        $criteria->select = "u.first_name, u.last_name,u.role_id,t.appointment_date,t.time,t.day, t.type_of_visit,t.appointment_id,t.doc_fees,t.patient_id,t.doctor_id,u.mobile, CONCAT(u.first_name,' ',u.last_name) as doctorname,(SELECT sum(ap.payment_amt) FROM az_appointment_payment_table ap WHERE ap.appointment_id = t.appointment_id) as payamtpay,t.patient_name,t.patient_mobile";
        $criteria->join = "LEFT JOIN az_user_details u ON u.user_id = t.doctor_id";

        if (!empty($this->first_name)) {
            $criteria->addCondition("CONCAT(u.first_name,' ',u.last_name) LIKE '%" . $this->first_name . "%'");
        }
        if (!empty($this->doctorname)) {
            $criteria->addCondition(" t.doctor_id IN(SELECT d.user_id FROM az_user_details d WHERE CONCAT(d.first_name,' ',d.last_name) LIKE '%" . $this->doctorname . "%' AND d.parent_hosp_id = $hospitalId)");
        }
        if (!empty($this->mobile)) {
            $criteria->addCondition("u.mobile LIKE '%" . $this->mobile . "%'");
        }
        if (!empty($this->appointment_date)) {
            $criteria->addCondition("t.appointment_date LIKE '%" . $this->appointment_date . "%'");
        }
        $criteria->addCondition("u.parent_hosp_id = $hospitalId");
        $criteria->order = "appointment_date desc";
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

    public function getSpecialtyName($doctorId) {
        $specialtyname = Yii::app()->db->createCommand()
                ->select('speciality_name')
                ->from('az_speciality_user_mapping sm')
                ->where('user_id=:id', array(':id' => $doctorId))
                ->queryRow();
        return $specialtyname['speciality_name'];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PatientAppointmentDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //new book appointment code
    public function getMonthCalendar($month, $year, $weekday_format = "N") {
        $arrayMonth = Array();
        $date = mktime(0, 0, 0, $month, 1, $year);
        for ($n = 1; $n <= date('t', $date); $n++) {
            $arrayMonth[$n] = Array();
            $arrayMonth[$n]["dayofweek"] = date($weekday_format, mktime(0, 0, 0, $month, $n, $year));
            $arrayMonth[$n]["daynum"] = date('d', mktime(0, 0, 0, $month, $n, $year));
            $arrayMonth[$n]["monthnum"] = date('m', mktime(0, 0, 0, $month, $n, $year));
            $arrayMonth[$n]["yearnum"] = date('Y', mktime(0, 0, 0, $month, $n, $year));
        }
        return $arrayMonth;
    }

    public function getSlotsPerDay($year, $month, $daynum, $calendar_id, $settingObj, $doctid, $hospitalid, $is_clinic, $returnType = "count") {
        if (strlen($month) == 1) {
            $month = "0" . $month;
        }
        if (strlen($daynum) == 1) {
            $daynum = "0" . $daynum;
        }
        $dayName = date("l", strtotime($year . "-" . $month . "-" . $daynum));
        $appointDate = date("Y-m-d", strtotime($year . "-" . $month . "-" . $daynum));
        $whereClause = " doctor_id = :docid AND day = :day ";
        $paramArr = array(":docid" => $doctid, ":day" => $dayName);
        if ($is_clinic == "Y") {
            $whereClause .= " AND role_type = :roletype AND clinic_id = :clinic_id";
            $paramArr[':roletype'] = "clinic";
            $paramArr[':clinic_id'] = $hospitalid;
        } else {
            $whereClause .= " AND role_type = :roletype";
            $paramArr[':roletype'] = "doctor";
        }
        $slotRow = array();
        $duration = '30';  // split by 30 mins
        $doctVisitDetails = Yii::app()->db->createCommand()->select('clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')->from('az_clinic_visiting_details')->where($whereClause, $paramArr)->queryRow();
        if (!empty($doctVisitDetails)) {
            if (!empty($doctVisitDetails['clinic_open_time']) && !empty($doctVisitDetails['clinic_close_time'])) {
                $start_time = strtotime($doctVisitDetails['clinic_open_time']); //change to strtotime
                $end_time = strtotime($doctVisitDetails['clinic_close_time']); //change to strtotime
                $add_mins = $duration * 60;
                while ($start_time <= $end_time) { // loop between time
                    $slotDate = date("H:i:s", $start_time);
                    $diff = strcmp($slotDate, $doctVisitDetails['clinic_close_time']);
                    if ($diff != 0) {
                        $slotRow[] = date("H:i:s", $start_time);
                    }
                    $start_time += $add_mins; // to check endtie=me
                }
            }
            if (!empty($doctVisitDetails['clinic_eve_open_time']) && !empty($doctVisitDetails['clinic_eve_close_time'])) {
                $eve_start_time = strtotime($doctVisitDetails['clinic_eve_open_time']); //change to strtotime
                $eve_end_time = strtotime($doctVisitDetails['clinic_eve_close_time']); //change to strtotime
                $add_mins = $duration * 60;
                while ($eve_start_time <= $eve_end_time) { // loop between time
                    $slotDate = date("H:i:s", $eve_start_time);
                    $diff = strcmp($slotDate, $doctVisitDetails['clinic_eve_close_time']);
                    if ($diff != 0) {
                        $slotRow[] = date("H:i:s", $eve_start_time);
                    }
                    $eve_start_time += $add_mins; // to check endtie=me
                }
            }
        }
        //print_r($slotRow); exit;
        $tot = count($slotRow);
        if ($tot == 0) {
            //it's not soldout
            $tot = -1;
        } else {
            foreach ($slotRow as $key => $slot) {
                $appwhereClause = " doctor_id = :docid AND appointment_date = :appointment_date AND hospital_id = :hospital_id AND is_clinic = :is_clinic AND time = '$slot'";
                $appparamArr = array(":docid" => $doctid, ":appointment_date" => $appointDate, ':hospital_id' => $hospitalid);
                if ($is_clinic == "Y") {
                    $appparamArr[':is_clinic'] = "Y";
                } else {
                    $appparamArr[':is_clinic'] = "N";
                }
                $aptVisitCount = Yii::app()->db->createCommand()->select('count(appointment_id)')->from('az_patient_appointment_details')->where($appwhereClause, $appparamArr)->queryScalar();
                if ($aptVisitCount > 0) {
                    $tot--;
                    unset($slotRow[$key]);
                }
            }
            //return $tot;
        }
        
        if($returnType == "count"){
            return $tot;
        }else{
            return $slotRow;
        }
    }
    
    public function getServiceSlotsPerDay($year, $month, $daynum, $doctid, $hospitalid, $is_clinic, $returnType = "count") {
        if (strlen($month) == 1) {
            $month = "0" . $month;
        }
        if (strlen($daynum) == 1) {
            $daynum = "0" . $daynum;
        }
        $dayName = date("l", strtotime($year . "-" . $month . "-" . $daynum));
        $appointDate = date("Y-m-d", strtotime($year . "-" . $month . "-" . $daynum));
        $slotRow = array();
        $duration = '30';  // split by 30 mins
        $is_open_allday = Yii::app()->db->createCommand()->select('is_open_allday')->from('az_user_details')->where("user_id = :user_id", array(":user_id" => $doctid))->queryScalar();
        if($is_open_allday == "N") {
            $whereClause = " doctor_id = :docid AND day = :day ";
            $paramArr = array(":docid" => $doctid, ":day" => $dayName);
            $doctVisitDetails = Yii::app()->db->createCommand()->select('clinic_open_time,clinic_close_time,clinic_eve_open_time,clinic_eve_close_time')->from('az_clinic_visiting_details')->where($whereClause, $paramArr)->queryRow();
            if (!empty($doctVisitDetails)) {
                if (!empty($doctVisitDetails['clinic_open_time']) && !empty($doctVisitDetails['clinic_close_time'])) {
                    $start_time = strtotime($doctVisitDetails['clinic_open_time']); //change to strtotime
                    $end_time = strtotime($doctVisitDetails['clinic_close_time']); //change to strtotime
                    $add_mins = $duration * 60;
                    while ($start_time <= $end_time) { // loop between time
                        $slotDate = date("H:i:s", $start_time);
                        $diff = strcmp($slotDate, $doctVisitDetails['clinic_close_time']);
                        if ($diff != 0) {
                            $slotRow[] = date("H:i:s", $start_time);
                        }
                        $start_time += $add_mins; // to check endtie=me
                    }
                }
                if (!empty($doctVisitDetails['clinic_eve_open_time']) && !empty($doctVisitDetails['clinic_eve_close_time'])) {
                    $eve_start_time = strtotime($doctVisitDetails['clinic_eve_open_time']); //change to strtotime
                    $eve_end_time = strtotime($doctVisitDetails['clinic_eve_close_time']); //change to strtotime
                    $add_mins = $duration * 60;
                    while ($eve_start_time <= $eve_end_time) { // loop between time
                        $slotDate = date("H:i:s", $eve_start_time);
                        $diff = strcmp($slotDate, $doctVisitDetails['clinic_eve_close_time']);
                        if ($diff != 0) {
                            $slotRow[] = date("H:i:s", $eve_start_time);
                        }
                        $eve_start_time += $add_mins; // to check endtie=me
                    }
                }
            }
        }elseif($is_open_allday == "Y"){
            $start_time = strtotime("00:00:00"); //change to strtotime
            $end_time = strtotime("24:00:00"); //change to strtotime
            $add_mins = $duration * 60;
            while ($start_time <= $end_time) { // loop between time
                $slotDate = date("H:i:s", $start_time);
                $diff = strcmp($slotDate, "00:00:00");
                if ($diff != 0) {
                    $slotRow[] = date("H:i:s", $start_time);
                }
                $start_time += $add_mins; // to check endtie=me
            }
        }
        
        //print_r($slotRow); exit;
        $tot = count($slotRow);
        if ($tot == 0) {
            //it's not soldout
            $tot = -1;
        } else {
            foreach ($slotRow as $key => $slot) {
                $appwhereClause = " center_id = :center_id AND appointment_date = :appointment_date AND parent_hosp_id = :hospital_id AND appointment_time = '$slot'";
                $appparamArr = array(":center_id" => $doctid, ":appointment_date" => $appointDate, ':hospital_id' => $hospitalid);
                $aptVisitCount = Yii::app()->db->createCommand()->select('count(book_id)')->from('az_lab_book_details')->where($appwhereClause, $appparamArr)->queryScalar();
                if ($aptVisitCount > 0) {
                    $tot--;
                    unset($slotRow[$key]);
                }
            }
            //return $tot;
        }
        
        if($returnType == "count"){
            return $tot;
        }else{
            return $slotRow;
        }
    }

    
}
