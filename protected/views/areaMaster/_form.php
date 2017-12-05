<?php
/* @var $this AreaMasterController */
/* @var $model AreaMaster */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'area-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	 <div class="form-group clearfix ">
		<?php echo $form->labelEx($model,'area_name',array("class" => "col-sm-2 control-label")); ?>
              <div class="col-sm-4">
		<?php echo $form->textField($model,'area_name',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'area_name'); ?>
             </div>
         </div>
	 <div class="form-group clearfix ">
		<?php echo $form->labelEx($model,'pincode',array("class" => "col-sm-2 control-label")); ?>
             <div class="col-sm-4">
		<?php echo $form->textField($model,'pincode',array('class' => 'form-control'));?>
		<?php echo $form->error($model,'pincode'); ?>
	</div>

         </div>
        <div class="form-group clearfix ">
		<?php echo $form->labelEx($model,'city_id',array("class" => "col-sm-2 control-label")); ?>
		  <?php
                    $city = CityMaster::model()->findAll();
                    $countr = CHtml::listData($city, 'city_id', 'city_name');
                    ?>
             <div class="col-sm-4">
                   <?php echo $form->dropDownList($model, 'city_id', $countr, array('prompt' => 'Select City', 'class' => 'form-control select'));
                    ?>

		<?php echo $form->error($model,'city_id'); ?>
	</div>
         </div>

	<div class="row buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function () {

        
        $.validator.addMethod(
                "regexp",
                function (value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please check your input."
                );    
        $("#area-master-form").validate({
            rules: {
                "AreaMaster[area_name]": {
                    required: true,
                    regexp: /^[a-zA-Z ]+$/,
                },
                "AreaMaster[city_id]": {
                    required: true,
                },
                "AreaMaster[pincode]": {
                    required: true,
                },
            },
            // Specify the validation error messages
            messages: {
                "AreaMaster[area_name]":{
                    required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "Area name")?>",
                    maxlength:"<?php echo sprintf(Constants::ERROR_MAX_LENGHT_MESSAGE, "50")?>",
                    regexp:  "<?php echo sprintf(Constants::ERROR_INVALID_MESSAGE, "Area name")?>",
                    
                },
                "AreaMaster[city_id]": {
                    required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "City name")?>",
                },
                "AreaMaster[pincode]": {
                    required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "Pincode")?>",
                },        
            },
          });
    });
</script>
