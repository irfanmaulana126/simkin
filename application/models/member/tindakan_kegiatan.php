<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class tindakan_kegiatan extends CI_Model
{
	var $column_order = array( 'cust_usr_nama','tindakan_tanggal','nama_pgw','fol_nama'); //set column field database for datatable orderable
	var $column_search = array('cust_usr_nama','tindakan_tanggal','nama_pgw','fol_nama'); //set column field database for datatable searchable 
	// var $order = array('id' => 'asc'); // default order 
    public function datasCusTindakan()
    {
        $query =$this->db->query("
        select cust_usr_nama,tindakan_tanggal,nama_pgw,fol_nama from klinik.klinik_folio_pelaksana a 
             INNER JOIN klinik.klinik_folio b on b.fol_id = a.id_fol 
						 INNER JOIN global.global_auth_user c on a.id_usr = c.usr_id
						 INNER JOIN hris.hris_pegawai as d on c.id_pgw=d.pgw_id 
						 INNER JOIN klinik.klinik_biaya as e on b.id_biaya=e.biaya_id
						 INNER JOIN klinik.klinik_kategori_tindakan as f on e.biaya_kategori=f.kategori_tindakan_id 
						 INNER JOIN global.global_customer_user as i on b.id_cust_usr=i.cust_usr_id
						 where usr_id='".$this->session->userdata('userId')."' order by tindakan_tanggal desc
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasTindakan()
    {
        $query =$this->db->query("
        select fol_nama from klinik.klinik_folio_pelaksana a 
             INNER JOIN klinik.klinik_folio b on b.fol_id = a.id_fol 
						 INNER JOIN klinik.klinik_biaya as e on b.id_biaya=e.biaya_id
						 INNER JOIN klinik.klinik_kategori_tindakan as f on e.biaya_kategori=f.kategori_tindakan_id 
						 INNER JOIN global.global_customer_user as i on b.id_cust_usr=i.cust_usr_id
						 where a.id_usr='".$this->session->userdata('userId')."' group by fol_nama order by fol_nama desc
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
 
   
}

  