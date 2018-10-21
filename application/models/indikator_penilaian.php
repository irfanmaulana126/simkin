<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class indikator_penilaian extends CI_Model
{
    public function datasIndikator()
    {
        $this->db->select('a.*,b.nama_unit,c.nama_jabatan,d.nama');
        $this->db->from('simkin.master_indikator as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_unit_kerja=b.id');
        $this->db->join('simkin.master_jabatan as c','b.id_jabatan=c.id');
        $this->db->join('simkin.master_indikator_tupoksi as d','a.indikator_tupoksi=d.id');
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
    public function datasMasterIndikatorTupoksi()
    {
        $this->db->select('*');
        // $this->db->order_by('kategori_tindakan_header_urut','asc');
        $query = $this->db->get('simkin.master_indikator_tupoksi');
        $MasterPosisi = $query->result();
        if(!empty($MasterPosisi)){
            return $MasterPosisi;
         } else {
            return array();
        }
    }
    public function datasMasterIndikator()
    {
        $this->db->select('*');
        // $this->db->order_by('kategori_tindakan_header_urut','asc');
        $query = $this->db->get('simkin.master_indikator');
        $Masterindikator = $query->result();
        if(!empty($Masterindikator)){
            return $Masterindikator;
         } else {
            return array();
        }
    }
    public function datasDetailIndikator()
    {
        $this->db->select('a.*,b.nama_unit,c.nama_jabatan,
                            d.klinik_kategori_tindakan_header_instalasi_nama as nama_header_instalasi,
                            e.kategori_tindakan_header_nama as header_nama,
                            f.kategori_tindakan_nama as nama_tindakan,
                            g.indikator');
        $this->db->from('simkin.detail_indikator as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_unit_kerja=b.id');
        $this->db->join('simkin.master_jabatan as c','b.id_jabatan=c.id');
        $this->db->join('klinik.klinik_kategori_tindakan_header_instalasi as d','a.id_header_instalasi=d.klinik_kategori_tindakan_header_instalasi_id');
        $this->db->join('klinik.klinik_kategori_tindakan_header as e','a.id_header=e.kategori_tindakan_header_id');
        $this->db->join('klinik.klinik_kategori_tindakan as f','a.id_tindakan=f.kategori_tindakan_id');
        $this->db->join('simkin.master_indikator as g','a.id_master_indikator=g.id');
        $this->db->where('a.aktif','Y');
        $query = $this->db->get();
        $Detailindikator = $query->result();
        if(!empty($Detailindikator)){
            return $Detailindikator;
         } else {
            return array();
        }
    }
    public function datasDetailIndikatorUnitKerja($datas)
    {
        $this->db->select('a.*,b.nama_unit,c.nama_jabatan,
                            d.klinik_kategori_tindakan_header_instalasi_nama as nama_header_instalasi,
                            e.kategori_tindakan_header_nama as header_nama,
                            f.kategori_tindakan_nama as nama_tindakan,
                            g.indikator');
        $this->db->from('simkin.detail_indikator as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_unit_kerja=b.id');
        $this->db->join('simkin.master_jabatan as c','b.id_jabatan=c.id');
        $this->db->join('klinik.klinik_kategori_tindakan_header_instalasi as d','a.id_header_instalasi=d.klinik_kategori_tindakan_header_instalasi_id');
        $this->db->join('klinik.klinik_kategori_tindakan_header as e','a.id_header=e.kategori_tindakan_header_id');
        $this->db->join('klinik.klinik_kategori_tindakan as f','a.id_tindakan=f.kategori_tindakan_id');
        $this->db->join('simkin.master_indikator as g','a.id_master_indikator=g.id');
        $this->db->where('a.aktif','Y');
        $this->db->where($datas);
        $query = $this->db->get();
        $Detailindikator = $query->result();
        if(!empty($Detailindikator)){
            return $Detailindikator;
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
    function add($userInfo,$table)
    {
        $this->db->trans_start();
        $this->db->insert($table, $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function edit($data, $id,$table)
    {     
        $this->db->where('id', $id);
        $this->db->update($table, $data);

        return TRUE;
    }
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($data, $id,$table)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        
        return $this->db->affected_rows();
    }
    function getSelect($id,$table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('aktif', 'Y');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
}

  