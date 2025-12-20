<div class="blockChart">
  <!-- <canvas id="myChart" style="width:100%"></canvas> -->
  <div id="container" style="height:300px"></div>
</div>

<script src="https://cdn.anychart.com/releases/8.0.0/js/anychart-base.min.js"></script>
<script>
  anychart.onDocumentReady(function() {

    // set the data
    var data = {
      header: ["Name", "Month"],
      rows: [
        ["Apr", '<?php echo $fees_count_month_april; ?>'],
        ["May", '<?php echo $fees_count_month_may; ?>'],
        ["Jun", '<?php echo $fees_count_month_june; ?>'],
        ["Jul", '<?php echo $fees_count_month_july; ?>'],
        ["Aug", '<?php echo $fees_count_month_aug; ?>'],
        ["Sep", '<?php echo $fees_count_month_sep; ?>'],
        ["Oct", '<?php echo $fees_count_month_oct; ?>'],
        ["Nov", '<?php echo $fees_count_month_nov; ?>'],
        ["Dec", '<?php echo $fees_count_month_dec; ?>'],
        ["Jan", '<?php echo $fees_count_month_jan; ?>'],
        ["Feb", '<?php echo $fees_count_month_feb; ?>'],
        ["Mar", '<?php echo $fees_count_month_march; ?>']
      ]
    };

    // create the chart
    var chart = anychart.column();

    // add data
    chart.data(data);

    // set the chart title
    // chart.title("The deadliest earthquakes in the XXth century");

    // draw
    chart.container("container");
    chart.draw();
  });
</script>