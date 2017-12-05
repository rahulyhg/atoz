
<?php

$session = new CHttpSession;
        $session->open();
$userid = $session['user_id'];

?>
<div class="text-left text-img" style="">
    <?php
    $enc_key = Yii::app()->params->enc_key;
    $baseUrl = Yii::app()->baseUrl;
                            $path = $baseUrl . "/uploads/" . $labInfoArr['profile_image'];
                            if (empty($labInfoArr['profile_image'])) {
                                $path = $baseUrl . "/images/icons/icon01.png";
                                
                                if ($roleid == 6) { 
                                    $path = $baseUrl . "/images/icons/icon06.png";
                                }
                                if ($roleid == 7) {
                                    $path = $baseUrl . "/images/icons/icon03.png";
                                }
                                if ($roleid == 8) {
                                    $path = $baseUrl . "/images/icons/icon05.png";
                                }
                                if ($roleid == 9) {
                                    $path = $baseUrl . "/images/icons/icon04.png";
                                }
                            }
                            
    
    
    
    $DocInfoArr =Yii::app()->db->createCommand()
    ->select('profile_image')
    ->from('az_user_details u')
    ->where('user_id=:id', array(':id'=>$userid))
    ->queryRow();
//    $path = $baseUrl . "/uploads/" . $DocInfoArr['profile_image'];
//    if (empty($DocInfoArr['profile_image'])) {
//        $path = $baseUrl . "/images/icons/icon06.png";
//    }
    ?>
    <a href="">
        <img src="<?php echo $path; ?>" class="img-circle img-responsive" style="margin-bottom:15px">
    </a> 

</div>
<div class="col-md-12 text-center">               	
    <ul class="service-list text-left col-pad" style="padding-top:22px;" >
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon38.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Services', array('site/listOfServices', 'centerid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'role'=> $roleid ,'type'=> 'Services'), array("style" => "display:inline;")); ?> </li>  
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/amenities.png" width="22" style="vertical-align:middle"> Amenities<?php //echo CHtml::link('Amenities', array('site/listOfServices', 'centerid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'role'=> $roleid ,'type'=> 'Amenities'), array("style" => "display:inline;")); ?> </li>  
        
         <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle"><?php echo CHtml::link('Discount', array('site/listOfServices', 'centerid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'role'=> $roleid ,'type'=> 'Discount'), array("style" => "display:inline;")); ?> </li>  
        
        <li style="list-style-type: none"><img src="<?= $baseUrl; ?>/images/icons/icon39.png" width="22" style="vertical-align:middle"> <?php echo CHtml::link('Payment', array('site/listOfServices', 'centerid' => Yii::app()->getSecurityManager()->encrypt($userid, $enc_key),'role'=> $roleid ,'type'=> 'Payment'), array("style" => "display:inline;")); ?> </li> 
       
        
       
       
       

    </ul>

</div> 