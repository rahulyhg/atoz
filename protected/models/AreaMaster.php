<?php

/**
 * This is the model class for table "az_area_master".
 *
 * The followings are the available columns in table 'az_area_master':
 * @property integer $area_id
 * @property string $area_name
 * @property integer $pincode
 * @property integer $city_id
 */
class AreaMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_area_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('area_name, city_id', 'required'),
			array('pincode, city_id', 'numerical', 'integerOnly'=>true),
			array('area_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('area_id, area_name, pincode, city_id', 'safe', 'on'=>'search'),
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
			//'area_id' => 'Area',
			'area_name' => 'Area Name',
			'pincode' => 'Pincode',
			'city_id' => 'City Name',
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

		//$criteria->compare('area_id',$this->area_id);
		$criteria->compare('area_name',$this->area_name,true);
		$criteria->compare('pincode',$this->pincode);
               
                $criteria->select="area_id,area_name,pincode,(select city_name from  az_city_master where city_id=t.city_id ) as city_id "; 
		//$criteria->compare('city_id',$this->city_id);
                
                if ($this->city_id){
                  $criteria->addCondition("city_id in(select city_id from az_city_master where city_name like '%" . $this->city_id . "%')");
                  
                 }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AreaMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
