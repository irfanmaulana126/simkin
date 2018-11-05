 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <div class="user-panel">
        <div class="pull-left image">
          <?php if($jk=='L' && $foto == 'default.jpg'){ ?>
            <img src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" class="img-circle" alt="User Image"/>
          <?php }elseif($jk=='P' && $foto == 'default.jpg'){ ?>
            <img src="<?php echo base_url(); ?>assets/dist/img/avatar2.png" class="img-circle" alt="User Image"/>
          <?php }else{ ?>
              <img src="<?php echo $foto;?>" class="img-circle" alt="User Image"/>
          <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php if($this->session->userdata('tipe')!='0' ){?>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>member/Dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <?php } ?>
            <li class="treeview">
              <a href="<?= base_url();?>member/tupoksi" >
                <i class="fa fa-thumb-tack"></i>
                <span>Tupoksi</span>
              </a>
            </li>
            <?php if($this->session->userdata('roleText')=='DOKTER'){?>
            <li class="treeview">
              <a href="<?= base_url();?>member/tindakan_pasien" >
                <i class="fa fa-thumb-tack"></i>
                <span>Data Tindakan Pasien</span>
              </a>
            </li>
            <?php } ?>
            <?php if($this->session->userdata('tipe')=='1' || $this->session->userdata('tipe')=='3'){?>
            <li class="treeview">
              <a href="<?= base_url();?>member/PegawaiUnit" >
                <i class="fa fa-thumb-tack"></i>
                <span>Data Pegawai</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>