<?php
/* @var $this SpecialityMasterController */
/* @var $model SpecialityMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'speciality-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'speciality_name'); ?>
		<?php echo $form->textField($model,'speciality_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'speciality_name'); ?>
	</div>

	<div class="row"> 
		<?php echo $form->labelEx($model,'img_name');
                if(!empty($model->img_name)) {
                    $baseDir = Yii::app()->baseUrl ."/uploads/";
                    echo CHtml::image($baseDir.$model->img_name,"icon_image",array('width'=>75,'height'=>75));
                }
		echo $form->fileField($model,'img_name',array('size'=>60,'maxlength'=>150));
		echo $form->error($model,'img_name'); ?>
	</div>

	
	 <div class="row buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->