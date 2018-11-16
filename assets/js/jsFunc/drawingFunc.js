var color = ["pink","cyan","lime","olive","purple","red","green","blue","navy","magenta","yellow"];
function clearChart() {

}
function drawJenisCluster(data,id,klus,pAxis){
  d3.select("#"+id).select("svg").remove();
  var svg = dimple.newSvg("#"+id, '100%', 525);
  var newData = dimple.filterData(data, "kluster", klus);
  var myChart = new dimple.chart(svg, newData);
  myChart.setBounds('5%', '10%', 380, 380);
  myChart.addMeasureAxis("p", pAxis);
  myChart.addSeries("jenis", dimple.plot.pie);
  myChart.addLegend('78%', '0%', 200, 2000, "left");
  //var filterValues = dimple.getUniqueValues(data, "kluster");
  //filterValues.forEach(function (f) {
  //  myChart.assignColor(f,color[f]);
  //});
  myChart.draw();
}
function drawCirKluster(data,id,yAxis,filterTahun){
  d3.select("#"+id).select("svg").remove();
  var svg = dimple.newSvg("#"+id, '100%', 265);
  if (filterTahun!='') {
    var newData = dimple.filterData(data, "tahun", filterTahun);
  } else {
    var newData = data;
  }
  var myChart = new dimple.chart(svg, newData);
  myChart.setBounds('5%', '15%', 210, 210);
  myChart.addMeasureAxis("p", yAxis);
  myChart.addSeries("kluster", dimple.plot.pie);
  var myLegend= myChart.addLegend('73%', '20%', 10, 200, "left");
  myLegend.verticalPadding = 10;
  //var filterValues = dimple.getUniqueValues(data, "kluster");
//filterValues.forEach(function (f) {
  //  myChart.assignColor(f,color[f]);
  //});
  myChart.draw(800);
}

function drawDisKluster(data,id,jenisGrap,yAxis,filterTahun){
  d3.select("#"+id).select("svg").remove();
  if (filterTahun!='') {
    var newData = dimple.filterData(data, "tahun", filterTahun);
  } else {
    var newData = data;
  }
  var jenis=dimple.plot[jenisGrap];
  if (jenisGrap=='bar') {
    var separator="kluster";
  }else{
    var separator=null;
  }
  var svg = dimple.newSvg("#"+id, '100%', 440);
  var myChart = new dimple.chart(svg, newData);
  var x=myChart.addCategoryAxis("x",'date');
  myChart.addMeasureAxis("y", yAxis);
  var mySeries=myChart.addSeries(separator, jenis);
  myChart.draw(800);
}
function drawBarHarga(data){
  d3.select("#chartBarHarga").select("svg").remove();
  var svg = dimple.newSvg("#chartBarHarga", 1200, 500);
  var myChart = new dimple.chart(svg, data);
  myChart.setBounds(100, 50, 1000, 300)
  var x=myChart.addCategoryAxis("x", ["bulan","tahun"]);
  myChart.addMeasureAxis("y", "harga");
  var mySeries=myChart.addSeries("kluster", dimple.plot.bar);
  x.addOrderRule(["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]);
  x.addGroupOrderRule(["2016","2017"]);
  mySeries.addOrderRule("kluster");
  var myLegend = myChart.addLegend(1100, 110, 60, 300, "Right");
  var filterValues = dimple.getUniqueValues(data, "kluster");
  filterValues.forEach(function (f) {
    myChart.assignColor(f,color[f]);
  });
  myChart.draw();
}
function drawSse(data){
  d3.select("#chartSse").select("svg").remove();
  var svg = dimple.newSvg("#chartSse", 1200, 500);
    // Create the chart
      // Latest period only
      //dimple.filterData(data, "Date", "01/12/2012");
      // Create the chart
      var myChart = new dimple.chart(svg, data);
      myChart.setBounds(100, 50, 1000, 300)
      //console.log(myChart.data);
      // Create a standard bubble of SKUs by Price and Sales Value
      // We are coloring by Owner as that will be the key in the legend
      myChart.addCategoryAxis("x", "k");
      myChart.addMeasureAxis("y", "sse");
      //myChart.addAxis("z","id");
      mySeries = myChart.addSeries(null, dimple.plot.line);
      var myLegend = myChart.addLegend(1100, 110, 60, 300, "Right");
      myChart.draw();
}
function drawDis(data,id){
  var svg = dimple.newSvg("#"+id, '100%', 440);
  var myChart = new dimple.chart(svg, data);
  //myChart.setBounds(100, 50, 1000, 300)
  myChart.addMeasureAxis("x", "berat");
  myChart.addMeasureAxis("y", "hperkg");
  mySeries = myChart.addSeries(["berat","bulan","jenis","tahun", "hperkg", "kluster"], dimple.plot.bubble);
  var myLegend = myChart.addLegend(0, 15, 725, 30, "Right");
  var filterValues = dimple.getUniqueValues(data, "kluster");
  mySeries.addOrderRule("kluster");
  myChart.draw();
  mySeries.getTooltipText = function (e) {
  //  console.log(Object.getOwnPropertyNames(e))
  //  for (var i = 0; i < data.length; i++) {
  //
  //  }
    return [
      'Total Berat :'+e.xValue+' Kg',
      'Harga/Kg : Rp.'+e.yValue,
      'Jenis :'+e.aggField[2],
      'Bulan :'+e.aggField[1],
      'Tahun :'+e.aggField[3],
    ];
  };
  $('#circle-distrib').hide();
  myChart.legends = [];
  myLegend.shapes.selectAll("rect")
    // Add a click event to each rectangle
    .on("click", function (e) {
      // This indicates whether the item is already visible or not

      var hide = false;
      var newFilters = [];
      // If the filters contain the clicked shape hide it
      filterValues.forEach(function (f) {
        if (f === e.aggField.slice(-1)[0]) {
          hide = true;
        } else {
          newFilters.push(f);
        }
      });

      // Hide the shape or show it
      if (hide) {
        d3.select(this).style("opacity", 0.2);
      } else {
        newFilters.push(e.aggField.slice(-1)[0]);
        d3.select(this).style("opacity", 0.8);
      }

      //DEFAULT
      //if (hide) {
        //  d3.select(this).style("opacity", 0.2);
        //} else {
        //  newFilters.push(e.aggField.slice(-1)[0]);
        //  d3.select(this).style("opacity", 0.8);
        //}
        // Update the filters
        //filterValues = newFilters;
      //.DEFAULT

      //cek, kalau filter kosong=> jangan di update!
      if (newFilters.length>0) {
        filterValues = newFilters;
      }else{
        d3.select(this).style("opacity", 0.8);
      }
      // Update the filters
      //filterValues = newFilters;
      // Filter the data
      myChart.data = dimple.filterData(data, "kluster", filterValues);
      // Passing a duration parameter makes the chart animate. Without
      // it there is no transition
      myChart.draw(800);
    });
}
