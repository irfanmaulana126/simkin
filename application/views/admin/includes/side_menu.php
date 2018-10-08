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
            <li class="treeview <?php if($aktif_menu=='dash'){ echo 'active'; }else{ echo '';} ?>">
              <a href="<?php echo base_url(); ?>admin/dashboard" >
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <li class="treeview <?php if($aktif_menu=='indi'){ echo 'active'; }else{ echo '';} ?>">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Indikator Tindakan Intalasi</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if($aktif_menu_sub == 'ku_dok'){ echo 'active'; }else{ echo '';} ?>"><a href="<?php echo base_url(); ?>admin/Indikator_tindakan_kuantitas_dokter" ><i class="fa fa-circle-o"></i> Kuantitas Dokter</a></li>
                <li class="<?php if($aktif_menu_sub == 'ku_peg'){ echo 'active'; }else{ echo '';} ?>"><a href="<?php echo base_url(); ?>admin/Indikator_tindakan_kuantitas_pegawai" ><i class="fa fa-circle-o"></i> Kuantitas Pegawai</a></li>
                <li class="<?php if($aktif_menu_sub == 'kua'){ echo 'active'; }else{ echo '';} ?>"><a href="<?php echo base_url(); ?>admin/Indikator_tindakan_kualitas"><i class="fa fa-circle-o"></i> Kualitas</a></li>
                <li class="<?php if($aktif_menu_sub == 'per'){ echo 'active'; }else{ echo '';} ?>"><a href="<?php echo base_url(); ?>admin/Indikator_tindakan_prilaku"><i class="fa fa-circle-o"></i> Perilaku</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>admin/pegawai">
                <i class="fa fa-users"></i>
                <span>Pegawai Unit kerja</span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>admin/pelanggaran_pegawai" >
                <i class="fa fa-files-o"></i>
                <span>Pelanggaran Pegawai</span>
              </a>
            </li>
            <li class="treeview">
              <a href="<?php echo base_url(); ?>admin/Report" >
                <i class="fa fa-files-o"></i>
                <span>Reports</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>