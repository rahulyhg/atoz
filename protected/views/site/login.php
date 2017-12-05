<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
$session = new CHttpSession;
$session->open();
if (isset($session['rMobile'])) {
    unset($session['rFirName']);
    unset($session['rLastName']);
    unset($session['rMobile']);
    unset($session['rPassword']);
    unset($session['rpatienttype']);
    unset($session['rOtp']);
}
?>
<div id="login-form" class="login-form">
    <div class="loader loaderimg" >

    </div>
    <section class="" style="background-color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="row">
            <div class="col-sm-12 section-content">
                <div class="center-block" style="width: 90%;">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array("onsubmit" => " return checkuser();"),
                    ));
                    ?>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="login_reg" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Login</a></li>
                        <li role="login_reg"> <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Register</a></li>

                    </ul>
                    <!-- Tab navigation -->
                    <div class="tab-content">

                        <!--tab content-->
                        

                        <div role="tabpanel" class="tab-pane active col-sm-10 col-sm-offset-2" id="tab1" style="margin-top:15px;">
                            <div class="info clearfix successmsglogin" style="display: none;">
                                <div class="alert alert-warning alert-dismissible headermargin" style="padding:5px;"></div>
                            </div>
                            <div class="login">


                                <div class=" clearfix search-fields error-div col-sm-10 " style="display: none" id="rerrorid">
                                    <div class="alert alert-warning alert-dismissible fade in login_error" role="alert"  style="padding:5px; background-color:#E91724;border:1px solid #E91724;">
                                    </div>
                                </div>
                                <div class="form-group clearfix col-sm-offset-1">
                                    <?php echo $form->labelEx($model, 'Mobile No', array("class" => "col-sm-5 control-label")); ?>
                                    <div class="col-sm-8">
                                        <?php echo $form->textField($model, 'username', array('maxlength' => 50, "class" => "form-control user-class", "placeholder" => "+91", "maxlength" => "10")); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                </div>

                                <div class="form-group col-sm-offset-1 clearfix">
                                    <?php echo $form->labelEx($model, 'password', array("class" => "col-sm-5 control-label")); ?>
                                    <div class="col-sm-8">
                                        <?php echo $form->passwordField($model, 'password', array("class" => "form-control pass-class")); ?>
                                        <?php echo $form->error($model, 'password'); ?>
                                    </div>
                                </div>
                                <div class="form-group col-sm-offset-1 clearfix forgot">

                                    <div class="col-sm-8 text-right ">
                                        <?php echo CHtml::link("Forgot Password ? ", "#"); ?>
										<input type="hidden" id="redirecturl" value="<?php echo isset($redirectUrl) ? $redirectUrl : "";?>" />

                                    </div>
                                </div>

                                <div class="form-group clearfix text-center col-sm-8">
                                    <button class="btn btn-log" type="submit" >Confirm</button><!-- Submit button -->
                                </div>
                            </div>
                            <div class="frgtpsssection">
                                <div class="alert alert-warning alert-dismissible" role="alert"  style="background-color:#E91724;border:1px solid #E91724;padding:5px; display: none;"></div>
                                <div class="forgotpassword" style="display: none;">
                                    <div class="form-group clearfix col-sm-offset-1">
                                        <div class="col-sm-8">
                                            Mobile No<input type="text" name="mobile_no" class="chkmobile form-control" pattern="[789][0-9]{9}"  maxlength="10">
                                        </div>
                                       
                                        <a href="javascript:" onclick="back_to_login()" >Home</a>
                                    </div>
                                    <div class="form-group clearfix text-center col-sm-8">
                                        <button class="btn btn-log" type="button" onclick="chkMobileNo(); ">Send OTP</button><!-- Submit button -->
                                    </div>

                                </div>

                                <div class="ShowOTPpanel" style="display: none;">
                                    <div class="col-sm-12 headermargin">
                                        <label class="col-sm-3 control-label">Confirm OTP</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="otp_pass" class="form-control userotppanel form-control" placeholder="Enter OTP" value="">
                                        </div>
                                        <div class="headermargin col-sm-3" >
                                            <button class="btn OTP" type="button" onclick="verifydetails1();">Confirm</button><!-- Submit button -->
                                        </div>
                                    </div>  

                                    
                                </div>

                                <div class="PasswordPanel" style="display: none;">
                                    <div class="form-group clearfix col-sm-offset-1">
                                    <div class="col-sm-8">
                                        Password<input type="password" name="password" class="pwd form-control">
                                    </div>
                                   <div class="col-sm-8">
                                       Confirm Password<input type="password" name="confirmpassword" class="cpwd form-control	">
                                    </div>
                                 </div>
                                <div class="form-group clearfix text-center col-sm-8">
                                    <button class="btn btn-log" type="button" onclick="confirmPassword();">Confirm Password</button><!-- Submit button -->
                                </div>

                                </div>
                            </div>
                            
                            
                        </div>
                        <div role="tabpanel" class="tab-pane clearfix" id="tab2">
                            
                            <div class="Registerform">
                                <div class="loginheading" style="margin-top:15px;"><strong>Healthcare Consumer</strong></div>
                                <div class="col-sm-6" style="border-right: 2px solid #55607e;">
                                    <div class="search-fields rerror-div col-sm-10" style="display: none">
                                        <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="padding:5px; "></div>
                                    </div>
                                    <div class="form-group patient_type clearfix">
                                        <div class="loginheadingmargin">
                                            <label><input type="radio" name="patienttype" value="Individual" checked class="selectuser"> Individual</label>
                                           <!-- <label><input type="radio" name="patienttype" value="Premium member" class="selectuser"> Premium member</label>-->
                                            <label><input type="radio" name="patienttype" value="Corporate" class="selectuser"> Corporate </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-10 nopadding">
                                        <div class="form-group fullname">
                                            <label class="col-md-12 nopadding fullnamelbl" >Full Name</label>
                                            <div class="col-md-6 nopadding">
                                                <input type="text" name="firstname" class="form-control firstname1" placeholder="First Name" value=""><span id="firstname" class="error1"></span>
                                            </div>
                                            <div class="col-md-6" style="padding-right: 0;">
                                                <input type="text" name="lastname" class="form-control col-sm-6 lastname1" placeholder="Last Name" value="" ><span id="lastname" class="error1"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group company_name">
                                            <label class="col-md-12 nopadding">Company Name</label>
                                            <div class="col-md-12 nopadding">
                                                <input type="text" name="company_name" maxlength="10" class="form-control company_name1" placeholder="Company Name" value=""><span id="company_name" class="error1"></span>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group clearfix role">
                                            <label class="nopadding">write your designation collector, CEO etc.</label>
                                            <div class="" style="">
                                                <input type="text" name="role" class="form-control col-sm-6 role1" placeholder="VVIP" value=""><span id="role" class="error1" ></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div> 

                                        <div class="form-group cleaxfix">
                                            <label class="nopadding">Mobile No</label>
                                            <div class="">
                                                <input type="text" name="mobile" maxlength="10" class="form-control col-sm-6 mobile1" placeholder="Mobile Number" value=""><span id="mobile" class="error1"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="nopadding">Create Password</label>
                                            <div class="" style="">
                                                <input type="password" name="password" class="form-control col-sm-6 Password1" placeholder="Password" value=""><span id="Password" class="error1"></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>  



                                        <div class="form-group clearfix">
                                            <input type="checkbox" name="acceptcondition"  class="agree"/> Agree to Terms & Conditions
                                            <p><span id="agree1" class="error1"></span></p>
                                            <div class="clearfix"></div>
                                        </div> 
                                        <div class="clerafix text-center">
                                            <button class="btn OTP" type="button" onclick="Getdetails();" >Send OTP</button><!-- Submit button -->
                                        </div>

                                    </div>
                                    <span class="hidden-xs" style="position: absolute;top:50%;right: -10px;background: #ffffff;">OR</span>
                                </div>

                                <div class="col-sm-6">
                                    <div  class="col-sm-12" style="margin-top: 40%;">
                                        <div class="loginheading"><strong>Registration of Healthcare Service Provider</strong></div>
                                        <p>Doctors / Hospitals / Pathology Labs / Diagnostic Centers / Blood Banks / Medical Stores / Emergency Services</p>
                                        <strong><?php echo CHtml::link("Click Here", array("userDetails/registration"), array("style" => "color: #ff2946;")) ?> </strong>

                                    </div>
                                </div>
                            </div>

                            <div class="clearfix OTPconfirm col-sm-10 col-sm-offset-2 ">
                                <div class=" clearfix search-fields rerror-div " style="display: none" id="rerrorid">
                                    <div class="alert alert-warning alert-dismissible fade in register-error" role="alert"  style="padding:5px;  background-color:#E91724;border:1px solid #E91724;">
                                    </div>
                                </div>
                                <div class="otpuser">

                                </div>
                                <div class="col-sm-10 headermargin">
                                    <label class="col-sm-4 control-label">confirm OTP</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="otp_pass" class="form-control userotp form-control" placeholder="Enter OTP" value="">
                                    </div>
                                </div>  

                                <div class=" clearfix text-center  headermargin col-sm-11" >
                                    <button class="btn OTP" type="button" onclick="verifydetails();">Confirm</button><!-- Submit button -->
                                </div>
                                <div class="clearfix">&nbsp;</div>

                            </div>


                        </div>

                    </div>
                    <?php $this->endWidget(); ?>
                </div>

            </div>
        </div>
    </section>
</div>
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>-->
<script type="text/javascript">
    $(function () {
       // $(".login_error").hide();
        $(".loader").hide();
        $(".OTPconfirm").hide();
        $(".info").hide();
        $('#myTabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
            //$(".login_error").hide();
            console.log('1');
        });
        $(".role").hide();

    });

    $(".forgot").click(function () {
        $(".login").hide();
        $(".PasswordPanel").hide();

        $(".forgotpassword").show();
    });

    var user = "Individual";
    $(".company_name").hide();
    $(".selectuser").on('click', function () {

        user = $('.selectuser:checked').val();
        if (user == "Premium member")
        {
            $(".role").show();
            $(".company_name").hide();
            $(".fullname").show();
            $(".fullnamelbl").text("Full Name");
        }
        if (user == "Corporate")
        {
            $(".role").hide();
            $(".company_name").show();
            $(".fullnamelbl").text("Authorized Person Name");
        }
        if (user == "Individual")
        {
            $(".role").hide();
            $(".company_name").hide();
            $(".fullname").show();
            $(".fullnamelbl").text("Full Name");
        }

    });

    function checkuser() { //authentication user
      //   console.log('2');
         //$(".login_error").hide();
        var uname = jQuery(".user-class").val();
        var pass = jQuery(".pass-class").val();
        var rememberMe = 0;
        if ($(".remember-class").prop("checked")) {
            rememberMe = 1;
        }
        if (uname != "" && pass != "") {
            $(".loader").show();
            // var hash = CryptoJS.MD5(pass);
            jQuery.ajax({
                async: false,
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/login"); ?> ',
                data: {username: uname, password: pass, rememberMe: rememberMe},
                success: function (data) {

                    var dataobj = data.data;
                    if (dataobj.isError) {
                        $(".info").hide();
                        $(".error-div").show();
                        $(".login_error").text(dataobj.errorMsg);

                    } else {
                        $(".error-div").hide();
                      //  $(".login_error").hide();

                        if($("#redirecturl").val() != ""){
							var redirecturl = $("#redirecturl").val();
							window.location.href = ""+redirecturl;
                        
						}else if (dataobj.var1 == 1) {
                            location.href = "<?php echo Yii::app()->createUrl("userDetails/adminDashboard") ?>";
                        } else if (dataobj.var1 == 3) {      //user is Doctor
                            location.href = "<?php echo Yii::app()->createUrl("site/docViewAppointment") ?>";
                        } else if (dataobj.var1 == 4) {      //user is Patient
                            location.href = "<?php echo Yii::app()->createUrl("userDetails/patientAppointments") ?>";
                        } else if (dataobj.var1 == 5) {
                            location.href = "<?php echo Yii::app()->createUrl("site/hosViewAppointment") ?>";
                        }
                        else if (dataobj.var1 == 6) {
                            location.href = "<?php echo Yii::app()->createUrl("site/labViewAppointment",array("roleid" => 6)) ?>";
                        }
                        else if (dataobj.var1 == 7) {
                            location.href = "<?php echo Yii::app()->createUrl("site/labViewAppointment", array("roleid" => 7)) ?>";
                        }
                        else if (dataobj.var1 == 8) {
                            location.href = "<?php echo Yii::app()->createUrl("site/labViewAppointment", array("roleid" => 8)) ?>";
                        }
                        else if (dataobj.var1 == 9) {
                            location.href = "<?php echo Yii::app()->createUrl("site/labViewAppointment", array("roleid" => 9)) ?>";
                        }else if (dataobj.var1 == 11) {      //user is Corporate
                            location.href = "<?php echo Yii::app()->createUrl("userDetails/corporateList") ?>";
                        }
                        else {
                            location.reload();
                          //  $(".login_error").hide();
                        }
                    }
                    $(".loader").hide();
                }

            });

        }

        return false;
    }
    function validate() //registeration form validation
    {

 //console.log('3');
        document.getElementById("firstname").innerHTML = "";
        document.getElementById("lastname").innerHTML = "";
        document.getElementById("mobile").innerHTML = "";
        document.getElementById("Password").innerHTML = "";
        document.getElementById("agree1").innerHTML = "";
        document.getElementById("role").innerHTML = "";
        document.getElementById("company_name").innerHTML = "";
        var reg = new RegExp("^[a-zA-Z\s' ']+$");
        var fname = $(".firstname1").val();
        var lname = $(".lastname1").val();
        var pass = $(".Password1").val();
        var mobile = $(".mobile1").val();
        var role = $(".role1").val();
        var company_name = $(".company_name1").val();

        var terms = $(".agree").prop("checked");
        var mo = new RegExp("^[0-9]{10}$");
        var flag = 1;
        if (terms == false) {
            document.getElementById("agree1").innerHTML = "*Please Select/ accept  above T&C";
            flag = 0;
        }

        if (fname == "") {
            document.getElementById("firstname").innerHTML = "*Please Enter First Name";
            flag = 0;
        } else if (((reg.test(fname)) == false)) {
            document.getElementById("firstname").innerHTML = "*Invalid First Name";
            flag = 0;
        }

        if (lname == "") {
            document.getElementById("lastname").innerHTML = "*Please Enter Last Name";
        } else if (((reg.test(lname)) == false)) {
            document.getElementById("lastname").innerHTML = "*Invalid Last Name";
            flag = 0;
        }
        if (pass == "") {
            document.getElementById("Password").innerHTML = "*Please Enter Password";
            flag = 0;
        }
        if (mobile == "") {
            document.getElementById("mobile").innerHTML = "*Please Enter Mobile Number";
            flag = 0;
        } else if (((mo.test(mobile)) == false)) {
            document.getElementById("mobile").innerHTML = "*Invalid Mobile Number";
            flag = 0;
        }
        if (user == "Premium member") {
            if (role == "") {
                document.getElementById("role").innerHTML = "*Please Enter Role";
                flag = 0;
            }
        }
        if (user == "Corporate") {
            if (company_name == "")
            {
                document.getElementById("company_name").innerHTML = "please Enter company Name";
                flag = 0;
            }
        }

        if (flag == 0)
        {
            return false
        }
        else
        {
            return true;
        }
    }
    function Getdetails() //getting details form register form
    {
        var res = validate();
        if (res)
        {
            var fname = $(".firstname1").val();
            var lname = $(".lastname1").val();
            var pass = $(".Password1").val();
            var mobile = $(".mobile1").val();
            var role = $(".role1").val();
            //    alert(authorized);
            var company = $(".company_name1").val();
            //    alert(company);


            var company_name = $(".company_name1").val();


            if ((pass != "" && mobile != ""))
            {
                jQuery.ajax({
                    async: false,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    url: '<?php echo Yii::app()->createUrl("site/confirm"); ?> ',
                    data: {firstname: fname, lastname: lname, password: pass, mobile: mobile, patient: user, role: role, company_name: company},
                    success: function (result) {
                        var resultobj = result.result;
                        if (resultobj.isError) {
                            $(".rerror-div").show();
                            $(".register-error").text(resultobj.errorMsg);
                        }
                        else
                        {
                            $(".rerror-div").hide();
                            $(".OTPconfirm").show();
                            $(".Registerform").hide();

                        }
                    }

                });
            }

        }
    }
    function verifydetails() //verify the otp details 
    {
        var otpval = $(".userotp").val().trim();
        if (otpval != "") {
            $.ajax({
                async: false,
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/verifyOtp"); ?> ',
                data: {otpval: otpval},
                success: function (data) {
                    var dataobj = data.data;
                    if (dataobj.isError) {

                        $(".rerror-div").show();
                        $(".info").hide();
                        $(".register-error").text(dataobj.errorMsg);
                    }
                    else
                    {
                        //$(".login_error").hide();
                        $(".rerror-div").hide();
                        $(".successmsglogin div").html("Your have been successfully Registered");
                        $(".successmsglogin").show();
                        $('.nav-tabs li').removeClass('active');
                        $(".OTPconfirm").hide();
                        $("a[href='#tab1']").parent("li").addClass("active");
                        $("#tab1").show();
                        $(".info").fadeIn("5000");
                    }

                }
            });
        }
    }
    
    
    function chkMobileNo(){
                                        
            var mobile = $(".chkmobile").val();

            $.ajax({
                    async: false,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    url: '<?php echo Yii::app()->createUrl("site/forgotPassword"); ?> ',
                    data: {mobile: mobile},
                    success: function (result) {
                        if ( result.iserror == false) {
                           $(".forgotpassword").hide();
                            $(".ShowOTPpanel").show();
                            $(".frgtpsssection .alert-warning").hide();
                        }else{
                            $(".frgtpsssection .alert-warning").html(result.errormsg);
                            $(".frgtpsssection .alert-warning").show();
                        }

                    }
                });
        }
                                        
        function verifydetails1() //verify the otp details 
        {
            var mobile = $(".chkmobile").val();
            var otpval = $(".userotppanel").val().trim();
            if (otpval != "") {
                $.ajax({
                    async: false,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    url: '<?php echo Yii::app()->createUrl("site/verifyOtpPanel"); ?> ',
                    data: {otpval: otpval,mobile: mobile},
                    success: function (result) {
                        var dataobj = result.data;
                        if (dataobj.isverified == "yes") {

                            $(".ShowOTPpanel").hide();
                            $(".PasswordPanel").show();
                             $(".frgtpsssection .alert-warning").hide();
                        }else{
                            $(".frgtpsssection .alert-warning").html("Invalid OTP");
                            $(".frgtpsssection .alert-warning").show();
                        }

                    }
                });
            }
        }
        
        function confirmPassword(){
            
            var pwd = $(".pwd").val();
            var cpwd = $(".cpwd").val();
            var mobile = $(".chkmobile").val();
           if(pwd == cpwd){
               
               $.ajax({
                  //  async: false,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    url: '<?php echo Yii::app()->createUrl("site/confirmPassword"); ?> ',
                    data: {pwd: pwd,cpwd: cpwd,mobile: mobile},
                    success: function (result) {
                        var dataobj = result.data;
                        if (dataobj.isverified == "yes") {

                        $(".PasswordPanel").hide();
                        $(".login").show();
                        $(".login_error").hide();
                        $(".successmsglogin div").html("You have been successfully update passwod");
                        $(".successmsglogin").show();
                        $(".frgtpsssection .alert-warning").hide();
                        }else{
                            $(".frgtpsssection .alert-warning").html("Problem in updating msg");
                            $(".frgtpsssection .alert-warning").show();
                        }

                    }
                });
            }
            else{
            $(".frgtpsssection .alert-warning").html("Password not Match");
                            $(".frgtpsssection .alert-warning").show();
            }
        
    }
    
function back_to_login(){
    $('.forgotpassword').hide();
    $('.login').show();
    $(".login_error").hide();
}
                                        
                                        

</script>
