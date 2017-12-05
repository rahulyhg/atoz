<?php

/**
 * This is the model class for table "az_notification".
 *
 * The followings are the available columns in table 'az_notification':
 * @property integer $id
 * @property integer $user_id
 * @property integer $record_id
 * @property string $module
 * @property string $action
 * @property string $operation
 * @property string $notification
 * @property integer $viewed
 * @property integer $created_by
 * @property string $created_date
 */
class Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $first_name,$last_name,$mobile;
	public function tableName()
	{
		return 'az_notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, module, action, operation, notification, viewed, created_by, created_date', 'required'),
			array('user_id, record_id, viewed, created_by', 'numerical', 'integerOnly'=>true),
			array('module, action', 'length', 'max'=>100),
			array('operation', 'length', 'max'=>80),
			array('notification', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, record_id, module, action, operation, notification, viewed, created_by, created_date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'record_id' => 'Record',
			'module' => 'Module',
			'action' => 'Action',
			'operation' => 'Operation',
			'notification' => 'Notification',
			'viewed' => 'Viewed',
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
	public function search($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                 $criteria->select = "notification,user_id,created_by,viewed,created_date,(select CONCAT(first_name,' ',last_name) as first_name from az_user_details ud where ud.user_id = t.created_by) as created_by";
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('record_id',$this->record_id);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('operation',$this->operation,true);
		$criteria->compare('notification',$this->notification,true);
		$criteria->compare('viewed',$this->viewed);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
                     
               $criteria->addCondition("user_id = $id");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         public function displayNotification($notification,$status)
         {
             if($status =="0")
             {
                 
                return "<b>$notification</b>";
             }
            elseif($status =="1"){
               return "$notification";
            }
         }
}
