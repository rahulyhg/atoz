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
    <div class="container" style="">

        <div class="col-md-2 text-center" style="">
            <!-- Start doctor Profile left tab box -->
            <?php $this->renderPartial('doctorProfileLeftTab'); ?>
            <!-- End doctor Profile left tab box -->
        </div>

        <div class="row col-sm-10 clearfix" style="">
            <div class="profile-note text-right">
                <a href="<?php echo $this->createUrl('site/docViewAppointment'); ?>" style="color:#0DB7A8;"> Home </a>|<a href="<?php echo $this->createUrl('UserDetails/updateDoctordetails', array('id' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key))); ?>" style="color:#0DB7A8;"> Profile/Edit </a>| <a href="<?php echo $this->createUrl('notification/admin'); ?>" style="color:#0DB7A8;"> Notification </a>|<a href="<?php echo $this->createUrl('PatientSecondopinion/admin'); ?>" style="color:#0DB7A8;"> Second opinion </a>
            </div>
            
            
           <?php  if($type == 'Appointment'){   ?>
            <h4 class="col-sm-5 clearfix" >Doctors's Appointment Details</h4><br>
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
                    'summaryText' => '',
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
                            'header' => 'Patient Name',
                            'value' => '$data->patient_name',
                        ),
                        array(
                            'header' => 'Patient Mobile',
                            'value' => '$data->patient_mobile',
                        ),
                        array(
                            'header' => 'Type Of Visit',
                            'value' => '$data->type_of_visit',
                        ),
                        array(
                            'header' => 'Clinic Name',
                            'value' => '$data->clinic_name',
                        ),
                        array(
                            'header' => 'Requested Date',
                            'value' => 'date("d-m-Y",strtotime($data->preferred_day))',
                        ),
                        
                        array(
                            'header' => 'Confirm Appointment',
                            'type' => 'raw',
                            'value' => 'CHtml::link("Confirm Appointment",array("bookappointment/index","id"=>$data->id),array("style"=>"color:red"))',
                           
                        ),
                    ),
                ));
                ?>
            </div>
            <?php  } ?>
            
            
           
            <?php 
            if($type == 'Services' || $type == 'Discount'){
                ?>
            
                <h4 class="col-sm-5 clearfix" >Service Details</h4><br>
                 <ul class="servicearr" style="border:1px solid #0DB7A8;list-style-type:none">
               <?php 
             if(!empty($serviceArr)){?>
                    <li><div class="col-sm-5 clearfix"><?php echo 'Service'; ?></div><div class="col-sm-3"><?php echo ' Discount'; ?>%</div><div class="col-sm-3"><?php echo 'Corporate Discount'; ?>%</div></li>
                    <?php
                    foreach ($serviceArr as $key => $value) {
                        ?> <li ><div class="col-sm-5 clearfix"><?php echo $value['service_name']; ?></div><div class="col-sm-3"><?php echo $value['service_discount']; ?>%</div><div class="col-sm-3"><?php echo $value['corporate_discount']; ?>%</div></li>

                    <?php } 
                    } ?>
            </ul>
          <?php  }  if($type == 'Payment'){ ?>
              <h4 class="col-sm-5 clearfix" >Payment Details</h4><br>
          <?php if(!empty($paymentArr)){
                   
                   $pay =  str_replace(',', '<br>',$paymentArr);
                    echo $pay;
                    }else{
                        echo 'NO Result';
                    }
          }?>
           
            
        </div>
    </div>
</section>
