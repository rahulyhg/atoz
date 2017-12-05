<?php
$enc_key = Yii::app()->params->enc_key;

$session = new CHttpSession;
$session->open();
$hid = $session["user_id"];
?>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('search', "
$('.sarchfield').blur(function(){
    $('#appointment-grid').yiiGridView('update', {
            data: $('#appointmentsearchform').serialize()
    });

    return false;
});
$('.sarchfield1').blur(function(){
    $('#appointment-grid').yiiGridView('update', {
            data: $('#appointmentsearchform').serialize()
    });

    return false;
});
$('.sarchfield2').blur(function(){
    $('#appointment-grid').yiiGridView('update', {
            data: $('#appointmentsearchform').serialize()
    });

    return false;
});
$('.sarchfield3').blur(function(){
    $('#appointment-grid').yiiGridView('update', {
            data: $('#appointmentsearchform').serialize()
    });

    return false;
});
$('.sarchfield5').blur(function(){
    $('#doctor-grid').yiiGridView('update', {
            data: $('#usersearchform').serialize()
    });

    return false;
});
$('.sarchfield6').blur(function(){
    $('#doctor-grid').yiiGridView('update', {
            data: $('#usersearchform').serialize()
    });

    return false;
});
$('.sarchfield4').blur(function(){
    $('#doctor-grid').yiiGridView('update', {
            data: $('#usersearchform').serialize()
    });

    return false;
});
$('#PatientAppointmentDetails_appointment_date').datetimepicker({
        //inline: true,
        sideBySide: true,
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-arrow-up',
            down: 'fa fa-arrow-down'
        },
        stepping : 5,
      format:'DD-MM-YYYY',
      maxDate :new Date(),
    });
	
");

Yii::app()->clientScript->registerScript('search1', "
 function testFun(userid, htmlObj) {
    var is_active;
    var result = jQuery(htmlObj).is(':checked');
    if(result==true)
         is_active = '1';
    else
        is_active = '0';
       
    $.ajax({
          url:'" . Yii::app()->createUrl('UserDetails/ActiveStatus') . "', 
          type : 'POST', 
          data : {is_active:is_active, user_id:userid},
          success:function(data) {
              if(is_active === '1'){
                  alert('User Activated successfully');
              }else{
                alert('User Deactivated successfully');
              }

          }
      });
       
    }

", CClientScript::POS_END);
?>
<?php
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
            url: '" . Yii::app()->createUrl("site/getappointpayment") . "',
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
<section class="content" id="menu1">
    <?php
    $quercount = Yii::app()->db->createCommand() ->select('count(id)')->from('az_aptmt_query')->where('doctor_id IN(SELECT user_id FROM az_user_details WHERE parent_hosp_id=:id AND role_id = 3)AND apt_confirm ="No"', array(':id' => $id))->queryScalar();
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Enquiry </span>
                <span class="info-box-number"><?php echo $quercount; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->       

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    <?php
    $quercount = Yii::app()->db->createCommand()->select('count(appointment_id)')->from(' az_patient_appointment_details')->where('hospital_id=:id ', array(':id' => $id))->queryScalar();
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user" aria-hidden="true"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Appointments   </span>
                <span class="info-box-number"><?php echo $quercount; ?> </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <?php
    $DoctorcountArr = Yii::app()->db->createCommand()->select('count(user_id) doctorcount')->from(' az_user_details t')->where('t.parent_hosp_id=:id AND role_id = 3', array(':id' => $id)) ->queryScalar();
    ?>
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-user-md" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Doctors </span>
                    <span class="info-box-number"><?php echo $DoctorcountArr; ?><small></small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                <?php
                $ReviewcountArr = Yii::app()->db->createCommand()
                        ->select('count(user_id) Notificationcount')
                        ->from(' az_rating t')
                        ->where('t.user_id=:id', array(':id' => $id))
                        ->queryScalar();
                ?>
                <div class="info-box-content">
                    <span class="info-box-text">Review </span>
                    <span class="info-box-number"><?php echo $ReviewcountArr; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">

            <div class="hospitaldetails">
                <!-- DIRECT CHAT -->
                <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title text-left col-md-12">Hospital's Appointment Details </h3>
                        <div class="row">
                            <div class="table-list">

                                <?php
                                $enc_key = Yii::app()->params->enc_key;
                                $hospitalId = Yii::app()->user->id;
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'appointment-grid',
                                    'dataProvider' => $apmtQuerymodel->getAppoimentQuery($hospitalId),
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
                                        array(
                                            'header' => 'PATIENT NAME',
                                            'value' => '$data->patient_name',
                                        ),
                                        array(
                                            'header' => 'PATIENT MOBILE',
                                            'value' => '$data->patient_mobile',
                                        ),
                                        array(
                                            'header' => 'TYPE OF VISIT',
                                            'value' => '$data->type_of_visit',
                                        ),
                                        array(
                                            'header' => 'DOCTOR NAME',
                                            'value' => '$data->doctor_name',
                                        ),
                                        array(
                                            'header' => 'BOOK APPOINTMENT',
                                            'type' => 'raw',
                                            'value' => 'CHtml::link("Book Appointment",array("bookappointment/hospitaldr","enquiry"=>$data->id))',
                                            'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                    ),
                                ));
                                ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="hospitaldetails">
                <!-- DIRECT CHAT -->
                <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title text-left col-md-12">Hospital's Doctor Details </h3>
                        <span>&nbsp;</span>
                        <?php
                        $form1 = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                            'id' => "usersearchform"
                        ));
                        ?>
                        <div class="col-md-3">
                            <span class="progress-text hospital-h1">Search Doctors </span>                    
                            <div id="imaginary_container"> 
                                <div class="input-group stylish-input-group">
                                    <?php
                                    echo $form1->textField($userdetailModel, 'doctorname', array("class" => "sarchfield4 form-control", "placeholder" => "Enter Doctor Name to search"));
                                    ?>
                                    <span class="input-group-addon">

                                    </span>
                                </div>
                            </div>                     
                        </div>
                        <div class="col-md-3">
                            <span class="progress-text hospital-h1">Speciality </span>                    
                            <div id="imaginary_container"> 
                                <div class="input-group stylish-input-group">
                                    <?php
                                    echo $form1->textField($userdetailModel, 'speciality', array("class" => "sarchfield5 form-control", "placeholder" => "Enter Doctor Speciality to search"));
                                    ?>
                                    <span class="input-group-addon">

                                    </span>
                                </div>
                            </div>                     
                        </div>
                        <div class="col-md-3">
                            <span class="progress-text hospital-h1">Search Mobile Number </span>
                            <div id="imaginary_container"> 
                                <div class="input-group stylish-input-group">
                                    <?php
                                    echo $form1->textField($userdetailModel, 'apt_contact_no_1', array("class" => "sarchfield6 form-control", "placeholder" => "Enter Doctor Mobile to search"));
                                    ?>
                                    <span class="input-group-addon">

                                    </span>
                                </div>
                            </div>                        	                           
                        </div>

                        <div class="clearfix"></div>
                        <?php $this->endWidget(); ?>
                        <div class="text-center"><!--link div-->
                            <?php
                            echo CHtml::link('Add Doctors ', array('userDetails/createHospDoc', "param1" => base64_encode($id)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                        </div><!--link End--> 
                        <div class="row">
                            <div class="table-list">
                                <?php
                                $enc_key = Yii::app()->params->enc_key;
                                $hospitalId = Yii::app()->user->id;
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'doctor-grid',
                                    'dataProvider' => $userdetailModel->getHospitalDoctor($hospitalId),
                                    'itemsCssClass' => 'table table-condensed table-hover table-stiped',
                                    'summaryCssClass' => 'label btn-info info-summery',
                                    'cssFile' => false,
                                    'pagerCssClass' => 'text-center middlepage',
                                   
                                    'pager' => array(
                                        'htmlOptions' => array('class' => 'pagination'),
                                        'header' => false,
                                        'prevPageLabel' => '&lt;&lt;',
                                        'nextPageLabel' => '&gt;&gt;',
                                        'internalPageCssClass' => '',
                                        'selectedPageCssClass' => 'active'
                                    ),
                                    'columns' => array(
                                        array(
                                            'header' => 'DOCTOR NAME',
                                            'value' => function($data) {
                                                echo "$data->first_name $data->last_name";
                                            },
                                        ),
                                        array(
                                            'header' => 'SPECIALTY',
                                            'value' => '$data->speciality_name',
                                        ),
                                        array(
                                            'header' => 'SKILLS',
                                            'value' => '$data->sub_speciality'
                                        ),
//                                        array(
//                                            'header' => 'OPD TIME-RANGE',
//                                            'value' => function($data) {
//                                               // echo "10AM-2PM";
//                                            },
//                                        ),
                                        array(
                                            'header' => 'OPD FEES',
                                            'value' => '$data->doctor_fees'
                                        ),
                                        array(
                                            'header' => 'FREE OPD PER DAY',
                                            'value' => '$data->free_opd_perday'
                                        ),
                                        array(
                                            'header' => 'MOBILE NO.',
                                            'value' => '$data->apt_contact_no_1'
                                            
                                        ),
                                        array(
                                            'header' => 'DEACTIVE',
                                            'type' => 'raw',
                                            'value' => '$data->ActiveStatus($data->is_active, $data->user_id)',
                                            'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                        array(
                                            'class' => 'CButtonColumn',
                                            'header' => 'EDIT',
                                            'template' => '{update}',
                                            'buttons' =>
                                            array(
                                                'update' =>
                                                array(
                                                    'label' => '<i class="fa fa-pencil fa-fw"></i>',
                                                    'url' => 'Yii::app()->createUrl("userDetails/updateHospitalDoctor",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                                                    'imageUrl' => false,
                                                    'options' => array('title' => 'Edit'),
                                                ),
                                            ),
                                            'htmlOptions' => array('style' => 'text-align:center; width:100px;'),
                                        ),
                                    ),
                                ));
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-12">

        <div class="doctor-details">
            <!-- DIRECT CHAT -->
            <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <h3 class="box-title text-left">Doctor Appointment Details  </h3>
                    </div>   
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'id' => 'appointmentsearchform'
                    ));
                    ?>
                    <div class="col-md-3">
                        <span class="progress-text hospital-h1">Search Doctors </span>                    
                        <div id="imaginary_container"> 
                            <?php
                            echo $form->textField($appointmentModel, 'doctorname', array("class" => "sarchfield1 form-control", "placeholder" => "Enter Patient Name to search"));
                            ?>
                        </div>                     
                    </div>
                    <div class="col-md-3">
                        <span class="progress-text hospital-h1">Search Patients </span>                    
                        <div id="imaginary_container"> 
                            <?php
                            echo $form->textField($appointmentModel, 'first_name', array("class" => "sarchfield form-control", "placeholder" => "Enter Patient Name to search"));
                            ?>
                        </div>                     
                    </div>
                    <div class="col-md-3">
                        <span class="progress-text hospital-h1">Search Dates </span>                    
                        <div id="imaginary_container"> 
                            <div class="form-group">
                                <div class="input-group date stylish-input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php echo $form->textField($appointmentModel, 'appointment_date', array("class" => "sarchfield3 form-control", "placeholder" => "Enter Appointment Date to search")); ?>
                                    <span class="input-group-addon">
                                        <button type="submit">

                                        </button>  
                                    </span>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                        </div>                     
                    </div>                
                    <div class="col-md-3">
                        <span class="progress-text hospital-h1">Search Mobile Number </span>
                        <div id="imaginary_container"> 
                            <div class="input-group stylish-input-group">
                                <?php
                                echo $form->textField($appointmentModel, 'mobile', array("class" => "sarchfield2 form-control", "placeholder" => "Enter Patient Mobile to search"));
                                ?>
                                <span class="input-group-addon">
                                    <button type="submit">

                                    </button>  
                                </span>
                            </div>
                        </div>                        	                           
                    </div>
                    <?php $this->endWidget(); ?>
                    <div class="clearfix"></div>
                    <input type="hidden" id="userid" value="">
                    <input type="hidden" id="patientid" value="">
                    <input type="hidden" id="dfees" value="">
                    <input type="hidden" id="apttid" value="">

                    <div class="viewer text-center"> 
                        <div class="col-md-12 appointment-button text-center">
                            <button type="button" class="btn btn-primary text-center today">Today Appointment </button>
                            <?php echo CHtml::link("Add Appointment", array('bookappointment/hospitaldr'), array('class' => 'btn btn-info')); ?>

                        </div>                 
                    </div> 

                    <div class="input-pfn col-md-5">                                                                                              
                        <div class="dropdown keep-open">
                            <!-- Dropdown Button -->
                           <!-- <span>At Home Service </span>-->

                        </div> 
                    </div>
                </div>
                <section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
                    <div class="overlay">
                        <div class="row">
                            <!-- 2-column layout -->
                            <div class="container">
                                <div class="col-md section" style="">
                                    <div class="col-md">                   
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

                                                </div>
                                            </div>
                                            <div class="table-list">
                                                <?php
                                                $enc_key = Yii::app()->params->enc_key;
                                                $hospitalId = Yii::app()->user->id;
                                                $this->widget('zii.widgets.grid.CGridView', array(
                                                    'id' => 'appointment-grid',
                                                    'dataProvider' => $appointmentModel->getHospitalAppointment($hospitalId),
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
                                                        array(
                                                            'header' => 'DOCTOR NAME',
                                                            'value' => '$data->doctorname'
                                                        ),
                                                        array(
                                                            'header' => 'Specialty',
                                                            'value' => '$data->getSpecialtyName($data->doctor_id)',
                                                        ),
                                                        array('header' => 'PATIENT NAME',
                                                            'value' => function($data) {
                                                                echo "$data->patient_name";
                                                            }, 'htmlOptions' => array(), 'type' => 'raw'),
                                                        array('header' => 'PATIENT MOBILE',
                                                            'value' => function($data) {
                                                                echo "$data->patient_mobile";
                                                            },
                                                        ),
                                                        array(
                                                            'header' => 'DATE/TIME',
                                                            'type' => 'raw',
                                                            'value' => function($data) {
                                                                echo date("d-m-Y h:i A", strtotime($data->appointment_date . " " . $data->time));
                                                            },
                                                            'htmlOptions' => array("style" => "text-align:center;")
                                                        ),
                                                        array(
                                                            'header' => 'PROFILE',
                                                            'type' => 'raw',
                                                            'value' => 'CHtml::link("Profile","#",array("class"=>""))'
                                                        ),
//                                                        array(
//                                                            'header' => 'PATIENT HISTORY',
//                                                            'type' => 'raw',
//                                                            'value' => '$data->patient_name'
//                                                        ),
                                                        array(
                                                            'header' => 'REPORT',
                                                            'type' => 'raw',
                                                            'value' => 'CHtml::link("Report","#",array("class"=>""))'
                                                        ),
                                                        array(
                                                            'header' => 'Doctor Fees',
                                                            'type' => 'raw',
                                                            'value' => '$data->doc_fees'
                                                        ),
                                                        array(
                                                            'header' => 'Paid Fee',
                                                            'type' => 'raw',
                                                            'value' => '$data->payamtpay',
                                                            'htmlOptions' => array(), 'type' => 'raw'),
                                                        array(
                                                            'header' => 'Add Payment',
                                                            'type' => 'raw',
                                                            'value' => 'CHtml::link("Addpayment","javascript:", array("onclick" => "payment($data->doc_fees,$data->doctor_id,$data->patient_id,$data->appointment_id)"))',
                                                            'htmlOptions' => array("class" => "payment")
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
                </section>
            </div>

        </div>
    </div>
</div>
<div class="row">            
    <!--<div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Doctor Members</h3>

                <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="color:gray"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times" style="color:gray"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <?php $baseUrl = Yii::app()->baseUrl; ?>
                    <?php
//                    $doctor = Yii::app()->db->createCommand()
//                            ->select('t.user_id,first_name,last_name,doctor_fees,sub_speciality,apt_contact_no_1,speciality_name,profile_image')
//                            ->from(' az_user_details t')
//                            ->join('az_speciality_user_mapping sm', 'sm.user_id=t.user_id')
//                            ->where('t.parent_hosp_id=:id', array(':id' => $id))
//                            ->queryAll();
                    ?>
                    <?php //foreach ($doctor as $key => $value) {
                        ?>
                        <li>
                            <img src="<?php //echo $baseUrl . "/uploads/" . $value['profile_image'] ?>" height="132px" width="132px" class="img-circle img-responsive" alt="User Image">
                            <?php //echo CHtml::link($value['first_name'] . " " . $value['last_name'] . "<br>", array('UserDetails/viewHospitalDoctor', 'id' => Yii::app()->getSecurityManager()->encrypt($value['user_id'], $enc_key))); ?>

                        </li>
                    <?php //} ?>
                </ul>
            </div>
            <div class="box-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Users</a>
            </div>
        </div>
    </div>-->
</div>
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
                    <?php $this->endWidget(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="paymentdetail();" style="background-color:#0DB7A8;color:#fff">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

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
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 54px;
        height: 26px;
    }

    .switch input {display:none;}

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 19px;
        width: 19px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>



