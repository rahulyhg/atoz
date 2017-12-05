<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<div class="box box-primary">
    <div class="box-header text-center">
        <h3 class="box-title " >Search Form</h3>
    </div>
 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <div class="box-body">
        
            <div class="form-grop">
                 <?php echo $form->label($model, 'Diagnostic Name', array("class" => "col-sm-2 control-label")); ?>
            
        <div class="col-sm-4">
            
<?php echo $form->textField($model, 'hospital_name', array("class" => "form-control ")); ?>
        </div>
     

    </div>
    <div class="form-grop">
         <?php echo $form->label($model, 'Registration No', array("class" => "col-sm-2 control-label")); ?>
        
        
        <div class="col-sm-4">

            
<?php echo $form->textField($model, 'hospital_registration_no', array("class" => "form-control ")); ?>
        </div>
 <?php echo $form->label($model, 'Mobile', array("class" => "col-sm-2 control-label")); ?>
          
        <div  class="col-sm-4">
          
<?php echo $form->textField($model, 'mobile', array('class' => 'form-control')); ?>
        </div>
    </div>
        
    </div>

    <div class="row buttons box-footer text-center">
    <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
    </div>

<?php $this->endWidget(); ?>


</div>

   





