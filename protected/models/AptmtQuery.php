<?php

/**
 * This is the model class for table "az_aptmt_query".
 *
 * The followings are the available columns in table 'az_aptmt_query':
 * @property integer $id
 * @property integer $is_patient
 * @property string $patient_name
 * @property string $patient_mobile
 * @property string $creator_number
 * @property string $relationship
 * @property string $type_of_visit
 * @property string $preferred_day
 * @property string $mode_of_pay
 * @property integer $created_by
 * @property string $created_date
 */
class AptmtQuery extends CActiveRecord {

    public $doctor_id, $doctorfees, $apt_fees, $apt_confirm, $promocode, $doctor_name, $promo_id, $clinic_id, $clinic_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'az_aptmt_query';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, created_date', 'required'),
            array('is_patient, created_by', 'numerical', 'integerOnly' => true),
            array('patient_name', 'length', 'max' => 150),
            array('patient_mobile, creator_number, relationship', 'length', 'max' => 20),
            array('type_of_visit, mode_of_pay', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, is_patient, patient_name, patient_mobile, creator_number, relationship, type_of_visit, preferred_day, mode_of_pay, created_by, created_date', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'is_patient' => 'Is Patient',
            'patient_name' => 'Patient Name',
            'patient_mobile' => 'Patient Mobile',
            'creator_number' => 'Creator Number',
            'relationship' => 'Relationship',
            'type_of_visit' => 'Type Of Visit',
            'preferred_day' => 'Preferred Day',
            'mode_of_pay' => 'Mode Of Pay',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('is_patient', $this->is_patient);
        $criteria->compare('patient_name', $this->patient_name, true);
        $criteria->compare('patient_mobile', $this->patient_mobile, true);
        $criteria->compare('creator_number', $this->creator_number, true);
        $criteria->compare('relationship', $this->relationship, true);
        $criteria->compare('type_of_visit', $this->type_of_visit, true);
        $criteria->compare('preferred_day', $this->preferred_day, true);
        $criteria->compare('mode_of_pay', $this->mode_of_pay, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_date', $this->created_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAppoimentQuery($hospitalId) {
        $criteria = new CDbCriteria;
        $criteria->select = "t.id,t.patient_name,t.patient_mobile,t.type_of_visit,t.doctor_id,apt_confirm,CONCAT(ud.first_name,' ', ud.last_name)  as doctor_name";
        $criteria->join = "LEFT JOIN az_user_details ud ON ud.user_id = t.doctor_id";
        $criteria->addCondition("apt_confirm ='No' AND ud.parent_hosp_id  = $hospitalId AND ud.role_id = 3");


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10
            ),
        ));
    }

    public function getDocAppoimentQuery($id) {
        $criteria = new CDbCriteria;
        //   $criteria->select = " t.id,t.patient_name,t.patient_mobile,t.type_of_visit,t.doctor_id,t.preferred_day,(SELECT CONCAT(first_name, last_name) FROM az_user_details ud WHERE ud.user_id = $id) as doctor_name";

        $criteria->select = " t.id,t.patient_name,t.patient_mobile,t.type_of_visit,t.doctor_id,t.preferred_day,(SELECT clinic_name FROM az_clinic_details cd WHERE cd.clinic_id = t.clinic_id) as clinic_name";

        $criteria->addCondition("apt_confirm ='NO'");
        $criteria->addCondition("doctor_id =$id ");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20
            ),
        ));
    }
    
    public function getPatientQuery($id){
        //echo $id.'hiii';exit;
        $criteria = new CDbCriteria;
         $criteria->select = " t.id,t.patient_name,t.patient_mobile,t.type_of_visit,t.doctor_id,t.preferred_day,(SELECT clinic_name FROM az_clinic_details cd WHERE cd.clinic_id = t.clinic_id) as clinic_name";

        $criteria->addCondition("apt_confirm ='NO'");
        $criteria->addCondition("created_by = $id ");

      // print_r($criteria);exit;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AptmtQuery the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
