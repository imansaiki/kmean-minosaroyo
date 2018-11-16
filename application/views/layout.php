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
          <div class="valign-wrapper">
            <i class="material-icons">assessment</i> Distribusi
          </div>
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
            <div class="valign-wrapper">
              <i class="material-icons">assessment</i>SSE
            </div>
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
            <div class="valign-wrapper">
              <i class="material-icons">assessment</i>Jumlah Data
            </div>
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
          <div class="valign-wrapper">
            <i class="material-icons">assessment</i>SSE
          </div>
          <div class="" id="drawBul">

          </div>
        </div>
      </div>
      <div class="col l4">
        <div class="card-panel">
          <div class="valign-wrapper">
            <i class="material-icons">assessment</i>SSE
          </div>
          <div id="drawCirBul">

          </div>
        </div>
      </div>
      <div class="col l4">
        <div class="card-panel">
          <div class="valign-wrapper">
            <i class="material-icons">assessment</i>SSE
          </div>
          <div>
            <label>
              <input name="jenisGrap" type="radio" value="bar" checked />
              <span>Bar</span>
            </label>
            <label>
              <input name="jenisGrap" type="radio" value="line"  />
              <span>Line</span>
            </label>
          </div>
          <div class="divider"></div>
          <div>
            <label>
              <input name="tahunDis" type="radio" value="" checked/>
              <span>Semua</span>
            </label>
            <label>
              <input name="tahunDis" type="radio" value="2016" />
              <span>2016</span>
            </label>
            <label>
              <input name="tahunDis" type="radio" value="2017"  />
              <span>2017</span>
            </label>
          </div>
          <div class="divider"></div>
          <div>
            <label>
              <input name="jenisDataDis" type="radio" value="harga" checked />
              <span>Penjualan</span>
            </label>
            <label>
              <input name="jenisDataDis" type="radio" value="berat"  />
              <span>Produksi</span>
            </label>
          </div>
          <div class="divider"></div>
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
      <div class="col l6">
        <div class="card-panel">
          <div id="circleKluster"></div>
        </div>
      </div>
      <div class="col l6">
        <div class="card-panel">
          <div class="input-field" id="kluster-selector">
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
     drawCirKluster(data,'drawCirBul','harga','');
     drawDisKluster(data,'drawBul','bar','harga','');
     drawJenisCluster(data,'circleKluster','0','count');
     $('#selectorklus').change(function(){
       var klusterTerpilih=$(this).val();
       console.log(klusterTerpilih);
       drawJenisCluster(data,'circleKluster',klusterTerpilih,'count');
     })
     $('input[type=radio]').change(function(){
       console.log('ganti');
       var tahun= $('input[type=radio][name=tahunDis]:checked').val();
       var jenisGrap= $('input[type=radio][name=jenisGrap]:checked').val();
       var yAxis= $('input[type=radio][name=jenisDataDis]:checked').val();
       drawCirKluster(data,'drawCirBul',yAxis,tahun);
       drawDisKluster(data,'drawBul',jenisGrap,yAxis,tahun);
     })
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
