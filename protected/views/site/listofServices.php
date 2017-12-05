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

        <div class="col-md-2 text-center" style="padding:15px;">
            <!-- Start doctor Profile left tab box -->
            <?php $this->renderPartial('LabLeftTab', array('labInfoArr' => $labInfoArr, 'roleid' => $role)); ?>
            <!-- End doctor Profile left tab box -->
        </div>

        <div class="row col-sm-10 clearfix" style="padding:30px;">
            <div class="profile-note text-right">
                <a href="<?php echo $this->createUrl('site/labViewAppointment', array('roleid' => $role)); ?>" style="color:#0DB7A8;"> Home </a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>" style="color:#0DB7A8;"> Notification </a>|<a href="<?php echo $this->createUrl(''); ?>" style="color:#0DB7A8;"> Second opinion </a>
            </div>
            <h4 class="col-sm-3 clearfix" ><?php echo $type ?> </h4><br>

            <div id="#service_id" style="margin-left:45px;">
                <ul style="padding-top:2px;">
                    <?php  if(!empty($serviceArr)){?>
                    <li><div class="col-sm-6 clearfix"><?php echo 'Service'; ?></div><div class="col-sm-3"><?php echo ' Discount'; ?>%</div><div class="col-sm-3"><?php echo 'Corporate Discount'; ?>%</div></li>
                    <?php
                    foreach ($serviceArr as $key => $value) {
                        ?> <li ><div class="col-sm-6 clearfix"><?php echo $value['service_name']; ?></div><div class="col-sm-3"><?php echo $value['service_discount']; ?>%</div><div class="col-sm-3"><?php echo $value['corporate_discount']; ?>%</div></li>

                    <?php } 
                    }else if(!empty($paymentArr)){
                   
                   $pay =  str_replace(',', '<br>',$paymentArr);
                    echo $pay;
                    }else{
                        echo 'NO Result';
                    }
                    
                    ?>
                    
                   
                </ul>
            </div>

        </div>
    </div>
</section>
