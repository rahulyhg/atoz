<?php
$session = new CHttpSession;
            $session->open();
              $user_id = $session['user_id'];
              
?>           

<section class="" style="background-color:#fff">
    <div class="row">
        <div class="col-sm-12 section-content">
            <div class="center-block" style="width: 90%;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul class="nav nav-tabs" role="tablist">
                    <li  class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Patient Information</a></li>
                </ul>
                <!-- Tab navigation -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active col-sm-10 " id="tab1" style="">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'book-appointment-form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => array("onsubmit" => " return validateform();"),
                        ));
                        ?>
                        <div class="queryform">
                            <div class="selfpatient">
                                <div class="form-group clearfix">
                                    <label class="control-label">
                                        <?php
                                        echo $form->checkbox($model,'is_patient',array("class" => "isselfpatitent","onclick" => "showpatientform(this);"));
                                        ?> I am the patient</label>
                                    <p><span id="agree1" class="error1"></span></p>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group cleaxfix">
                                    <label class="col-md-4 control-label">Patient Name</label>
                                    <div class="col-sm-8">
                                        
                                        <?php 
                                        
                                        echo $form->textField($model,'patient_name',array("class"=>"form-control col-sm-6 patname","placeholder"=>"e.g. Xyz","data-rule-required" => "true","data-msg-required"=>"Please Enter Patient Name"));
                                        ?>
                                        <span class="formerror"></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group cleaxfix">
                                    <label class="col-md-4 control-label">Patient Mobile</label>
                                    <div class="col-sm-8">
                                        <?php 
                                        echo $form->textField($model,'patient_mobile',array("class"=>"form-control col-sm-6 patmobile","placeholder"=>"+91","data-rule-required" => "true","data-msg-required"=>"Please Enter Patient Mobile", "data-rule-regexp" => "^[\d]+$","maxlength" => 10));
                                        ?>
                                        <span class="formerror"></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="otherpatient" style="display: none;">
                                <div class="form-group cleaxfix">
                                    <label class="col-md-4 control-label">Your Mobile Number</label>
                                    <div class="col-sm-8">
                                        <?php 
                                        echo $form->textField($model,'creator_number',array("class"=>"form-control col-sm-6 patcrtno","placeholder"=>"+91","data-rule-required" => "true","data-msg-required"=>"Please Enter Your Number", "data-rule-regexp" => "^[\d]+$","maxlength" => 10));
                                        echo $form->hiddenField($model,'doctor_id');
                                        ?>
                                        <span class="formerror"></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group cleaxfix">
                                    <label class="col-md-4 control-label">Relationship with patient</label>
                                    <div class="col-sm-8">
                                        <?php 
                                        $optionArr = array("Father/Mother"=>"Father/Mother", "Spouse" => "Spouse","Children" => "Children");
                                        echo $form->dropDownList($model,'relationship',$optionArr,array("class"=>"form-control col-sm-6 patrel","prompt" => "Select Relationship","data-rule-required" => "true","data-msg-required"=>"Please Select Relationship"));
                                        ?>
                                        <span class="formerror"></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group cleaxfix">
                                    <label class="col-md-4 control-label">Nature of visit</label>
                                    <div class="col-sm-8">
                                        <?php 
                                        $optionArr = array("firstvisit" => "First Time Visit", "followup" => "Follow Up Visit");
                                        echo $form->radioButtonList($model,'type_of_visit',$optionArr,array("class"=>"patvisittype",'labelOptions'=>array('style'=>'display:inline'),'separator'=>'  '));
                                        ?>
                                        <span class="formerror"></span>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            </div>
                            
                            <div class="clerafix text-center">
                                <button class="btn" type="button" onclick="confirmdetails();" >Confirm</button><!-- Submit button -->
                                <div class="clearfix"></div>
                            </div> 
                        </div>
                        <div class="appointdateinfo" style="display:none;">
                            <div class="alert alert-danger" role="alert" style="display:none; "></div>
                            <div class="form-group clearfix text-center">
                                <label class="doctorname control-label col-sm-12"><?php echo  "Dr. " . $doctorprofile['first_name'] . " " . $doctorprofile['last_name'];?></label>
                                <label class="doctoraddress control-label col-sm-12"><?php echo $doctorprofile['address'];
                                if(!empty($doctorprofile['area_name']))
                                    echo ", " . $doctorprofile['area_name'] ;
                                if(!empty($doctorprofile['city_name']))
                                echo "," . $doctorprofile['city_name'] . "," ;
                                if(!empty($doctorprofile['state_name'])) 
                                  echo  $doctorprofile['state_name']; ?></label>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group clearfix text-center">
                                <input type="text" id="doctorno" value="<?php echo $doctorprofile['apt_contact_no_1']; ?>" disabled="" class="text-center"/>
                                <div class="clearfix"></div>
                            </div>
                          
                            <div class="form-group clearfix text-center" style="<?php echo $source != 'freeoffer' ? 'display:none;' : ''; ?>">
                                <label class="">Enter Promo Code</label>
                                <div class="text-center">
                                    <div class="promocode" style="">
                                        <input type="text" name="AptmtQuery[promocode]" class="promo" style="" id="promo">
                                        <div>
                                            <span id="promoerror" style="color: red;"></span>
                                            <span id="promosuccess" style="color: green;"></span>
                                        </div>
                                    </div>
                                    <button class="btn" type="button" onclick="checkpromo(<?php echo $user_id;?>);" style="padding: 6px" >Apply</button>
                                    <?php 
                                    echo $form->hiddenField($model,'promo_id',array("class"=>"promoid"));
                                    ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                           
                            <div class="form-group clearfix text-center">
                                <label class="">Request for Appointment</label>
                                <div class="text-center">
                                    <div class="input-group  date datepick" style="width:250px;margin: 0 auto;">
                                        <?php 
                                        echo $form->textField($model,'preferred_day',array("class"=>"form-control","placeholder"=>"Select Date For Appointment","data-rule-required" => "true","data-msg-required"=>"Please Select Date"));
                                        ?>
                                        <span class="input-group-addon" style="padding:6px !important;"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group clearfix text-center">
                                <label class="">Please confirm appointment schedule in consultation with Doctor</label>
                                <div class="clearfix"></div>
                                <input type ="hidden" name="AptmtQuery[doctorfees]" value ="<?php echo $docfee;?>" class="docfees">
                                <input type ="hidden" name="AptmtQuery[clinic_id]" value ="<?php echo $clinic_id;?>" class="docfees">
                            </div>
                            <div class="clerafix text-center">
                                
                                <button class="btn" type="button" onclick="bookappointment();" >Done</button><!-- Submit button -->
                                <div class="clearfix"></div>
                            </div> 
                        </div>
                        <div class="paymentinfo clearfix" style="display:none; ">
                            <div class="alert alert-success" role="alert" style="display:none; "></div>
                            <div class="alert alert-danger" role="alert" style="display:none; "></div>
                                <div class="center-block text-center" style="width: 70%; border: 1px solid #dfdfdf;">
                                  
                                    <p>Cash On Counter</p>
                                    
                                    <?php if($docfee == 0){
                                        $docfee = 'NA';
                                    }
?>
                                    
                                    <label class="control-label col-sm-12">Fees : <span class="appointfeetext">Rs <?php echo $docfee;?></span></label>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .appointdateinfo .form-group label {color : #0db7a8;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-datepicker.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function(){
        $.validator.addMethod(
        "regexp",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $("#book-appointment-form").validate({
        errorElement: "label",
        ignore:":not(:visible)",
        errorClass: "help-block has-error",
        errorPlacement: function (error, element) {
            if (element.parents("label").length > 0) {
                console.log("inif");
                element.parents("label").after(error);
            } else {
                
                if($(element).parent(".input-group ").length > 0){
                    $(element).parent(".input-group ").after(error);
                }else{
                    element.after(error);
                }
            }
        },
        highlight: function (label) {
            $(label).closest("div").removeClass("has-error has-success").addClass("has-error");
        },
        success: function (label) {
            label.addClass("valid").closest("div").removeClass("has-error has-success").addClass("has-success");
        },
        onkeyup: function (element) {
            $(element).valid();
        },
        onfocusout: function (element) {
            $(element).valid();
        }
    });
        $(".datepick").datepicker({
            autoclose : true,
            format: 'dd-mm-yyyy',
            startDate : "+1d",
            endDate :"+30d"
        });
    });
function showpatientform(htmlObj) {
    if($(htmlObj).prop("checked")) {
        $(".otherpatient").hide();
    }else{
        $(".otherpatient").show();
    }
}
function confirmdetails(){
   // alert($("#book-appointment-form").valid());
    if($("#book-appointment-form").valid()){
        
        $(".queryform").hide();
        $(".appointdateinfo").fadeIn()
    }
}
function bookappointment(){
    if($("#book-appointment-form").valid()){
       

        $.ajax({
            //async: false,
            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/confirmappointment"); ?> ',
            data:$("#book-appointment-form").serialize(),
            success:function(data)
            {
                if(data) {
                    $(".appointdateinfo").hide();
                    $(".paymentinfo .alert-success").html("Your request for appointment sent successfully.");
                    $(".paymentinfo .alert-success").show();
                    $(".paymentinfo").fadeIn();
                }else{
                    $(".appointdateinfo .alert-danger").html("Problem in Appointment. Please Try after some time");
                    $(".appointdateinfo .alert-danger").show();
                }
            }
        });
    }
}
function checkpromo(userid)
{
    var promo = $("#promo").val();
    if(promo != '') {
        
        $('#promoerror').html(""); 
        $("#promosuccess").html("");
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/checkpromocode"); ?> ',
            data: {promo: promo,userid:userid},
            success: function (data) {
                 var result = data.result;
                if (result.promo_status == "available") {
                    $("#promosuccess").html("<i class='fa fa-check fa-1'></i> Promo Code Applied Successfully ");
                    $(".promoid").val(result.promoid);
                    $(".docfees").val("FREE");
                    $(".appointfeetext").text("FREE");
                }else{
                   $('#promoerror').html(result.promo_status); 
                }
            }
        });  
    }
}
</script>