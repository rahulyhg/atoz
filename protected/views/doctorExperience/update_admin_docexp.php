
<?php
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
    'id' => 'doctor-experience-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<section class="content-header">

    <h3>Update Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor Exp ', array('DoctorExperience/AdminDocExperience', 'id' => Yii::app()->getSecurityManager()->encrypt($model->doctor_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    

                       
                        <?php echo $form->errorSummary($model); ?>
<span>Select Year & Month</span><br>
                        <div class="form-group clearfix">
<div class="textdetails">
                                                
 <?php
                                    $expGroupArr = Yii::app()->db->createCommand()
                                            ->select('work_from,work_to')
                                            ->from(' az_doctor_experience')
                                            ->where('doctor_id=:id', array(':id' => $doctorid))
                                            ->queryRow();

                                    ?>
                                
                                                <div class="col-md-8">
                                                    
                                                    
                                                        <div class="col-md-4">

                                                            <?php
                                                            if (isset($session['work_from'])) {
                                                                $model->work_from = $session['work_from'];
                                                            }
                                                            ?>
                                                            <select name="DoctorExperience[work_from]" class="expyear form-control">
                                                                <?php
                                                                for($i=0;$i<=30;$i++){
                                                                    
                                                                   if($expGroupArr['work_from'] == $i) {
                                                                       ?><option value="<?php echo $expGroupArr['work_from']?>"selected><?php echo $expGroupArr['work_from'].' Year' ?></option> <?php  
                                                                   }else{ ?>
                                                                       <option value="<?php echo $i;?>"><?php echo $i.' Year'; ?></option>
                                                                 <?php  }
                                                                }
                                                                ?>
                                                               
                                                            </select>
                                                            <?php
                                                        
                                                            echo $form->error($model, 'work_from');
                                                            ?>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php
                                                            if (isset($session['work_to'])) {
                                                                $model->work_to = $session['work_to'];
                                                            }?>
                                                           <select name="DoctorExperience[work_to]" class="expyear form-control">
                                                                <?php
                                                                for($i=0;$i<=12;$i++){
                                                                    
                                                                   if($expGroupArr['work_to'] == $i) {
                                                                       ?><option value="<?php echo $expGroupArr['work_to']?>"selected><?php echo $expGroupArr['work_to'].' Month' ?></option> <?php  
                                                                   }else{ ?>
                                                                       <option value="<?php echo $i;?>"><?php echo $i.' Month'; ?></option>
                                                                 <?php  }
                                                                }
                                                                ?>
                                                               
                                                            </select>
                                                          <?php  echo $form->error($model, 'work_to');
                                                            ?>

                                                        </div>
                                                             
                                                </div>

                                                
                                               
                                            </div> <!--end textdetails-->
                            
                          
                        </div>
                        
                        <div class="row buttons text-center">
                            <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-primary')); ?>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->



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
        $("#doctor-experience-form").validate({
            rules: {
                "DoctorExperience[work_from]": {
                    required: true,
                },
                "DoctorExperience[work_to]": {
                    required: true,
                },
               
            },
            // Specify the validation error messages
            messages: {
                "DoctorExperience[work_from]": {
                    required: "Please Select Work From",
                },
                "DoctorExperience[work_to]": {
                    required: "Please Select Work To",
                },
                
            }
        });
    });
</script>


