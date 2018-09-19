<?php
/**
 *
 */
class dataM extends CI_Model
{
  function inputDataIkan($nama,$beratot,$hargatot,$hargaperkg,$bulan,$tahun){
    $this->db->flush_cache();
    $data = array(
        'jenis' => $nama,
        'berat'  => $beratot,
        'harga'  => $hargatot,
        'hperkg' => $hargaperkg,
        'bulan'  => $bulan,
        'tahun'  => $tahun
        );
    $this->db->replace('dataikan',$data);
  }
  function getMaxHarga(){
    $this->db->flush_cache();
    $this->db->select_max('hperkg');
    $query = $this->db->get('dataikan');
    $query= $query->row();
    return $query->hperkg;
  }
  function getMaxBerat(){
    $this->db->flush_cache();
    $this->db->select_max('berat');
    $query = $this->db->get('dataikan');
    $query= $query->row();
    return $query->berat;
  }
  function getMinHarga(){
    $this->db->flush_cache();
    $this->db->select_min('hperkg');
    $query = $this->db->get('dataikan');
    $query= $query->row();
    return $query->hperkg;
  }
  function getMinBerat(){
    $this->db->flush_cache();
    $this->db->select_min('berat');
    $query = $this->db->get('dataikan');
    $query= $query->row();
    return $query->berat;
  }
  function getHargaBerat(){
    $this->db->flush_cache();
    $this->db->select('id,hperkg, berat');
    $query = $this->db->get('dataikan');
    return $query->result();

  }
  function updateDataNormal($id,$harga,$berat){
    $data = array(
        'hperkg_normal' => $harga,
        'berat_normal' => $berat
      );
      $this->db->flush_cache();
      $this->db->where('id', $id);
      $this->db->update('dataikan', $data);
  }
  function updateDataKluster($id,$kluster){
    $data = array(
        'kluster' => $kluster
      );
      $this->db->flush_cache();
      $this->db->where('id', $id);
      $this->db->update('dataikan', $data);
  }
  function getDataIkan(){
    $this->db->flush_cache();
    $this->db->select('id,hperkg_normal, berat_normal');
    $query = $this->db->get('dataikan');
    return $query->result_array();
  }
  function getDataIkanAll(){
    $this->db->flush_cache();
    $query = $this->db->get('dataikan');
    return $query->result_array();
  }
  function updateCentroid($centroid){
    $this->db->flush_cache();
    $this->db->empty_table('centroid');
    $this->db->flush_cache();
    foreach ($centroid as $key => $value) {
      # code...
      $array= array('id' => $key,
                    'x' => $value['x'],
                    'y'=> $value['y']);
      $this->db->replace('centroid',$array);
      $this->db->flush_cache();
    }

  }
  function getListCentro(){
    $this->db->flush_cache();
    $data=$this->db->get('centroid');
    return $data->result_array();
  }
  function getAnggotaKluster($centroid){
    $this->db->flush_cache();
    $this->db->where('kluster',$centroid);
    $data=$this->db->get('dataikan');
    return $data->result_array();
  }
}

 ?>
