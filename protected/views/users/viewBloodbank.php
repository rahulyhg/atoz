<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $enc_key = Yii::app()->params->enc_key;
?>
<section class="content-header">
<?php if($roleid == 8){?>
    <h3>View Blood-Bank</h3>
	<?php } ?>
<?php if($roleid == 9){?>
    <h3>View Medical-Store</h3>
	<?php } ?>	
</section>
<div class="tab-content"><!-- tab-content start-->
        <section class="content"> <!-- section content start -->
            <div class="row"><!-- row start-->
                <div class="col-lg-12"> <!-- column col-lg-12 start -->
                    <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                        <div class="box-header with-border"><!-- box header start -->
                            <div class="text-right"><!--link div-->
							<?php if($roleid == 8){?>
                                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Blood-Bank', array('users/manageDiagnostic'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
							<?php } ?>
							<?php if($roleid == 9){?>
                                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Medical-Store', array('users/manageBloodBank','roleid'=>9), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
							<?php } ?>
                      </div><!--link End-->    
                          
            <table class="table table-hover table-striped">
                <tbody>
				<?php if($roleid == 8){ ?>
                    <tr class="odd"><th>Blood-Bank Name</th><td><?php echo CHtml::encode($model->hospital_name); ?></td></tr>
					<?php } ?>
					<?php if($roleid == 9){ ?>
                    <tr class="odd"><th>Medical-Store Name</th><td><?php echo CHtml::encode($model->hospital_name); ?></td></tr>
					<?php } ?>
					<?php if($roleid == 8){ ?>
                    <tr class="odd"><th>Blood-Bank Registration No</th><td><?php echo CHtml::encode($model->hospital_registration_no); ?></td></tr>
					<?php } ?>
					<?php if($roleid == 9){ ?>
                    <tr class="odd"><th>Medical-Store Registration No</th><td><?php echo CHtml::encode($model->hospital_registration_no); ?></td></tr>
					<?php } ?>
						<?php if($roleid == 8){ ?>
                    <tr class="odd"><th>Blood-Bank  Establishment</th><td><?php echo CHtml::encode($model->hos_establishment); ?></td></tr>
					<?php } ?>
					
                    <?php if(!empty($model->apt_contact_no_1)){echo"<tr class='odd'><th>Contact No</th><td>$model->apt_contact_no_1</td></tr>"; }?>
                    <?php if(!empty($model->apt_contact_no_2)){echo"<tr class='odd'><th>Contact No</th><td>$model->apt_contact_no_2</td></tr>"; }?>
            
                    <tr class="odd"><th>Address</th><td><?php echo CHtml::encode($model->address); ?></td></tr>
                    <tr class="odd"><th>Landmark</th><td><?php echo CHtml::encode($model->landmark); ?></td></tr>
                     <tr class="odd"><th>Pincode</th><td><?php echo CHtml::encode($model->pincode); ?></td></tr>
                      <tr class="odd"><th>City</th><td><?php echo CHtml::encode($model->city_name); ?></td></tr>
                       <tr class="odd"><th>State</th><td><?php echo CHtml::encode($model->state_name); ?></td></tr>
                 </tbody>
            </table>
                        
                        </div><!-- box header end -->
                    </div><!-- box end -->
                </div> <!-- column col-lg-12 end -->
            </div><!--row end-->
        </section> <!-- section content End -->
    </div><!-- tab-content end-->


    
        
       
           
           
           

       
 
    

    
 

