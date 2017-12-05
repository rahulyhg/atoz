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
$clientScriptObj = Yii::app()->clientScript;
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.js',CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.yiilistview_new.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js',CClientScript::POS_END);
?>

<div class="section-body"> 
    <section id="intro" class="section-doctors">
        <div class="overlay">
            <div class="row search-banner">
                <div class="container main-text">
                    <div class="col-md-12 backward">
                        <a class="back-home" href="<?= Yii::app()->createUrl("site/index"); ?>">Home</a> 
                    </div>

                    <!-- Start Search box -->
                    <?php $this->renderPartial('_searchbox'); ?>
                    <!-- End Search box -->
                    <div class="row">
                        <div class="col-md-2 back-backward">
                            <a class="back-title" href="">Hospital </a> 
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
                            $sortarray = array("Establishment" => "Establishment", "Rating" => "Rating", "beds-strength" => "beds-strength");
                            ?>
                            <span>Sort By: 
                                <select class="minimal" name="sortby"  id="sort">
                                    <option value="Selecttype">Select Type</option>
                                    <?php
                                    foreach ($sortarray as $sorttype => $value) {
                                        echo "<option value='$value' ";
                                        if ($sortoption == $value) {
                                            echo " selected ";
                                        }
                                        echo ">$value</option>";
                                    }
                                    ?>
                                </select> 
                            </span> 
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
                    'itemView' => '_searchhospital',
                    'pagerCssClass' => 'pagination-box clearfix text-center',
                    'summaryText' => '',
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
<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<div class="modal fade" id="hospappointdetails" role="dialog" style="background-color:rgba(83,116,115,0.8);">
    <div class="modal-dialog" style="width:768px;margin:60px auto">

        <!-- Modal content-->
        <div style="background-color:rgba(83,116,115,0.8);">
            <div class="modal-header" style="border:none;">
                <button type="button" class="close" data-dismiss="modal" style="padding:10px;color:#fff;font-size:45px;">&times;</button>
                <!--<h4 class="modal-title">Modal Header</h4>-->
            </div>
            <div class="modal-body" style="background-color:rgba(83,116,115,0.8);color:#fff;">
                <div class="form-group ">
                    <div class="appintlist">
                    </div>
                    <div class="modal-footer" style="border:none;">
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    </div>
                </div>

            </div>
        </div> 
    </div>
</div>
<div class="modal fade" id="appointModal1"  role="dialog" data-backdrop="static" >

    <div class="modal-dialog modal-lg" >
<!--        <div class="modal-header" style="border:none;">
            <button type="button" class="close" data-dismiss="modal" style="padding:10px;color:#fff;font-size:45px;">&times;</button>
        </div>-->
        <!-- Modal content-->
        <div class="modal-content appointcontent1" style="">
        </div>
    </div>
</div>

<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$redirectUrl = Yii::app()->request->getUrl();
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    var redirectUrl = '<?php echo $redirectUrl; ?>';
    var action = '';
    //var source = '<?php //echo $source; ?>';
    $(document).ready(function () {
        $('#sort').on('change', function () {
            var $form = $(this).closest('form');

            $("#sort-form").submit();
        });
        <?php if (isset($session['isshowappoint'])) { ?>
            checkuser(<?php echo $session['temp_hospid']; ?>);
        <?php } ?>

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
    function checkuser(hospid)
    {
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/getHospitalAppointment"); ?> ',
            data: {hospid: hospid, detaillink :redirectUrl},
            success: function (data)
            {
                $(".appointcontent1").html(data);
                $("#appointModal1").modal("show");
            }
        });
    }

//     function showAppointment(hospid, detaillink){
//       $.ajax({
//            //async: false,
//            type: 'POST',
//            cache: false,
//            url: '<?php //echo Yii::app()->createUrl("site/getHospitalAppointment");  ?> ',
//            data: {hospid: hospid},
//            success:function(data)
//            {
//                 var hospstr = "<div class='col-sm-4' style='margin-top:15px;'> <h4 class='modal-title'><a href='" + detaillink + "' style='color:#fff;'>OPD</a></h4><p> </p></div>";
//                    for (var key in data) {
//
//                        var item = data[key];
//                        hospstr += "<div class='col-sm-4' style='margin-top:15px;'> <h4 class='modal-title'>" + item.role_name + "</h4><p>" + item.apt_contact_no_1 + "</p></div>";
//                    }
//                //alert(data);
//                $(".appintlist").html(hospstr);
//                    $('#hospappointdetails').modal('show');
//            }
//        });
//    }

</script>


<style type="text/css">

    .morecontent span {
        display: none;

    }
    .morelink {
        display: block;
    }

</style>
