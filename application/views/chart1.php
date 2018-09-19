<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
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
