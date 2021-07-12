<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_grafik extends CI_Model {

	function from_last($prd_ta=''){
		$date = explode("/",$prd_ta);
		$date['from'] = date($date[0]."-07-01 00:00:00");
		$date['last'] = date($date[1]."-06-30 23:59:59");
		
		return $date;
	}
	
	function chek_buku_tag( $id_buku, $id_tag){
		$this->db->where('buku_id', $id_buku, false);
		$this->db->where('tag_id', $id_tag, false);
		
		$query = $this->db->get('perpus_buku_tag')->result();
		$result=0;
		foreach($query as $q){
			if($q->modified_time){
				$result = 1;
			}
		}
		
		return $result;
	}
	
    function listing($send_data = "", $role='siswa') {
		
		$d = $this->d;
		
		if(isset($send_data['from'])){
			$data['from'] = date(tgltodb($send_data['from'])." 00:00:00");
			$data['last'] = date(tgltodb($send_data['last'])." 23:59:59");
		}else{
			$data = $this->from_last($send_data['prd_ta']);
		}
		$this->db->select("
			baca_detail.baca_kode,
			baca_detail.read_first,
			
			user.nama as nama_user,
			buku.buku_nama as nama_buku,
			buku_bab.buku_bab_nama as nama_buku_bab,
		");
		if($role=='siswa'){
			$this->db->join('dprofil_siswa user', 'user.id =  baca_detail.baca_user_id', 'inner');
		}elseif($role=='sdm'){
			$this->db->join('dprofil_sdm user', 'user.id =  baca_detail.baca_user_id', 'inner');
		}
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca_detail.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		$this->db->where('read_first >=', "'".$data['from']."'", false);
		$this->db->where('read_first <=', "'".$data['last']."'", false);
		
		//// WHERE ID
		if(isset($send_data['siswa_id'])){
			$this->db->where('user.id', $send_data['siswa_id'], false);
		}
		
		if(isset($send_data['sdm_id'])){
			$this->db->where('user.id', $send_data['sdm_id'], false);
		}
		
		if(isset($send_data['buku_id'])){
			$this->db->where('buku.buku_id', $send_data['buku_id'], false);
		}
		
		$this->db->order_by('read_first');
		
        $query = $this->db->get('perpus_baca_detail baca_detail');
        $a=0;
		$tanggal	= '';
		$tmp_buku 	= array('');
		$jml_buku	= 0;
		$tmp_siswa 	= array('');
		$jml_siswa	= 0;
        foreach ($query->result() as $arra1) {
           /* $a++;
			$datas = array(
				'kode' 				=> $arra1->baca_kode,
				'read_first' 		=> $arra1->read_first,
				'nama_siswa' 		=> $arra1->nama_siswa,
				'nama_buku' 		=> $arra1->nama_buku,
				'nama_buku_bab' 		=> $arra1->nama_buku_bab,
			);
			$data1['data'][$a] = $datas;
			*/
			//// siswa
			$temp_tanggal = explode(" ",$arra1->read_first);
			$arra1->read_first = $temp_tanggal[0]; 
			if($tanggal != $arra1->read_first){
				if($tanggal==''){
					$tanggal = $arra1->read_first;
				}else{
					$siswas = array(
						((strtotime($tanggal)+25200)*1000),
						$jml_siswa
					);
					$data1['user'][] = $siswas;
				
					$tmp_siswa 	= array('');
					$jml_siswa	= 0;
					
					$bukus = array(
						((strtotime($tanggal)+25200)*1000),
						$jml_buku
					);
					$data1['buku'][] = $bukus;
				
					$tmp_buku 	= array('');
					$jml_buku	= 0;
					
					$tanggal 	= $arra1->read_first;
				}
			}
			if (in_array( $arra1->nama_user, $tmp_siswa)){
				
			}else{
				$tmp_siswa[] = $arra1->nama_user;
				$jml_siswa++;
			}
			
			//// buku
			
			if (in_array( $arra1->nama_buku, $tmp_buku)){
				
			}else{
				$tmp_buku[] = $arra1->nama_buku;
				$jml_buku++;
			}
			
        }
		
		/// LAST DATE
		$siswas = array(
			((strtotime($tanggal)+25200)*1000),
			$jml_siswa
		);
		$data1['user'][] = $siswas;
	
		$bukus = array(
			((strtotime($tanggal)+25200)*1000),
			$jml_buku
		);
		$data1['buku'][] = $bukus;
		//////////////////////
		
					
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function listing_peringkat($send_data = "") {
		
		$d = $this->d;
	
		if(isset($send_data['from'])){
			$data['from'] = date(tgltodb($send_data['from'])." 00:00:00");
			$data['last'] = date(tgltodb($send_data['last'])." 23:59:59");
		}else{
			$data = $this->from_last($send_data['prd_ta']);
		}
		$this->db->select("
			(SUM(baca_detail.total_waktu)/60) as total_waktu,
			
			kelas.grade,
			kelas.nama as nama_kelas,
			siswa.nama as nama_siswa,
			buku.buku_id as id_buku,
			buku.buku_nama as nama_buku,
		");
		$this->db->join('dprofil_siswa siswa', 'siswa.id =  baca_detail.baca_user_id', 'inner');
		$this->db->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left');
		
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca_detail.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		$this->db->where('read_first >=', "'".$data['from']."'", false);
		$this->db->where('read_first <=', "'".$data['last']."'", false);
		
		if($send_data['group']=='siswa'){ 
			$this->db->group_by('siswa.id');
		}elseif($send_data['group']=='buku'){
			$this->db->group_by('buku.buku_id');
		}
		$this->db->order_by('total_waktu desc');
		
		if(isset($send_data['limit'])){ 
			$this->db->limit($send_data['limit'], 0);
		}
		
        $query = $this->db->get('perpus_baca_detail baca_detail');
        
		$a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'total_waktu' 		=> $arra1->total_waktu,
				
			);
			if($send_data['group']=='siswa'){ 
				$datas['nama_siswa'] = $arra1->nama_siswa;
				$datas['nama_kelas'] = $arra1->nama_kelas;
				$datas['grade'] 	 = $arra1->grade;
				
			}elseif($send_data['group']=='buku'){
				$datas['id_buku'] 	= $arra1->id_buku;
				$datas['nama_buku'] = $arra1->nama_buku;
			}
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function listing_peringkat2($send_data = "") {
		
		if($send_data['group']=='grade'){
			$send_data['group']='siswa';
			$listing_peringkat_siswa = $this->listing_peringkat($send_data);
		
			$no=0;
			$tmp_grade = array();
			if(isset($listing_peringkat_siswa['data'])){
				foreach($listing_peringkat_siswa['data'] as $siswa){
					
					if (in_array( $siswa['grade'], $tmp_grade)){
						$tmp_grade[$siswa['grade']] = $tmp_grade[$siswa['grade']] + $siswa['total_waktu'];
					}else{
						$tmp_grade[$siswa['grade']] = $siswa['total_waktu'];
					}
					$no++;
				}
			}
			
			return $tmp_grade;
		} 
		
		if($send_data['group']=='tag'){
			$send_data['group']='buku';
			$data_tag_ori = $send_data['data_tag']['data'];
			$listing_peringkat_buku = $this->listing_peringkat($send_data);
		
			$no=0;
			$tmp_tag = array();
			if(isset($listing_peringkat_buku['data'])){
				foreach($listing_peringkat_buku['data'] as $buku){
					
					$data_tag=$data_tag_ori;
					foreach($data_tag as $tag){
						$result_tag = $this->chek_buku_tag( $buku['id_buku'], $tag['tag_id']);
						if ($result_tag==1){
							if(isset($tmp_tag[$tag['tag_nama']])){
								$tmp_tag[$tag['tag_nama']] = $tmp_tag[$tag['tag_nama']] + $buku['total_waktu'];
							}else{
								$tmp_tag[$tag['tag_nama']] = $buku['total_waktu'];
							}
						}
					}
					$no++;
				}
			}
			
			return $tmp_tag;
		} 
	}

}
