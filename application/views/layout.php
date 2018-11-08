<main>
  <div class="" style="padding:0px 35px">

    <!-- 1st Row -->
    <div class="row">
      <div class="section">
        <h4>Distribusi Data</h4>
        <div class="divider">
        </div>
      </div>
      <div class="col l8">
        <div class="card-panel">
          >Distribusi
          <div class="center-align" id="circle-distrib">
            <div class="preloader-wrapper big active">
              <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div>
                <div class="gap-patch">
                  <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="" id="drawDis"></div>
        </div>
      </div>
      <div class="col l4">


          <div class="card-panel">
            >SSE
            <div class="center-align" id="circle-SSE">
              <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                  <div class="circle-clipper left">
                    <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                    <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                    <div class="circle"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="" id="drawSSE">
            </div>
          </div>



          <div class="card-panel">
            >Jumlah Data
            <div class="center-align" id="circle-jumlahData">
              <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                  <div class="circle-clipper left">
                    <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                    <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                    <div class="circle"></div>
                  </div>
                </div>
              </div>
            </div>
            <table id="jumlahData" class="striped">
              <tbody>
              </tbody>
            </table>
          </div>


      </div>
    </div>
    <!-- .1st Row -->

    <!-- 2nd Row -->
    <div class="row">
      <div class="section">
        <h4>Distribusi Kluster</h4>
        <div class="divider">
        </div>
      </div>
      <div class="col l8">
        <div class="card-panel">
          <div class="" id="drawBul">

          </div>
        </div>
      </div>
      <div class="col l4">
        <div class="card-panel">
          <div id="empat">

          </div>
        </div>
      </div>
      <div class="col l3">
        <div class="card-panel">
          Kontrol
          <div class="input-field">
            <select class="" name="" id="" >
              <option value="1">Bar</option>
              <option value="2">Line</option>
            </select>
            <label for="">Grafik</label>
          </div>
          <div class="input-field">
            <select class="" name="" id="" >
              <option value="1">2016</option>
              <option value="2">2017</option>
            </select>
            <label for="">Tahun</label>
          </div>
          <div class="input-field">
            <select class="" name="" id="" >
              <option value="1">Penjualan</option>
              <option value="2">Produksi</option>
            </select>
            <label for="">Jenis Data  </label>
          </div>
        </div>
      </div>
    </div>
    <!-- .2nd Row -->

    <!-- 3rd Row -->
    <div class="row">
      <div class="section">
        <h4>Kluster</h4>
        <div class="divider">
        </div>
      </div>
      <div class="col l5">
        <div class="card-panel">

        </div>
      </div>
      <div class="col l7">
        <div class="row">
          <div class="col l12">
            <div class="card-panel">

            </div>
          </div>
          <div class="col l4">
            <div class="card-panel">

            </div>
          </div>
          <div class="col l4">
            <div class="card-panel">

            </div>
          </div>
          <div class="col l4">
            <div class="card-panel">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script type="text/javascript">
$(document).ready(function () {
   M.AutoInit();

   fetch("<?php echo base_url('data/getdata2/')?>")
   .then(res=>res.json())
   .then(data=>{
     console.log('data berhasil diambil');
     drawDis(data,'drawDis');
     drawBar(data,'drawBul');
   });
   fetch("<?php echo base_url('data/getsse/')?>")
   .then(res=>res.json())
   .then(data=>{
     console.log('data berhasil diambil');
       var svg = dimple.newSvg("#drawSSE", '100%', 200);
       var myChart = new dimple.chart(svg, data);

       myChart.addCategoryAxis("x", "k");
       myChart.addMeasureAxis("y", "sse");

       mySeries = myChart.addSeries(null, dimple.plot.line);

       myChart.draw();
       $('#circle-SSE').hide();
   });
   fetch("<?php echo base_url('data/getJumlahData/')?>")
   .then(res=>res.json())
   .then(data=>{
     console.log('data berhasil diambil');
     var total=0;
      $.each(data,function(index, value){
       console.log('My array has at position ' + index + ', this value: '+ value.tahun +' =>' + value.total);
       total=(parseInt(value.total) + parseInt(total));
       $('#jumlahData > tbody:last-child').append('<tr><td>tahun '+value.tahun+'</td><td>'+value.total+' Baris</td></tr>');

      });
    console.log('total data ='+total);
    $('#jumlahData > tbody:last-child').append('<tr><td>Total </td><td>'+total+' Baris</td></tr>');
    $('#circle-jumlahData').hide();
   });

   fetch("<?php echo base_url('data/getdata2/')?>")
   .then(res=>res.json())
   .then(data=>{
     console.log('data berhasil diambil');

       pieDraw(data,'empat');
   });
   function pieDraw(data,id){
     var svg = dimple.newSvg("#"+id, '100%', 200);
     var myChart = new dimple.chart(svg, data);
     //myChart.setBounds(100, 50, 1000, 300)
     myChart.addMeasureAxis("p", "harga");
     mySeries = myChart.addSeries("kluster", dimple.plot.pie);
     //var myLegend = myChart.addLegend(1100, 110, 60, 300, "Right");
     var filterValues = dimple.getUniqueValues(data, "kluster");
     mySeries.addOrderRule("kluster");
     myChart.draw();

   }
})
</script>
