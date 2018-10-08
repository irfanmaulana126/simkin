<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">    
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAqElEQVRYR+2WYQ6AIAiF8W7cq7oXd6v5I2eYAw2nbfivYq+vtwcUgB1EPPNbRBR4Tby2qivErYRvaEnPAdyB5AAi7gCwvSUeAA4iis/TkcKl1csBHu3HQXg7KgBUegVA7UW9AJKeA6znQKULoDcDkt46bahdHtZ1Por/54B2xmuz0uwA3wFfd0Y3gDTjhzvgANMdkGb8yAyY/ro1d4H2y7R1DuAOTHfgAn2CtjCe07uwAAAAAElFTkSuQmCC">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/datatables.min.css"/> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css"/> 
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.chained.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/Buttons-master/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/Buttons-master/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/Buttons-master/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/DataTables-1.10.18/Buttons-master/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!-- <body class="sidebar-mini skin-black-light"> -->
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SI</b>KIN</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SIM</b>KIN</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php if($jk=='L' && $foto == 'default.jpg'){ ?>
                      <img src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" class="user-image" alt="User Image"/>
                    <?php }elseif($jk=='P' && $foto == 'default.jpg'){ ?>
                      <img src="<?php echo base_url(); ?>assets/dist/img/avatar2.png" class="user-image" alt="User Image"/>
                    <?php }else{ ?>
                        <img src="<?php echo $foto;?>" class="user-image" alt="User Image"/>
                    <?php } ?>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?php if($jk=='L' && $foto == 'default.jpg'){ ?>
                        <img src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" class="img-circle" alt="User Image"/>
                      <?php }elseif($jk=='P' && $foto == 'default.jpg'){ ?>
                        <img src="<?php echo base_url(); ?>assets/dist/img/avatar2.png" class="img-circle" alt="User Image"/>
                      <?php }else{ ?>
                          <img src="<?php echo $foto;?>" class="img-circle" alt="User Image"/>
                      <?php } ?>
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>admin/user/loadChangePass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>admin/user/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
     