<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$session = new CHttpSession;
$session->open();
$enc_key = Yii::app()->params->enc_key;
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.yiilistview_new.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq_new.js', CClientScript::POS_END);
?>

<div class="section-body"> 
    <section id="intro" class="section-doctors">
        <div class="overlay">
            <div class="row search-banner">
                <div class="container main-text">
                    <div class="col-md-12 backward">

                    </div>
                    <div class="col-md-12 backward">
                        <a class="back-home" href="<?= Yii::app()->createUrl("site/index"); ?>">Home</a> 
                    </div>
                    <!-- Start Search box -->
<?php $this->renderPartial('_searchbox'); ?>
                    <!-- End Search box -->
                    <div class="row">
                        <div class="col-md-2 back-backward">
<?php if ($role == 6) { ?>
                                <a class="back-title" href=""> Pathology </a> 
                            <?php } ?>
                            <?php if ($role == 7) { ?>
                                <a class="back-title" href="">Diagnostic </a> 
                            <?php } ?>
                            <?php if ($role == 8) { ?>
                                <a class="back-title" href="">Blood Bank </a> 
                            <?php } ?>
                            <?php if ($role == 9) { ?>
                                <a class="back-title" href="">Medical Store </a> 
                            <?php } ?>

                            <div class="underline-line"></div>
                        </div>
                        <div class="col-md-6">&nbsp;</div>
                        <div class="col-md-4 text-right rating">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sort-form',
    'method' => 'get'
        ));
?>
                            <?php
                            $sortarray = array();
                            $sortarray = array("Experience" => "Experience", "Rating" => "Rating");
                            ?>
                            <span>Sort By: <select class="minimal" name="sortby"  id="sort">
                                    <option value="Selecttype">Select Type</option>
                            <?php
                            foreach ($sortarray as $sorttype => $value) {
                                print_r($value);
                                echo "<option value='$value' ";
                                if ($sortoption == $value) {
                                    echo " selected ";
                                }
                                echo ">$value</option>";
                            }
                            ?>
                                </select> </span> 
                                    <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 
<section class="container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container section">

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_searchpathology',
    'viewData' => array('role' => $role),
    'summaryText' => '',
    'pagerCssClass' => 'pagination-box clearfix text-center',
    'pager' => array(
        'htmlOptions' => array('class' => 'list-inline'),
        'header' => false,
        'prevPageLabel' => '&lt;&lt;',
        'nextPageLabel' => '&gt;&gt;',
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
    ),
));
?>
                <?php //$this->endWidget(); ?>
            </div><!--/.container section-->
        </div>
    </div>
</section>
<div class="modal fade" id="appointModal1"  role="dialog" data-backdrop="static" >

    <div class="modal-dialog modal-lg" >
        <div class="modal-header" style="border:none;">
            <button type="button" class="close" data-dismiss="modal" style="font-size:45px;">&times;</button></div>
        <!-- Modal content-->
        <div class="modal-content appointcontent1" style="background-color: #87c5bc;">


        </div>

    </div>
</div>
<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    
    
    $(document).ready(function () {
        <?php if(isset($session['isshowappoint'])) { ?>
        checkuser(<?php echo $session['centerid']?>, '<?php echo $actual_link;?>', <?php echo $session['bookroleid'];?>)
        <?php } ?>
        $('#sort').on('change', function () {
            var $form = $(this).closest('form');
            $("#sort-form").submit();
        });

        var showChar = 100;  // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function () {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent" ><span >' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function () {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });


    });
    function rate(userid, rateval)
    {
        var session = '<?php echo $session['user_id']; ?>';
        if (session === '') {
            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
        } else {
            // var rate = $(".br-current-rating").text();
            $.ajax({
                //async: false,
                type: 'POST',
                //dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/addRating"); ?> ',
                data: {userid: userid, rate: rateval},
                success: function (data)
                {
                    alert("Review submitted successfully Thank you For Review");
                    $('.example_' + userid).barrating('readonly', true);
                    var reviewno = parseInt($(".reviewCount_" + userid).text());
                    $(".reviewCount_" + userid).text(reviewno + 1);
                }
            });

        }

    }

    function checkuser(hospid, detaillink, role)
    {
        $.ajax({

            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/chklabTestBook"); ?> ',
            data: {hospid: hospid, detaillink: detaillink, role: role},
            dataType :'json',
            success: function (result)
            {
                if (result.is_link == 'Y') {
                window.location.href = result.data;
                } else {
                    $(".appointcontent1").html(result.data);
                    $("#appointModal1").modal("show");

                }

            }
        });

    }


</script>

<style type="text/css">

    .morecontent span {
        display: none;

    }
    .morelink {
        display: block;
    }

</style>

