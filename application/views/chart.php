<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="<?php echo base_url('assets/js/d3.v5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dimple.v2.3.0.min.js'); ?>"></script>

<head>

</head>
<body>
  <div id="be"></div>
  <script type="text/javascript">
  fetch("<?php echo base_url('data/getdata2/')?>")
    .then((resp) => resp.json()) //convert to json
    .then(function(data) {
    // do somthing with data
    draw(data);
  });
  function draw(data){
    var svg = dimple.newSvg("#be", 590, 400);


        var myChart = new dimple.chart(svg, data);
        myChart.setBounds(60, 30, 420, 330)
        xAxis = myChart.addMeasureAxis("x","berat");
        yAxis = myChart.addMeasureAxis("y","hperkg");

        myChart.addSeries(["berat","hperkg","kluster"], dimple.plot.bubble,[xAxis,yAxis]);
        var myLegend = myChart.addLegend(530, 100, 60, 300, "Right");
        myChart.draw();


        myChart.legends = [];

       // This block simply adds the legend title. I put it into a d3 data
       // object to split it onto 2 lines.  This technique works with any
       // number of lines, it isn't dimple specific.
       svg.selectAll("title_text")
         .data(["Click legend to","show/hide owners:"])
         .enter()
         .append("text")
           .attr("x", 499)
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
           // Update the filters
           filterValues = newFilters;
           // Filter the data
           myChart.data = dimple.filterData(data, "kluster", filterValues);
           // Passing a duration parameter makes the chart animate. Without
           // it there is no transition
           myChart.draw(800);
         });



  }




  </script>
</body>

  <!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<canvas id="myChart"></canvas>
<script>
function draw(result){
  var ctx = document.getElementById("myChart");
  var scatterChart = new Chart(ctx, {
      type: 'scatter',
      data: result,
      options: {
        tooltips: {
          callbacks: {
              title: function(tooltipItem, data) {
                return data.datasets[tooltipItem[0].datasetIndex].data[tooltipItem[0].index]['jenis'];
              },
              afterTitle : function(tooltipItem, data){
                return data.datasets[tooltipItem[0].datasetIndex].data[tooltipItem[0].index]['bulan'] + ', ' + data.datasets[tooltipItem[0].datasetIndex].data[tooltipItem[0].index]['tahun'];;
              },
          },
        },
          showLines: false,

          scales: {
              xAxes: [{
                  type: 'linear',
                  position: 'bottom'
              }],
              yAxes: [{
                  type: 'linear',
                  position: 'left'
              }]
          }
      }
  });
}

$(document).ready(function(){
var response;
	$.ajax({
	  	  url: "<?php echo base_url('data/getdata/')?>",
        dataType:'json',
	  	  success: function( result ) {
          draw(result);
	  	  }
	  	});

});



</script>
-->
