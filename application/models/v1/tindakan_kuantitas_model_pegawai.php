<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class tindakan_kuantitas_model_pegawai extends CI_Model
{
    public function datasKuantitasPegawai()
    {
        $this->db->select('a.*,b.nama_unit,c.nama_jabatan');
        $this->db->from('simkin.kuantitas_pegawai as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_pos=b.id');
        $this->db->join('simkin.master_jabatan as c','b.id_jabatan=c.id');
        $this->db->where('a.aktif','Y');
        $query = $this->db->get();
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasMasterJabatan()
    {
        $this->db->select('*');
        // $this->db->order_by('klinik_kategori_tindakan_header_instalasi_urut','asc');
        $query = $this->db->get('simkin.master_jabatan');
        $masterJenisPosisi = $query->result();
        if(!empty($masterJenisPosisi)){
            return $masterJenisPosisi;
         } else {
            return array();
        }
    }
    public function datasMasterUnitKerja()
    {
        $this->db->select('*');
        // $this->db->order_by('kategori_tindakan_header_urut','asc');
        $query = $this->db->get('simkin.master_unit_kerja');
        $MasterPosisi = $query->result();
        if(!empty($MasterPosisi)){
            return $MasterPosisi;
         } else {
            return array();
        }
    }
    
    function add($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('kuantitas_pegawai', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function edit($data, $id)
    {     
        $this->db->where('id', $id);
        $this->db->update('kuantitas_pegawai', $data);

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
        $this->db->update('kuantitas_pegawai', $data);
        
        return $this->db->affected_rows();
    }
    function getSelect($id)
    {
        $this->db->select('*');
        $this->db->from('kuantitas_pegawai');
        $this->db->where('aktif', 'Y');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
}

  