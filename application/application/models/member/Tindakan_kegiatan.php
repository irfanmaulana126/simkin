<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class tindakan_kegiatan extends CI_Model
{
	var $column_order = array( 'cust_usr_nama','tindakan_tanggal','nama_pgw','fol_nama'); //set column field database for datatable orderable
	var $column_search = array('cust_usr_nama','tindakan_tanggal','nama_pgw','fol_nama'); //set column field database for datatable searchable 

    public function datasCusTindakan($filter)
    {
        
        $this->db->select('f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input');
        $this->db->from('simkin.master_indikator as a');
        $this->db->join('simkin.detail_indikator as b','a.id=b.id_master_indikator');
        $this->db->join('klinik.klinik_kategori_tindakan as c','b.id_tindakan=c.kategori_tindakan_id');
        $this->db->join('klinik.klinik_biaya as d','d.biaya_kategori=c.kategori_tindakan_id');
        $this->db->join('klinik.klinik_folio as e','e.id_biaya=d.biaya_id');
        $this->db->join('klinik.klinik_folio_pelaksana as f','f.id_fol= e.fol_id');
        $this->db->join('global.global_auth_user as g','g.usr_id=f.id_usr');
        $this->db->join('global.global_customer_user as h','e.id_cust_usr=h.cust_usr_id');
        $this->db->join('hris.hris_pegawai as i','g.id_pgw=i.pgw_id');
        $this->db->where_in('fol_pelaksana_tipe',array('1','10'));
        $this->db->where('usr_id = ',$this->session->userdata('userId'));
        $this->db->where('a.id_unit_kerja = ',$this->session->userdata('unit'));
        $this->db->group_by(array('f.id_usr','fol_pelaksana_tipe','fol_pelaksana_nominal','fol_id','id_reg','fol_nama','cust_usr_nama','fol_nominal','tindakan_tanggal','tindakan_waktu','usr_id','indikator','difinisi','jns_input'));
        if (!empty($filter)) $query = $this->db->where($filter);
        $query1 =  $this->db->get_compiled_select();

        $this->db->select('d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input');
        $this->db->from('simkin.master_indikator as a ');
        $this->db->join('simkin.detail_indikator_folio as b','a.id=b.id_master_indikator');
        $this->db->join('klinik.klinik_folio as c','c.id_poli=b.id_folio');
        $this->db->join('klinik.klinik_folio_pelaksana as d','d.id_fol= c.fol_id');
        $this->db->join('global.global_customer_user as e','c.id_cust_usr=e.cust_usr_id');
        $this->db->join('global.global_auth_user as f','f.usr_id=d.id_usr');
        $this->db->join('hris.hris_pegawai as g','f.id_pgw=g.pgw_id');
        $this->db->where('usr_id = ',$this->session->userdata('userId'));
        $this->db->where_in('fol_pelaksana_tipe',array('1','10'));
        $this->db->where('a.id_unit_kerja = ',$this->session->userdata('unit'));
		$this->db->group_by(array('d.id_usr','fol_pelaksana_tipe','fol_pelaksana_nominal','fol_id','id_reg','fol_nama','cust_usr_nama','fol_nominal','tindakan_tanggal','tindakan_waktu','usr_id','indikator','difinisi','jns_input'));
        if (!empty($filter)) $query = $this->db->where($filter);
        $query2 =  $this->db->get_compiled_select();
        
        $indikator = $this->db->query($query1 . ' UNION ' . $query2)->result();        
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasTindakan()
    {
        $query =$this->db->query("
        select * from master_indikator where  jns_input in ('1','0') and id_unit_kerja='".$this->session->userdata('unit')." '
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
 
   
}

  