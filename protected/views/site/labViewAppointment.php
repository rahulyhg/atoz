<?php
$session = new CHttpSession;
$session->open();
$enc_key = Yii::app()->params->enc_key;
?>

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
        var payedamt = $('.patientamt').val();
        var role = $('#srole').val();
        var patientid = $('#patientid').val();
        var bookid = $('#userid').val();
        var doctorid = $('#apttid').val()
        $.ajax({
            async: false,
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '" . Yii::app()->createUrl("site/getappointpayment") . "',
            data: {doctorfee: doctorfee, payedamt: payedamt, role: role, patientid: patientid, bookid: bookid, doctorid: doctorid},
            success: function (result) {
                $('#appointment-grid').yiiGridView('update', {
                        data: $('#userpaymentform').serialize()
                });
            }
        });

    }
", CClientScript::POS_END);
?>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container">
                <div class="col-md section" style="">
                    <div class="col-md-2 text-center" style="margin-top: -35px;">
                        <?php $this->renderPartial('LabLeftTab', array('labInfoArr' => $labInfoArr, 'roleid' => $roleid));
                        $baseUrl = Yii::app()->baseUrl;
                        ?>

                    </div> 
                    <div class="col-md-10 col-mar" style="margin-top: -35px;"> 

<?php //print_r($labInfoArr);  ?>
                        <div class="col-md">
                            <div class="saving" style="border:none"> Review+15 <img src="<?= $baseUrl; ?>/images/icons/review.png" style="width:20px; height:20px"></div>  



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
                        <input type="hidden" id="srole" value="">
                        <input type="hidden" id="apttid" value="">
                        <input type="hidden" id="homedelivery" value="">
                        <div class="col-md">      

                            <h4 style="text-transform:capitalize;"><?php echo $labInfoArr['hospital_name']; ?></h4> 
                            <span class="col-view">Address<?php echo " " . $labInfoArr['city_name'] . " " . $labInfoArr['state_name'] . " " . $labInfoArr['country_name'] . "<br>"; ?></span>
                            <h5 class="title-details" style="padding-left:0">
                            </h5>
<!--                            <p id="descriptiontext" style="height: 25px;overflow: hidden;"><?php //echo $labInfoArr['description'];  ?></p>
                            <a class="" href="javascript:" onclick="$('#descriptiontext').attr('style', 'height:auto;');
                                    $(this).hide();">Read More </a>-->

                            <div style="width: 71%; text-align: justify;"> 
                                <span class="more">  
<?php echo $labInfoArr['description']; ?>
                                </span>
                            </div>

                            <div class="clearfix"></div>

                            <div class="profile-note text-right">

<?php if ($roleid == 6) { ?>
                                    <div class="profile-note text-right">
                                        <a href="<?php echo $this->createUrl('UserDetails/updatePathology', array('id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>">Profile/Edit </a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>
                                    </div>
<?php } else if ($roleid == 7) { ?>
                                    <div class="profile-note text-right">
                                        <a href="<?php echo $this->createUrl('Users/updateDiagnostic', array('id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>">Profile/Edit </a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>
                                    </div>

                                <?php } ?>

<?php if ($roleid == 8) { ?>
                                    <div class="profile-note text-right">
                                        <a href="<?php echo $this->createUrl('users/updateBloodBank', array('roleid' => Yii::app()->getSecurityManager()->encrypt($roleid, $enc_key))); ?>">Profile/Edit </a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>
                                    </div>

<?php } if ($roleid == 9) { ?>
                                    <div class="profile-note text-right">
                                        <a href="<?php echo $this->createUrl('users/updateBloodBank', array('roleid' => Yii::app()->getSecurityManager()->encrypt($roleid, $enc_key))); ?>">Profile/Edit</a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>
                                    </div>
<?php } ?>
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
                                        <?php if ($roleid == 6 || $roleid == 7) { ?>
                                            <a href="javascript:"  class="btn-appoint" style="color:#56b8a8" onclick ="checkuser();"> Book / Request your Lab </a>
                                        <?php } if ($roleid == 9) { ?>
                                            <a href="javascript:"  class="btn-appoint" style="color:#56b8a8" onclick ="checkuser();"> Book Medicine </a>
                                        <?php } if ($roleid == 8) { ?>
                                            <a href="javascript:"  class="btn-appoint" style="color:#56b8a8" onclick ="checkuser();"> Book / Request your Blood </a>
<?php } ?>

                                    </div>

                                    <div class="col-md-6 appointment-button text-right">
                                        <?php
                                        $form1 = $this->beginWidget('CActiveForm', array(
                                            'action' => Yii::app()->createUrl($this->route),
                                            'method' => 'get',
                                            'id' => 'appointmentsearch'
                                        ));
                                        echo $form1->textField($labbookModel, 'full_name', array("class" => "sarchfield", "placeholder" => "Enter Name/Mobile to Search", 'style' => 'width:220px'));
                                        $this->endWidget();
                                        ?>
                                        <br>
                                    </div>
                                    
                                </div> 
                                <div class="clearfix"></div>
                                <div class="table-list">
                                    <?php
                                    $enc_key = Yii::app()->params->enc_key;
                                    $centerid = Yii::app()->user->id;
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'appointment-grid',
                                        'dataProvider' => $labbookModel->getLabAppointment($centerid),
                                        'summaryCssClass' => 'label btn-info info-summery',
                                        'summaryText' => '',
                                        'cssFile' => false,
                                        'itemsCssClass' => 'table table-bordered  table-hover table-striped',
                                        'pagerCssClass' => 'pagination-box  center clearfix col-lg-12',
                                        'pager' => array(
                                            'htmlOptions' => array('class' => 'list-inline'),
                                            'header' => false,
                                            'prevPageLabel' => '&lt;&lt;',
                                            'nextPageLabel' => '&gt;&gt;',
                                            'firstPageLabel' => 'First',
                                            'lastPageLabel' => 'Last',
                                        ),
                                        'columns' => array(
                                            array(
                                                'header' => 'Patient Name',
                                                'type' => 'raw',
                                                'value' => '$data->full_name',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Mobile',
                                                'type' => 'raw',
                                                'value' => '$data->mobile_no',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Patient Age',
                                                'type' => 'raw',
                                                'value' => '$data->patient_age',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Home Delivery',
                                                'type' => 'raw',
                                                'value' => '$data->collect_home',
                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Prescription',
                                                'type' => 'raw',
                                                'value' => 'CHtml::link("Prescription",Yii::app()->baseUrl ."/uploads/".$data->discription_doc,array("target"=>"_black"))',
                                                'type' => 'raw'),
//                                            array(
//                                                'header' => 'Total Charges',
//                                                'type' => 'raw',
//                                                'value' => '$data->total_charges',
//                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'Status',
                                                'type' => 'raw',
                                                'value' => '$data->status==null?"Pending":"$data->status"',
                                                'htmlOptions' => array(), 'type' => 'raw'),
//                                            array(
//                                                'header' => 'payeedFees',
//                                                'type' => 'raw',
//                                                'value' => '$data->payamtpay',
//                                                'htmlOptions' => array(), 'type' => 'raw'),
                                            array(
                                                'header' => 'payFees',
                                                'type' => 'raw',
                                                'value' => 'CHtml::link("Addpayment","javascript:",array("onclick" => "payment($data->book_id,$data->patient_id,$data->role_id,$data->center_id,\'$data->collect_home\',$data->doctor_fees,$data->discount)"))',
                                                'htmlOptions' => array("class" => "payment")
                                            ),
                                            array(
                                                'header' => 'Edit',
                                                'type' => 'raw',
                                                'value' => 'CHtml::link("Edit",array("site/confirmLabTest","id" => "$data->book_id"))',
                                                'htmlOptions' => array("class" => "status")
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
                <h4 class="modal-title">Payment Details</h4>
            </div>
            <div class="modal-body" style="padding: 0px">

                <div class="form-grop">
                    <div class="col-sm-4">
                        <label class="control-label">Lab Fess:</label>
                        <input type ="text" name="total_charges" class="form-control doctorfee">
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
<?php $this->endWidget(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="paymentdetail();">Save</button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="medicalDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Medical Details</h4>
            </div>
            <div class="modal-body" style="padding: 0px">
                <?php
                $form1 = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => "medicalform"
                ));
                ?>
                <div class="col-md-12">

                    <div class="col-md-12 clearfix">
                        <div class="col-md-6">
                            <label class="control-label">Total Amount:</label>
                            <input type ="text" name="total_amount" class="form-control" id="doctorfee" onkeyup="CalculateAmount()">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Discount:</label>
                            <input type ="text" name="discount" class="form-control" id="patientamt" onkeyup="CalculateAmount()">
                        </div>
                    </div>

                    <div class="col-md-12 clearfix" >
                        <div class="col-md-6 charge" hidden="true">
                            <label class="control-label">Delivery/Other Charge</label>
                            <input type="text" class="form-control delivery_charge" onkeyup="CalculateAmount()">
                        </div>
                    </div>
                    <div class="col-md-6 clearfix">

                        <label class="control-label">Net Charge</label>
                        <input type="text" class="form-control netcharge">
                    </div>

                </div>
<?php $this->endWidget(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="medicalPayment();">Save</button>
            </div>
        </div>

    </div>
</div>
</div>


<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>

<script type="text/javascript">

                    $(function () {
                        $('.delivery_charge').click(function () {
                            var delcharge = $('.delivery_charge').val();


                        });

                        $('.service_clk').click(function () {
                            $('.clk_service').show();
                        });

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

                    function CalculateAmount() {

                        var totalamount = $('#doctorfee').val();
                        var discount = $('#patientamt').val();
                        var deliverycharge = $('.delivery_charge').val();
                        var DiscountAmount = 0;
                        if (deliverycharge === '')
                        {
                            deliverycharge = 0;
                        } else {
                            deliverycharge = parseInt(deliverycharge);
                        }
                        if (totalamount != '' && discount != '' && totalamount != 0 && discount != 0) {
                            DiscountAmount = (totalamount * discount) / 100;
                        } else {
                            DiscountAmount = 0;
                        }
                        var amount = totalamount - DiscountAmount;
                        // alert(amount);
                        var NetAmount = parseInt(amount) + parseInt(deliverycharge);

                        $('.netcharge').val(NetAmount);
                    }
                    //     });




                    function checkuser() {
                        var session = '<?php echo $session['user_id']; ?>';
                        var roleid = '<?php echo $session['role_id']; ?>';
                        if (session === '') {
                            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
                        } else {
                            window.location.href = "<?php echo Yii::app()->createUrl("site/labTestBook", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key), 'param2' => Yii::app()->getSecurityManager()->encrypt($roleid, $enc_key), 'param3' => Yii::app()->getSecurityManager()->encrypt($labInfoArr['user_id'], $enc_key))); ?>";
                        }
                    }


                    function payment(bookid, patientid, roleid, apttid, home_delivery, del_charge, discount) {
                        // alert(discount);
                        $("#userid").val(bookid);
                        $("#patientid").val(patientid);
                        $("#srole").val(roleid);
                        $("#apttid").val(apttid);
                        $("#homedelivery").val(home_delivery);
                        $('#patientamt').val(discount);
                        var del_charge = del_charge;
                        // alert(home_delivery+del_charge);
                        if (roleid !== 9) {
                            $('#paymentdetails').modal('show');
                        } else {
                            $('#medicalDetails').modal('show');
                            // var homdel = $("#homedelivery").val();
                            if (home_delivery == 'YES') {
                                $('.charge').show();
                                $('.delivery_charge').val(del_charge);

                            }
                        }
                    }
//                    8d799aaf3bbf
                    function medicalPayment() {

                        var totalamount = $('.netcharge').val();
                        var discount = $('#patientamt').val();
                        var deliverycharge = $('.delivery_charge').val();
                        var role = $('#srole').val();
                        var patientid = $('#patientid').val();
                        var bookid = $('#userid').val();
                        var doctorid = $('#apttid').val()

                        //console.log('totalamount--'+totalamount+'--discount'+discount+'--deliverycharge'+deliverycharge);
                        // console.log('patientid--'+patientid+'--role'+role+'--bookid'+bookid+'--doctorid'+doctorid);
                        $.ajax({
                            async: false,
                            type: 'POST',
                            dataType: 'json',
                            cache: false,
                            url: '<?php echo Yii::app()->createUrl("site/medicalPayment"); ?>',
                            data: {totalamount: totalamount, extracharge: deliverycharge, role: role, patientid: patientid, bookid: bookid, doctorid: doctorid},
                            success: function (result) {
                                //alert('ok'+result);
                            }
                        });
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