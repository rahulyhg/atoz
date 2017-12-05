<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Ambulance', array('Users/manageAmbulanceServices', 'roleid' => $roleid), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End--> 
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr class="odd"><th>Driver Name</th><td><?php echo CHtml::encode($model->hospital_name); ?></td></tr>
                                <tr class="odd"><th>Mobile</th><td><?php echo CHtml::encode($model->mobile); ?></td></tr>
                                <tr class="odd"><th>Type of Ambulance</th><td><?php echo CHtml::encode($model->type_of_hospital); ?></td></tr>
                                <tr class="odd"><th>Ambulance Registration No</th><td><?php echo CHtml::encode($model->hospital_registration_no); ?></td></tr>
                               <tr class="odd"><th>City</th><td><?php echo CHtml::encode($model->city_name); ?></td></tr>
                                <tr class="odd"><th>Sr./Surve/Bldg No.</th><td><?php echo CHtml::encode($model->address); ?></td></tr>
                                <tr class="odd"><th>Working Days</th><td><?php echo CHtml::encode($model2->working_day); ?></td></tr>
                                <tr class="odd"><th>Vehical No</th><td><?php echo CHtml::encode($model2->vehical_no); ?></td></tr>
                                 <tr class="odd"><th>Vehical Type</th><td><?php echo CHtml::encode($model2->vehical_type); ?></td></tr>
                                <tr class="odd"><th>24x7 services</th><td><?php echo CHtml::encode($model->take_home); ?></td></tr>
                                <tr class="odd"><th>free services</th><td><?php echo CHtml::encode($model->extra_charges); ?></td></tr>
                               <tr class="odd"></tr>
                            </tbody>
                        </table>
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
