<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard_model extends CI_Model
{
    public function datasKegiatan($id)
    {
        $query =$this->db->query("
        SELECT * FROM 
            ((SELECT id,id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,'kualitas' as jenis FROM simkin.kualitas)UNION
            (SELECT id,id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,'perilaku'	as jenis FROM simkin.perilaku)UNION
            (SELECT id,id_jenis_pos,id_pos,indikator,target,bobot,difinisi_ops,'kuantitas' as jenis from simkin.kuantitas_pegawai))a WHERE id_pos='".$id."'
        ");
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }


    public function datasAllKegiatan($limit, $start, $id)
    {
        $query =$this->db->query("
        SELECT * FROM 
        ((SELECT a.id,a.aktif,a.created_at,a.updated_at,a.usr_insrt,a.usr_edit,a.id_tupoksi,nilai,a.usr_id,b.indikator,b.difinisi_ops,'kualitas' as jenis FROM tupoksi_kualitas as a
        INNER JOIN kualitas as b ON id_tupoksi=b.id 
        ) UNION
        (SELECT a.id,a.aktif,a.created_at,a.updated_at,a.usr_insrt,a.usr_edit,a.id_tupoksi,nilai,a.usr_id,b.indikator,b.difinisi_ops,'kuantitas' as jenis FROM tupoksi_kuantitas as a 
        INNER JOIN kuantitas_pegawai as b ON id_tupoksi=b.id )UNION
        (SELECT a.id,a.aktif,a.created_at,a.updated_at,a.usr_insrt,a.usr_edit,a.id_tupoksi,nilai,a.usr_id,b.indikator,b.difinisi_ops,'perilaku' as jenis FROM tupoksi_perilaku as a 
        INNER JOIN perilaku as b ON id_tupoksi=b.id))aa WHERE usr_id='".$id."' AND aktif='Y' order by created_at desc limit '".$limit."' OFFSET '".$start."'
        ");
        // print_r($limit);die();
        $indikator = $query->result();
        foreach ($indikator as $key) {
            $users[date('Y-m-d', strtotime($key->created_at))][] = $key;
        }
        if(!empty($users)){
            return $users;
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
    public function upload($data){
        $this->db->where('id_pgw', $this->session->userdata('userId'));
		$this->db->update('tbl_pegawai',$data);
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

  