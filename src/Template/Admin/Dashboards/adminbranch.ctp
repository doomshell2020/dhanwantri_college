<style>
    table {
        border: 1px solid #e7e7e7 !important;
    }

    table td,
    table th {
        font-size: 12px;
        border: 1px solid #e7e7e7 !important;
    }

    .view {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }

    .view .column {
        flex: 1;
        min-width: 20%;
        padding: 0px 15px;
    }

    .blockHeader {
        display: flex;
        justify-content: space-between;
    }

    .blockHeader select {
        width: 200px;
    }

    #ac_layer_1q path {
        fill: #198754 !important;
        stroke: #198754 !important;
    }

    .lightYellow {
        background-color: #fff2cf !important;
        border-color: #ddb13b !important;
    }

    .bg-lightYellow {
        background-color: #ddb13b !important;
    }
</style>

<div class="content-wrapper">
    <div id="homeDashboard">
        <div class="container-fluid">
            <div class="blockView">
                <div class="view">
                    <!-- <div class="column">
                        <div class="detailBlocks danger">
                            <div class="detailBlockIcon  bg-danger">
                                <img src="<?php //echo SITE_URL; 
                                            ?>images/branchesInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Branches</p>
                                <h5>20</h5>
                            </div>
                        </div>
                    </div> -->
                    <div class="column">
                        <div class="detailBlocks success">
                            <div class="detailBlockIcon bg-success">
                                <img src="<?php echo SITE_URL; ?>images/staffInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Staff</p>
                                <h5><small><?php echo $teacher_count; ?>/<?php echo $staff_drop; ?></small></h5>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="detailBlocks info">
                            <div class="detailBlockIcon bg-info">
                                <img src="<?php echo SITE_URL; ?>images/studentsInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Students</p>
                                <h5><?php echo $stu_count; ?><small>/<?php echo $stu_drop; ?></small></h5>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="column">
                        <div class="detailBlocks warning">
                            <div class="detailBlockIcon bg-warning">
                                <img src="<?php //echo SITE_URL; 
                                            ?>images/attendanceInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Attendance</p>
                                <h5><?php //echo $stu_present; 
                                    ?><small>/<?php //echo $stu_absent; 
                                                ?></small></h5>
                            </div>
                        </div>
                    </div> -->

                    <div class="column">
                        <div class="detailBlocks purple">
                            <div class="detailBlockIcon bg-purple">
                                <img src="<?php echo SITE_URL; ?>images/feesInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Total Collection</p>

                                <!-- <a href="<?php //echo SITE_URL; 
                                                ?>admin/report/collectionrecipiet/all"> -->
                                <h5>₹
                                    <?php if ($fees_count['deposite_amt']) {
                                        echo $fees_count['deposite_amt'];
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </h5>
                                <!-- </a> -->
                            </div>
                        </div>
                    </div>





                    <!-- Pending Fees-->

                    <div class="column">
                        <div class="detailBlocks lightYellow" style="position: relative;">
                            <div class="detailBlockIcon bg-lightYellow">
                                <img src="<?php echo SITE_URL; ?>images/feesInfo.png" alt="icon" />
                            </div>
                            <div class="blockData">
                                <p>Pending Tuition Fees</p>

                                <a target="_blank" href="<?php echo SITE_URL;  ?>admin/students/studentpendingfeedetails/">
                                    <h5>₹
                                        <?php



                                        if ($total_pending['pending_fees']) {
                                            echo $total_pending['pending_fees'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </h5>
                                </a>
                                <a href="<?php echo SITE_URL;  ?>cron/gettotalpendingfees" style="position: absolute; right: 10px; bottom: 14px;
    height: 25px;
    width: 25px;
    background-color: #ddb13b;
    text-align: center;
    line-height: 25px;
    border-radius: 4px;
    color: #fff;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>



                    <!--  -->




                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="adminBlock">
                        <div class="blockHeader">
                            <h3>Fee Collections</h3>
                            <!-- <select class="form-control">
                                <option value="all">All</option>
                                <option value="all">Kids Club School</option>
                                <option value="all">The Palace School</option>
                                <option value="all">St. Martin's School</option>
                            </select> -->
                        </div>
                        <div class="blockChart">
                            <!-- <canvas id="myChart" style="width:100%"></canvas> -->
                            <div id="container" style="height:300px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blockHeader">
                        <h3>Statistics</h3>
                        <!-- <select class="form-control">
                            <option value="all">All</option>
                            <option value="all">Kids Club School</option>
                            <option value="all">The Palace School</option>
                            <option value="all">St. Martin's School</option>
                        </select> -->
                    </div>
                    <div class="adminBlock">
                        <div class="blockContainer">
                            <ul>
                                <li class="listView">
                                    <span class="impoData">Total Students</span>
                                    <span class="dataView"><?php echo $stu_count; ?></span>
                                </li>
                                <li>
                                    <span>Active Students</span>
                                    <span><?php echo $stu_count; ?></span>
                                </li>
                                <li>
                                    <span>Drop Students</span>
                                    <span><?php echo $stu_drop; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="adminBlock">
                        <div class="blockContainer">
                            <ul>
                                <li class="listView">
                                    <span class="impoData">Fees Today</span>
                                    <span class="dataView">₹
                                        <?php if ($fees_count_days['deposite_amt']) {

                                            echo $fees_count_days['deposite_amt'];
                                        } else {
                                            echo "0";
                                        }

                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <span>This Week</span>
                                    <span>₹ <?php if ($fees_count_week) {

                                                echo $fees_count_week;
                                            } else {
                                                echo "0";
                                            }
                                            ?></span>
                                </li>
                                <li>
                                    <span>This Month</span>
                                    <span>₹
                                        <?php if ($fees_count_month['deposite_amt']) {

                                            echo $fees_count_month['deposite_amt'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <span>Total Year</span>
                                    <span>₹
                                        <?php if ($fees_current_year['deposite_amt']) {

                                            echo $fees_current_year['deposite_amt'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- <div class="adminBlock">
                        <div class="blockContainer">
                            <ul>
                                <li class="listView">
                                    <span class="impoData">New Admission</span>
                                    <span class="dataView"><?php //echo $new_admission; 
                                                            ?></span>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="adminBlock">
                <div class="blockHeader">
                    <h3>Top 10 Latest Admissions</h3>

                </div>
                <div class="table-responsive" style="padding:15px;">
                    <table class="table table-bordered table-striped" style="min-width:900px">
                        <thead>
                            <tr>
                                <th width="60px">Sr. No.</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Mobile No.</th>
                                <th>Scholar No</th>
                                <th>Course</th>
                                <th>Admission Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1;
                            if (count($latest_student) > 0) { //pr($events);
                            ?>
                                <?php foreach ($latest_student as $studentDetails) { //pr($studentDetails);
                                ?>

                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo ucwords(strtolower($studentDetails['st_full_name'])); ?>
                                        </td>
                                        <td><?php echo ucwords(strtolower($studentDetails['fathername']));; ?></td>
                                        <td>
                                            <?php if ($studentDetails['mobile']) {
                                                echo $studentDetails['mobile'];
                                            } else {
                                                echo "--";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $studentDetails['enroll']; ?></td>
                                        <td><?php echo $studentDetails['class']['title']; ?>-<?php echo $studentDetails['section']['title']; ?></td>
                                        <td><?php echo (date('d-m-Y', strtotime($studentDetails['created']))); ?></td>
                                    </tr>


                                <?php
                                } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="adminBlock">
                <div class="blockHeader">
                    <h3>Store Updates</h3>

                </div>
                <div class="table-responsive" style="padding:15px;">
                <table class="table table-bordered table-striped" style="min-width:900px">
                    <thead>
                        <tr>
                            <th width="60px">Sr. No.</th>
                            <th>Date</th>
                            <th>Branch</th>
                            <th>Item Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1 April 2021</td>
                            <td>Kids Club School</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1 April 2021</td>
                            <td>Kids Club School</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1 April 2021</td>
                            <td>Kids Club School</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1 April 2021</td>
                            <td>Kids Club School</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>1 April 2021</td>
                            <td>Kids Club School</td>
                            <td>20</td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
        </div>
    </div>
</div>
</div>
<!-- Graph 1 -->
<!-- <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
    var xArray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var yArray = [550000, 490000, 440000, 240000, 150000, 550000, 490000, 440000, 240000, 150000, 550000, 490000];
    
    var data = [{
        x: xArray,
        y: yArray,
        type: "bar"
    }];
    
    var layout = {
        title: "Yearly Fee Collection"
    };
    
    Plotly.newPlot("myPlot", data, layout);
</script> -->

<?php //echo $fees_count_month_jan; 
?>
<!-- New -->
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

<!-- Graph 2 -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var yValues = [550000, 490000, 440000, 240000, 250000, 550000, 490000, 440000, 240000, 250000, 550000, 490000];
var barColors = ["#198754", "#198754", "#198754", "#198754", "#198754", "#198754", "#198754", "#198754", "#198754",
    "#198754", "#198754", "#198754"
];

new Chart("myChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "2021 Fee Collection"
        }
    }
});
</script> -->

<!-- Graph 3 -->
<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<?php /*<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	// title: {
	// 	text: "GDP Growth Rate - 2021"
	// },
	axisY: {
		// title: "Growth Rate (in Lac)",
		suffix: "Lac"
	},
	// axisX: {
	// 	title: "Countries"
	// },
	data: [{
		type: "column",
		// yValueFormatString: "#,##0.0#\"%\"",
		dataPoints: [
			{ label: "January", y: 8.2 },	
			{ label: "February", y: 9.5 },	
			{ label: "March", y: 7.5 },
			{ label: "April", y: 6 },	
			{ label: "May", y: 8 },
			{ label: "June", y: 12 },
			{ label: "July", y: 8 },
			{ label: "August", y: 8.5 },
			{ label: "Sepetmber", y: 11 },
			{ label: "October", y: 10.5 },
			{ label: "November", y: 5 },
			{ label: "December", y: 7 }
            // { label: "January", y: 7.1 },	
			// { label: "February", y: 6.70 },	
			// { label: "March", y: 5.00 },
			// { label: "April", y: 2.50 },	
			// { label: "May", y: 2.30 },
			// { label: "June", y: 1.80 },
			// { label: "July", y: 1.60 },
			// { label: "August", y: 1.60 }
			// { label: "Sepetmber", y: 1.60 }
			
		]
	}]
});
chart.render();

}
</script> */ ?>

<!-- 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.7.3/d3.min.js"></script> -->

<?php /*<script>
// Function to create random data in format: [date, amount]
function createData(num) {
	let data = [];
	for (var i = 0; i < num; i++) {
		const randomNum = Math.floor(Math.random() * 100000 + 1);
		let d = new Date();
		d.setDate(d.getDate() - (i * 30));
		data.push({
			date: d,
			amount: randomNum
		});
	}
	return data;
}
// Create + Format data
let data = createData(12).sort(function(a, b) { return a.date - b.date; });

// what are these and are they things that someone should edit
const margin = { top: 30, right: 20, bottom: 60, left: 65 };
const width = 800 - (margin.left + margin.right);
const height = 300 - (margin.top + margin.bottom);
const labelOffset = 50;
const axisOffset = 16;

// Set Time Format (JAN, FEB, etc..)
const timeFormat = d3.timeFormat('%b');

// Set the scales
const x = d3.scaleBand()
	.rangeRound([0, width])
	.domain(data.map((d) => d.date))
	.padding(0.5);

const y = d3.scaleLinear()
	.range([height, 0])
	.domain([0, d3.max(data, (d) => d.amount)]);

// // Set the axes
const xAxis = d3.axisBottom()
	.scale(x)
	.tickSize(0)
	.tickFormat(timeFormat)

const yAxis = d3.axisLeft()
	.ticks(4) 
	.tickSize(-width)
	.scale(y.nice());

// // Set up SVG with initial transform to avoid repeat positioning
const svg = d3.select('svg')
		.attr('class', 'graph')
		.attr('width', width + (margin.left + margin.right))
		.attr('height', height + (margin.top + margin.bottom))
		.append('g')
		.attr('class', 'group-container')
		.attr('transform', `translate(${margin.left}, ${margin.top})`)
		.attr('font-family', 'ibm-plex-sans');

// // Add Y axis
svg.append('g')
	.attr('class', 'axis y')
	.attr('stroke-dasharray', '4')
	.call(yAxis)
	.selectAll('text')
	.attr("x", -axisOffset)
	.attr('font-family', 'ibm-plex-sans');

// // Add Y axis label
const yLabel = svg.select('.y')
	.append('text')
	.text('USAGE ($)')
	.attr('class', 'label')
	.attr('transform', `translate(${-labelOffset}, ${height / 2}) rotate(-90)`)
	.attr('font-family', 'ibm-plex-sans');

// // Add X axis
svg.append('g')
	.attr('class', 'axis x')
	.attr('transform', `translate(0, ${height})`)
	.call(xAxis)
	.selectAll('text')
	.attr("y", axisOffset)
	.attr('font-family', 'ibm-plex-sans')

// // Add X axis label
const xLabel = svg.select('.x')
	.append('text')
	.text('MONTH')
	.attr('class', 'label')
	.attr('transform', `translate(${width / 2}, ${labelOffset})`)
	.attr('font-family', 'ibm-plex-sans');

svg.append('g')
	.attr('class', 'bar-container')
	.selectAll('rect')
	.data(data)
	.enter().append('rect')
	.attr('class', 'bar')
	.attr('x', (d) => x(d.date))
	.attr('y', (d) => height)
	.attr('height', 0)
	.attr('width', x.bandwidth())
	.attr('fill', '#2d95e3')
	.transition()
	.duration(500)
	.delay((d, i) => i * 50)
	.attr('height', (d) => height - y(d.amount))
	.attr('y', (d) => y(d.amount));

// Select Tooltip
const tooltip = d3.select('.tooltip');
	
const bars = svg.selectAll('.bar')
	.on('mouseover', function(d) {	
		let color = d3.color('#2d95e3').darker()
		d3.select(this)
			.attr('fill', color)
		tooltip
			.style('display', 'inherit')
			.text(`$${d.amount}`)
			.style('top', `${y(d.amount) - axisOffset}px`);
		
		let bandwidth = x.bandwidth();
		let tooltipWidth = tooltip.nodes()[0].getBoundingClientRect().width;
		let offset = (tooltipWidth - bandwidth) / 2;
		
		tooltip
			.style('left', `${x(d.date) + margin.left - offset}px`)
	})
	.on('mouseout', function(d) {
		d3.select(this)
			.transition()
			.duration(250)
			.attr('fill', '#2d95e3')
		tooltip
			.style('display', 'none')
	})
</script> */ ?>