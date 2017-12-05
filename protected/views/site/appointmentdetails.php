<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appointment-details-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
$enc_key = Yii::app()->params->enc_key;
?>

<div class="">
    <div class="form-group">
        <div class="col-sm-2">
            <?php
            $baseDir = Yii::app()->basePath . "/../uploads/";
            $path = $user_details['profile_pic'];
            ?>
            <img alt="shortcut icon" src="<?php echo Yii::app()->request->baseUrl . '/uploads/' . $path; ?>" class="img-circle" width= "160px" border=" 1px solid #dfdfdf" height="137px"/>
            <hr style="border: 2px solid #031097;">
            <ul>
                <li>Modes Of Payment</li>
                <?php
                $paymenttype = $user_details['payment_type'];
                $paymentArr = explode(",", $paymenttype);
                $paymenttypeFinalArr = array_combine($paymentArr, $paymentArr);
                foreach ($paymenttypeFinalArr as $key => $value) {
                    if (!empty($value)) {
                        ?>
                        <li> <?php echo $value; ?></li>
                        <?php
                    }
                }
                ?>
                <li>Year of Experience</li>
                <li class="text-center"><?php echo $user_details['experience']; ?></li>
            </ul>
        </div>
    </div>
    <div class="col-sm-9" style= "margin-bottom:2%">
        <ul>
            <li style="font-weight: bold;font-size: 20px;"class="text-uppercase" style="margin-top:1%;"><?php echo $user_details['clinic_name']; ?></li>
            <li style="font-size:14px;"class="text-uppercase"><?php echo $user_details['first_name']; ?></li>
            <li style="margin-top:1%;margin-bottom:1%;"><?php echo $user_details['speciality'] ?></li>
            <li class="text-capitalize"><label>Address&nbsp;</label><?php echo $user_details['address'] ?>&nbsp;,<?php echo $user_details['city_name'] ?>&nbsp;,<?php echo $user_details['state_name'] ?>&nbsp;<?php echo $user_details['country_name'] ?>&nbsp;</li>
        </ul>
        <p class="text-capitalize" style="margin-top:1%;margin-bottom:1%;"><?php echo $user_details['description'] ?></p>
        <ul class="link">
            <li style="font-size:14px;" class="link col-sm-3"> Hours Of Operation <?php echo CHtml::link('(ViewAll)', 'javascript:', array('class' => 'view',"onclick"=>"visit();","data-toggle"=>"modal","data-target"=>"#myModal")); ?></li>
            <li class="link col-sm-2"><?php echo CHtml::link('Location Map', 'javascript:', array('class' => 'Map')); ?></li>
            <li class="link col-sm-2"><?php echo CHtml::link('Discount', 'javascript:', array('class' => 'discount')); ?></li>
            <li class="link col-sm-2 clearfix"><?php echo CHtml::link('website link', 'javascript:', array('class' => 'website')); ?></li>
        </ul>
        <div class="clearfix">&nbsp;</div>
        <?php
        $visitdetailArr = Yii::app()->db->createCommand()
                ->select('*')
                ->from('az_doctor_visiting_details')
                ->where('doctor_id=:id', array(':id' => $user_details['user_id']))
                ->queryAll();

        foreach ($visitdetailArr as $key => $value) {
            if (($value['day'] == date("l"))) {
                $starttime = $value['start_time'];
                $endtime = $value['end_time'];
                ?>
                <p class="clearfix" style="margin-top:1%;"> <?php echo "Today" . "    " . date('h:i a', strtotime($starttime)) . '  To  ' . date('h:i a', strtotime($endtime)); ?> </p>

                <?php
            }
        }
        ?>

         <?php echo CHtml::link("Book Your Appointment", array("site/patientdetail",'id' => Yii::app()->getSecurityManager()->encrypt($user_details['user_id'], $enc_key)), array("class" => "" )); ?>
        <?php //echo CHtml::button("Book Your Appointment", array('title' => "Customer", 'onclick' => '$("#dialog-crud").dialog("open"); return false;')); ?>
      
        <?php echo CHtml::submitButton('Today Appointment', array("class" => "btn-default btn-xs ", "style" => "border :1px solid;  opacity: 0.8 ;border-radius: 0.5em;","onclick"=>"display();")); ?>&nbsp;&nbsp;
    </div>
    <div class="form-grop">

  <!-- Modal -->
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Visiting Details</h4>
        </div>
        <div class="modal-body">
            <table class="table table-striped">
            <thead>
            <tr>
            <th>hospital Name</th>
            <th>visiting Time</th>
            <th>day</th>
            </tr>
            </thead>
             <tbody>
                  <tr>
           <?php
        foreach($visitdetailArr as $key =>$value)
        {
          ?>
        <tr>
             <?php  $HospitalName = Yii::app()->db->createCommand()->select('hospital_name')
                ->from('az_user_details')->where('user_id =:hospitalid',array(':hospitalid'=>$value['hospital_id']))
                ->queryColumn();?>
          
            
            <td><?php print_r($HospitalName[0]);?></td>
        
            <td><?php echo date('h:i a',strtotime($value['start_time']));?> To <?php echo date('h:i a',strtotime($value['end_time']));?></td>
            <td><?php print_r($value['day']);?></td>
       
       
          <?php }?>  
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
    <div class="col-sm-9 today clearfix">
    <?php
   
    $appointmentdetailArr = Yii::app()->db->createCommand()
                ->select('patient_id,appointment_date')
                ->from('az_patient_appointment_details')
                ->where('appointment_date >=:date',array(':date'=>date("Y-m-d")))
                ->queryAll();
//    echo"<pre>";
//    print_r($appointmentdetailArr);
//            exit;
    ?>
    <table class="table table-bordered tableformat">
        <thead>
      <tr>
        <th>Patient Name</th>
        <th>Update</th>
        <th>profile</th>
        <th>Patient History</th>
        <th>Report</th>
        <th>Forward</th>
        <th>Diagnostic</th>
      </tr>
    </thead>
    <tbody>
        <?php
        foreach($appointmentdetailArr as $key => $value)
        {
        ?>
        <tr>
             <?php $name = Yii::app()->db->createCommand()->select('first_name')
                ->from('az_user_details')->where('user_id =:userid',array(':userid'=>$value['patient_id']))
                ->queryColumn();?>
          
            
            <td><?php print_r($name[0]);?></td>
            <td><?php print_r($value['appointment_date']);?></td>
            <td><?php echo CHtml::link("Profile", array("UserDetails/viewProfilePatient",'id' => Yii::app()->getSecurityManager()->encrypt($value['patient_id'], $enc_key)));?></td>
        <td>Patient History</td>
        <td>Report</td>
        <td>Forward</td>
        <td>Diagnostic</td>
       
          <?php }?>  
       
       
    </tbody>
        
    </table>
    </div>

    <?php $this->endWidget(); ?>
</div>
<style>
    .link{
        display: inline;

    }
</style>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript">
  
   $(function () {
    
        
   });
   
   function display()
     {
         $(".today").show();
        
     }
    
</script>