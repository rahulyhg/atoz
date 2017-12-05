<?php
/* @var $this ServiceMasterController */
/* @var $model ServiceMaster */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);


?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'service-master-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        
    ));
    ?>
    
 <?php echo $form->errorSummary($model); ?>
<!--    <div class="box box-primary">-->
        <div class="box-body">
            <div class="form-group clearfix">

               

                <?php echo $form->labelEx($model, 'service_name', array("class" => "col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'service_name', array('size' => 50, 'maxlength' => 50, "class" => "form-control ")); ?>
                    <?php echo $form->error($model, 'service_name'); ?>
                </div>
            </div>
        </div>



         <div class="row buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-primary  ")); ?>
        </div>

        <?php $this->endWidget(); ?>

<!--    </div> form -->
    
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
        $("#service-master-form").validate({
            rules: {
                "ServiceMaster[name]": {
                    required: true,
                    regexp: /^[a-zA-Z]+$/,
                   
                },
            },
            // Specify the validation error messages
            messages: {
                "ServiceMaster[name]": {
                     required: "<?php echo sprintf(Constants::ERROR_EMPTY_MESSAGE, "name")?>",
                    maxlength:"<?php echo sprintf(Constants::ERROR_MAX_LENGHT_MESSAGE, "50")?>",
                    regexp:  "<?php echo sprintf(Constants::ERROR_INVALID_MESSAGE, "name")?>",
                    
                },
            }
        });
    });
</script>