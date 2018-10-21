<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class tindakan_kuantitas_model_dokter extends CI_Model
{
    public function datasKuantitasDokter()
    {
        $this->db->select('a.*,b.nama_unit,c.nama_jabatan,d.kategori_tindakan_nama,e.kategori_tindakan_header_nama,f.klinik_kategori_tindakan_header_instalasi_nama');
        $this->db->from('simkin.kuantitas_dokter as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_pos=b.id','left');
        $this->db->join('simkin.master_jabatan as c','b.id_jabatan=c.id','left');
        $this->db->join('klinik.klinik_kategori_tindakan as d','a.id_tindakan=d.kategori_tindakan_id','left');
        $this->db->join('klinik.klinik_kategori_tindakan_header as e','d.id_kategori_tindakan_header=e.kategori_tindakan_header_id','left');
        $this->db->join('klinik.klinik_kategori_tindakan_header_instalasi as f',' e.id_kategori_tindakan_header_instalasi=f.klinik_kategori_tindakan_header_instalasi_id','left');
        $this->db->where('a.aktif','Y');
        $query = $this->db->get();
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasKategoriHeaderInstalasi()
    {
        $this->db->select('klinik_kategori_tindakan_header_instalasi_id as id, klinik_kategori_tindakan_header_instalasi_nama as nama');
        $this->db->order_by('klinik_kategori_tindakan_header_instalasi_urut','asc');
        $query = $this->db->get('klinik.klinik_kategori_tindakan_header_instalasi');
        $tindakan = $query->result();
        if(!empty($tindakan)){
            return $tindakan;
         } else {
            return array();
        }
    }
    public function datasKategoriTindakanHeader()
    {
        $this->db->select('kategori_tindakan_header_id as id, kategori_tindakan_header_nama as nama,id_kategori_tindakan_header_instalasi as id_instilasi');
        $this->db->order_by('kategori_tindakan_header_urut','asc');
        $query = $this->db->get('klinik.klinik_kategori_tindakan_header');
        $tindakan = $query->result();
        if(!empty($tindakan)){
            return $tindakan;
         } else {
            return array();
        }
    }
    public function datasKategoriTindakan()
    {
        $this->db->select('kategori_tindakan_id as id, kategori_tindakan_nama as nama,id_kategori_tindakan_header as id_header');
        $this->db->order_by('kategori_urut','asc');
        $query = $this->db->get('klinik.klinik_kategori_tindakan');
        $tindakan = $query->result();
        if(!empty($tindakan)){
            return $tindakan;
         } else {
            return array();
        }
    }
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function add($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('kuantitas_dokter', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function edit($data, $id)
    {     
        $this->db->where('id', $id);
        $this->db->update('kuantitas_dokter', $data);

        return TRUE;
    }
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('kuantitas_dokter', $data);
        
        return $this->db->affected_rows();
    }
    function getSelect($id)
    {
        $this->db->select('*');
        $this->db->from('kuantitas_dokter');
        $this->db->where('aktif', 'Y');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
}

  