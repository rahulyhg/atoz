<?php
/* @var $this CountryMasterController */
/* @var $model CountryMaster */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'country-master-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>


  <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
<!--    <div class="box box-primary">-->
        <div class="box-body">
            <div class="form-group clearfix">

                <?php echo $form->labelEx($model, 'country_name', array("class" => "col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'country_name', array('size' => 40, 'maxlength' => 40, "class" => "form-control ")); ?>
                    <?php echo $form->error($model, 'country_name'); ?>
                </div>   
            </div>
        </div>
        <div class="row buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-primary  ")); ?>
        </div>

        <?php $this->endWidget(); ?>
<!--    </div>-->
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
                "CountryMaster[country_name]": {
                    required: true,
                    regexp: /^[a-zA-Z]+$/,
                   
                },
            },
            // Specify the validation error messages
            messages: {
                "CountryMaster[country_name]": {
                     required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "Country Name")?>",
                    maxlength:"<?php echo sprintf(Constants::ERROR_MAX_LENGHT_MESSAGE, "50")?>",
                    regexp:  "<?php echo sprintf(Constants::ERROR_INVALID_MESSAGE, "Country Name")?>",
                    
                },
            }
        });
    });
</script>


