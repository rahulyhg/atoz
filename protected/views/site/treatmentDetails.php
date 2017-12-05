<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$session = new CHttpSession;
$session->open();
$userid = $session['user_id'];
$enc_key = Yii::app()->params->enc_key;
$clientScriptObj = Yii::app()->clientScript;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/radio_style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin/bootstrap-datepicker.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap-fileupload.min.js', CClientScript::POS_END);
?>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">


    <div class="container">



        <div class="profile-note text-right">
            <a href="<?php echo $this->createUrl('site/docViewAppointment'); ?>" style="color:#0DB7A8;"> Home </a>
        </div>

        <?php if (Yii::app()->user->hasFlash('Success')): ?>
            <div class="alert alert-success clearfix" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">x</span>
                </button>
                <div>
                    <?php echo Yii::app()->user->getFlash('Success'); ?>
                </div>
            </div>
        <?php endif; ?>



        <div class="col-md-2 text-center clearfix" style="padding:15px;">
            <!-- Start doctor Profile left tab box -->
            <?php $this->renderPartial('doctorProfileLeftTab'); ?>
            <!-- End doctor Profile left tab box -->
        </div>



        <div class="col-sm-10"> 
            <div class="form clearfix">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'treatment-details-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <?php echo $form->errorSummary($model); ?>
                <?php
                $userdetail = Yii::app()->db->createCommand()
                        ->select('first_name,last_name,mobile')
                        ->from('az_user_details ud')
                        ->where('user_id=:id', array(':id' => $appointmentpayment['patient_id']))
                        ->queryRow();
                ?>
                <h4 class="col-sm-5 clearfix text-center" style="border-bottom: 2px solid #556180;">Patient Medical Details</h4><br>

                <div class="form-group clearfix">

                    <div class="col-sm-4">
                        <label>Appointment No:</label><span class="control-label"><?php echo $appointmentpayment['appointment_id']; ?></span>
                    </div>
                    <div class="col-sm-4">
                        <label>Patient Name:</label><span class="control-label"><?php echo $userdetail['first_name'] . " " . $userdetail['last_name']; ?></span>
                    </div>
                    <div class="col-sm-4">
                        <label>Patient Mobile:</label><span class="control-label"><?php echo $userdetail['mobile']; ?></span>
                    </div>
                </div>
                <div class="form-group clearfix">

                    <div class="col-sm-4">
                        <label>Appointment Date:</label><span class="control-label"><?php echo $appointmentpayment['appointment_date']; ?></span>
                    </div>
                    <div class="col-sm-5">
                        <label>Appointment Time:</label><span class="control-label"><?php echo $appointmentpayment['time']; ?></span>
                    </div>
                    <div class="col-sm-3">
                        <label>Type Of Visit:</label><span class="control-label"><?php echo $appointmentpayment['type_of_visit']; ?></span>
                    </div>

                </div>
                <div class="form-group clearfix">
                    <div class="col-sm-8">
                        <span>Symptoms Description</span>
                        <?php echo $form->labelEx($model, 'symptoms'); ?>
                        <?php echo $form->textArea($model, 'symptoms', array('rows' => 6, 'cols' => 50, 'class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Age")); ?>
                        <?php echo $form->error($model, 'treatment'); ?>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-sm-8">
                        <span>Treatment Description</span>
                        <?php echo $form->textArea($model, 'treatment', array('rows' => 6, 'cols' => 50, 'class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Age")); ?>
                        <?php echo $form->error($model, 'treatment'); ?>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-4">
                        <span>Patient Document</span>
                        <?php
                        echo $form->fileField($model3, 'document', array("class" => "w3-input input-group"));
                        echo $form->error($model, 'document');
                        ?> 
                    </div>
                </div>
                <div class="row buttons text-center">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save', array('class' => 'btn')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->

    </div>

</section>