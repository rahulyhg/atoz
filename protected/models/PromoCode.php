<?php

/**
 * This is the model class for table "az_promo_code".
 *
 * The followings are the available columns in table 'az_promo_code':
 * @property integer $promo_id
 * @property string $promo_code
 * @property string $generate_date
 * @property string $expired_date
 * @property integer $created_by
 */
class PromoCode extends CActiveRecord
{
    public $promo_status;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_promo_code';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promo_code, generate_date, expired_date, created_by', 'required'),
			array('created_by', 'numerical', 'integerOnly'=>true),
			array('promo_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('promo_id, promo_code, generate_date, expired_date, created_by', 'safe', 'on'=>'search'),
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
			'promo_id' => 'Promo',
			'promo_code' => 'Promo Code',
			'generate_date' => 'Generate Date',
			'expired_date' => 'Expired Date',
			'created_by' => 'Created By',
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

		$criteria->compare('promo_id',$this->promo_id);
		$criteria->compare('promo_code',$this->promo_code,true);
		$criteria->compare('generate_date',$this->generate_date,true);
		$criteria->compare('expired_date',$this->expired_date,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PromoCode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
