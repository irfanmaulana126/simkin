<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class pegawai_unit extends CI_Model
{
    public function AllPegawai($kode)
    {
        $this->db->select('pgw_id,pgw_nama,id_unit_kerja,id_jabatan,nama_unit,c.usr_id');
        $this->db->from('hris.hris_pegawai as a');
        $this->db->join('simkin.master_unit_kerja as b','a.id_unit_kerja=b.id');
        $this->db->join('global.global_auth_user as c','a.pgw_id=c.id_pgw');
        $this->db->where('is_pegawai','y');
        $this->db->where('id_jabatan',$kode);
        $this->db->where_in('tipe',array('0','2'));
        $query = $this->db->get();
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasDetailAllTupoksi($id,$unit,$date)
    {
        $query =$this->db->query("
		SELECT *, (sumall / target)*bobot as total FROM simkin.master_indikator as a LEFT JOIN 
        (
        SELECT id_master_indikator as id ,usr_id,sum(nilai) as sumall,target,bobot from input_kegitan_tupoksi WHERE usr_id='".$id."' and created::TEXT like '".$date."%' and aktif='Y' GROUP BY id_master_indikator,usr_id,usr_insrt,aktif,target,bobot
        UNION
        select b.id,aa.usr_id,sumall,target,bobot from (
select id,count(id) as sumall from(select a.id,f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input from simkin.master_indikator as a 
                                    INNER JOIN simkin.detail_indikator as b on a.id=b.id_master_indikator
                                    INNER JOIN klinik.klinik_kategori_tindakan as c on b.id_tindakan=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_biaya as d on d.biaya_kategori=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_folio as e on e.id_biaya=d.biaya_id
                                    INNER JOIN klinik.klinik_folio_pelaksana as f on f.id_fol= e.fol_id
                                    INNER JOIN global.global_auth_user as g on g.usr_id=f.id_usr
                                    INNER JOIN global.global_customer_user as h on e.id_cust_usr=h.cust_usr_id
                                    INNER JOIN target_bobot as j on j.id_m_indikator=b.id_master_indikator
                    INNER JOIN hris.hris_pegawai as i on g.id_pgw=i.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
                    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$id."' and a.id_unit_kerja='".$unit."' GROUP BY a.id,tindakan_tanggal,f.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_waktu,usr_id,indikator,difinisi,jns_input ORDER BY tindakan_tanggal DESC)a GROUP BY id)b
INNER JOIN 
(select a.id,f.id_usr as usr_id,target,bobot from simkin.master_indikator as a 
                                    INNER JOIN simkin.detail_indikator as b on a.id=b.id_master_indikator
                                    INNER JOIN klinik.klinik_kategori_tindakan as c on b.id_tindakan=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_biaya as d on d.biaya_kategori=c.kategori_tindakan_id 
                                    INNER JOIN klinik.klinik_folio as e on e.id_biaya=d.biaya_id
                                    INNER JOIN klinik.klinik_folio_pelaksana as f on f.id_fol= e.fol_id
                                    INNER JOIN global.global_auth_user as g on g.usr_id=f.id_usr
                                    INNER JOIN global.global_customer_user as h on e.id_cust_usr=h.cust_usr_id
                    INNER JOIN hris.hris_pegawai as i on g.id_pgw=i.pgw_id 
                                    INNER JOIN target_bobot as j on j.id_m_indikator=b.id_master_indikator
                                    WHERE fol_pelaksana_tipe IN('1','10') and tindakan_tanggal::TEXT like '".$date."%' and f.id_usr='".$id."' and tgl_akhir::TEXT<='".$date."%'  GROUP BY a.id,f.id_usr,target,bobot)aa on b.id=aa.id
    UNION
    select d.id,bb.usr_id,sumall,target,bobot from (
select id,count(id) as sumall from(select a.id,d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_tanggal,tindakan_waktu,usr_id,indikator,difinisi,jns_input  from simkin.master_indikator as a 
        INNER JOIN simkin.detail_indikator_folio as b on a.id=b.id_master_indikator
        INNER JOIN klinik.klinik_folio as c on c.id_poli=b.id_folio
        INNER JOIN klinik.klinik_folio_pelaksana as d on d.id_fol= c.fol_id
        INNER JOIN global.global_customer_user as e on c.id_cust_usr=e.cust_usr_id
        INNER JOIN global.global_auth_user as f on f.usr_id=d.id_usr
        INNER JOIN hris.hris_pegawai as g on f.id_pgw=g.pgw_id WHERE fol_pelaksana_tipe IN('1','10')
                    and tindakan_tanggal::TEXT like '".$date."%' and usr_id='".$id."' and a.id_unit_kerja='".$unit."'  GROUP BY a.id,tindakan_tanggal,d.id_usr,fol_pelaksana_tipe,fol_pelaksana_nominal,fol_id,id_reg,fol_nama,cust_usr_nama,fol_nominal,tindakan_waktu,usr_id,indikator,difinisi,jns_input  ORDER BY tindakan_tanggal DESC)c GROUP BY id)d
INNER JOIN 
(select a.id,d.id_usr as usr_id,target,bobot from simkin.master_indikator as a 
                                    INNER JOIN simkin.detail_indikator_folio as b on a.id=b.id_master_indikator
                                    INNER JOIN klinik.klinik_folio as c on c.id_poli=b.id_folio
                                    INNER JOIN klinik.klinik_folio_pelaksana as d on d.id_fol= c.fol_id
                                    INNER JOIN global.global_customer_user as e on c.id_cust_usr=e.cust_usr_id
                                    INNER JOIN global.global_auth_user as f on f.usr_id=d.id_usr
                    INNER JOIN hris.hris_pegawai as g on f.id_pgw=g.pgw_id
                                    INNER JOIN target_bobot as h on h.id_m_indikator=b.id_master_indikator
                                    WHERE fol_pelaksana_tipe IN('1','10') and tindakan_tanggal::TEXT like '".$date."%' and d.id_usr='".$id."' and tgl_akhir::TEXT<='".$date."%' GROUP BY a.id,d.id_usr,target,bobot)bb on d.id=bb.id
                                            ) as b
    on b.id=a.id WHERE aktif='Y' and a.id_unit_kerja='".$unit."'
    ORDER BY indikator_tupoksi ASC");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    function addTupoksiKegitan($usr_id,$dates,$userInfo,$table)
    {
        $this->db->trans_start();
        $this->db->insert($table, $userInfo);
        
        $insert_id = $this->db->insert_id();
        $inputtupoksi = array(  
            'nilai'=>1,
            'id_master_indikator'=>$insert_id,
            'aktif'=>'Y',
            'target'=>1,
            'bobot'=>0.5,
            'usr_id'=>$usr_id,
            'created_at'=>date('Y-m-d H:i:s'),
            'created'=>$dates,
            'usr_insrt'=>$this->session->userdata ('name')
        );
        $this->db->insert('input_kegitan_tupoksi', $inputtupoksi);
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    public function datasPegawai($id)
    {

        $this->db->select('usr_id,id_rol,pgw_nama,usr_name,pgw_nip,pgw_jenis_kelamin,id_jabatan,b.rol_name,d.nama_unit,d.tipe,d.id_jabatan');
        $this->db->from('global.global_auth_user as a');
        $this->db->join('global.global_auth_role as b','a.id_rol=b.rol_id','left');
        $this->db->join('hris.hris_pegawai as c ','a.id_pgw=c.pgw_id','left');
        $this->db->join('simkin.master_unit_kerja as d ','d.id=c.id_unit_kerja','left');
        $this->db->where('is_pegawai', 'y');
        $this->db->where('usr_id', $id);
        $query = $this->db->get();
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    public function datasPegawaijabatan($jabatan)
    {

        $this->db->select('*');
        $this->db->from('simkin.master_jabatan');
        $this->db->where('id', $jabatan);
        $query = $this->db->get();
        $indikator = $query->row();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }    
}

  