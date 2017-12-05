
<?php
$session = new CHttpSession;
$session->open();
$userid = $session['user_id'];
$enc_key = Yii::app()->params->enc_key;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/multiple-select.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery.timepicker.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datepicker.css');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/multiple-select.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.timepicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js', CClientScript::POS_END);
$default = date("Y-m-d");
if (!empty($model->appointment_date)) {
    $default = date("Y-m-d", strtotime($model->appointment_date));
}
Yii::app()->clientScript->registerScript('myjavascript', '
    $(".appointmentdate").datetimepicker({
        //inline: true,
        sideBySide: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        stepping : 5,
      format:"DD-MM-YYYY",
      minDate :new Date(),
     // defaultDate : new Date("' . $default . '")
    });
     $(".appointmentdate").on("dp.change", function(e) {
     console.log(e);
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var date11 = new Date(e.date);
        var dayName = days[date11.getDay()];
        console.log(dayName);
        $("#dayOfWeek").val(dayName);
    });      

    var chckslot = [[moment({ h: 18,m:00 }), moment({ h: 18,m:30 })], [moment({ h: 20,m:00 }), moment({ h: 20,m:30 })]];        
    $(".visittime").datetimepicker({
               // inline: true,
                sideBySide: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
                
                stepping : 5,
                 format:"h:mm A",
                 disabledTimeIntervals: chckslot,
    });
   
', CClientScript::POS_END);
?>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container">
                <div class="profile-note text-right">
                    <a href="<?php echo $this->createUrl('site/docViewAppointment'); ?>" style="color:#0DB7A8;"> All Appointment </a> | <a href="<?php echo $this->createUrl('site/listDocAppointment', array('doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),"type"=>"Appointment")); ?>" style="color:#0DB7A8;"> All Request </a>
                </div>
                <h4>Create Appointment</h4>

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'patient-details-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
                ));
                ?>

                <?php //echo $form->errorSummary($model); ?>
                <div class="form-group" style="margin-top:15px;"> <!--accept patient appointment details--> 
                    <?php
                    $lable = "Hospital  ";
                    if (empty($doctorModel['parent_hosp_id'])) {
                        $lable = "Clinic ";
                    }if ($role_id == 6) {
                        $lable = "Pathology";
                    }if ($role_id == 7) {
                        $lable = "Diagnostic ";
                    }
                    ?>

                    <label class="col-sm-2 control-label required" for="PatientAppointmentDetails_hospital_id"><?php echo $lable; ?><span class="required">*</span></label>

                    <div class="col-sm-2">
                        <?php
                        $hospIdArr = array();
                        if (!empty($doctorModel['parent_hosp_id'])) {
                            $doctHospital = Yii::app()->db->createCommand()->select("hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $doctorModel['parent_hosp_id']))->queryScalar();
                            $hospIdArr[$doctorModel['parent_hosp_id']] = $doctHospital;
                            $model->is_clinic = "N";
                        } else {
                            $doctClinic = Yii::app()->db->createCommand()->select("clinic_id,clinic_name")->from("az_clinic_details")->where("doctor_id = :id", array(":id" => $id))->queryAll();
                            if (!empty($doctClinic)) {
                                foreach ($doctClinic as $row) {
                                    $hospIdArr[$row['clinic_id']] = $row['clinic_name'];
                                }
                            }
                            $model->is_clinic = "Y";
                        }
                        echo $form->dropDownList($model, 'hospital_id', $hospIdArr, array("class" => "form-control hospitalselect hospitalid"));
                        echo $form->hiddenField($model, 'is_clinic', array('maxlength' => 10, "class" => "form-control"));
                        ?>
                        <?php echo $form->error($model, 'hospital_id'); ?>
                    </div>

                    <?php echo $form->labelEx($model, 'patient mobile', array("class" => "col-sm-2 control-label ")); ?>
                    <div class="col-sm-2">
                        <?php
                        echo $form->textField($model, 'patient_mobile', array('maxlength' => 10, "class" => "form-control pmobile"));
                        ?><button type="button" class="buttons pserch" data-toggle="modal" data-target="#myModal" >Search</button>
                        <?php echo $form->error($model, 'patient_mobile'); ?>

                    </div>
                    <?php
                    if ($role_id == 3 || $role_id == 5) {     //show only to  doctor or hospital 
                        echo $form->labelEx($model, 'type_of_visit', array("class" => "col-sm-2 control-label"));
                        ?>
                        <div class="col-sm-2">
                            <?php
                            if (empty($model->type_of_visit)) {
                                $model->type_of_visit = 'firstvisit';
                            }
                            echo $form->radioButtonList($model, 'type_of_visit', array('firstvisit' => 'firstvisit', 'followup' => 'followup'), array('class' => 'visit', 'labelOptions' => array('style' => ''), 'separator' => '&nbsp;&nbsp;&nbsp;', 'template' => '<label class="ui-radio-inline">{input} <span>{label}</span></label>', 'container' => 'div class="ui-radio ui-radio-pink"'));
                            ?>
                            <?php echo $form->error($model, 'type_of_visit'); ?>
                        </div>

                    <?php } ?>

                </div>
                <div class="form-group" style="margin-top:15px;">
                    <?php echo $form->labelEx($model, 'appointment_date', array("class" => "col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo$form->textField($model, 'appointment_date', array("class" => "form-control appointmentdate", "id" => "appointmentdate")); ?>
                        <?php echo $form->error($model, 'appointment_date'); ?>
                    </div>
                    <?php echo $form->labelEx($model, 'day', array("class" => "col-sm-2 control-label")); ?>

                    <div class="col-sm-2">

                        <?php
                        if (!empty($model->appointment_date)) {
                            $model->day = date("l", strtotime($model->appointment_date));
                        }
                        echo$form->textField($model, 'day', array("class" => "form-control", "id" => "dayOfWeek"));
                        ?>
                        <?php echo $form->error($model, 'day'); ?>
                    </div>
                    <?php echo $form->labelEx($model, 'time', array("class" => "col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo $form->textField($model, 'time', array("class" => "form-control visittime", "placeholder" => "select To")); ?>
                        <span>To</span>
                        <input type="text" class="visittime form-control" name="from" placeholder="select From">

                        <?php echo $form->error($model, 'time'); ?>
                    </div>

                </div>
                <div class="form-group" style="margin-top:15px;">
                    <?php echo $form->labelEx($model, 'patient_name', array("class" => "col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo$form->textField($model, 'patient_name', array("class" => "form-control", "id" => "patient_name")); ?>


                    </div>

                    <?php if ($role_id == 3 || $role_id == 5) {     //show only to  doctor or hospital ?>
                        <label class ="col-sm-2 control-label">Doctor fees:</label>

                    <?php }if ($role_id == 6) { ?>

                        <label class ="col-sm-2 control-label">Pathology fees:</label>
                    <?php } if ($role_id == 7) { ?>

                        <label class ="col-sm-2 control-label">Diagnostic fees:</label>
                    <?php } ?>
                    <div class="col-sm-2">
                        <?php
                        echo$form->textField($model, 'doc_fees', array("class" => "form-control", "id" => "fees"));
                        echo $form->hiddenField($model, 'pid', array("class" => "", "id" => "pid"));
                        ?>
                    </div>
                </div>
                <div class="form-group text-center">

                    <div class="container">



                    </div>


                    <div class="form-grop clearfix tableformat" style="display: none;"> <!-- display visiting hospital information -->
                        <div class="col-sm-9 col-sm-offset-2">
                            <?php
//                $visitdetailArr = Yii::app()->db->createCommand()
//                        ->select('*')
//                        ->from('az_doctor_visiting_details')
//                        ->where('doctor_id=:id', array(':id' => $id))
//                        ->queryALL();
                            //  print_r($visitdetailArr);
                            ?>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>hospital Name</th>
                                        <th>visiting Time</th>
                                        <th>day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>



                            </table>

                            <div class="clearfix">&nbsp;</div>
                        </div>
                    </div>
                    <div class="clearfix text-center">
                        <?php echo CHtml::submitButton('Confirm', array("class" => "btn btn- confirm")); ?>
                    </div>

                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Patient Information</h4>
            </div>
            <div class="modal-body tablecontent" >

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="patientname()">Select</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">

                    $(function () {

                        var pname = "";
                        var pmobile = "";
                        var visittype = "";
                        var aptdate = "";
                        var docfees = "";
                        var pid = "";
                        var arr1 = [];
                        var arr2 = [];
                        var timeoption = "";

                        $(".pmobile").blur(function () {
                            var mobile = $('.pmobile').val()
                            if (mobile === '')
                            {
                                $(".pserch").hide();
                                $(".confirm").hide();
                            }
                            else
                            {
                                $(".pserch").show();
                                $(".confirm").show();
                            }
                        });
                        $(".pserch").click(function () {//check patient is authorized or not

                            var mobile = $('.pmobile').val();
                            var userid = '<?php echo $session['user_id']; ?>';
                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                cache: false,
                                url: '<?php echo Yii::app()->createUrl("site/getPatientDetails"); ?> ',
                                data: {mobile: mobile, userid: userid},
                                success: function (data) {
                                    var str = "";
                                    var dataobj = data.data;
                                    if ($.isEmptyObject(data)) {
                                        $(".tablecontent").after("This is Not Register user");
                                        //return;
                                    }
                                    else {
                                        str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th><th>Visit type</th><th>Visit fees</th><th>Appointment Date</th></thead> <tbody>";

                                        $.each(dataobj, function (key, value) {

                                            str += "<tr><td><input type='radio' name='patientlist' class='pradio' id='radio1' onclick=test(this);><td class='pid hidden'> " + value.id + "</td></td><td class='fname'> " + value.patient_name + " </td><td class='mobile'> " + value.patient_mobile + "</td><td class='visittype'> " + value.type_of_visit + " </td><td class='docfees'>" + value.apt_fees + "</td><td class='aptdate'>" + value.preferred_day + "</td></tr>";
                                        });
                                        str += "</table> </tbody>";

                                        var apt = $('.aptdate').val();
                                        //alert(apt);


                                        $(".tablecontent").html(str);
                                        if (typeof (apt) === "undefined")
                                        {
                                            var today = new Date();
                                            var dd = today.getDate();
                                            var mm = today.getMonth() + 1; //January is 0!

                                            var yyyy = today.getFullYear();
                                            if (dd < 10) {
                                                dd = '0' + dd;
                                            }
                                            if (mm < 10) {
                                                mm = '0' + mm;
                                            }
                                            var today = dd + '/' + mm + '/' + yyyy;
                                            document.getElementById("DATE").value = today;


//                                           alert(apt);
//                                           var d = new Date('YY-M-D');
                                            //   alert(today);
                                            $('.aptdate').html(today);
                                        }
                                    }

                                }
                            });

                        });
                        $(".hospitalid").change(function () {
                            var hospital = $('.hospitalid option:selected').val();
                            var hospital1 = $('.hospitalid option:selected').text();
                        });
//                        $("#appointmentdate").blur(function () {
//                           
//                            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
//                            var date1 = $("#appointmentdate").val();
//                            
//                            var date11 = new Date(date1);
//                            var dayName = days[date11.getDay()];
//                            $("#dayOfWeek").val(dayName);
//                        });
                    });
                    function test(htmlobj)
                    {
                        pid = $(htmlobj).closest("tr").find(".pid").text();
                        pname = $(htmlobj).closest("tr").find(".fname").text();
                        pmobile = $(htmlobj).closest("tr").find(".mobile").text();
                        visittype = $(htmlobj).closest("tr").find(".visittype").text();
                        aptdate = $(htmlobj).closest("tr").find(".aptdate").text();
                        docfees = $(htmlobj).closest("tr").find(".docfees").text();
                    }
                    function patientname()
                    {
                        $("#patient_name").val(pname);
                        $("#appointmentdate").val(aptdate);
                        $("#fees").val(docfees);
                        $("#pid").val(pid);
                        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        var date11 = new Date(aptdate);
                        var dayName = days[date11.getDay()];
                        $("#dayOfWeek").val(dayName);
                        $("input[name='PatientAppointmentDetails[type_of_visit]'][value=" + visittype + "]").attr('checked', 'checked');
                        $("#myModal").modal("hide");
                    }

                    function  patientamttime()
                    {

                        //  aptdate = $("#appointmentdate").val();
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            cache: false,
                            url: '<?php echo Yii::app()->createUrl("site/getSelectedAptTime"); ?> ',
                            data: {aptdate: aptdate},
                            success: function (result) {
                                var time1 = "";
                                var time2 = "";
                                var time3 = "";
                                var dataobj = result;
                                var timeslotArr = [];
                                //[moment({ h: 18,m:00 }), moment({ h: 18,m:30 })]
                                $.each(dataobj, function (key, value) {

                                    time1 = value.time;
                                    arr1 = time1.split(":");

                                    var minuteval = parseInt(arr1[1]) + 30;

                                    time2 = moment.utc(value.time, 'hh:mm').add(30, 'minutes').format('hh:mm');
                                    arr2 = time2.split(":");

                                    var currentTimeSlot = [moment({h: arr1[0], m: arr1[1]}), moment({h: arr2[0], m: arr2[1]})];
                                    //var currentTimeSlot = [moment({ h: parseInt(arr1[0]),m:parseInt(arr1[1]) })];
                                    timeslotArr.push(currentTimeSlot);

                                    time3 += "['" + [] + "'],";
                                });

                                $('.visittime').data("DateTimePicker").disabledTimeIntervals(timeslotArr);
                                $(".visittime").datetimepicker({
                                    sideBySide: true,
                                    icons: {
                                        time: "fa fa-clock-o",
                                        date: "fa fa-calendar",
                                        up: "fa fa-arrow-up",
                                        down: "fa fa-arrow-down"
                                    },
                                    stepping: 5,
                                    format: "h:mm A",
                                    disabledTimeIntervals: timeslotArr,
                                });

                            }

                        });
                    }
</script>

