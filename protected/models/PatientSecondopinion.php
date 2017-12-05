<?php

/**
 * This is the model class for table "az_patient_secondopinion".
 *
 * The followings are the available columns in table 'az_patient_secondopinion':
 * @property integer $opinion_id
 * @property integer $user_id
 * @property integer $doctor_id
 * @property string $fullname
 * @property string $mobile
 * @property string $age
 * @property string $nature_of_visit
 * @property string $description
 * @property string $docs
 * @property string $doctor_feedback
 * @property string $status
 * @property string $pay_amt
 * @property string $created_date
 */
class PatientSecondopinion extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'az_patient_secondopinion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, doctor_id, fullname, age, status, created_date', 'required'),
            array('user_id, doctor_id', 'numerical', 'integerOnly' => true),
            array('fullname, pay_amt', 'length', 'max' => 150),
            array('mobile, age', 'length', 'max' => 20),
            array('nature_of_visit', 'length', 'max' => 9),
            array('description, docs', 'length', 'max' => 300),
            array('doctor_feedback', 'length', 'max' => 200),
            array('status', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('opinion_id, user_id, doctor_id, fullname, mobile, age, nature_of_visit, description, docs, doctor_feedback, status, pay_amt, created_date', 'safe', 'on' => 'search'),
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
            'opinion_id' => 'Opinion',
            'user_id' => 'User',
            'doctor_id' => 'Doctor',
            'fullname' => 'Fullname',
            'mobile' => 'Mobile',
            'age' => 'Age',
            'nature_of_visit' => 'Nature Of Visit',
            'description' => 'Description',
            'docs' => 'Docs',
            'doctor_feedback' => 'Doctor Feedback',
            'status' => 'Status',
            'pay_amt' => 'Pay Amt',
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
    public function search($doctorid) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "fullname,mobile,age,nature_of_visit,description,status,created_date,doctor_id,user_id";
        $criteria->compare('opinion_id', $this->opinion_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('doctor_id', $this->doctor_id);
        $criteria->compare('fullname', $this->fullname, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('age', $this->age, true);
        $criteria->compare('nature_of_visit', $this->nature_of_visit, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('docs', $this->docs, true);
        $criteria->compare('doctor_feedback', $this->doctor_feedback, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('pay_amt', $this->pay_amt, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->addCondition("doctor_id = $doctorid");
      

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PatientSecondopinion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
