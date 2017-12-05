<?php

/**
 * This is the model class for table "az_bank_details".
 *
 * The followings are the available columns in table 'az_bank_details':
 * @property integer $id
 * @property string $acc_holder_name
 * @property string $bank_name
 * @property string $branch_name
 * @property string $account_no
 * @property string $account_type
 * @property integer $ifsc_code
 * @property integer $user_id
 */
class BankDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_bank_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acc_holder_name, bank_name, branch_name, account_no, account_type, ifsc_code, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('acc_holder_name, bank_name, branch_name, account_type', 'length', 'max'=>200),
			array('account_no', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('acc_holder_name, bank_name, branch_name, account_no, account_type, ifsc_code, user_id', 'safe', 'on'=>'search'),
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
			'acc_holder_name' => 'Acc Holder Name',
			'bank_name' => 'Bank Name',
			'branch_name' => 'Branch Name',
			'account_no' => 'Account No',
			'account_type' => 'Account Type',
			'ifsc_code' => 'Ifsc Code',
			'user_id' => 'User',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('acc_holder_name',$this->acc_holder_name,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('branch_name',$this->branch_name,true);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('account_type',$this->account_type,true);
		$criteria->compare('ifsc_code',$this->ifsc_code);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BankDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
