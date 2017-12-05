<?php

/**
 * This is the model class for table "az_service_master".
 *
 * The followings are the available columns in table 'az_service_master':
 * @property integer $service_id
 * @property string $name
 * @property integer $user_id
 * @property integer $is_active
 */
class ServiceMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    // public $is_active;
    public function tableName() {
        return 'az_service_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_name', 'required'),
           
            array('service_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(' service_name,is_active', 'safe', 'on' => 'search'),
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
            'service_id' => 'Service',
            // 'role_id' => 'Role',
            'service_name' => 'Name',
           // 'user_id' => 'User',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

     //write query for advancesearch.   
       // $criteria->compare('service_id', $this->service_id);
        $criteria->compare('service_name', $this->service_name, true);
         if ($this->service_id){
                     $criteria->addCondition("service_id in (select service_id from az_service_master where service_name like '%" . $this->service_id . "%' ) ");
                }
        //$criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_active', $this->is_active);

       // $criteria->addCondition("role_id = $roleId");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ServiceMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
     public function ActiveStatus($active_status, $serviceid) {
           
      
        $checked = "";
        if ($active_status == "1") {
            $checked = " checked ";
        
        }
           
         echo '<input type="hidden" name="serviceid" value="' . $serviceid . '"><label class="switch"><input type="checkbox" name="active_status"  value="" onclick="js:testFun(' . $serviceid . ',this);" ' . $checked . '><div class="slider round"></div></label>';
    }

}
