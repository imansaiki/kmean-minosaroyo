var color = ["pink","cyan","lime","olive","purple","red","green","blue","navy","magenta","yellow"];
function clearChart() {

}
function drawJenisCluster(data,klus){
  d3.select("#chartJenisKluster").select("svg").remove();
  var svg = dimple.newSvg("#chartJenisKluster", 1200, 500);
  var newData = dimple.filterData(data, "kluster", klus);
  var myChart = new dimple.chart(svg, newData);
  myChart.setBounds(20, 20, 460, 360);
    myChart.addMeasureAxis("p", "count");
  myChart.addSeries("jenis", dimple.plot.pie);
  myChart.addLegend(500, 20, 90, 300, "left");
  //var filterValues = dimple.getUniqueValues(data, "kluster");
  //filterValues.forEach(function (f) {
  //  myChart.assignColor(f,color[f]);
  //});
  myChart.draw();
}
function drawCirBerat(data){
  d3.select("#chartCirBerat").select("svg").remove();
  var svg = dimple.newSvg("#chartCirBerat", 1200, 500);
  var myChart = new dimple.chart(svg, data);
  myChart.setBounds(20, 20, 460, 360);
  myChart.addMeasureAxis("p", "berat");
  myChart.addSeries("kluster", dimple.plot.pie);
  myChart.addLegend(500, 20, 90, 300, "left");
  var filterValues = dimple.getUniqueValues(data, "kluster");
  filterValues.forEach(function (f) {
    myChart.assignColor(f,color[f]);
  });
  myChart.draw();
}
function drawCirHarga(data){
  d3.select("#chartCirHarga").select("svg").remove();
  var svg = dimple.newSvg("#chartCirHarga", 1200, 500);
  var myChart = new dimple.chart(svg, data);
  myChart.setBounds(20, 20, 460, 360)
  myChart.addMeasureAxis("p", "harga");
  myChart.addSeries("kluster", dimple.plot.pie);
  myChart.addLegend(500, 20, 90, 300, "left");
  var filterValues = dimple.getUniqueValues(data, "kluster");
  filterValues.forEach(function (f) {
    myChart.assignColor(f,color[f]);
  });
  myChart.draw();
}
function drawBarBerat(data){
  d3.select("#chartBarBerat").select("svg").remove();
  var svg = dimple.newSvg("#chartBarBerat", 1200, 500);
  var myChart = new dimple.chart(svg, data);
  myChart.setBounds(100, 50, 1000, 300)
  var x=myChart.addCategoryAxis("x", ["bulan","tahun"]);
  myChart.addMeasureAxis("y", "berat");
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
function drawDis(data){
  d3.select("#chartDis").select("svg").remove();
  var svg = dimple.newSvg("#chartDis", 1200, 400);
    // Create the chart
      // Latest period only
      //dimple.filterData(data, "Date", "01/12/2012");
      // Create the chart
      var myChart = new dimple.chart(svg, data);
      myChart.setBounds(100, 50, 1000, 300)
      //console.log(myChart.data);
      // Create a standard bubble of SKUs by Price and Sales Value
      // We are coloring by Owner as that will be the key in the legend
      myChart.addMeasureAxis("x", "berat");
      myChart.addMeasureAxis("y", "hperkg");
      //myChart.addAxis("z","id");
      mySeries = myChart.addSeries(["berat","bulan","jenis","tahun", "hperkg", "kluster"], dimple.plot.bubble);
      var myLegend = myChart.addLegend(1100, 110, 60, 300, "Right");
      var filterValues = dimple.getUniqueValues(data, "kluster");
      filterValues.forEach(function (f) {
        myChart.assignColor(f,color[f]);
      });
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
//myStoryboard.addOrderRule("GDP", true);
      // This is a critical step.  By doing this we orphan the legend. This
      // means it will not respond to graph updates.  Without this the legend
      // will redraw when the chart refreshes removing the unchecked item and
      // also dropping the events we define below.
      myChart.legends = [];

      // This block simply adds the legend title. I put it into a d3 data
      // object to split it onto 2 lines.  This technique works with any
      // number of lines, it isn't dimple specific.
      svg.selectAll("title_text")
        .data(["Daftar","Kluster:"])
        .enter()
        .append("text")
          .attr("x", 1120)
          .attr("y", function (d, i) { return 90 + i * 14; })
          .style("font-family", "sans-serif")
          .style("font-size", "10px")
          .style("color", "Black")
          .text(function (d) { return d; });

      // Get a unique list of Owner values to use when filtering

      // Get all the rectangles from our now orphaned legend
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
