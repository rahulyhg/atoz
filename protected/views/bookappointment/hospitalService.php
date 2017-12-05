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
                <h4 class="col-sm-12" >Create Appointment</h4>

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
                <div class="form-grop clearfix" style="margin-top:15px;">
                    <div class="col-sm-4">
                        <label>Hospital Service<span class="required">*</span></label>
                        <?php
                        $hospDrIdArr = array();
                        $serviceIdStr = $roleIdStr = "[";
                        $serHospital = Yii::app()->db->createCommand()->select("u.user_id,hospital_name,role_id")->from("az_user_details u")->where("parent_hosp_id = :id and role_id <> 3 and is_active=1", array(":id" => $hid))->queryAll();
                        if (!empty($serHospital)) {
                            foreach ($serHospital as $key => $value) {
                                $hospDrIdArr[$value['user_id']] = $value['hospital_name'];
                                $serviceIdStr .= $value['user_id'].",";
                                $roleIdStr .= $value['role_id'].",";
                            }
                            $serviceIdStr = rtrim($serviceIdStr, ",");
                            $roleIdStr = rtrim($roleIdStr, ",");
                        }
                        $serviceIdStr .= "]";
                        $roleIdStr .= "]";
                        echo $form->dropDownList($model,"center_id", $hospDrIdArr, array( "class"=> "form-control doctid","prompt" => "Select Service"));
                        $model->parent_hosp_id = $hid;
                        echo $form->hiddenField($model, 'parent_hosp_id', array("class" => "hospitalselect hospitalid"));
                        echo $form->hiddenField($model, 'role_id', array("class" => "hospitalselect serroleid"));
                        echo $form->hiddenField($model, 'query_bookid', array("class" => "query_bookid"));
                        echo $form->hiddenField($model, 'patient_id', array('maxlength' => 10, "class" => "form-control patient_id"));
                        echo CHtml::hiddenField("calenderurl",Yii::app()->createUrl("bookappointment/getMonthCalendar"),array( "class"=> "calenderurl"));
                        echo CHtml::hiddenField("fillSlotsPopupUrl",Yii::app()->createUrl("bookappointment/fillSlotsPopup"),array( "class"=> "fillSlotsPopupUrl"));      
                        echo CHtml::hiddenField("getBookingFormUrl",Yii::app()->createUrl("bookappointment/getBookingForm"),array( "class"=> "getBookingFormUrl"));
                        ?>
                        <?php echo $form->error($model, 'center_id'); ?>
                    </div>
                    <div class="col-sm-4">
                        <label>Relation</label>
                        <?php echo $form->dropDownList($model, 'relation', array('SELF' => 'SELF', 'SPOUSE' => 'SPOUSE', 'FATHER' => 'FATHER', 'MOTHER' => 'MOTHER', 'CHILDREN' => 'CHILDREN', 'OTHERS' => 'OTHERS'), array("class"=> "form-control selecttype" , 'onChange' => 'typeestablishment();')); ?>
                        <?php echo $form->error($model, 'relation'); ?>
                    </div>
                    <div class="col-sm-4 otherrelation" style="display:none">
                        <label>Please Specify</label>
                        <?php echo $form->textField($model, 'other_relation_dis', array("class" => "form-control")); ?>
                        <?php echo $form->error($model, 'other_relation_dis'); ?>   
                    </div>
                </div>
                <div class="clearfix" style="margin-top:15px;"> <!--accept patient appointment details--> 
                    <div class="col-sm-4">
                        <?php echo $form->labelEx($model, 'mobile_no', array("class" => "")); ?>
                        <div>
                            <div class="col-sm-9" style="">
                            <?php
                            echo $form->textField($model, 'mobile_no', array('maxlength' => 10, "class" => "form-control pmobile"));
                            ?>
                            <?php echo $form->error($model, 'mobile_no'); ?>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="buttons pserch btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <?php echo $form->labelEx($model, 'full_name', array("class" => "")); ?>
                        <?php echo$form->textField($model, 'full_name', array("class" => "form-control", "id" => "patient_name")); ?>
                        <?php echo $form->error($model, 'full_name'); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->labelEx($model, 'patient_age', array("class" => "")); ?>
                        <?php echo $form->textField($model, 'patient_age', array('class' => 'form-control', "data-rule-required" => "true", "data-msg-required" => "Please Enter Age")); ?>
                        <?php echo $form->error($model, 'patient_age'); ?>
                    </div>
                </div>
                <div class="clearfix">
                    <?php 
                    $displayStyle = "display:none;";
                    if($model->role_id == 8 ){ 
                        $displayStyle = "";
                    } 
                    ?>
                    <div class="col-sm-4 role_base role_8" style="<?php echo $displayStyle;?>">
                        <label>Blood Group</label>
                        <?php echo $form->dropDownList($model, 'blood_group', array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'otherselect form-control w3-input input-group', 'prompt' => 'Select Blood Group', "data-msg-required" => "Please select Blood Group")); ?>
                        <?php echo $form->error($model, 'blood_group'); ?>                                                     
                    </div>

                    <div class="col-sm-4  role_base role_8" style="<?php echo $displayStyle;?>">
                        <label>No Of Unit</label>
                        <?php
                        echo $form->textField($model, 'no_of_unit', array('class' => 'form-control'));
                        echo $form->error($model, 'no_of_unit');
                        ?>                                                                  
                    </div>
                </div>
                <div class="clearfix">
                    <?php 
                    $displayStyle = "display:none;";
                    if($model->role_id == 6 || $model->role_id == 7 ){ 
                        $displayStyle = "";
                        } ?>
                    <div class="col-sm-4  role_base role_6 role_7" style="<?php echo $displayStyle;?>">   
                         <?php echo $form->labelEx($model, 'service_name', array("class" => "")); ?>
                         <?php
                         $services = array();
                         $servicename = Yii::app()->db->createCommand()
                                 ->select('t.service_id,sm.service_name')
                                 ->from('az_service_user_mapping t')
                                 ->join('az_service_master sm', 't.service_id = sm.service_id')
                                 ->where('t.user_id=:id', array(':id' => $model->center_id))
                                 ->queryAll();
                        foreach ($servicename as $key => $value) {
                             $services[$value['service_id']] = $value['service_name'];
                         }
                         echo $form->dropDownList($model,"service_name", $services, array( "class"=> "form-control","prompt" => "Select Service"));
                         echo $form->error($model, 'service_name'); ?>
                     </div>
                     
                     <div class="col-md-4">
                         <?php echo $form->labelEx($model, 'discription_doc', array("class" => "")); ?>
                         <?php
                         if(!empty($model->discription_doc)) {
                             echo "<div><a href='".Yii::app()->baseUrl."/uploads/".$model->discription_doc."' target='_blank'>Click Here To Get Attachment</a></div>";
                         }
                         echo $form->fileField($model, 'discription_doc', array("class" => "w3-input input-group"));
                         echo $form->error($model, 'discription_doc');
                         ?> 
                     </div>
                     <div class="col-md-4">
                         <label>At Home Service </label>
                         <div class="clearfix"></div>
                         <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Collect @ Home </button>
                     </div>
                 </div>
                <div class="" >
                    <div class="col-sm-6">
                        &nbsp;
                    </div>
                    <div class="dropdown keep-open col-sm-6">
                        <div id="demo" <?php if(!empty($model->pincode)) { ?> aria-expanded="true" class="collapse in" <?php }else{ ?> class="collapse" <?php } ?> >
                            <div class="dorp-form" style="background-color:#eee; display:inline-block;border:1px solid #ddd;">

                                <h4 class="title-details" style="padding:15px">Address </h4>
                                <div class="form-group clearfix">
                                    <div class="input-pfn col-md-4">
                                        <label> Zip Code </label> 
                                        <?php
                                        if (isset($session['pincode'])) {
                                            $model->pincode = $session['pincode'];
                                        }
                                        echo $form->textField($model, 'pincode', array("class" => "form-control input-group pincode-id-class"));
                                        echo $form->error($model, 'pincode');
                                        ?>
                                    </div>

                                    <div class="input-pfn col-md-4">
                                        <b><span>State</span></b>
                                        <?php
                                        $stateArr = array();
                                        $selected = array();
                                        $stateType = Yii::app()->db->createCommand()->select("state_id,state_name")->from("az_state_master")->queryAll();
                                        foreach ($stateType as $row) {
                                            $stateArr[$row['state_id']] = $row['state_name'];
                                        }
                                        echo $form->dropDownList($model, 'state_id', $stateArr, array("class" => "form-control state-class", "style" => "width:100%;", "prompt" => "Select State", "data-rule-required" => "true", "data-msg-required" => "Please Select State", 'onchange' => 'getCity()'));
                                        echo $form->error($model, 'state_id');
                                        echo $form->hiddenField($model, "state_name", array("class" => "state-id-class"));
                                        ?>   
                                    </div>
                                    <div class="input-pfn col-md-4">

                                        <b><span>City<strong class="mandatory">*</strong></span></b>
                                        <?php
                                        $cityArr = array();
                                        if (!empty($model->state_id)) {
                                            $citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $model->state_id))->queryAll();
                                            foreach ($citycmd as $row) {
                                                $cityArr[$row['city_id']] = $row['city_name'];
                                            }
                                        }
                                        echo $form->dropDownList($model, 'city_id', $cityArr, array("class" => "form-control cityId city-class", "style" => "width:100%;", "prompt" => "Select City", "data-rule-required" => "true", "data-msg-required" => "Please Select City", 'onchange' => 'getArea()'));
                                        echo $form->error($model, 'city_id');
                                        echo $form->hiddenField($model, "city_name", array("class" => "city-id-class"));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="input-pfn col-md-4">
                                        <b><span>Area</span></b>
                                        <?php
                                        $areaArr = array();
                                        $selected = array();
                                        if (!empty($model->city_id)) {
                                            $stateType = Yii::app()->db->createCommand()->select("area_id,area_name")->from("az_area_master")->where('city_id=:id', array(':id' => $model->city_id))->queryAll();
                                            foreach ($stateType as $row) {
                                                $areaArr[$row['area_id']] = $row['area_name'];
                                            }
                                        }
                                        echo $form->dropDownList($model, 'area_id', $areaArr, array("class" => "form-control area-class areaId", "style" => "width:100%;", "prompt" => "Select Area", "data-rule-required" => "true", "data-msg-required" => "Please Select Area", 'onchange' => 'getAreaid()'));
                                        echo $form->error($model, 'area_id');
                                        echo $form->hiddenField($model, "area_name", array("class" => "area-id-class"));
                                        ?>   

                                    </div>
                                    <div class="input-pfn col-md-4">

                                        <b><span>Landmark<strong class="mandatory">*</strong></span></b>
                                        <?php
                                        echo $form->textField($model, 'landmark', array("class" => "form-control input-group"));
                                        echo $form->error($model, 'landmark');
                                        ?>
                                    </div>                                       
                                    <div class="input-pfn col-md-4">
                                        <b><span>Address<strong class="mandatory">*</strong></span></b>
                                        <?php
                                        echo $form->textField($model, 'address', array("class" => "form-control input-group"));
                                        echo $form->error($model, 'address');
                                        ?>
                                    </div>       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- ===============================================================
                        box preview available time slots
                ================================================================ -->
                <div class="box_preview_container_all " id="box_slots" style="display:none;margin-left: 15px;">
                    <div class="box_preview_title" id="popup_title">Available Time</div>
                    <div class="box_preview_slots_container" id="slots_popup" style="margin-left: 15px;">

                    </div>
                </div>

                <!-- ===============================================================
                        booking calendar begins here
                ================================================================ -->
                <div class="header_container col-sm-12" id="container_all">
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
                <div class="calendar_container_all" style="margin-left: 15px;">
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
                <div class="booking_container_all col-sm-12" id="booking_container" style="display:none">
                    <div id="slot_form">

                    </div>
                </div>
                <div class="cleardiv">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-center">
                    <?php echo CHtml::submitButton('Confirm', array("class" => "btn btn-primary")); ?>
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
                <button type="button" class="btn btn-primary" onclick="setSelectedPatient()" style="margin-bottom:0;">Select</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php echo $this->renderPartial("_statecity");?>
<script language="javascript" type="text/javascript" src="js/bookappointjs/jquery.bxSlider.min.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_core.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_form.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/tmt_libs/tmt_validator.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/wach.calendar.js"></script>
<script language="javascript" type="text/javascript" src="js/bookappointjs/lib.min.js"></script>

<script language="javascript" type="text/javascript">
    var serviceIdArr = <?php echo $serviceIdStr;?>;
    var roleIdArr = <?php echo $roleIdStr;?>;                        
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
    var resultArr = [];
    var uploadurl = '<?php echo Yii::app()->baseUrl."/uploads/"; ?>';
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
            var hospitalid = $(".hospitalid").val();
            var doctid = $(".doctid").val();
            if(mobile == "") {
                alert("Please Enter Patient Mobile Number");
            }else{
            $.ajax({
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/findServicePatient"); ?> ',
                data: {mobile: mobile, userid: doctid,hospitalid :hospitalid },
                success: function (resultdata) {
                    var str = "";
                    var dataobj = resultdata.data;
                    if ($.isEmptyObject(resultdata)) {
                        $(".tablecontent").after("This is Not Register user");
                    } else {
                        var index = 0;
                        if(dataobj.source == "query") {
                            str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th><th>Age</th><th>Appointment Date</th></thead> <tbody>";
                            $.each(dataobj.resultset, function (key, value) {
                                resultArr[index] = { selectedsource : 'query', patient_id : value.patient_id,book_id : value.book_id, role_id : value.role_id,center_id : value.center_id, relation : value.relation,other_relation_dis : value.other_relation_dis, patient_name : value.patient_name,patient_mobile : value.patient_mobile, patient_age : value.patient_age,service_name : value.service_name, total_charges : value.total_charges,collect_home : value.collect_home, blood_group : value.blood_group,no_of_unit : value.no_of_unit, status : value.status,pincode : value.pincode, country_id : value.country_id,country_name : value.country_name, state_id : value.state_id,state_name : value.state_name, city_id : value.city_id,city_name : value.city_name, area_id : value.area_id,area_name : value.area_name, landmark : value.landmark,address : value.address, parent_hosp_id : value.parent_hosp_id,preferred_day : value.preferred_day, discription_doc : value.discription_doc  }; 
                                str += "<tr><td><input type='radio' name='patientlist' class='pradio' value='"+index+"'></td><td> " + value.patient_name + " </td><td> " + value.patient_mobile + " </td><td> " + value.patient_age + " </td><td> " + value.preferred_day + " </td></tr>";
                                index++;
                            });
                            str += "</tbody></table>";
                        }else if(dataobj.source == "exist") {
                            str += "<table class='table table-bordered selectpatient'> <thead><th>selection</th><th>Patient Name</th> <th>Patient Mobile</th><th>Age</th></thead> <tbody>";
                            if(dataobj.resultset == false) {
                                str += "<tr><td colspan='4' style='text-align:center;'>No Patient Found</td></tr>";
                            }else{
                                $.each(dataobj.resultset, function (key, value) {
                                    resultArr[index] = { selectedsource : 'exist', patient_id : value.user_id, patient_name : value.patient_name,patient_mobile : value.patient_mobile, patient_age : value.age }; 
                                    var patage = "";
                                    if(value.age != null)
                                        patage = value.age;
                                    str += "<tr><td><input type='radio' name='patientlist' class='pradio' value='"+index+"'></td><td> " + value.patient_name + " </td><td> " + value.patient_mobile + " </td><td> " + patage + " </td></tr>";
                                    index++;
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
            selectYear = aptdatearr[0];
            selectMonth = aptdatearr[1];
            selectDay = aptdatearr[2];
        }
        getBookingForm(selectYear, selectMonth, selectDay, '1', '1') ;
        <?php }else{ ?>
            getMonthCalendar((newday.getMonth() + 1), newday.getFullYear(), '1', '1');
        <?php } ?>
            
        
        $(".doctid").change(function(){
            getMonthCalendar((newday.getMonth() + 1), newday.getFullYear(), '1', '1');
            //$("#patient_name").val("");
            $("#fees").val("");
            //$(".patient_id").val("");
            var selectedRole = 0;
            var selectid = $(this).val();
            for(var i = 0; i < serviceIdArr.length; i++) {
                if(serviceIdArr[i] == selectid) {
                    $(".serroleid").val(roleIdArr[i]);
                    selectedRole = roleIdArr[i];
                }
            }
            $(".role_base").hide();
            $(".role_"+selectedRole).show();
            
        })
    });
    function typeestablishment(){
        var user1 = $('.selecttype').val();
        if (user1 == 'OTHERS'){
            $(".otherrelation").show();
        }else{
            $(".otherrelation").hide();
        }
    }
    function setSelectedPatient(){
        if($(".pradio:checked").length != 0) {
            var selectedIndex = $(".pradio:checked").val();
            var selectedsource = resultArr[selectedIndex].selectedsource;
            if(selectedsource == "query") {
                $(".query_bookid").val(resultArr[selectedIndex].book_id);
                $("#LabBookDetails_center_id").val(resultArr[selectedIndex].center_id);
                $("#LabBookDetails_relation").val(resultArr[selectedIndex].relation);
                $("#LabBookDetails_other_relation_dis").val(resultArr[selectedIndex].other_relation_dis);
                $("#patient_name").val(resultArr[selectedIndex].patient_name);
                $(".patient_id").val(resultArr[selectedIndex].patient_id);
                $("#LabBookDetails_patient_age").val(resultArr[selectedIndex].patient_age);
                $("#LabBookDetails_blood_group").val(resultArr[selectedIndex].blood_group);
                $("#LabBookDetails_no_of_unit").val(resultArr[selectedIndex].no_of_unit);
                $("#LabBookDetails_service_name").val(resultArr[selectedIndex].service_name);
                if(resultArr[selectedIndex].discription_doc != null)
                    $("<div><a href='"+uploadurl+resultArr[selectedIndex].discription_doc+"' target='_blank'>Click Here To Get Attachment</a></div>").before("#LabBookDetails_discription_doc");
                $("#LabBookDetails_pincode").val(resultArr[selectedIndex].pincode);
                if(resultArr[selectedIndex].pincode != null){
                    getPincodeCity(pincode);
                    $(".dropdown").toggle();
                }
                $("#LabBookDetails_state_id").val(resultArr[selectedIndex].state_id);
                $("#LabBookDetails_state_name").val(resultArr[selectedIndex].state_name);
                $("#LabBookDetails_city_id").val(resultArr[selectedIndex].city_id);
                $("#LabBookDetails_city_name").val(resultArr[selectedIndex].city_name);
                $("#LabBookDetails_area_id").val(resultArr[selectedIndex].area_id);
                $("#LabBookDetails_area_name").val(resultArr[selectedIndex].area_name);
                $("#LabBookDetails_landmark").val(resultArr[selectedIndex].landmark);
                $("#LabBookDetails_address").val(resultArr[selectedIndex].address);
                $("#LabBookDetails_role_id").val(resultArr[selectedIndex].role_id);
                if(resultArr[selectedIndex].parent_hosp_id != null)
                    $("#LabBookDetails_address").val(resultArr[selectedIndex].parent_hosp_id);
                
                var selectYear, selectMonth, selectDay;
                var aptdate = resultArr[selectedIndex].preferred_day;
                if (aptdate != null){
                    var aptdatearr = aptdate.split("-");
                    selectYear = aptdatearr[2];
                    selectMonth = aptdatearr[1];
                    selectDay = aptdatearr[0];
                }
                
                $("#myModal").modal("hide");
                getBookingForm(selectYear, selectMonth, selectDay, '1', '1') ;
            }else if(selectedsource == "exist") {
                $("#patient_name").val(resultArr[selectedIndex].patient_name);
                $(".patient_id").val(resultArr[selectedIndex].patient_id);
                if(resultArr[selectedIndex].patient_age != null)
                    $("#LabBookDetails_patient_age").val(resultArr[selectedIndex].patient_age);
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