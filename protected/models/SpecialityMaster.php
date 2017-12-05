<?php

/**
 * This is the model class for table "az_speciality_master".
 *
 * The followings are the available columns in table 'az_speciality_master':
 * @property integer $id
 * @property string $speciality_name
 * @property string $img_name
 * @property integer $is_active
 */
class SpecialityMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_speciality_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('speciality_name','required'),
			array('is_active', 'numerical', 'integerOnly'=>true),
			array('speciality_name', 'length', 'max'=>100),
                        array('img_name', 'file','types'=>'jpg, gif, png','safe'=>true,'allowEmpty'=>false,'on'=>'Insert'),
			array('img_name', 'file','types'=>'jpg, gif, png','allowEmpty'=>true,'on'=>'Update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, speciality_name, img_name, is_active', 'safe', 'on'=>'search'),
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
			'speciality_name' => 'Speciality Name',
			'img_name' => 'Img Name',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->speciality_id);
		$criteria->compare('speciality_name',$this->speciality_name,true);
		$criteria->compare('img_name',$this->img_name,true);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpecialityMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function ActiveStatus($active_status, $id) {
        $checked = "";
        if ($active_status == "1") {
            $checked = " checked ";
        }
        echo '<input type="hidden" name="userid" value="' . $id . '"><label class="switch"><input type="checkbox" name="active_status"  value="" onclick="js:testFun(' . $id . ',this);" ' . $checked . '><div class="slider round"></div></label>';
    }
}
