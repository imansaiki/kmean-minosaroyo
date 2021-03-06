<?php
/**
 *
 */
class dataM extends CI_Model
{
  function inputDataIkan($nama,$beratot,$hargatot,$hargaperkg,$bulan,$tahun){
    $dafBulan= array('Januari' => '01',
                  'Februari' => '02',
                  'Maret' => '03',
                  'April' => '04',
                  'Mei' => '05',
                  'Juni' => '06',
                  'Juli' => '07',
                  'Agustus' => '08',
                  'September' => '09',
                  'Oktober' => '10',
                  'November' => '11',
                  'Desember' => '12');
    $this->db->flush_cache();
    $this->db->where('jenis', $nama);
    $this->db->where('bulan', $bulan);
    $this->db->where('tahun', $tahun);
    $this->db->delete('dataikan');
    $this->db->flush_cache();
    $date=$tahun.'-'.$dafBulan[$bulan].'-01';
    $data = array(
        'jenis' => $nama,
        'berat'  => $beratot,
        'harga'  => $hargatot,
        'hperkg' => $hargaperkg,
        'bulan'  => $bulan,
        'tahun'  => $tahun,
        'date'   => $date
        );
    $this->db->insert('dataikan',$data);
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
  function getSSE()
  {
    // code...
    $this->db->flush_cache();
    $query = $this->db->get('daftarsse');
    return $query->result();
  }
  function updateDataNormal($id,$harga,$berat){
    $data = array(
        'hperkg_normal' => $harga,
        'berat_normal' => $berat,
        'normalize'=>1,
      );
      $this->db->flush_cache();
      $this->db->where('id', $id);
      $this->db->update('dataikan', $data);
  }
  function updateDaftarSSE($k,$sse){
    $data = array(
        'k' => $k,
        'sse' => $sse
      );
    $this->db->flush_cache();
    $this->db->replace('daftarsse', $data);
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
    $this->db->select();
    $this->db->order_by('tahun ASC');
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
  function getDafKlus(){
    $this->db->flush_cache();
    $this->db->select('id');
    $data=$this->db->get('centroid');
    return $data->result_array();
  }
  function cekKluster()
  {
    $this->db->flush_cache();
    $this->db->where('kluster',"");
    $data=$this->db->get('dataikan');
    return $data->result_array();
  }
  function cekNormal()
  {
    $this->db->flush_cache();
    $this->db->where('normalize',"");
    $data=$this->db->get('dataikan');
    return $data->result_array();
  }
  function getJumlahData(){
    $this->db->flush_cache();
    $this->db->select('tahun, COUNT(id) as total');
    $this->db->group_by("tahun");
    $this->db->from('dataikan');
    $data=$this->db->get();
    return $data->result_array();
  }
}

 ?>
