<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

?>


<!-- Page Header End --> 
<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                <h3 class="section-title">Sign In</h3>
            </div>
            <div class="col-md-12 section-content">
                <div class="center-block" style="width: 50%;">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'appointmentlogin-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array("onsubmit" => " return checkuser();"),
                    ));
                    $enc_key = Yii::app()->params->enc_key;
                    ?>
                    <div class=" clearfix search-fields error-div col-sm-12 " style="display: none" id="rerrorid">
                        <div class="alert alert-warning alert-dismissible fade in login_error" role="alert"  style="margin-top:15px; background-color:#E91724;border:1px solid #E91724;">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <?php echo $form->labelEx($model, 'Mobile NO', array("class" => "col-sm-4 control-label")); ?>
                        <div class="col-sm-8">
                            <?php echo $form->textField($model, 'username', array('maxlength' => 50, "class" => "form-control user-class", "placeholder" => "+91", "maxlength" => "10")); ?>
                            <?php echo $form->error($model, 'username'); ?>

                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <?php echo $form->labelEx($model, 'Password', array("class" => "col-sm-4 control-label")); ?>
                        <div class="col-sm-8">
                            <?php echo $form->passwordField($model, 'password', array("class" => "form-control pass-class")); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div> 
                     <div class="form-group clearfix">

        <div class="col-sm-offset-8 col-sm-4 text-right">
            <?php echo CHtml::link("Forgot Password ? ", "#"); ?>

        </div>
    </div>
                    <div class="col-sm-offset-4 text-center">
                        <?php
                        echo CHtml::submitButton('Confirm', array("class" => "btn"));
                        ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>

            </div>
        </div>
    </div>

</section>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    function checkuser() { //authentication user

        var uname = jQuery(".user-class").val();
        var pass = jQuery(".pass-class").val();
       if (uname != "" && pass != "") {

            // var hash = CryptoJS.MD5(pass);
            jQuery.ajax({
                async: false,
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/login"); ?> ',
                data: {username: uname, password: pass},
                success: function (data) {

                    var dataobj = data.data;
                    if (dataobj.isError) {

                        $(".error-div").show();
                        $(".login_error").text(dataobj.errorMsg);

                    } else {
                        $(".error-div").hide();
                        location.href = "<?php echo $id?>";

                    }
                    $(".loader").hide();
                }

            });

        }

        return false;
    }
</script>