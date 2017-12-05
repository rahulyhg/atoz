<?php

/**
 * This is the model class for table "az_city_master".
 *
 * The followings are the available columns in table 'az_city_master':
 * @property integer $city_id
 * @property string $city_name
 * @property integer $state_id
 */
class CityMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_city_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_name, state_id', 'required'),
			array('state_id', 'numerical', 'integerOnly'=>true),
			array('city_name', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(' city_name, state_id', 'safe', 'on'=>'search'),
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
			//'city_id' => 'City',
			
			//'state_name' => 'State',
                       'city_name' => 'City Name',
                       'state_id'=>'State Name',
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
                // changes made 
                $criteria->select="city_id,city_name,(select state_name from  az_state_master where state_id=t.state_id ) as state_id ";

		//$criteria->compare('city_id',$this->city_id);
		$criteria->compare('city_name',$this->city_name,true);
		//$criteria->compare('state_id',$this->state_id);
                 if ($this->state_id){
                     $criteria->addCondition ("state_id in(select state_id from az_state_master where state_name like '%" . $this->state_id . "%') ");
              }
              
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination' => array('pageSize' => 2,),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CityMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
