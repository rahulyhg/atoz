<?php
$session = new CHttpSession;
$session->open();
$userid = $session['user_id'];
$enc_key = Yii::app()->params->enc_key;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/radio_style.css');
?>
<link rel="stylesheet" href="js/bookappointjs/mainstyle.css" type="text/css" />
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container">
                <div class="profile-note text-right">
                    <a href="<?php echo $this->createUrl('site/docViewAppointment'); ?>" style="color:#0DB7A8;"> All Appointment </a> | <a href="<?php echo $this->createUrl('site/listDocAppointment', array('doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key), "type" => "Appointment")); ?>" style="color:#0DB7A8;"> All Request </a>
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

                <?php echo $form->errorSummary($model); ?>
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
                        echo $form->hiddenField($model, 'is_clinic', array('maxlength' => 10, "class" => "form-control is_clinic"));
                        echo $form->hiddenField($model, 'patient_id', array('maxlength' => 10, "class" => "form-control patient_id"));
                        echo CHtml::hiddenField("user", $userid, array( "class"=> "doctid"));
                        echo CHtml::hiddenField("calenderurl",Yii::app()->createUrl("bookappointment/getMonthCalendar"),array( "class"=> "calenderurl"));
                        echo CHtml::hiddenField("fillSlotsPopupUrl",Yii::app()->createUrl("bookappointment/fillSlotsPopup"),array( "class"=> "fillSlotsPopupUrl"));      
                        echo CHtml::hiddenField("getBookingFormUrl",Yii::app()->createUrl("bookappointment/getBookingForm"),array( "class"=> "getBookingFormUrl"));
                        ?>
                        <?php echo $form->error($model, 'hospital_id'); ?>
                    </div>

                    <?php echo $form->labelEx($model, 'patient_mobile', array("class" => "col-sm-2 control-label ")); ?>
                    <div class="col-sm-2">
                        <div class="col-sm-9" style="padding: 0;">
                        <?php
                        echo $form->textField($model, 'patient_mobile', array('maxlength' => 10, "class" => "form-control pmobile"));
                        ?>
                        <?php echo $form->error($model, 'patient_mobile'); ?>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="buttons pserch btn btn-primary btn-sm">Search</button>
                        </div>
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
                    <?php echo $form->labelEx($model, 'patient_name', array("class" => "col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo$form->textField($model, 'patient_name', array("class" => "form-control", "id" => "patient_name")); ?>


                    </div>

                    <?php if ($role_id == 3 || $role_id == 5) {     //show only to  doctor or hospital ?>
                        <label class ="col-sm-2 control-label">Doctor fees<span class="required">*</span> :</label>
                    <?php }if ($role_id == 6) { ?>
                        <label class ="col-sm-2 control-label">Pathology fees<span class="required">*</span> :</label>
                    <?php } if ($role_id == 7) { ?>
                        <label class ="col-sm-2 control-label">Diagnostic fees<span class="required">*</span> :</label>
                    <?php } ?>
                    <div class="col-sm-2">
                        <?php
                        echo $form->textField($model, 'doc_fees', array("class" => "form-control", "id" => "fees"));
                        echo $form->hiddenField($model, 'enquiry_id', array("class" => "", "id" => "enquiry_id"));
                        ?>
                    </div>
                </div>
                <!-- ===============================================================
                        box preview available time slots
                ================================================================ -->
                <div class="box_preview_container_all" id="box_slots" style="display:none">
                    <div class="box_preview_title" id="popup_title">Available Time</div>
                    <div class="box_preview_slots_container" id="slots_popup">

                    </div>
                </div>

                <!-- ===============================================================
                        booking calendar begins here
                ================================================================ -->
                <div class="header_container" id="container_all">
                    <!-- month and navigation -->
                    <div class="month_container_all">
                        <!-- month -->
                        <div class="month_container  month_container_custom" style="background-color: #333333;">
                            <div class="font_custom month_name month_name_custom" id="month_name" style="color: #FFFFFF;"></div>
                            <div class="font_custom month_year year_name_custom" id="month_year" style="color: #999999;"></div>
                        </div>

                        <!-- navigation -->
                        <div class="month_nav_container" id="month_nav">
                            <div class="mont_nav_button_container" id="month_nav_prev" ><a href="javascript:getPreviousMonth(1,'1',-1);" class="month_nav_button month_navigation_button_custom" style="background-color: #333333;"><img src="js/bookappointjs/prev.png" /></a></div>
                            <div class="mont_nav_button_container" id="month_nav_next" ><a href="javascript:getNextMonth(1,'1',-1);" class="month_nav_button month_navigation_button_custom" style="background-color: #333333;"><img src="js/bookappointjs/next.png" /></a></div>
                        </div>
                        <div class="cleardiv"></div>
    <!--                <div class="back_today" id="back_today"><a href="javascript:getMonthCalendar((today.getMonth()+1),today.getFullYear(),$('#calendar_id').val(),'1');">BACK_TODAY</a></div>-->
                    </div>
                </div>
                <div class="cleardiv"></div>
            <!-- =======================================
                calendar
                ======================================== -->
                <!-- calendar -->
                <div class="calendar_container_all">
                    <!-- days name -->
                    <div class="name_days_container" id="name_days_container">
                        <div class="font_custom day_name weekdays_custom">MONDAY</div>
                        <div class="font_custom day_name weekdays_custom">TUESDAY</div>
                        <div class="font_custom day_name weekdays_custom">WEDNESDAY</div>
                        <div class="font_custom day_name weekdays_custom">THURSDAY</div>
                        <div class="font_custom day_name weekdays_custom">FRIDAY</div>
                        <div class="font_custom day_name weekdays_custom">SATURDAY</div>
                        <div class="font_custom day_name weekdays_custom" style="margin-right: 0px;">SUNDAY</div>

                    </div>

                    <!-- days -->
                    <div class="days_container_all" id="calendar_container">
                            <!-- content by js -->
                    </div>
                </div>
                <!-- =======================================
                booking form. It appears once user clicked on a day
                ======================================== -->
                <div class="booking_container_all" id="booking_container" style="display:none">
                    <div id="slot_form">

                    </div>
                </div>
                <div class="cleardiv"></div>
                <div class="form-group text-center">
                    <?php echo CHtml::submitButton('Confirm', array("class" => "btn btn- confirm")); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Patient Information</h4>
            </div>
            <div class="modal-body tablecontent" >

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="setSelectedPatient()">Select</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script language="javascript" type="text/javascript" src="js/bookappointjs/jquery.bxSlider.min.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_core.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_form.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_validator.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/wach.calendar.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/lib.min.js"></script>

<script language="javascript" type="text/javascript">
    var currentMonth;
    var currentYear;
    var pageX;
    var pageY;
    var today = new Date();
    var newday = new Date();

    var booking_day_white_bg = '#FFFFFF';
    var booking_day_white_bg_hover = '#567BD2';
    var booking_day_black_bg = '#333333';
    var booking_day_black_bg_hover = '#567BD2';
    var booking_day_white_line1_color = '#999999';
    var booking_day_white_line1_color_hover = '#FFFFFF';
    var booking_day_white_line2_color = '#00CC33';
    var booking_day_white_line2_color_hover = '#FFFFFF';
    var booking_day_black_line1_color = '#FFFFFF';
    var booking_day_black_line1_color_hover = '#FFFFFF';
    var booking_day_black_line2_color = '#FFFFFF';
    var booking_day_black_line2_color_hover = '#CCCCCC';
    var booking_recaptcha_style = 'white';

    $(function () {
        $('#back_today').fadeOut(0);
        
        
        var pname = "";
        var pmobile = "";
        var visittype = "";
        var aptdate = "";
        var docfees = "";
        var pid = "";
        var arr1 = [];
        var arr2 = [];
        var timeoption = "";

        $(".pserch").click(function () {//check patient is authorized or not

            var mobile = $('.pmobile').val();
            var is_clinic = $(".is_clinic").val();
            var hospitalid = $(".hospitalid").val();
            var doctid = $(".doctid").val();
            if(mobile == "") {
                alert("Please Enter Patient Mobile Number");
            }else{
            $.ajax({
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/getPatientDetails"); ?> ',
                data: {mobile: mobile, userid: doctid,is_clinic : is_clinic, hospitalid :hospitalid },
                success: function (resultdata) {
                    var str = "";
                    var dataobj = resultdata.data;
                    if ($.isEmptyObject(resultdata)) {
                        $(".tablecontent").after("This is Not Register user");
                    } else {
                        if(dataobj.source == "query") {
                            str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th><th>Visit type</th><th>Visit fees</th><th>Appointment Date</th></thead> <tbody>";
                            $.each(dataobj.resultset, function (key, value) {
                                str += "<tr><td><input type='radio' name='patientlist' class='pradio'><input type='hidden' class='selectedsource' value='query'/><input type='hidden' class='querycreator' value='" + value.created_by + "'/></td><td class='pid hidden'> " + value.id + "</td></td><td class='fname'> " + value.patient_name + " </td><td class='mobile'> " + value.patient_mobile + "</td><td class='visittype'> " + value.type_of_visit + " </td><td class='docfees'>" + value.apt_fees + "</td><td class='aptdate'>" + value.preferred_day + "</td></tr>";
                            });
                            str += "</tbody></table>";
                        }else if(dataobj.source == "exist") {
                            str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th></thead> <tbody>";
                            if(dataobj.resultset == false) {
                                str += "<tr><td colspan='4' style='text-align:center;'>No Patient Found</td></tr>";
                            }else{
                                $.each(dataobj.resultset, function (key, value) {
                                    str += "<tr><td><input type='radio' name='patientlist' class='pradio'><input type='hidden' class='selectedsource' value='exist'/><input type='hidden' class='docfees' value='" + value.apt_fees + "'/></td><td class='pid hidden'> " + value.user_id, + "</td></td><td class='fname'> " + value.patient_name + " </td><td class='mobile'> " + value.patient_mobile + "</td></tr>";
                                });
                            }
                            
                            str += "</tbody></table> ";
                        }
                        
                        $(".tablecontent").html(str);
                    }
                    $('#myModal').modal('show');
                }
            });
            }
        });
        $(".hospitalid").change(function () {
            var hospital = $('.hospitalid option:selected').val();
            var hospital1 = $('.hospitalid option:selected').text();
        });
        <?php if(!empty($model->appointment_date)) {?>
        var aptdate = '<?php echo $model->appointment_date;?>';
        var selectYear, selectMonth, selectDay;
        if (aptdate != null){
            var aptdatearr = aptdate.split("-");
            selectYear = aptdatearr[2];
            selectMonth = aptdatearr[1];
            selectDay = aptdatearr[0];
        }
        getBookingForm(selectYear, selectMonth, selectDay, '1', '1') ;
        <?php }else{ ?>
            getMonthCalendar((newday.getMonth() + 1), newday.getFullYear(), '1', '1');
        <?php } ?>    
    });
    
    function setSelectedPatient(){
        if($(".pradio:checked").length != 0) {
            var htmlobj = $(".pradio:checked");
            var selectedsource = $(htmlobj).closest("tr").find(".selectedsource").val();
            var docfees = $(htmlobj).closest("tr").find(".docfees").text();
            if(selectedsource == "query") {
                var visittype = $(htmlobj).closest("tr").find(".visittype").text();
                var aptdate = $(htmlobj).closest("tr").find(".aptdate").text();
                
                $("#patient_name").val($(htmlobj).closest("tr").find(".fname").text());
                //$("#appointmentdate").val(aptdate);
                if(docfees != null){
                    $("#fees").val(docfees);
                }
                $("#enquiry_id").val($(htmlobj).closest("tr").find(".pid").text());
                $(".patient_id").val($(htmlobj).closest("tr").find(".querycreator").val());
                
                //var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                //var date11 = new Date(aptdate);
                //var dayName = days[date11.getDay()];
                //$("#dayOfWeek").val(dayName);
                $("input[name='PatientAppointmentDetails[type_of_visit]'][value=" + visittype + "]").attr('checked', 'checked');
                var selectYear, selectMonth, selectDay;
                if (aptdate != null){
                    var aptdatearr = aptdate.split("-");
                    selectYear = aptdatearr[2];
                    selectMonth = aptdatearr[1];
                    selectDay = aptdatearr[0];
                }
                
                $("#myModal").modal("hide");
                getBookingForm(selectYear, selectMonth, selectDay, '1', '1') ;
            }else if(selectedsource == "exist") {
                $("#patient_name").val($(htmlobj).closest("tr").find(".fname").text());
                if(docfees != null){
                    $("#fees").val(docfees);
                }
                $(".patient_id").val($(htmlobj).closest("tr").find(".pid").text());
                 $("#myModal").modal("hide");
            }
            
           
        }else{
            alert("Please Select Patient");
        }
        
    }

    function getMonthName(month) {
        var m = new Array();
        m[0] = "JANUARY";m[1] = "FEBRUARY";m[2] = "MARCH";m[3] = "APRIL";m[4] = "MAY";m[5] = "JUNE";
        m[6] = "JULY";m[7] = "AUGUST";m[8] = "SEPTEMBER";m[9] = "OCTOBER";m[10] = "NOVEMBER";m[11] = "DECEMBER";
        $('#month_name').html(m[(month - 1)]);
        currentMonth = month;

        if ((today.getMonth() + 1) != (month)) {
            $('#back_today').fadeIn();
        } else {
            $('#back_today').fadeOut(0);
        }
    }


    function showResponse(calendar_id) {
        $('#container_all').parent().prepend('<div id="sfondo" class="modal_sfondo" onclick="hideResponse(' + calendar_id + ',\'1\',' + newday.getFullYear() + ',' + (newday.getMonth() + 1) + ')"></div>');
        $('#ok_response').attr("href", "javascript:hideResponse(" + calendar_id + ",'1'," + newday.getFullYear() + "," + (newday.getMonth() + 1) + ");");
        $('#modal_response').fadeIn('slow');
        $('#submit_button').removeAttr("disabled");
    }

    function updateCalendarSelect(category) {
        $.ajax({
            url: 'ajax/getCalendarsList.php?category_id=' + category,
            success: function (data) {
                arrData = data.split('|');
                $('#calendar_select_input').html(arrData[0]);
                $("#calendar_select_input").val($("#calendar_select_input option:first").val());
                 var newday = today;

                $('#calendar_id').val($("#calendar_select_input option:first").val());
                getMonthCalendar((newday.getMonth() + 1), newday.getFullYear(), arrData[1], '1');
            }
        });
    }
    function updateCalendar(calendar_id) {
        $.ajax({
            url: 'ajax/getCalendar.php?calendar_id=' + calendar_id,
            success: function (data) {
                var newday = today;
                $('#calendar_id').val(calendar_id);
                getMonthCalendar((newday.getMonth() + 1), newday.getFullYear(), calendar_id, '1');
            }
        });

    }

</script>