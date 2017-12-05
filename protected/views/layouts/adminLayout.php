<?php
$baseUrl = Yii::app()->request->baseUrl;
$session = new CHttpSession;
$session->open();
$hosname = ucwords(strtolower($session["hospital_name"])) ;
$companyname = ucwords(strtolower($session["company_name"])) ;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>A-Z Health+ </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->

        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/bootstrap.min_2.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/jquery-jvectormap-1.2.2.css">

        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/bootstrap3-wysihtml5.min.css">

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Clasified">
        <meta name="description" content="AtoZ is online healthcare portal.">
        <meta name="keywords" content="Medical, Healthcare, Hospital">
        <link rel="shortcut icon" href="<?= $baseUrl; ?>/images/favicon.PNG">
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.11.1.min.js"></script>
        <link id="main-style-file-css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/admin.css"/>
        <link id="main-style-file-css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css"/>

        <link rel="stylesheet" href="<?= $baseUrl; ?>/css/admin/font-awesome.min.css" type="text/css">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?=  Yii::app()->createUrl("site/index"); ?>" class="logo">
                   <!-- logo for regular state and mobile devices -->
                   <?php if($session['user_role_id'] == 1){?> 
                   <span class="logo-lg">A-Z Healthplus</span>
                   
                   <?php } else if($session['user_role_id'] == 11) {?>
                   <span ><?php  echo $companyname;?></span>
                   <?php  } else{ ?>
                   <span ><?php  echo $hosname;?></span>
                   <?php  }  ?>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">

                    <?php if (!Yii::app()->user->isGuest): ?>
                        <!-- Login Links -->
                        <ul id="" class="list-inline pull-right">

                            <li>

                                <?php
                               
                                
                                
                                // echo CHtml::link("<img src='images/icons/sign-in.png'/>Logout", array("site/logout"));
                                if ($session['user_role_id'] == 11) {
                                    echo CHtml::link("Logout (" . $companyname . ")", array("site/logout"), array("class" => "bd"));
                                }else{
                                
                                
                                echo CHtml::link("Logout (" . $hosname . ")", array("site/logout"), array("class" => "bd"));
                                }
                                if ($session['user_role_id'] == 5) {
                                     
                                    echo CHtml::link("  Profile Edit", array("userDetails/updateHospitalProfile"), array("class" => "bd"));
                                }
                                ?>


                            </li>
                        </ul>
                        <!-- End of Login Links -->
                    <?php endif; ?>

                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                </nav>
            </header>

            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <?php if ($session['user_role_id'] == 5) { ?>
                            <li class="active"> <a href="<?php echo $this->createUrl('site/hosViewAppointment'); ?>"><i class="fa fa-circle-o"></i>Dashboard</a></li>
                            <li class=""> <a href="<?php echo $this->createUrl('bookappointment/manageAppointmentServices'); ?>"><i class="fa fa-circle-o"></i>Service Appointment Request</a></li>
                            <li class=""> <a href="<?php echo $this->createUrl('bookappointment/hosServiceAppointment'); ?>"><i class="fa fa-circle-o"></i>Service Appointment</a></li>

                        <?php } ?>
                        <li class="treeview">
                            <?php if ($session['user_role_id'] == 1) { ?>
                                <a href="#">
                                    <i class="fa fa-asterisk"></i>
                                    <span>Manage Masters</span>

                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                            <?php } ?>
                            <?php if ($session['user_role_id'] == 1) { ?>
                                <ul class="treeview-menu">
                                    <li class="active"> <a href="<?php echo $this->createUrl('stateMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage State</a></li>
                                    <li> <a href="<?php echo $this->createUrl('cityMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage City</a></li>
                                    <li> <a href="<?php echo $this->createUrl('countryMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage Country</a></li>
                                    <li> <a href="<?php echo $this->createUrl('serviceMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage Service</a></li>
                                    <li> <a href="<?php echo $this->createUrl('AreaMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage Area</a></li>
                                    <li> <a href="<?php echo $this->createUrl('degreeMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage Degree</a></li>
                                    <li> <a href="<?php echo $this->createUrl('specialityMaster/admin'); ?>"><i class="fa fa-circle-o"></i>Manage Specialty</a></li>
                                </ul>
                            <?php } ?>
                        </li>
                        <li class="treeview">

                            <a href="#">
                                <i class="fa fa-user"></i>
                                <?php if ($session['user_role_id'] == 1) { ?> <span>Manage Users</span> <?php } ?>
                                <?php if ($session['user_role_id'] == 5) { ?> <span>Manage Hospital</span> <?php } ?>
                                <?php if ($session['user_role_id'] == 11) { ?> <span>Manage CO-Users</span> <?php } ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($session['user_role_id'] == 1) { ?>  
                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/admindoctor'); ?>"><i class="fa fa-circle-o"></i>Manage Doctor</a></li>

                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/manageHospital'); ?>"><i class="fa fa-circle-o"></i>Manage Hospital</a></li> <?php } ?>
                                    <?php if ($session['user_role_id'] == 5) { ?>
                                    <li class=""> <a href="<?php echo $this->createUrl('users/manageHospitalServices'); ?>"><i class="fa fa-circle-o"></i>Manage Services</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/manageHospitalDoctor', array("param1" => base64_encode($session['user_id']))); ?>"><i class="fa fa-circle-o"></i>Manage Doctors</a></li>
                                     <?php } ?>
                                    
                                <?php if ($session['user_role_id'] == 1) { ?>
                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/managePathology'); ?>"><i class="fa fa-circle-o"></i>Manage Pathology</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('users/manageDiagnostic'); ?>"><i class="fa fa-circle-o"></i>Manage Diagnostic</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('users/manageBloodBank', array('roleid' => 8)); ?>"><i class="fa fa-circle-o"></i>Manage Blood Bank</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('users/manageBloodBank', array('roleid' => 9)); ?>"><i class="fa fa-circle-o"></i>Manage Medical Store</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('users/manageAmbulanceServices',array('roleid' => 10)); ?>"><i class="fa fa-circle-o"></i>Manage Ambulance Services</a></li>

                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/adminpatient'); ?>"><i class="fa fa-circle-o"></i>Manage Patient</a></li>
                                    <li class=""> <a href="<?php echo $this->createUrl('userDetails/corporatePatient'); ?>"><i class="fa fa-circle-o"></i>Manage Company</a></li> 
                                    
                                <?php } ?>
                            </ul>
                        </li>


                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <div class="content-wrapper" style="min-height: 572px;">
                <?php echo $content; 
               ?>
                <!-- Content Header (Page header) -->
<!--                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Version 2.0</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>-->

<!--                <section class="main-container container">
                    <div class="box box-warning direct-chat direct-chat-warning">

                        <div class="clearfix">&nbsp;</div>
                        
                    </div>
                </section>-->


            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.6
                </div>
                <strong>Copyright &copy; 2014-2016 <a href="#">ATOZ</a>.</strong> All rights reserved.
            </footer>
        </div>



        <script src="<?php echo Yii::app()->baseUrl; ?>/js/admin/bootstrap.min_2.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/admin/app.min.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/admin/fastclick.js"></script>



    </body>
</html>
