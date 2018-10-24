<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard_model extends CI_Model
{
    public function Indikator($id)
    {
        $this->db->select('*');
        $this->db->from('simkin.master_indikator');
        $this->db->where('aktif','Y');
        $this->db->where('id_unit_kerja',$id);
        $this->db->where_in('jns_input',array('2','3'));
        $query = $this->db->get();
        $indikator = $query->result();
        if(!empty($indikator)){
            return $indikator;
         } else {
            return array();
        }
    }
    function datasAllKegiatan($limit, $start, $id)
    {
        $this->db->select('a.*,b.indikator,b.difinisi,b.indikator_tupoksi');
        $this->db->from('simkin.input_kegitan_tupoksi as a ');
        $this->db->join('master_indikator as b ','a.id_master_indikator=b.id');
        $this->db->where('usr_id',$id);
        $this->db->where('a.aktif','Y');
        $this->db->limit($limit, $start);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
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
    function addTupoksiKegitan($userInfo,$table)
    {
        $this->db->trans_start();
        $this->db->insert($table, $userInfo);
        
        $insert_id = $this->db->insert_id();
        $inputtupoksi = array(  
            'nilai'=>1,
            'id_master_indikator'=>$insert_id,
            'aktif'=>'Y',
            'target'=>1,
            'bobot'=>1,
            'usr_id'=>$this->session->userdata('userId'),
            'created_at'=>date('Y-m-d H:i:s'),
            'usr_insrt'=>$this->session->userdata ('name')
        );
        $this->db->insert('input_kegitan_tupoksi', $inputtupoksi);
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    function getBoborTarget($date)
    {     
        $this->db->select('bobot,target');
        $this->db->from('simkin.target_bobot');
        $this->db->where('tgl_akhir>=', $date);
        $this->db->order_by('tgl_akhir','ASC');
        $query = $this->db->get();
        $bobottarget = $query->row();
        if(!empty($bobottarget)){
            return $bobottarget;
         } else {
            return array();
        }
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
}

  