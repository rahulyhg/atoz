<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="form section-details ">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'feedback-secondopinion-form',
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
                    <span>Full Name:&nbsp;</span>
                    <label class="control-label"><?php echo $model->fullname; ?></label>

                </div>


                <div class="col-sm-4">
                    <span>Patient Mobile No:&nbsp;</span>
                    <label class="control-label"><?php echo $model->mobile; ?></label>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-grop clearfix">
                <div class="col-sm-4">
                    <span>Age:&nbsp;</span>
                    <label class="control-label"><?php echo $model->mobile; ?></label>
                </div>

                <div class="col-sm-4">
                    <span>Nature  OF  Visit:&nbsp;</span>
                    <label class="control-label"><?php echo $model->nature_of_visit; ?></label>
                </div>
            </div>
            <div class="form-grop clearfix">
                <div class="col-sm-8">
                    <span>Patient Health Description&nbsp;</span>  
                     <label class="control-label"><?php echo $model->description; ?></label>
                          </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-grop clearfix">
                <div class="col-sm-4">
                    <span>Reports:&nbsp;</span>
                    <?php
                    if (!empty($model->docs)) {
                        $baseDir = Yii::app()->baseUrl . "/uploads/";
                     ?>
                    <a target="_blank" href="<?php echo $baseDir.$model->docs?>" class="btn-default"><?php echo basename($model->docs);?></a> 
                       
                   <?php }
                    ?>

                </div>
            </div>
            <div class="form-grop clearfix">
                <div class="col-sm-8">
                    <span>Feedback</span>
                    <?php echo $form->textArea($model, 'doctor_feedback', array('maxlength' => 300, 'rows' => 6, 'cols' => 100)); ?>
                    <?php echo $form->error($model, 'doctor_feedback'); ?>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            
                <div class="clearfix">&nbsp;</div>

                <div class="row buttons text-center">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn')); ?>
                </div>
        </section>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
