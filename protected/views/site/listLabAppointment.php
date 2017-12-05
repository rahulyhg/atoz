<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
$session->open();
$userid = $session['user_id'];
$enc_key = Yii::app()->params->enc_key;
?>
<section class="section-details container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="container" style="padding:15px;">

        <div class="col-md-2 text-center" style="margin-top: -35px;">
                        <div class="col-md-12 text-left text-img" style="">
                            <?php
                            $enc_key = Yii::app()->params->enc_key;
                            $baseUrl = Yii::app()->baseUrl;
                            $path = $baseUrl . "/uploads/" . $session['profile_image'];
                            if (empty($labInfoArr['profile_image'])) {
                                $path = $baseUrl . "/images/icons/icon01.png";
                            }
                            ?>
                            <a href="">
                                <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
                            </a> 

                        </div>
<div class="col-md-12 text-center">               	
    <ul class="service-list text-left col-pad" style="padding-top:22px;" >

        
        <li style="list-style-type: none"><a href=""><img src="<?= $baseUrl; ?>/images/icons/icon38.png" width="22" style="vertical-align:middle">&nbsp; Services </a> </li>
        <li style="list-style-type: none"><a href=""><img src="<?= $baseUrl; ?>/images/icons/amenities.png" width="22" style="vertical-align:middle">&nbsp; Amenities </a> </li>
        <li style="list-style-type: none"><a href=""><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle">&nbsp; Discount </a> </li>
        <li style="list-style-type: none"><a href=""><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle">&nbsp; Payment </a> </li>
       

    </ul>

</div>               
                    </div>

        <div class="row col-sm-10 clearfix" style="padding:30px;">
            <div class="profile-note text-right">
                  <?php if ($session['role_id'] == 6) { ?>
                                <div class="profile-note text-right">
                                    <a href="<?php echo $this->createUrl('UserDetails/updatePathology', array('id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>">Profile/Edit</a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>|<a href="<?php echo $this->createUrl('PatientSecondopinion/admin'); ?>">Second opinion</a>
                                </div>
                            <?php } else if ($session['role_id'] == 7) { ?>
                                <div class="profile-note text-right">
                                    <a href="<?php echo $this->createUrl('Users/updateDiagnostic', array('id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key))); ?>">Profile/Edit</a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>">Notification</a>|<a href="<?php echo $this->createUrl('PatientSecondopinion/admin'); ?>">Second opinion</a>
                                </div>

                            <?php } ?>
            </div>
            <h4 class="col-sm-5 clearfix">Lab Booking Details</h4><br>
            <div class="table-list clearfix"  style="padding:30px;">
                <?php
                $enc_key = Yii::app()->params->enc_key;
                $hospitalId = Yii::app()->user->id;
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'appointment-grid',
                    'dataProvider' => $appointmentmodel->getDocAppoimentQuery($id),
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
                            'header' => 'Requested Date',
                            'value' => 'date("d-m-Y",strtotime($data->preferred_day))',
                        ),
                        
                        array(
                            'header' => 'BOOK APPOINTMENT',
                            'type' => 'raw',
                            'value' => 'CHtml::link("Book Appointment",array("site/patientdetail","id"=>$data->id))',
                           
                        ),
                    ),
                ));
                ?>
            </div>

        </div>
    </div>
</section>
