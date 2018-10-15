<!----------------------------------------------------------------->
<!-- AUTOMATICALLY GENERATED CODE - PLEASE EDIT TEMPLATE INSTEAD -->
<!----------------------------------------------------------------->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="http://dimplejs.org/dist/dimple.v2.3.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jsFunc/drawingFunc.js"></script>
  </head>
  <body>
    <header>
      <nav>
        <div class="container">
          <div class="nav-wrapper">
            <a href="#!" class="brand-logo">Logo</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a href="sass.html">Olah Data</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <ul class="sidenav" id="mobile-demo">
        <li><a href="sass.html">Olah Data</a></li>
      </ul>
    </header>

    <main>
      <div class="row">
        <div class="col l10 offset-l1">
          <div class="row">
            <div class="input-field col s12">
              <select id="selectorgraph">
                <option value="" disabled selected>--PILIH--</option>
                <option value="1">Distribusi</option>
                <option value="2">SSE</option>
                <option value="3">Produksi</option>
                <option value="4">Penjualan</option>
                <option value="5">Produksi per Bulan</option>
                <option value="6">Penjualan</option>
              </select>
              <label>Pilih Jenis Grafik</label>
            </div>
          </div>
          <div class="row">
            <div class="content-graph 1" >
              <h5>Distribusi Harga/Produksi untuk setiap jenis</h5>
              <div id="chartDis"></div>
            </div>
            <div class="content-graph 2">
              <h5>Nilai SSE Tiap K</h5>
              <div id="chartSse"></div>
            </div>
            <div class="content-graph 3">
              <h5>Distribusi Produksi Berdasarkan Kluster</h5>
              <div id="chartCirBerat"></div>
            </div>
            <div class="content-graph 4">
              <h5>Distribusi Penjualan Berdasarkan Kluster</h5>
              <div id="chartCirHarga"></div>
            </div>
            <div class="content-graph 5">
              <h5>Distribusi Produksi Perbulan</h5>
              <div id="chartBarBerat"></div>
            </div>
            <div class="content-graph 6">
              <h5>Distribusi Penjualan Perbulan</h5>
              <div id="chartBarHarga"></div>
            </div>


          </div>
        </div>
      </div>

    </main>

    <footer>

    </footer>
  </body>
<script type="text/javascript">
$(document).ready(function(){
    $('select').formSelect();

  });
async function testing(){
  const datafetch = await fetch("<?php echo base_url('data/getdata2/')?>");
  const datasse = await fetch("<?php echo base_url('data/getsse/')?>");
  let hasil1 = await datafetch.json();
  let hasil2 = await datasse.json();
  $('.content-graph').hide();
  $(document).ready(function(){
    $('#selectorgraph').change(function(){
      var selectedOpt=$(this).val();
      switch (selectedOpt) {
        case '1':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawDis(hasil1);
        break;
        case '2':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawSse(hasil2);
        break;
        case '3':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawCirBerat(hasil1);
        break;
        case '4':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawCirHarga(hasil1);
        break;
        case '5':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawBarBerat(hasil1);
        break;
        case '6':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).show();
          drawBarHarga(hasil1);
          break;
        default:
      }
    })
  })
}
testing();

  </script>
</html>
