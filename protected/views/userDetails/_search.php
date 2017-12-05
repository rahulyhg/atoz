<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <?php if ($role_id == 5) {
        ?>
        <div class="form-grop">
            <div class="col-sm-4">
                <span>Hospital Name</span>
                <?php echo $form->textField($model, 'hospital_name', array('maxlength' => 50, 'class' => 'form-control')); ?>
            </div>
            <div class="col-sm-4">
                <span>Hospital Type</span>
                <?php
                $hospCat = Constants::HOSPITAL_CATEGORY;
                $hospCateArr = explode(";", $hospCat);
                $cateArr = array_combine($hospCateArr, $hospCateArr);
                echo $form->dropDownList($model, 'type_of_hospital', $cateArr, array("class" => "form-control", "style" => "width:100%;", "prompt" => "Select Type Of Hospital"));
                ?>
            </div>
            <div  class="col-sm-4">
                <span>Mobile</span>
                <?php echo $form->textField($model, 'mobile', array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($role_id == 3 || $role_id == 4) {
        ?>
        <div class="form-grop">
            <div class="col-sm-4">
                <span>First Name</span>
                <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'class' => 'form-control')); ?>
            </div>
            <div class="col-sm-4">
                <span>Last Name</span>
                <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'class' => 'form-control')); ?>
            </div>
            <div class="col-sm-4">
                <span>City Name</span>
                <?php echo $form->textField($model, 'city_name', array('maxlength' => 80, 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-grop">
            <div class="col-sm-4">

                <span>Area Name</span>
                <?php echo $form->textField($model, 'area_name', array('maxlength' => 100, 'class' => 'form-control')); ?>
            </div>

            <div  class="col-sm-4">
                <span>Mobile</span>
                <?php echo $form->textField($model, 'mobile', array('class' => 'form-control')); ?>
            </div>
        </div>

    <?php } ?>

    <div class="row buttons text-center">
        <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->