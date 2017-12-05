<?php
/* @var $this DegreeMasterController */
/* @var $model DegreeMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'degree-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'degree_name'); ?>
		<?php echo $form->textField($model,'degree_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'degree_name'); ?>
	</div>

	 <div class="row buttons text-center">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<!-- Form Validation -->

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
        $("#country-master-form").validate({
            rules: {
                "DegreeMaster[degree_name]": {
                    required: true,
                    regexp: /^[a-zA-Z]+$/,
                   
                },
            },
            // Specify the validation error messages
            messages: {
                "CountryMaster[country_name]": {
                     required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "Degree Name")?>",
                    maxlength:"<?php echo sprintf(Constants::ERROR_MAX_LENGHT_MESSAGE, "150")?>",
                    regexp:  "<?php echo sprintf(Constants::ERROR_INVALID_MESSAGE, "Degree Name")?>",
                    
                },
            }
        });
    });
</script>