<!----------------------------------------------------------------->
<!-- AUTOMATICALLY GENERATED CODE - PLEASE EDIT TEMPLATE INSTEAD -->
<!----------------------------------------------------------------->


    <main>
      <div class="row">
        <div class="col l10 offset-l1">
          <div class="row">
            <div class="section">

            </div>
            <div class="input-field col s12 ">
              <select id="selectorgraph" >
                <option value="" disabled selected>--PILIH--</option>
                <option value="1">Distribusi</option>
                <option value="2">SSE</option>
                <option value="3">Produksi</option>
                <option value="4">Penjualan</option>
                <option value="5">Produksi per Bulan</option>
                <option value="6">Penjualan</option>
                <option value="7">Penjenisan kluster</option>
              </select>
              <label>Pilih Jenis Grafik</label>
            </div>
          </div>
          <div class="row">
            <div class="content-graph 1" >
              <h5></h5>
              <div id="chartDis"></div>
            </div>
            <div class="content-graph 2">
              <h5></h5>
              <div id="chartSse"></div>
            </div>
            <div class="content-graph 3">
              <h5></h5>
              <div id="chartCirBerat"></div>
            </div>
            <div class="content-graph 4">
              <h5></h5>
              <div id="chartCirHarga"></div>
            </div>
            <div class="content-graph 5">
              <h5></h5>
              <div id="chartBarBerat"></div>
            </div>
            <div class="content-graph 6">
              <h5></h5>
              <div id="chartBarHarga"></div>
            </div>
            <div class="content-graph 7">
              <h5></h5>
              <div class="section">
                <div class="input-field" id="kluster-selector" style="display:none">
                  <select id="selectorklus" >
                    <option value="" disabled selected>--PILIH--</option>
                  <?php if (isset($kluster)): ?>
                    <?php foreach ($kluster as $key => $value): ?>
                      <option value="<?php echo $value['id']; ?>"><?php echo $value['id']; ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </select>
                  <label>Pilih Kluster</label>
                </div>
              </div>
              <div id="chartJenisKluster"></div>
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
function graphKluster(data){
  $('#selectorklus').on('change',function(){
    var klus= $(this).val();
    drawJenisCluster(data,klus);
  })
}
async function testing(){
  const datafetch = await fetch("<?php echo base_url('data/getdata2/')?>");
  const datasse = await fetch("<?php echo base_url('data/getsse/')?>");

  let hasil1 = await datafetch.json();
  let hasil2 = await datasse.json();

  $(document).ready(function(){
    $('#selectorgraph').change(function(){
      var selectedOpt=$(this).val();
      switch (selectedOpt) {
        case '1':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Distribusi Harga/Produksi untuk setiap jenis');
          $('.content-graph.'+selectedOpt).show();
          drawDis(hasil1);
        break;
        case '2':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Nilai SSE Tiap K');
          $('.content-graph.'+selectedOpt).show();
          drawSse(hasil2);
        break;
        case '3':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Distribusi Produksi Berdasarkan Kluster');
          $('.content-graph.'+selectedOpt).show();
          drawCirBerat(hasil1);
        break;
        case '4':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Distribusi Penjualan Berdasarkan Kluster');
          $('.content-graph.'+selectedOpt).show();
          drawCirHarga(hasil1);
        break;
        case '5':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Distribusi Produksi Perbulan');
          $('.content-graph.'+selectedOpt).show();
          drawBarBerat(hasil1);
        break;
        case '6':
          console.log(selectedOpt);
          $('.content-graph').hide();
          $('.content-graph.'+selectedOpt).find('h5').text('Distribusi Penjualan Perbulan');
          $('.content-graph.'+selectedOpt).show();
          drawBarHarga(hasil1);
          break;
          case '7':
            console.log(selectedOpt);
            $('.content-graph').hide();
            $('.content-graph.'+selectedOpt).find('h5').text('Distribusi jenis tangkapan per kluster');
            $('.content-graph.'+selectedOpt).show();
            $('#kluster-selector').show();
            graphKluster(hasil1);
            //drawJenisCluster(hasil1);
            break;
        default:
      }
    })
  })
}
testing();

  </script>
</html>
