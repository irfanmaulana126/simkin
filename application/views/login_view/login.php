<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIMKIN</title>
    <link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAqElEQVRYR+2WYQ6AIAiF8W7cq7oXd6v5I2eYAw2nbfivYq+vtwcUgB1EPPNbRBR4Tby2qivErYRvaEnPAdyB5AAi7gCwvSUeAA4iis/TkcKl1csBHu3HQXg7KgBUegVA7UW9AJKeA6znQKULoDcDkt46bahdHtZ1Por/54B2xmuz0uwA3wFfd0Y3gDTjhzvgANMdkGb8yAyY/ro1d4H2y7R1DuAOTHfgAn2CtjCe07uwAAAAAElFTkSuQmCC">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <style>
         @font-face { font-family: Bebas; src: url('<?php echo base_url();?>assets/font/BebasNeue.otf'); }
         @font-face { font-family: Mermaid; src: url('<?php echo base_url();?>assets/font/Mermaid1001.tff'); }
         #login-side{
            height: 100vh;
            padding-top: 50px;
          }
          #title-side{
              padding-top: 15%;
              text-align: center;;
          }
          #sub-title {
            margin-bottom: -20px;
            font-family: "Mermaid";
            font-size: 16pt;
          }
      #logo {
            text-align:center;
          }
          #logo p {
            padding-top: 20px;
            font-family: "Bebas";
            font-size: 18pt;
            margin-bottom: -10px;
          }
          #logo-sub {

            font-family: "Mermaid";
            font-size: 14pt;
            font-weight: bold;

          }
          #title-side h1 {
            color: 212121;
            font-family: "Bebas";
            font-weight: bold;
            font-size: 48pt;
            margin-bottom: -5px;

          }
          .smashinglogo {background: url('<?php echo base_url();?>assets/images/login-bg.jpg') no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="smashinglogo">
    <div class="row">
      <div class="col-md-4 col-md-offset-4" id="title-side">
          <p id="sub-title">Pengembangan Model</p>
            <h1><span style="color:#0000ff">SIM</span> <span style="color:#ee82ee">Kinerja</span></h1>
          <p>
            <b><i style="color:#ea6227">"Berbasis Networking Smarthpone System"</i></b>
          </p>
        <p>
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
          </span>
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-desktop fa-stack-1x fa-inverse"></i>
          </span>
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
          </span>
        </p>
      </div>
      <div class="col-md-4" id="login-side">
        <div class="login-box">
          <div class="login-box-body">
              <div  id="logo">
                  <img src="<?php echo base_url();?>assets/images/logo-sultra.png" alt="" />
                  <p>
                    RSPI Prof.Dr. Sulianti Saroso
                  </p>
                  <div id="logo-sub"><h5>Responsive Satisfaction Profesionalism Integrity</h5></div>
                </div>
              </br>
            <?php $this->load->helper('form'); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
            <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>                    
                </div>
            <?php }
            $success = $this->session->flashdata('success');
            if($success)
            {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>                    
                </div>
            <?php } ?>
            
            <form action="<?php echo base_url(); ?>loginMe" method="post">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Email" name="email" required />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" required />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-8">    
                  <!-- <div class="checkbox icheck">
                    <label>
                      <input type="checkbox"> Remember Me
                    </label>
                  </div>  -->                       
                </div><!-- /.col -->
                <div class="col-xs-4">
                  <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" />
                </div><!-- /.col -->
              </div>
            </form>            
          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
      </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>