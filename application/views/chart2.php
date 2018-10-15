<!----------------------------------------------------------------->
<!-- AUTOMATICALLY GENERATED CODE - PLEASE EDIT TEMPLATE INSTEAD -->
<!----------------------------------------------------------------->
<!DOCTYPE html>
<meta charset="utf-8">
<script src="http://d3js.org/d3.v4.min.js"></script>
<script src="http://dimplejs.org/dist/dimple.v2.3.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jsFunc/drawingFunc.js"></script>
<html>
<h2>Distribusi Harga/Produksi untuk setiap jenis</h2>
<div id="chartDis"></div>
<h2>Nilai SSE Tiap K</h2>
<div id="chartSse"></div>
<h2>Distribusi Produksi Berdasarkan Kluster</h2>
<div id="chartCirBerat"></div>
<h2>Distribusi Penjualan Berdasarkan Kluster</h2>
<div id="chartCirHarga"></div>
<h2>Distribusi Produksi Perbulan</h2>
<div id="chartBarBerat"></div>
<h2>Distribusi Penjualan Perbulan</h2>
<div id="chartBarHarga"></div>


  <script type="text/javascript">

fetch("<?php echo base_url('data/getdata2/')?>")
    .then((resp) => resp.json()) //convert to json
    .then(function(data) {
    // do somthing with data
    //drawDis(data);
    //drawBarBerat(data);
    //drawBarHarga(data);
    //drawCirHarga(data);
    //drawCirBerat(data);
    //console.log(data);
    logPrint(data);
  });
function logPrint(inp){
  $(document).ready(function(){
    $(this).click(function(){
      console.log(inp);
    })
  })
}


  //console.log(datafetch);
  fetch("<?php echo base_url('data/getsse/')?>")
    .then((resp) => resp.json()) //convert to json
    .then(function(data) {
    // do somthing with data
    drawSse(data);
  });

  </script>
</html>
