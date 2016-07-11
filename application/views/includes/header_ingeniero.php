<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo doctype('html5'); ?>

<head>
    <?php echo meta('Content-type', 'text/html; charset=utf-8','equiv'); ?>
    <title><?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>images/logo_login.png" type="image/x-icon" rel="icon">
    
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Quattrocento' rel='stylesheet' type='text/css'>  
    <link rel="stylesheet" href="<?php echo base_url() ?>style/style.css?<?php echo date('Y-m-d H:i:s'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url() ?>style/responsive.css?<?php echo date('Y-m-d H:i:s'); ?>" type="text/css" media="screen" />
    <link href='<?php echo base_url()?>style/mensajes.css?<?php echo date('Y-m-d H:i:s'); ?>' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url()?>style/menu.css?<?php echo date('Y-m-d H:i:s'); ?>' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    <link type='text/css' href="<?php echo base_url() ?>style/cssfamily.css" rel='stylesheet'>
    <link type="text/css" href="<?php echo base_url() ?>style/font-awesome.min.css" rel="stylesheet">       
    <link type="text/css" href="<?php echo base_url() ?>style/themify-icons/themify-icons.css" rel="stylesheet">                       
    <link type="text/css" href="<?php echo base_url() ?>style/weather-icons.min.css" rel="stylesheet">     
    <link rel="stylesheet" href="<?php echo base_url() ?>style/style-alternative.css?>" type="text/css" id?"theme" />
    <link rel="stylesheet" href="<?php echo base_url() ?>style/styles.css?>" type="text/css" media="screen" />
    <link type="text/css" href="<?php echo base_url() ?>style/prettify.css" rel="stylesheet">               
    <link type="text/css" href="<?php echo base_url() ?>style/blue.css" rel="stylesheet">             
    <!-- <link type="text/css" href="assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">                         -->
    <link type="text/css" href="<?php echo base_url() ?>style/jquery-jvectormap-2.0.2.css" rel="stylesheet">            
    <!-- <link type="text/css" href="assets/plugins/switchery/switchery.css" rel="stylesheet">                               -->
    <!-- <link type="text/css" href="assets/plugins/charts-chartistjs/chartist.min.css" rel="stylesheet"> -->
    <!-- Print dinamical files css -->
    <?php 
        if( !empty( $css ) ):
            foreach( $css as $key => $value ):  
                echo $value ;
            endforeach;
                    
        endif;
    ?>
    <!-- EndPrint dinamical files css -->   
</head>

<body> 
        <div class="extrabar">
        <div class="container-fluid"></div>
        </div>
        <div class="extrabar-underlay"></div>
        <header id="topnav" class="navbar navbar-fixed-top navbar-blue">

            <div class="logo-area">
                <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
                    <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
                        <span class="icon-bg">
                            <i class="ti ti-shift-left"></i>
                        </span>
                    </a>
                </span>
                <a class="navbar-brand" href="">TalentsNote</a>

            </div><!-- logo-area -->
            
            <ul class="nav navbar-nav toolbar pull-right">
                <li class="dropdown toolbar-icon-bg">
                    <a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">
                        <span class="icon-bg">
                            <i class="ti ti-more"></i>
                        </span>
                    </a>
                </li>
                <!-- <li class="dropdown toolbar-icon-bg">
                    <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="ti ti-bell"></i></span><span class="badge badge-deeporange">2</span></a>
                    <div class="dropdown-menu notifications arrow" style="left: inherit;">
                        <div class="topnav-dropdown-header">
                            <span>Notifications</span>
                        </div>
                        <div class="scroll-pane">
                            <ul class="media-list scroll-content">
                                <li class="media notification-success">
                                    <a href="#">
                                        <div class="media-left">
                                            <span class="notification-icon"><i class="ti ti-pencil"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="notification-heading">Profile page has been updated</h4>
                                            <span class="notification-time">12 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="media notification-info">
                                    <a href="#">
                                        <div class="media-left">
                                            <span class="notification-icon"><i class="ti ti-check"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="notification-heading">Updates pushed successfully</h4>
                                            <span class="notification-time">35 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="media notification-teal">
                                    <a href="#">
                                        <div class="media-left">
                                            <span class="notification-icon"><i class="ti ti-user"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="notification-heading">New users requested to join</h4>
                                            <span class="notification-time">11 hours ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="media notification-indigo">
                                    <a href="#">
                                        <div class="media-left">
                                            <span class="notification-icon"><i class="ti ti-shopping-cart"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="notification-heading">More orders are pending</h4>
                                            <span class="notification-time">2 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="media notification-danger">
                                    <a href="#">
                                        <div class="media-left">
                                            <span class="notification-icon"><i class="ti ti-arrow-up"></i></span>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="notification-heading">Pending membership approval</h4>
                                            <span class="notification-time">4 days ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">See all notifications</a>
                        </div>
                    </div>
                </li>
 -->
                <li class="dropdown toolbar-icon-bg">
                    <a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="ti ti-user"></i></span></i></a>
                    <ul class="dropdown-menu userinfo arrow" style="left: inherit;">
                        <li><a href="<?php echo base_url()?>ingeniero/perfil_ingeniero/<?php echo $login[0]['id_ingeniero']?>"><i class="ti ti-user"></i><span>Perfil</span></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url()?>usuario/logout/"><i class="ti ti-shift-right"></i><span>Salir</span></a></li>
                    </ul>
                </li>

            </ul>
        </header>
        <?php 
            if($login[0]['id_perfil'] == 2 )
                $this->load->view('includes/menu_ingeniero');
        ?>
</body>