<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('myjavascript', '
   
        
//  $(".working_hours").datepicker( {
//    format: "mm-yyyy",
//    startView: "months", 
//    minViewMode: "months"
//});

 $(".from").datepicker({
    autoclose: true,
    minViewMode: 1,
    format: "mm/yyyy"
}).on("changeDate", function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $(".to").datepicker("setStartDate", startDate);
    }); 
    
$(".to").datepicker({
    autoclose: true,
    minViewMode: 1,
    format: "mm/yyyy"
}).on("changeDate", function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $(".from").datepicker("setEndDate", FromEndDate);
    });


       ', CClientScript::POS_END);
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'doctor-experience-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
 Experience Details
</div>
	<div class="row">
		<?php echo $form->labelEx($model,'work_from'); ?>
		<?php echo $form->textField($model,'work_from',array('size'=>60,'maxlength'=>100,'class'=>'from')); ?>
		<?php echo $form->error($model,'work_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_to'); ?>
		<?php echo $form->textField($model,'work_to',array('size'=>60,'maxlength'=>100,'class'=>'to')); ?>
		<?php echo $form->error($model,'work_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_role'); ?>
		<?php echo $form->textField($model,'doctor_role',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'doctor_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
             <?php
            $city = CityMaster::model()->findAll();
            $citynameArr = CHtml::listData($city, 'city_id', 'city_name');
            echo $form->dropDownList($model, 'city_id', $citynameArr, array('empty' => 'Select City'));
            ?>
            
	
		<?php echo $form->error($model,'city_id'); ?>
	</div>
        
         <div class="row">
		<?php echo $form->labelEx($model,'clinic_Hospital_Name'); ?>
		<?php echo $form->textField($model,'clinic_Hospital_Name'); ?>
		<?php echo $form->error($model,'clinic_Hospital_Name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Create' ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
