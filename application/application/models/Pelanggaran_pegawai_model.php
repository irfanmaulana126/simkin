<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class pelanggaran_pegawai_model extends CI_Model
{
    public function dataspegawai()
    {
        $this->db->from('hris.hris_pegawai');
        $query = $this->db->get();
        $pegawai = $query->result();
        if(!empty($pegawai)){
            return $pegawai;
         } else {
            return array();
        }
    }
    public function dataspegawais()
    {
        $this->db->select('a.id,pgw_nama,pgw_nip,nama_jabatan,nama_unit');
        $this->db->from('simkin.tbl_pegawai as a');
        $this->db->join('simkin.master_jabatan as b','a.id_jabatan=b.id');
        $this->db->join('simkin.master_unit_kerja as c','a.id_unit_kerja=c.id');
        $this->db->join('hris.hris_pegawai as d','a.id_pgw=d.pgw_id');
        $query = $this->db->get();
        $pegawai = $query->result();
        if(!empty($pegawai)){
            return $pegawai;
         } else {
            return array();
        }
    }
    public function addPegawai($data)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_pegawai', $data);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    public function getSelect($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
    public function editPegawai($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_pegawai', $data);

        return TRUE;
    }
    public function editPegawaihris($data, $id)
    {
        $this->db->where('pgw_id', $id);
        $this->db->update('hris.hris_pegawai', $data);

        return TRUE;
    }
    public function delete($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_pegawai', $data);

        return TRUE;
    }
}

  