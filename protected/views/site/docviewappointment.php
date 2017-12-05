<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.sarchfield').blur(function(){
    $('#appointment-grid').yiiGridView('update', {
            data: $('#appointmentsearch').serialize()
    });

    return false;
});

");
Yii::app()->clientScript->registerScript('functions', "
    function paymentdetail(){
        var doctorfee = $('.doctorfee').val();
        var patientamt = $('.patientamt').val();
        var userid = $('#dfees').val();
        var patientid = $('#patientid').val();
        var doctorid = $('#userid').val();
        var aptid = $('#apttid').val()
        $.ajax({
            async: false,
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '".Yii::app()->createUrl("site/getappointpayment")."',
            data: {doctorfee: doctorfee, patientamt: patientamt, userid: userid, patientid: patientid, doctorid: doctorid, aptid: aptid},
            success: function (result) {
                $('#appointment-grid').yiiGridView('update', {
                        data: $('#appointmentsearch').serialize()
                });
            }
        });

    }
", CClientScript::POS_END);    
?>
<?php $doctorfee = ""; 
$enc_key = Yii::app()->params->enc_key;
$baseUrl = Yii::app()->baseUrl;
?>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container">
                <div class="col-md section" style="">

                    <div class="col-md-2 text-center" style="margin-top: -35px;">
                        <!-- Start doctor Profile left tab box -->
                        <?php $this->renderPartial('doctorProfileLeftTab'); ?>
                        <!-- End doctor Profile left tab box -->
                    </div>
                    <div class="col-md-10 col-mar" style="margin-top: -35px;"> 
                        <div class="col-md">
                            
                            <?php //print_r($DocInfoArr);?>
                             <div class="profile-note text-right">
                                <a href="<?php echo Yii::app()->createUrl('UserDetails/updateDoctordetails', array('id' => Yii::app()->getSecurityManager()->encrypt($DocInfoArr['user_id'], $enc_key))); ?>" style="color:#0DB7A8;">Profile/Edit</a>| <a href="<?php echo Yii::app()->createUrl('notification/admin'); ?>"style="color:#0DB7A8;">Notification</a>|<a href="<?php echo Yii::app()->createUrl('PatientSecondopinion/admin'); ?>"style="color:#0DB7A8;">Second opinion</a>
                            </div>



                            <div class='starrr navbar-right' id='star1' style="margin-right: -99px;margin-top: 20px;"> 
                                <div style="margin-left:5px">&nbsp;
                                    <span class='your-choice-was' style='display:none;'>
                                        Your rating was <span class='choice'></span>
                                    </span>
                                </div> 
                            </div>   
                            <p>&nbsp;</p>
                        </div>
                        <input type="hidden" id="userid" value="">
                        <input type="hidden" id="patientid" value="">
                        <input type="hidden" id="dfees" value="">
                        <input type="hidden" id="apttid" value="">
                        <div class="col-md">      

                            <h4 style=" text-transform: capitalize;"><?php echo $DocInfoArr['first_name'] . ' ' . $DocInfoArr['last_name']; ?></h4> 
                            <span class="col-view">Address<?php echo " " . $DocInfoArr['city_name'] . " " . $DocInfoArr['state_name'] . " " . $DocInfoArr['country_name'] . "<br>"; ?></span>
                            <h5 class="title-details" style="padding-left:0">
                                <?php
                                $doctor_fees = "";
                                if (!empty($DocInfoArr['parent_hosp_id'])) { //means it belong to hospital
                                    $hospitalName = Yii::app()->db->createCommand()->select("hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $DocInfoArr['parent_hosp_id']))->queryScalar();
                                    echo $hospitalName;
                                    $doctor_fees = $DocInfoArr['doctor_fees'] . " Rs";
                                } else { //get clinic name
                                    $clinicDetails = Yii::app()->db->createCommand()->select("GROUP_CONCAT(clinic_name) as clinicname, min(opd_consultation_fee) as minrange,max(opd_consultation_fee) as maxrange")->from("az_clinic_details")->where("doctor_id = :id", array(":id" => $DocInfoArr['user_id']))->queryRow();
                                    echo $clinicDetails['clinicname'];
                                    if ($clinicDetails['minrange'] != $clinicDetails['maxrange'])
                                        $doctor_fees = $clinicDetails['minrange'] . " Rs - " . $clinicDetails['maxrange'] . " Rs";
                                    else
                                        $doctor_fees = $clinicDetails['minrange'] . " Rs ";
                                }
                                ?>
                            </h5>
<!--                            <p id="descriptiontext" style="height: 25px;overflow: hidden;"><?php //echo $DocInfoArr['description']; ?></p>
                            <a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
                                    $(this).hide();">Read More </a>-->
                            
                            <div style="width: 71%; text-align: justify;"> 
                                            <span class="more">  
                                                <?php echo $DocInfoArr['description']; ?>
                                            </span>
                                        </div>
                            
                            <div class="viewer"> 
                                <ul class="view-list">              
                                    <li style="padding-left:0"><span><img src="<?= $baseUrl; ?>/images/icons/icon34.png" style="width:12px"> <a class="btn-list"> 
                                                <?php
                                                if (!empty($doctor_fees)) {
                                                    echo "Fee - " . $doctor_fees;
                                                }
                                                ?>&nbsp;</a> 
                                        </span>
                                    </li>  

                                    <li><a href="" class="btn-default"><span><img src="<?= $baseUrl; ?>/images/icons/icon35.png" style="width:12px">Experience- <a class="btn-list"> <?php echo CommonFunction::CalculateAge($DocInfoArr['experience']);   ?></a> </span></li>		
                                    <li> <span><img src="<?= $baseUrl; ?>/images/icons/review.png" style="width:20px; height:20px"><a href="" class="btn-list">Review +15 </a></span></li>


                                </ul>
                            </div>      



                           
                            <div class="clearfix"></div>

                            <div class="Appointment-table">
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
                                <div class="viewer"> 
                                    <div class="col-md-6 appointment-button text-right">
                                        <?php echo CHtml::link('Book New Appointment', array("bookappointment/index"), array("class" => "btn-appoint","style"=>"color:#56b8a8")); ?>

                                    </div>

                                    <div class="col-md-6 appointment-button text-right">
                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'action' => Yii::app()->createUrl($this->route),
                                            'method' => 'get',
                                            'id' => 'appointmentsearch'
                                        ));
                                        echo $form->textField($appointmentModel, 'first_name', array("class" => "sarchfield", "placeholder" => "Enter Name/Mobile to search","style"=>"width:200px"));
                                        $this->endWidget();
                                        ?>
                                    </div>
                                </div> 
                                <div class="table-list">
                                    <?php
                                  //  $enc_key = Yii::app()->params->enc_key;
                                    $doctorId = Yii::app()->user->id;
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'appointment-grid',
                                        'dataProvider' => $appointmentModel->getDoctorAppointment($doctorId),
                                        'itemsCssClass' => 'table table-condensed table-hover table-stiped',
                                        'summaryCssClass' => 'label btn-info info-summery',
                                        'cssFile' => false,
                                        'pagerCssClass' => 'text-center middlepage',
                                        //'filter' => $model,
                                        'pager' => array(
                                            'htmlOptions' => array('class' => 'pagination'),
                                            'header' => false,
                                            'prevPageLabel' => '&lt;&lt;',
                                            'nextPageLabel' => '&gt;&gt;',
                                            'internalPageCssClass' => '',
                                            'selectedPageCssClass' => 'active'
                                        ),
                                        'columns' => array(
                                            array('header' => 'Patient Name',
                                                'value' => function($data) {
                                                    echo "$data->patient_name";
                                                }, 'htmlOptions' => array(), 'type' => 'raw'),
                                             array(
                                                'header' => 'Patient Mobile',
                                                'type' => 'raw',
                                                'value' => '$data->patient_mobile',
                                            ),
                                            array(
                                                //'asc'=>'$data->appointment_date',
                                                'header' => 'Appointment Date',
                                                'type' => 'raw',
                                                'value' => '!empty($data->appointment_date) ? date("d-m-Y",strtotime($data->appointment_date) ) : ""',
                                            ),
                                            array(
                                                'header' => 'Appointment Time',
                                                'type' => 'raw',
                                                'value' => 'date("h:i a",strtotime($data->time))',
                                            ),            
                                                        
                                                        
                                             array('header' => 'Place',
                                                'value' => function($data) {
                                                    echo "$data->clinic_name";
                                                }, 'htmlOptions' => array(), 'type' => 'raw'),
                                          
                                            array(
                                                'header' => 'Fees',
                                                'type' => 'raw',
                                                'value' => '$data->doc_fees',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Paid Fees',
                                                'type' => 'raw',
                                                'value' => '$data->payamtpay',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Add Payment',
                                                'type' => 'raw',
                                                'value' => 'CHtml::link("Add Payment","javascript:", array("onclick" => "payment($data->doc_fees,$data->doctor_id,$data->patient_id,$data->appointment_id)"))',
                                                'htmlOptions' => array("class" => "payment")
                                                ),
                                             array(
                                                'header' => 'Treatment',
                                                'type' => 'raw',
                                                'value' => 'CHtml::link("Treatment",array("site/treatmentDetails","id"=>Yii::app()->getSecurityManager()->encrypt($data->appointment_id,"' . $enc_key . '")))',
                                              
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>

                            </div>


                        </div>
                    </div> <!--col-md-12 end-->
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="paymentdetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">payment Details</h4>
            </div>
            <div class="modal-body" style="padding: 0px">

                <div class="form-grop">
                    <div class="col-sm-4">
                        <label class="control-label">Doctor Fess:</label>
                        <input type ="text" name="doctor_fees" class="form-control doctorfee" value="<?php echo $DocInfoArr['doctor_fees']; ?>">
                    </div>
                   
                    <div class="col-sm-4">
                         <?php
                    $form1 = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'id' => "userpaymentform"
                    ));
                    ?>
                        <label class="control-label">Enter Amount:</label>
                        <input type ="text" name="patient_pay_amt" class="form-control patientamt">
                    </div>
                      <?php $this->endWidget();?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="paymentdetail();">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    
     $(document).ready(function () {
    
    var showChar = 100;  // How many characters are shown by default
                                        var ellipsestext = "...";
                                        var moretext = "Show more >";
                                        var lesstext = "Show less";


                                        $('.more').each(function () {
                                            var content = $(this).html();

                                            if (content.length > showChar) {

                                                var c = content.substr(0, showChar);
                                                var h = content.substr(showChar, content.length - showChar);

                                                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent" ><span >' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                                                $(this).html(html);
                                            }

                                        });

                                        $(".morelink").click(function () {
                                            if ($(this).hasClass("less")) {
                                                $(this).removeClass("less");
                                                $(this).html(moretext);
                                            } else {
                                                $(this).addClass("less");
                                                $(this).html(lesstext);
                                            }
                                            $(this).parent().prev().toggle();
                                            $(this).prev().toggle();
                                            return false;
                                        });
   
    });
    function payment(fees, doctorid, patientid, apttid)
    {
        $("#userid").val(doctorid);
        $("#patientid").val(patientid);
        $("#dfees").val(fees);
        $("#apttid").val(apttid);
        $('#paymentdetails').modal('show');

    }
</script>

<style type="text/css">

                .morecontent span {
                    display: none;

                }
                .morelink {
                    display: block;
                }

            </style>