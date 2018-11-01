<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class tupoksi_model extends CI_Model
{

    
    public function datasDetailTupoksiTindakan($tupoksi,$date)
    {
        $query =$this->db->query("
        select f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input from simkin.master_indikator as a 
        INNER JOIN simkin.detail_indikator as b on a.id=b.id_master_indikator
        INNER JOIN klinik.klinik_kategori_tindakan as c on b.id_tindakan=c.kategori_tindakan_id 
        INNER JOIN klinik.klinik_biaya as d on d.biaya_kategori=c.kategori_tindakan_id 
        INNER JOIN klinik.klinik_folio as e on e.id_biaya=d.biaya_id
        INNER JOIN klinik.klinik_folio_pelaksana as f on f.id_fol= e.fol_id
        INNER JOIN global.global_auth_user as g on g.usr_id=f.id_usr
        INNER JOIN global.global_customer_user as h on e.id_cust_usr=h.cust_usr_id
        INNER JOIN target_bobot as j on j.id_m_indikator=b.id_master_indikator
                    INNER JOIN hris.hris_pegawai as i on g.id_pgw=i.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
                    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and a.id='".$tupoksi."' and a.id_unit_kerja='".$this->session->userdata('unit')."' GROUP BY f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input ORDER BY tindakan_tanggal DESC");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasDetailTupoksiFolio($tupoksi,$date)
    {
        $query =$this->db->query("
        select d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input  from simkin.master_indikator as a 
        INNER JOIN simkin.detail_indikator_folio as b on a.id=b.id_master_indikator
        INNER JOIN klinik.klinik_folio as c on c.id_poli=b.id_folio
        INNER JOIN klinik.klinik_folio_pelaksana as d on d.id_fol= c.fol_id
        INNER JOIN global.global_customer_user as e on c.id_cust_usr=e.cust_usr_id
        INNER JOIN global.global_auth_user as f on f.usr_id=d.id_usr
        INNER JOIN hris.hris_pegawai as g on f.id_pgw=g.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
                    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and a.id='".$tupoksi."' and a.id_unit_kerja='".$this->session->userdata('unit')."' GROUP BY d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input  ORDER BY tindakan_tanggal DESC");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasDetailAllTupoksi($date)
    {
        $query =$this->db->query("
        SELECT *, (sumall / target)*bobot as total FROM simkin.master_indikator as a LEFT JOIN 
        (
        SELECT id_master_indikator as id ,usr_id,sum(nilai) as sumall,target,bobot from input_kegitan_tupoksi WHERE usr_id='".$this->session->userdata('userId')."' and created::TEXT like '".$date."%' and aktif='Y' GROUP BY id_master_indikator,usr_id,usr_insrt,aktif,target,bobot
        UNION
        select a.id,f.id_usr as usr_id,count(DISTINCT cust_usr_nama) as sumall,target,bobot from simkin.master_indikator as a 
                                    INNER JOIN simkin.detail_indikator as b on a.id=b.id_master_indikator
                                    INNER JOIN klinik.klinik_kategori_tindakan as c on b.id_tindakan=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_biaya as d on d.biaya_kategori=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_folio as e on e.id_biaya=d.biaya_id
                                    INNER JOIN klinik.klinik_folio_pelaksana as f on f.id_fol= e.fol_id
                                    INNER JOIN global.global_auth_user as g on g.usr_id=f.id_usr
                                    INNER JOIN global.global_customer_user as h on e.id_cust_usr=h.cust_usr_id
                    INNER JOIN hris.hris_pegawai as i on g.id_pgw=i.pgw_id 
                                    INNER JOIN target_bobot as j on j.id_m_indikator=b.id_master_indikator
                                    WHERE fol_pelaksana_tipe IN('1','10') and tindakan_tanggal::TEXT like '".$date."%' and f.id_usr='".$this->session->userdata('userId')."' and tgl_akhir::TEXT<='".$date."%'  GROUP BY a.id,f.id_usr,target,bobot
    UNION
    select a.id,d.id_usr as usr_id,count(cust_usr_nama) as sumall,target,bobot from simkin.master_indikator as a 
                                    INNER JOIN simkin.detail_indikator_folio as b on a.id=b.id_master_indikator
                                    INNER JOIN klinik.klinik_folio as c on c.id_poli=b.id_folio
                                    INNER JOIN klinik.klinik_folio_pelaksana as d on d.id_fol= c.fol_id
                                    INNER JOIN global.global_customer_user as e on c.id_cust_usr=e.cust_usr_id
                                    INNER JOIN global.global_auth_user as f on f.usr_id=d.id_usr
                    INNER JOIN hris.hris_pegawai as g on f.id_pgw=g.pgw_id
                                    INNER JOIN target_bobot as h on h.id_m_indikator=b.id_master_indikator
                                    WHERE fol_pelaksana_tipe IN('1','10') and tindakan_tanggal::TEXT like '".$date."%' and d.id_usr='".$this->session->userdata('userId')."' and tgl_akhir::TEXT<='".$date."%' GROUP BY a.id,d.id_usr,target,bobot
                                            ) as b
    on b.id=a.id WHERE aktif='Y' and a.id_unit_kerja='".$this->session->userdata('unit')."'
    ORDER BY indikator_tupoksi ASC ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasDetailAllTupoksiTindakanPoli($date)
    {
        $query =$this->db->query(" 
    select f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input from 
    simkin.master_indikator as a 
    INNER JOIN simkin.detail_indikator as b on a.id=b.id_master_indikator
    INNER JOIN klinik.klinik_kategori_tindakan as c on b.id_tindakan=c.kategori_tindakan_id 
    INNER JOIN klinik.klinik_biaya as d on d.biaya_kategori=c.kategori_tindakan_id 
    INNER JOIN klinik.klinik_folio as e on e.id_biaya=d.biaya_id
    INNER JOIN klinik.klinik_folio_pelaksana as f on f.id_fol= e.fol_id
    INNER JOIN global.global_auth_user as g on g.usr_id=f.id_usr
    INNER JOIN global.global_customer_user as h on e.id_cust_usr=h.cust_usr_id
    INNER JOIN hris.hris_pegawai as i on g.id_pgw=i.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and a.id_unit_kerja='".$this->session->userdata('unit')."' GROUP BY f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input
    UNION 
    select d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input 
    from simkin.master_indikator as a 
    INNER JOIN simkin.detail_indikator_folio as b on a.id=b.id_master_indikator
    INNER JOIN klinik.klinik_folio as c on c.id_poli=b.id_folio
    INNER JOIN klinik.klinik_folio_pelaksana as d on d.id_fol= c.fol_id
    INNER JOIN global.global_customer_user as e on c.id_cust_usr=e.cust_usr_id
    INNER JOIN global.global_auth_user as f on f.usr_id=d.id_usr
    INNER JOIN hris.hris_pegawai as g on f.id_pgw=g.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and a.id_unit_kerja='".$this->session->userdata('unit')."' GROUP BY d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input  ORDER BY tindakan_tanggal DESC");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasDetailTupoksiKuantitasPegawai($tupoksi,$date)
    {
        $query =$this->db->query("
        select fol_nama,tindakan_tanggal,cust_usr_nama,nama_pgw from klinik.klinik_folio_pelaksana a 
        INNER JOIN klinik.klinik_folio b on b.fol_id = a.id_fol 
                    INNER JOIN global.global_auth_user c on a.id_usr = c.usr_id
                    INNER JOIN hris.hris_pegawai as d on c.id_pgw=d.pgw_id 
                    INNER JOIN klinik.klinik_biaya as e on b.id_biaya=e.biaya_id
                    INNER JOIN klinik.klinik_kategori_tindakan as f on e.biaya_kategori=f.kategori_tindakan_id 
                    INNER JOIN simkin.kuantitas_dokter as g on f.kategori_tindakan_id=g.id_tindakan 
                    INNER JOIN simkin.master_unit_kerja as h on g.id_pos=h.id
                    INNER JOIN global.global_customer_user as i on b.id_cust_usr=i.cust_usr_id
                    where tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and g.id_tindakan='".$tupoksi."' and g.id_pos='".$this->session->userdata('unit')."' and aktif ='Y' GROUP BY fol_nama,tindakan_tanggal,cust_usr_nama,nama_pgw ORDER BY tindakan_tanggal DESC");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    
    public function datasTupoksiKuantitas($date)
    {
        $query =$this->db->query("
        (SELECT '' as id_tindakan,id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,a.nilai,((nilai/target)*bobot) as tot,'staff' as pegawai FROM (SELECT id_tupoksi,sum(nilai) as nilai FROM simkin.tupoksi_kuantitas WHERE created_at::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and aktif ='Y' GROUP BY id_tupoksi)a INNER JOIN simkin.kuantitas_pegawai as b on a.id_tupoksi=b.id WHERE id_pos='".$this->session->userdata('unit')."' and aktif ='Y')
        UNION
        (select id_tindakan,id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,count(id_tindakan) as nilai,((count(id_tindakan)::FLOAT / target) * bobot) as tot, 'dokter' as pegawai from(select id_tindakan,id_jenis_pos,id_pos,cust_usr_nama,kategori_tindakan_nama as indikator,target,bobot,tindakan_tanggal,definisi_ops as difinisi_ops from klinik.klinik_folio_pelaksana a 
        INNER JOIN klinik.klinik_folio b on b.fol_id = a.id_fol 
                    INNER JOIN global.global_auth_user c on a.id_usr = c.usr_id
                    INNER JOIN hris.hris_pegawai as d on c.id_pgw=d.pgw_id 
                    INNER JOIN klinik.klinik_biaya as e on b.id_biaya=e.biaya_id
                    INNER JOIN klinik.klinik_kategori_tindakan as f on e.biaya_kategori=f.kategori_tindakan_id 
                    INNER JOIN simkin.kuantitas_dokter as g on f.kategori_tindakan_id=g.id_tindakan 
                    INNER JOIN simkin.master_unit_kerja as h on g.id_pos=h.id
                    INNER JOIN global.global_customer_user as i on b.id_cust_usr=i.cust_usr_id
						 where tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and g.id_pos='".$this->session->userdata('unit')."'  and aktif ='Y'
						 GROUP BY id_tindakan,indikator,nama_unit,definisi_ops,id_jenis_pos,id_pos,cust_usr_nama,target,bobot,tindakan_tanggal ORDER BY id_tindakan DESC)aa group by id_tindakan,indikator,difinisi_ops,id_jenis_pos,id_pos,target,bobot,pegawai )
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasTupoksiKualitas($date)
    {
        $query =$this->db->query("
        SELECT id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,a.nilai,((nilai/target)*bobot) as tot FROM
        (SELECT id_tupoksi,sum(nilai) as nilai FROM tupoksi_kualitas WHERE created_at::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and aktif ='Y' GROUP BY id_tupoksi)a INNER JOIN kualitas as b on a.id_tupoksi=b.id where id_pos='".$this->session->userdata('unit')."' 
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasTupoksiPerilaku($date)
    {
        $query =$this->db->query("
        SELECT id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,a.nilai,((nilai/target)*bobot) as tot FROM
        (SELECT id_tupoksi,sum(nilai) as nilai FROM tupoksi_perilaku WHERE created_at::TEXT like '".$date."%' and usr_id='".$this->session->userdata('userId')."' and aktif ='Y' GROUP BY id_tupoksi)a INNER JOIN perilaku as b on a.id_tupoksi=b.id where id_pos='".$this->session->userdata('unit')."' and aktif ='Y'
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
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
    function update($data, $id,$table)
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
    function deletefix($id,$table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
        
        return $this->db->affected_rows();
    }
    function getSelect($id,$table,$tipe)
    {
        $this->db->select('*,\''.$tipe.'\' as jenis');
        $this->db->from($table);
        $this->db->where('aktif', 'Y');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->row();
    }
}

  