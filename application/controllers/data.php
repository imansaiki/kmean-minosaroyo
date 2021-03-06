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
  function readCSV(){
    $config['upload_path']          = './';
    $config['allowed_types']        = 'csv';
    $config['overwrite']            = TRUE;
    //$config['file_name']          = $bulan.'_'.$tahun.'.csv';
    $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('upcsv')){
          $data = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('msg',' gagal di upload') ;
          $this->load->view('input', $data);
      }
      else{
          $data = $this->upload->data();
          $this->session->set_flashdata('msg',$data['file_name'].' berhasil di upload') ;
          $this->load->view('input', $data);
      }
    $array_ret['data']=$this->csv_to_array($data['file_name'],';');
    $piece=explode('_',$data['file_name']);
    $array_ret['bulan']=$piece[0];
    $array_ret['tahun']=substr($piece[1],0,-4);
    unlink($data['file_name']);
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
    $data=$this->readCSV();
    for($i=71;$i<=115;$i++){
      $beratot=$this->tofloat($data['data'][$i][8]);
      $hargatot=$this->tofloat($data['data'][$i][9]);
      if($beratot!=0){
        $hargaperkg=round(($hargatot/$beratot),2);
        $this->dataM->inputDataIkan($data['data'][$i][1],$beratot,$hargatot,$hargaperkg,$data['bulan'],$data['tahun']);
      }
      //echo $data[$i][1].'-'.$beratot.'-'.$hargatot.'-'.$hargaperkg.'-'.$bulan.'-'.$tahun.'<br>';

    }
    redirect(base_url('data/input'));
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
    ini_set('max_execution_time', 300);
    $start = microtime(true);
    $maxberat=$this->getMaxBerat();
    $minberat=$this->getMinBerat();
    $maxharga=$this->getMaxHarga();
    $minharga=$this->getMinHarga();
    $data=$this->dataM->getHargaBerat();
    $i=0;
    foreach ($data as $key => $value) {
      $harganormal=(($value->hperkg - $minharga)/($maxharga-$minharga))*10000;
      $beratnormal=(($value->berat - $minberat)/($maxberat-$minberat))*10000;
      $this->dataM->updateDataNormal($value->id,$harganormal,$beratnormal);
      $i++;
      //echo $value->hperkg.'-'.$minharga.'/'.$maxharga.'-'.$minharga.'='.$harganormal;
      //echo '<br>';
    }
    echo "<br>total kalkulasi & update database = ".$i." operasi<br>";
    $time = microtime(true)-$start;
    echo "Waktu Eksekusi = ".$time."s";
  }

  function kMeansLoop($data,$centroid,$loop=0){
    //k counter loop
    $k=0;

    //inisialisasi array anggota kluster
    foreach ($centroid as $key => $value) {
        $anggotaKluster[$key]=[];
        $k++;
    }

    // init total sse disini
    $sse=0;

    foreach ($data as $keyData => $valueData) {

      foreach ($centroid as $keyCentro => $valueCentro) {
        //hitung jarak antara data dengan tiap centroid
        $xVal=pow(($valueCentro['x']-$valueData['berat_normal']),2);
        $yVal=pow(($valueCentro['y']-$valueData['hperkg_normal']),2);
        $jarak[$keyCentro]=sqrt($xVal+$yVal);
      }
      //set data pada centroid terdekat
      $klusterPilih=array_search(min($jarak),$jarak);
      $data[$keyData]['kluster']= $klusterPilih;
      $anggotaKluster[$klusterPilih]['x'][]=$valueData['berat_normal'];
      $anggotaKluster[$klusterPilih]['y'][]=$valueData['hperkg_normal'];
      //kumulatifkan sse disini
      $sse+=min($jarak);
    }
    $diff=0;
    foreach ($centroid as $key => $value) {
      //kondisi jika centroid tidak dapat anggota, maka set centroid baru
      if(empty($anggotaKluster[$key])){
        echo 'empty'.$key.'<br>';
        echo $data[rand((count($data)-1),0)]['berat_normal'];
        echo $data[rand((count($data)-1),0)]['hperkg_normal'];
        $newCentro[$key]['x']=$data[rand((count($data)-1),0)]['berat_normal'];
        $newCentro[$key]['y']=$data[rand((count($data)-1),0)]['hperkg_normal'];
        $diff++;

      }else{
        //cek apakah centroid berubah
        $newCentro[$key]['x']=array_sum($anggotaKluster[$key]['x'])/count($anggotaKluster[$key]['x']);
        $newCentro[$key]['y']=array_sum($anggotaKluster[$key]['y'])/count($anggotaKluster[$key]['y']);
        if($newCentro[$key]['x']!=$value['x']||$newCentro[$key]['y']!=$value['y']){
          $diff++;
        }
      }
    }
    //jika ada perubahan centroid, ulang
    if($diff>0){
      $loop++;
      $this->kMeansLoop($data,$newCentro,$loop);
    }else{
    //jika tidak ada perubahan centroid
      foreach ($data as $key => $value) {
        # code...
        $this->dataM->updateDataKluster($value['id'],$value['kluster']);
        //input sse dan k disini
      }
      //input sse dan k disini
      $this->dataM->updateDaftarSSE($k,$sse);
      $this->dataM->updateCentroid($newCentro);
      echo 'banyaknya perulangan : '.$loop.' kali<br>';
    }

  }
  // Fungsi inisialisasi Centroid awal
  function kMeans($k){
    $start = microtime(true);
    //set timeout
    ini_set('max_execution_time', 300);
    //ambil data sumber
    $data=$this->dataM->getDataIkan();
    for($i=0;$i<$k;$i++){
      //set centroid awal, nilai random dari data sumber
      $centroid[$i]['x']=$data[rand((count($data)-1),0)]['berat_normal'];
      $centroid[$i]['y']=$data[rand((count($data)-1),0)]['hperkg_normal'];
    }
    //mulai rekursif kmeans
    $loop=$this->kMeansLoop($data,$centroid);
    $time = microtime(true)-$start;
    echo 'waktu eksekusi : '.$time.'s';
    echo $loop;
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
  function getData2(){
    $data=$this->dataM->getDataIkanAll();
    echo json_encode($data);
  }
  function expCsv(){
    $data=$this->dataM->getDataIkanAll();
    $df = fopen("php://output", 'w');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($df, array_keys(reset($data)),';');
    foreach ($data as $row) {
      fputcsv($df, $row,';');
    }
    fclose($df);
  }
  function getSSE()
  {
    // code...
    $data=$this->dataM->getSSE();
    echo json_encode($data);
  }
  function getDafKlus(){
    $data=$this->dataM->getDafKlus();
    echo json_encode($data);
  }
  function getDataD3(){
    $dataKluster=$this->dataM->getAnggotaKluster(1);
    foreach ($dataKluster as $keyklus => $valueklus) {
      $korditat[]= array('x' => $valueklus['jenis'],
                          'y'=> $valueklus['hperkg']);
    }
    echo json_encode($korditat);
  }
  function getJumlahData()
  {
    echo json_encode($this->dataM->getJumlahData());
  }

  function input(){
    $data['normal']=$this->dataM->cekNormal();
    $data['kluster']=$this->dataM->cekKluster();
    $this->load->view('head');
    $this->load->view('input',$data);
  }

}

 ?>
