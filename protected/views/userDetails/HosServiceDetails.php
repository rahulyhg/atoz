<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hosService-details-form',
	
    'htmlOptions' => array('enctype' => 'multipart/form-data', "class" => "form-horizontal"),
  
	'enableAjaxValidation'=>false,
)); ?>

<div id="serviceclone">
        <div class="row">
            <?php echo $form->labelEx($model, 'service_id', array("class" => "col-sm-2 control-label")); ?>

            <?php
            $service = ServiceMaster::model()->findAll();
            $servicenameArr = CHtml::listData($service, 'service_id', 'service_name');
            ?>
            <select class="form-control servicename" name="service[]" >
                <?php foreach ($servicenameArr as $key => $value) {
                    ?>
                    <option value='<?php echo $key; ?>'> <?php echo $value; ?></option>
                <?php }
                ?>
            </select>
           
            <?php echo $form->error($model, 'service_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'service_discount'); ?>
            
            <input type="text" name="service_discount[]">
            <?php echo $form->error($model, 'service_discount'); ?>
        </div>
    
    
    </div>     
    <button id="addbutton" type="button">+</button>
    
     <?php echo CHtml::submitButton('Create'); ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->
    
   <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.validate.min.js"></script>

<script type="text/javascript"> 
    
        $('#addbutton').click(function () {
            var htmlstr = "";
            var servicename = $('.servicename').html();
           
                    // var dayname = $('.dayname').html();
                    htmlstr = "<div class='form-group doctor_visiting_info'><label>service</label><div class='col-sm-2'><select class='form-control servicename' name='service[]'>" + servicename + "</select></div><div> <input type=text name=service_discount[]></div>";
            $('#serviceclone').after(htmlstr);
        });
        
        </script>