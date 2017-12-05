<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */
/* @var $form CActiveForm */
?>

<div class="form section-details ">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'patient-secondopinion-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
    $clientScriptObj = Yii::app()->clientScript;
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
    ?>
    <div class="container">

        <section id="intro">
            <div class="row">
                <div class= main-text">
                    <div class="col-md-12 backward">
                        <a class="back-home" href="<?php echo Yii::app()->baseUrl; ?>">Home / </a> <a class="back-sub" href=""> Second Opinion</a>
                    </div>

                </div>
            </div>
         <?php if (Yii::app()->user->hasFlash('Success')): ?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">
                                                <span aria-hidden="true">x</span>
                                        </button>
                                        <div>
                                        <?php echo Yii::app()->user->getFlash('Success'); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                  
    
        <?php echo $form->errorSummary($model); ?>
        <div class="form-grop">

            <div class="col-sm-4">
                <span>Full Name</span>
                <?php echo $form->textField($model, 'fullname', array('class' => 'form-control',"data-rule-required" => "true","data-msg-required"=>"Please Eenter Your full Name")); ?>
                <?php echo $form->error($model, 'fullname'); ?>
            </div>


            <div class="col-sm-4">
              <span>Patient Mobile No</span>
              <?php echo $form->textField($model, 'mobile', array('maxlength' => '10','class' => 'form-control',"data-rule-required" => "true","data-rule-regexp" => "^[\d]+$","data-msg-required"=>"Please Enter Mobile Number")); ?>
              <?php echo $form->error($model, 'mobile'); ?>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="form-grop clearfix">
            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'age'); ?>
                <?php echo $form->textField($model, 'age', array('class' => 'form-control',"data-rule-required" => "true","data-msg-required"=>"Please Enter Age")); ?>
                <?php echo $form->error($model, 'age'); ?>
            </div>

            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'nature_of_visit'); ?>
                <?php echo $form->radioButtonList($model, 'nature_of_visit', array('first' => 'first', 'follow-up' => 'follow-up'), array('labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"')); ?>
                <?php echo $form->error($model, 'nature_of_visit'); ?>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="form-grop clearfix">
            <div class="col-sm-8">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('maxlength' => 300, 'rows' => 6, 'cols' => 100,"data-rule-required" => "true","data-msg-required"=>"Please Enter Health Description")); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="form-grop clearfix">
            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'docs'); ?>
                <?php echo $form->fileField($model, 'docs'); ?>
                <?php echo $form->error($model, 'docs'); ?>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>


        <div class="form-grop clearfix">
            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'pay_amt'); ?>
                <?php echo $form->textField($model, 'pay_amt', array('size' => 20, 'maxlength' => 150, 'class' => 'form-control',"data-rule-required" => "true","data-msg-required"=>"Please Enter Pay Amount")); ?>
                <?php echo $form->error($model, 'pay_amt'); ?>
            </div>
        </div>


        <div class="row buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn')); ?>
        </div>
            </section>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-min.js"></script>
<script src="js/jquery.validate.min.js"></script>

            <script type="text/javascript">
              //          

              $(function () {
                  // alert("sdsdsd");exit;
                  $.validator.addMethod(
                          "regexp",
                          function (value, element, regexp) {
                              var re = new RegExp(regexp);
                              return this.optional(element) || re.test(value);
                          },
                          "Please check your input."
                          );
                  $("#patient-secondopinion-form").validate({
                 
                  });



              });

          </script>
