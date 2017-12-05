<?php

/**
 * This is the model class for table "az_document_details".
 *
 * The followings are the available columns in table 'az_document_details':
 * @property integer $doc_id
 * @property integer $user_id
 * @property string $doc_type
 * @property string $document
 */
class DocumentDetails extends CActiveRecord
{
   public $doc_hos_reg_certificate,$doc_photo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'az_document_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, doc_type, document', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('doc_type', 'length', 'max'=>50),
			array('document', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('doc_id, user_id, doc_type, document', 'safe', 'on'=>'search'),
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
			'doc_id' => 'Doc',
			'user_id' => 'User',
			'doc_type' => 'Doc Type',
			'document' => 'Document',
                    'doc_hos_reg_certificate' => 'reg_certificate',
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

		$criteria->compare('doc_id',$this->doc_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('doc_type',$this->doc_type,true);
		$criteria->compare('document',$this->document,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
