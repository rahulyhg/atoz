<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
   

       ', CClientScript::POS_END);
$enc_key = Yii::app()->params->enc_key;
?>




<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'create_doctor-experience-form',
    'enableAjaxValidation' => false,
        ));
?>

<section class="content-header">

    <h3>  Create Doctor Experience</h3> 


</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor Exp ', array('DoctorExperience/AdminDocExperience', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>



                        </div><!--link End-->    
                        <?php echo $form->errorSummary($model); ?>

                        <span> Select Year & Month</span>

                        <div class="form-group clearfix ">

                            <div class="col-sm-4">
                                <select name="DoctorExperience[work_from]" class="expyear form-control"></select>
                                <?php echo $form->error($model, 'work_from');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <select name="DoctorExperience[work_to]" class="expmonth form-control"></select>
                                <?php
                                echo $form->error($model, 'work_to');
                                ?>
                            </div>
                        </div>
                        <div class="row buttons text-center">
                            <?php echo CHtml::submitButton('Create', array('class' => 'btn btn-primary')); ?>
                        </div>

                        <?php $this->endWidget(); ?>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->



<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

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
        $("#create_doctor-experience-form").validate({
            rules: {
                "DoctorExperience[work_from]": {
                    required: true
                },
                "DoctorExperience[work_to]": {
                    required: true
                },

            },
            // Specify the validation error messages
            messages: {
                "DoctorExperience[work_from]": {
                    required: "Please Enter Field",
                },
                "DoctorExperience[work_to]": {
                    required: "Please Enter Field ",
                },

            }
        });

        var $select = $(".expyear");
        for (i = 0; i <= 30; i++) {
            $select.append($('<option></option>').val(i).html(i + ' Year'))
        }
        var $select1 = $(".expmonth");
        for (i = 0; i <= 12; i++) {
            $select1.append($('<option></option>').val(i).html(i + ' Month'))
        }

    });
</script>
