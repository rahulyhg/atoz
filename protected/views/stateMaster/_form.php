<?php
/* @var $this StateMasterController */
/* @var $model StateMaster */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'state-master-form',
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

    <div class="form-group clearfix">

        <?php echo $form->labelEx($model, 'country_id', array("class" => "col-sm-2 control-label")); ?>

        <div class="col-sm-4">
            <!-- code for drop down of country -->
            <?php
            $country = CountryMaster::model()->findAll();
            $countr = CHtml::listData($country, 'country_id', 'country_name');
            echo $form->dropDownList($model, 'country_id', $countr, array('prompt' => 'Select Country', 'class' => 'form-control select'));
            ?>

            <?php echo $form->error($model, 'country_id'); ?>
        </div> 
    </div>


    <div class="form-group clearfix">
        <?php echo $form->labelEx($model, 'state_name', array("class" => "col-sm-2 control-label")); ?>
        <div class="col-sm-4">
            <?php echo $form->textField($model, 'state_name', array('size' => 40, 'maxlength' => 60, 'class' => 'form-control ')); ?>
            <?php echo $form->error($model, 'state_name'); ?>
        </div>
    </div>

    <div class="row buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-primary")); ?>
    </div>

    <?php $this->endWidget(); ?>
    <!--    </div>-->

</div><!-- form -->


<!-- Form Validation -->

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>
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
        $("#state-master-form").validate({
            rules: {
                "StateMaster[state_name]": {
                    required: true,
                    regexp: /^[a-zA-Z]+$/,
                },
                "StateMaster[country_id]": {
                    required: true,
                },
            },
            // Specify the validation error messages
            messages: {
                "StateMaster[state_name]": {
                    required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "state name") ?>",
                    maxlength: "<?php echo sprintf(Constants::ERROR_MAX_LENGHT_MESSAGE, "60") ?>",
                    regexp: "<?php echo sprintf(Constants::ERROR_INVALID_MESSAGE, "state name") ?>",
                },
                "StateMaster[country_id]": {
                    required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "country name") ?>",
                },
            },
        });
    });
</script>
