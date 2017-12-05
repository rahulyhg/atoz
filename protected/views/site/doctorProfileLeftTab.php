<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
        $session->open();
$userid = $session['user_id'];

?>
<div class="text-left text-img" style="">
    <?php
    $enc_key = Yii::app()->params->enc_key;
    $baseUrl = Yii::app()->baseUrl;
    $DocInfoArr =Yii::app()->db->createCommand()
    ->select('profile_image')
    ->from('az_user_details u')
    ->where('user_id=:id', array(':id'=>$userid))
    ->queryRow();
    $path = $baseUrl . "/uploads/" . $DocInfoArr['profile_image'];
    if (empty($DocInfoArr['profile_image'])) {
        $path = $baseUrl . "/images/icons/icon01.png";
    }
    ?>
    <a href="">
        <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
    </a> 

</div>

<div class="col-md-12 text-center">               	
    <ul class="service-list text-left col-pad" style="padding-top:22px;" >
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon38.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Appointment Request', array('site/listDocAppointment', 'doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'type'=> 'Appointment'), array("style" => "display:inline;")); ?> </li>  
     
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon38.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Services', array('site/listDocAppointment', 'doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'type'=> 'Services'), array("style" => "display:inline;")); ?> </li>  
        
        <li style="list-style-type: none"><a href=""><img src="<?= $baseUrl; ?>/images/icons/amenities.png" width="22" style="vertical-align:middle">&nbsp; Amenities </a> </li>
        
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Discount', array('site/listDocAppointment', 'doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'type'=> 'Discount'), array("style" => "display:inline;")); ?> </li>  
        
       
       <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Payment', array('site/listDocAppointment', 'doctorid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'type'=> 'Payment'), array("style" => "display:inline;")); ?> </li> 

    </ul>

</div>              

