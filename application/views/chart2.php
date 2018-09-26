<!----------------------------------------------------------------->
<!-- AUTOMATICALLY GENERATED CODE - PLEASE EDIT TEMPLATE INSTEAD -->
<!----------------------------------------------------------------->
<!DOCTYPE html>
<meta charset="utf-8">
<script src="http://d3js.org/d3.v4.min.js"></script>
<script src="http://dimplejs.org/dist/dimple.v2.3.0.min.js"></script>
<html>
<div id="chartDis"></div>
<div id="chartSse"></div>

  <script type="text/javascript">
  fetch("<?php echo base_url('data/getdata2/')?>")
    .then((resp) => resp.json()) //convert to json
    .then(function(data) {
    // do somthing with data
    drawDis(data);
  });
  fetch("<?php echo base_url('data/getsse/')?>")
    .then((resp) => resp.json()) //convert to json
    .then(function(data) {
    // do somthing with data
    drawSse(data);
  });
  function drawSse(data){
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
        var filterValues = dimple.getUniqueValues(data, "kluster");
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

  </script>
</html>
