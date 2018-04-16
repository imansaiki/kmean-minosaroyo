<?php
/**
 *
 */
class data extends CI_Controller
{

  function __construct()
  {
    # code...
    parent::__construct();
		//if (!$this->session->userdata('id'))
		//{
		//	redirect(base_url());
		//}
		//$this->load->model('jadwalM');
		//$this->load->model('guruM');
		$this->load->model('dataM');
  }
  function tofloat($num) {
      $dotPos = strrpos($num, '.');
      $commaPos = strrpos($num, ',');
      $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
          ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

      if (!$sep) {
          return floatval(preg_replace("/[^0-9]/", "", $num));
      }

      return floatval(
          preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
          preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
      );
  }
  function csv_to_array($filename='', $delimiter=',')
  {
      if(!file_exists($filename) || !is_readable($filename))
          return FALSE;

    	$rownum=1;
      $data = array();
      if (($handle = fopen($filename, 'r')) !== FALSE)
      {
          while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
          {
                  $data[$rownum] = $row;
  								$rownum++;
          }
          fclose($handle);
      }
      return $data;
  }
  function readCSV($bulan,$tahun){
    $config['upload_path']          = './';
    $config['allowed_types']        = 'csv';
    $config['file_name']          = $bulan.'_'.$tahun.'.csv';
    $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('upcsv')){
          $error = array('error' => $this->upload->display_errors());
          echo 'gagal';
          $this->load->view('input', $error);
      }
      else{
          $data = array('upload_data' => $this->upload->data());
          echo 'berhasil';
          $this->load->view('input', $data);
      }
    $array_ret=$this->csv_to_array($bulan.'_'.$tahun.'.csv',';');
    unlink($config['file_name']);
    return $array_ret;

  }
  function getMaxHarga(){
    $data=$this->dataM->getMaxHarga();
    return $data;
  }
  function getMaxBerat(){
    $data=$this->dataM->getMaxBerat();
    return $data;
  }
  function getMinHarga(){
    $data=$this->dataM->getMinHarga();
    return $data;
  }
  function getMinBerat(){
    $data=$this->dataM->getMinBerat();
    return $data;
  }

  function inputData(){
    $bulan=$this->input->post('bulan');
    $tahun=$this->input->post('tahun');
    $data=$this->readCSV($bulan,$tahun);
    for($i=71;$i<=115;$i++){
      $beratot=$this->tofloat($data[$i][8]);
      $hargatot=$this->tofloat($data[$i][9]);
      if($beratot!=0){
        $hargaperkg=$hargatot/$beratot;
        $this->dataM->inputDataIkan($data[$i][1],$beratot,$hargatot,$hargaperkg,$bulan,$tahun);
      }
      //echo $data[$i][1].'-'.$beratot.'-'.$hargatot.'-'.$hargaperkg.'-'.$bulan.'-'.$tahun.'<br>';

    }
  }
  function jarakBulan($bulan1,$bulan2){
    $inc=array('Januari' => 1,
                'Februari'=> 2,
                'Maret'   => 3,
                'April'   => 4,
                'Mei'     => 5,
                'Juni'    => 6,
                'Juli'    => 7,
                'Agustus' => 8,
                'September'=>9 ,
                'Oktober' => 10,
                'November'=> 11,
                'Desember'=>  12,
                );
    $dec=array('Januari' => 1,
                'Februari'=> 2,
                'Maret'   => 3,
                'April'   => 4,
                'Mei'     => 5,
                'Juni'    => 6,
                'Juli'    => 7,
                'Agustus' => 8,
                'September'=>9 ,
                'Oktober' => 10,
                'November'=> 11,
                'Desember'=>  12,
                );
    $jarak[]=abs($dec[$bulan1]-$dec[$bulan2]);
    $jarak[]=abs($inc[$bulan1]-$inc[$bulan2]);
    $jaraknormal=(min($jarak))/(6);
    return $jaraknormal;
  }
  function normalisasiData(){
    $maxberat=$this->getMaxBerat();
    $minberat=$this->getMinBerat();
    $maxharga=$this->getMaxHarga();
    $minharga=$this->getMinHarga();
    $data=$this->dataM->getHargaBerat();
    foreach ($data as $key => $value) {
      $harganormal=(($value->hperkg - $minharga)/($maxharga-$minharga));
      $beratnormal=(($value->berat - $minberat)/($maxberat-$minberat));
      $this->dataM->updateDataNormal($value->id,$harganormal,$beratnormal);
      echo $value->hperkg.'-'.$minharga.'/'.$maxharga.'-'.$minharga.'='.$harganormal;
      echo '<br>';
    }

  }
  function kMeansLoop($data,$centroid){
    foreach ($data as $keyData => $valueData) {
      # code...
      foreach ($centroid as $keyCentro => $valueCentro) {
        # code...
        $xVal=pow(($valueCentro['x']-$valueData['berat_normal']),2);
        $yVal=pow(($valueCentro['y']-$valueData['hperkg_normal']),2);
        $jarak[$keyCentro]=sqrt($xVal+$yVal);
      }
      $klusterPilih=array_search(min($jarak),$jarak);
      $data[$keyData]['kluster']= $klusterPilih;
      $anggotaKluster[$klusterPilih]['x'][]=$valueData['berat_normal'];
      $anggotaKluster[$klusterPilih]['y'][]=$valueData['hperkg_normal'];
    }
    $diff=0;
    foreach ($centroid as $key => $value) {
      # code...
      if(empty($anggotaKluster[$key])){
        $anggotaKluster[$key]['x']=rand(1000000000,1)/1000000000;
        $anggotaKluster[$key]['y']=rand(1000000000,1)/1000000000;
        $diff++;
      }else{
        $newCentro[$key]['x']=array_sum($anggotaKluster[$key]['x'])/count($anggotaKluster[$key]['x']);
        $newCentro[$key]['y']=array_sum($anggotaKluster[$key]['y'])/count($anggotaKluster[$key]['y']);
        if($newCentro[$key]['x']!=$value['x']||$newCentro[$key]['y']!=$value['y']){
          $diff++;
        }
      }
    }
    if($diff>0){
      $this->kMeansLoop($data,$newCentro);
    }else{
      foreach ($data as $key => $value) {
        # code...
        $this->dataM->updateDataKluster($value['id'],$value['kluster']);
      }
      $this->dataM->updateCentroid($newCentro);
    }
  }
  function kMeans($k){
    for($i=0;$i<$k;$i++){
      $centroid[$i]['x']=rand(1000000000,1)/1000000000;
      $centroid[$i]['y']=rand(1000000000,1)/1000000000;
    }
    $data=$this->dataM->getDataIkan();
    $this->kMeansLoop($data,$centroid);

  }
  function getData(){
    $color=['#C0392B','#9B59B6','#2980B9','#1ABC9C','#F1C40F','#E67E22'];
    $color2=['#E74C3C','#8E44AD','#3498DB','#16A085','#F39C12','#D35400'];
    $i=0;
    $data=$this->dataM->getListCentro();
    foreach ($data as $key => $value) {
      $dataKluster=$this->dataM->getAnggotaKluster($value['id']);
      foreach ($dataKluster as $keyklus => $valueklus) {
            $kordinat[$key][]= array('x' => $valueklus['berat'],
                                'y' => $valueklus['hperkg'],
                                'jenis' => $valueklus['jenis'],
                                'bulan'=> $valueklus['bulan'],
                                'tahun' => $valueklus['tahun']);
      }

      $array['datasets'][]= array('label' =>'kluster'.$value['id'] ,
                      'pointBackgroundColor' =>$color[$i] ,
                      'pointBorderColor' => $color2[$i],
                      'backgroundColor' => $color[$i],
                      'borderColor' => $color2[$i],
                      'data' => $kordinat[$key]);
      $i++;
    }
    echo json_encode($array);
  }
  function input(){
    $this->load->view('input');
  }

}

 ?>
