<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>

  /* chartZoomable:hover{
    zoom:2;
    position: absolute;
    background: #fff;
    z-index: 990;
    width: 900% !important;
    margin: auto;
  } */
  #inOutTableChart,#binCardTableChart{
    max-height: 200px;
    overflow-y: auto;
  }
  #sideBtn,#refresh{
    max-width: 60px;
    position: fixed;
    z-index: 990;
    right: 0;
  }
  #sidebar{
    top: 0;
    position: absolute;
    z-index: 1000;
    right: 0;
    background: #f1f1f1;
    display: none;
    padding-left: 15px;
  }
  #tableContent{
      height: 500px;
      overflow-y: auto;
  }
</style>

<!-- <div class="row"> -->
  <!-- <div class="col-md-9 col-xl-9 col-lg-9"> -->
    <div class="card card-body">
      <button type="button" class="btn btn-info btn-sm" id="sideBtn" data-toggle="tooltip" title="Tabler View" data-placement="left"><i class="fa fa-filter"></i></button>
      <?php flash('register_success'); ?>
      <?php if(isset($_SESSION['search'])) : ?>
         <button onclick="refresh()" type="button" class="btn-danger m-1" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh" ><i class="fa fa-spinner fa-lg fa-spin"></i></button>
       <?php endif ?>
    <div class="row">
      <div class="col-md-8">
        <p id="googleDefault"></p>

      </div>
      <div class="col-md-4">
        <p id="monthlyTrend"></p>

      </div>
      <div class="col-md-7">
          <div class="row">
            <div class="col-md-5">
              <!-- schedule  each region PieChart-->
              <div id="regionPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
            </div>
            <div class="col-md-7">
              <!-- schedule  each feeder PieChart-->
              <div id="feederPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
            </div>
          </div>
      </div>
      <div class="col-md-5" id="chartZoomable">
        <!-- schedule  to each region type, status Breakdown column chart  -->
        <div id="regionTypeStatus" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <!-- schedule asigned to each company PieChart-->
        <div id="companyPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
      <div class="col-md-7">
        <!-- column chart for company installation status -->
        <div id="companyTypePiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <!-- meter health status-->
        <div id="meterStatusPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
      <div class="col-md-5">
        <!-- meter edat status chart -->
        <div id="meterNoEdatPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
      <div class="col-md-3">
        <!-- meter Technologies PieChart -->
        <div id="meterTechPiechart" class="chartZoomable" style="width:100%;height:auto;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <small>Inventory Record</small>
        <!-- store inventory -->
        <div id="binCardTableChart" style="width:100%;height:auto;"></div>
      </div>
      <div class="col-md-8">
        <!-- in out history -->
        <small>Inventory History</small>
        <div id="inOutTableChart" style="width: 100%;height:auto;"></div>
      </div>
    </div>
  </div>
  <!-- </div> -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);
    function drawPieChart(){
         var data = google.visualization.arrayToDataTable([
                   ['region', 'Number'],
                   <?php foreach($data['region'] as $row): ?>
                     [' <?php echo ucwords($row->region) ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Schedule in each Region',
               legend:'bottom'
              };
         var chart = new google.visualization.PieChart(document.getElementById('regionPiechart'));
         chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(feederPieChart);
    function feederPieChart(){
         var data = google.visualization.arrayToDataTable([
                   ['feeder', 'Number'],
                   <?php foreach($data['groupSchedulByEdat'] as $row): ?>
                     [' <?php echo ucwords($row->feeder) ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Schedule in each Feeder'

              };
         var chart = new google.visualization.PieChart(document.getElementById('feederPiechart'));
         chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(companyPiechart);
    function companyPiechart(){
         var data = google.visualization.arrayToDataTable([
                   ['Company', 'Number'],
                   <?php foreach($data['company'] as $row): ?>
                     [' <?php echo empty($row->names) ? 'Not Asigned' : $row->names ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Schedule Asigned to companies'
              };
         var chart = new google.visualization.PieChart(document.getElementById('companyPiechart'));
         chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(meterStatusPiechart);
    function meterStatusPiechart(){
         var data = google.visualization.arrayToDataTable([
                   ['Status', 'Number'],
                   <?php foreach($data['meterStatus'] as $row): ?>
                     [' <?php echo $row->status ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Installed Meter Status',
               legend:'bottom'
              };
         var chart = new google.visualization.PieChart(document.getElementById('meterStatusPiechart'));
         chart.draw(data, options);
    }

    google.charts.setOnLoadCallback(meterNoEdatPiechart);
    function meterNoEdatPiechart(){
         var data = google.visualization.arrayToDataTable([
                   ['Region Status', 'Number'],
                   <?php foreach($data['meterNoEdat'] as $row): ?>
                     [' <?php echo ucwords($row->region) ?> \, <?php echo strtolower($row->edatstatus) ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Edat Status'

              };
         var chart = new google.visualization.PieChart(document.getElementById('meterNoEdatPiechart'));
         chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(meterTechPiechart);
    function meterTechPiechart(){
         var data = google.visualization.arrayToDataTable([
                   ['Technology', 'Total'],
                   <?php foreach($data['meterTech'] as $row): ?>
                     [' <?php echo strtoupper($row->tech) ?> ',<?php echo $row->count ?>],
                   <?php endforeach; ?>
              ]);
         var options = {
               title: 'Installed Meters Technologies',
               pieHole: 0.2
              };
         var chart = new google.visualization.PieChart(document.getElementById('meterTechPiechart'));
         chart.draw(data, options);
    }
    google.charts.load('current', {'packages':['bar']});

    google.charts.setOnLoadCallback(drawregionTypeStatusColumnChart);
    function drawregionTypeStatusColumnChart(){
      var data = google.visualization.arrayToDataTable([
        ['Region Meter type Status','Number',{ role: 'style' }],
        <?php $color="black"; foreach($data['regionTypeStatus'] as $row): ?>
          <?php  if(strtolower($row->metertype)=='3 phase' and strtolower($row->status)=='installed'){$color='red';}
          elseif(strtolower($row->metertype)=='1 phase' and strtolower($row->status)=='installed'){$color="#76A7FA";}
          elseif(strtolower($row->metertype)=='3 phase' and strtolower($row->status)=='not install'){$color="#b87333";} ?>
          [ '<?php echo $row->region ?> <?php echo $row->metertype ?>  <?php echo $row->status ?>' , <?php echo $row->count ?> ,'color: <?php echo $color ?>'],
        <?php endforeach; ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0,1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Breakdown of Schedule in each Region",
        subtitle:"based on meter type and installation status",
        // bar: {groupWidth: "50%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("regionTypeStatus"));
      chart.draw(view, options);
    }
    google.charts.setOnLoadCallback(drawCompanyTypeColumnChart);
    function drawCompanyTypeColumnChart(){
      var data = google.visualization.arrayToDataTable([
        ['Company Meter type Status','Number'],
        <?php foreach($data['companyTypeStatus'] as $row): ?>
          [ '<?php echo empty($row->names) ? 'Not Asigned' : $row->names ?> <?php echo $row->metertype ?> <?php echo $row->status ?>', <?php echo $row->count ?> ],
        <?php endforeach; ?>
      ]);
      var view = new google.visualization.DataView(data);
      view.setColumns([0,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       1]);

      var options = {
        title: "Schedule Asigned to companies Breakdown",
        subtitle:"based on meter type and installation status",
        bar: {groupWidth: "55%"},
        legend: { position: "none" },
        colors: ['#e7711c']
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("companyTypePiechart"));
      chart.draw(view, options);
    }
   google.charts.load('current', {'packages':['table']});
   google.charts.setOnLoadCallback(drawInOutTable);
   function drawInOutTable() {
     var data = new google.visualization.DataTable();
     data.addColumn('string', 'Item');
     data.addColumn('string', 'Store');
     data.addColumn('string', 'Category');
     data.addColumn('number', 'Count');
     // data.addColumn('boolean', 'Full Time Employee');
     data.addRows([
       <?php foreach($data['inOut'] as $row): ?>
       ['<?php echo ucwords($row->name) ?>','<?php echo ucwords($row->store) ?>','<?php echo $row->category ?>',<?php echo $row->sum ?> ],
       <?php endforeach; ?>
     ]);

     var table = new google.visualization.Table(document.getElementById('inOutTableChart'));

     table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
   }
   google.charts.setOnLoadCallback(drawbinCardTable);
   function drawbinCardTable() {
     var data = new google.visualization.DataTable();
     data.addColumn('string', 'Store');
     data.addColumn('string', 'Item');
     // data.addColumn('string', 'Category');
     data.addColumn('number', 'Count');
     // data.addColumn('boolean', 'Full Time Employee');
     data.addRows([
       <?php foreach($data['invent'] as $row): ?>
       ['<?php echo ucwords($row->name) ?>','<?php echo ucwords($row->store) ?>',<?php echo $row->qnt ?> ],
       <?php endforeach; ?>
     ]);
     var table = new google.visualization.Table(document.getElementById('binCardTableChart'));
     table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
   }

google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);
google.charts.setOnLoadCallback(drawChartMonthly);

function drawChart() {

var data = new google.visualization.DataTable();
data.addColumn('string', 'Day');
data.addColumn('number', 'Installed');
data.addColumn('number', 'Schedule');
data.addColumn('number', 'Replacement');
//data.addColumn('number', 'Transformers: Age of Extinction');

data.addRows([
  <?php foreach($data['lineChartDaily'] as $row): ?>
    ['<?php echo $row->date ?>',<?php echo $row->installed ?>,<?php echo $row->meter ?>,<?php echo $row->replaced ?>],
  <?php endforeach; ?>
]);

var options = {
  chart: {
    title: 'Daily Schedule and Installation',
    subtitle: '<?php echo loadStateRegion()->state ?>'
  },
  width: '100%',
  height: 500,
  legend: { position: "none" },
};

var chart = new google.charts.Line(document.getElementById('googleDefault'));

chart.draw(data, google.charts.Line.convertOptions(options));
}

function drawChartMonthly() {

var data = new google.visualization.DataTable();
data.addColumn('string', 'Day');
data.addColumn('number', 'Installed');
data.addColumn('number', 'Schedule');
data.addColumn('number', 'Replacement');
//data.addColumn('number', 'Transformers: Age of Extinction');

data.addRows([
  <?php foreach($data['lineChartMonth'] as $row): ?>
    ['<?php echo date('M',strtotime($row->date)) ?>',<?php echo $row->installed ?>,<?php echo $row->meter ?>,<?php echo $row->replaced ?>],
  <?php endforeach; ?>
]);

var options = {
  chart: {
    title: 'Monthly Schedule and Installation',
    subtitle: '<?php echo loadStateRegion()->state ?>'
  },
  width: '100%',
  height: 500,
  legend: { position: 'bottom' },
};

var chart = new google.charts.Line(document.getElementById('monthlyTrend'));

chart.draw(data, google.charts.Line.convertOptions(options));
}
  </script>

  <div class="" id="sidebar">
    <nav class="navbar">

       <div class="btn-group">
        <button  id ="bydate" type="button" class="btn bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Filter
        </button>
       </div>
       <button  id ="close" type="button" class="btn btn-danger btn-xs">
         <i class="fa fa-times-circle" id="hideSide"></i>
       </button>
   </nav>

   <form method="post" id="bydateRange" action="<?php echo URLROOT; ?>/dashboards/conditional" style="display:none;">
     <div class="input-group mb-2">
        <input class="form-control form-control-sm" type="date" name="from" aria-label="Search" aria-describedby="basic-addon2" equired />
        <div class="input-group-append">
            <button class="btn-primary btn btn-sm" type="button">From</button>
        </div>
    </div>
    <div class="input-group">
       <input class="form-control form-control-sm" type="date" name="to" aria-label="Search" aria-describedby="basic-addon2" equired />
       <div class="input-group-append">
            <button class="btn-primary btn btn-sm" type="button">To</button>
       </div>
   </div>
       <input class="btn btn-success btn-sm m-1" type="submit" value="Go" id="bydateRangeBtn">
   </form>
    <div id="tableContent">
      <div class="card card-body" >
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Schedule Region
          <table class="table table-bordered table-striped table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >Region</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($data['region'] as $row): ?>
              <tr class="small" >
                  <td><?php echo $row->region ?></td>
                  <td><?php echo $row->count ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Schedule By Feeder
          <table class="table table-bordered table-striped table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >Feeder</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data['groupSchedulByEdat'] as $row): ?>
                <tr>
                  <td><?php echo $row->feeder ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Schedule Type & Status
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
              <tr class="small">
                <th >Region</th>
                <th >Type</th>
                <th >Status</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['regionTypeStatus'] as $row): ?>
                  <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo $row->region ?></td>
                  <td><?php echo $row->metertype ?></td>
                  <td><?php echo $row->status ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="table-responsive"><i class="fas fa-table mr-1"></i> Company
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
              <tr class="small">
                <th >Company</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['company'] as $row): ?>
                <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo empty($row->names) ? 'Not Asigned' : $row->names ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="bg-info">
                  <td>Total</td>
                  <td><b><?php echo $count ?></b></td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Company Breakdown
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
              <tr class="small">
                <th >Company</th>
                <th >Type</th>
                <th >Status</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['companyTypeStatus'] as $row): ?>
                <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo empty($row->names) ? 'Not Asigned' : $row->names ?></td>
                  <td><?php echo $row->metertype ?></td>
                  <td><?php echo $row->status ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="bg-info">
                <td colspan="3" >Total</td>
                <td><b><?php echo $count ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Meter Tech
          <table class="table table-bordered table-striped small table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >Tech</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['meterTech'] as $row): ?>
                <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo strtoupper($row->tech) ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="bg-info">
                <td>Total</td>
                <td><b><?php echo $count ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Meter Condition
          <table class="table table-bordered table-striped small table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >Status</th>
                <th >Count</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['meterStatus'] as $row): ?>
                <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo  $row->status ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="bg-info">
                <td>Total</td>
                <td><b><?php echo $count ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>Edat Status
          <table class="table table-bordered table-striped small table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >Region</th>
                <th >Status</th>
                <th >#</th>
              </tr>
            </thead>
            <tbody>
              <?php $count=0; foreach($data['meterNoEdat'] as $row): ?>
                <?php $count+=$row->count; ?>
                <tr>
                  <td><?php echo  $row->region ?></td>
                  <td><?php echo $row->edatstatus ?></td>
                  <td><?php echo $row->count ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="bg-info">
                <td colspan="2">Total</td>
                <td><b><?php echo $count ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
        <h5>Inventory</h5>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>SRIN
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
              <tr class="small">
                <th >Item</th>
                <th >QNT</th>
                <th >Store</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data['srin'] as $row): ?>
                  <tr class="small" >
                  <td><?php echo $row->name ?></td>
                  <td><?php echo $row->sum ?></td>
                  <td><?php echo $row->store ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>SRCN
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
              <tr class="small">
                <th >Item</th>
                <th >QNT</th>
                <th >Store</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data['srcn'] as $row): ?>
                  <tr class="small" >
                  <td><?php echo $row->name ?></td>
                  <td><?php echo $row->sum ?></td>
                  <td><?php echo $row->store ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="table-responsive"><i class="fas fa-table mr-1"></i>BIN
          <table class="table table-bordered table-striped small table-hover" width="100%">
            <thead>
              <tr class="small">
                <th >name</th>
                <th >Store</th>
                <th >QNT</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data['invent'] as $row): ?>
                  <tr class="small" >
                  <td><?php echo $row->name ?></td>
                  <td><?php echo $row->store ?></td>
                  <td><?php echo $row->qnt ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      </div>
  </div>
  <!-- </div> -->
<!-- </div> -->
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
function refresh(){
  location.replace("<?php echo URLROOT;?>/dashboards");
  <?php
  if(isset($_SESSION['search'])){
    unset($_SESSION['search']);
  }
  ?>
}
$(document).ready(function(){
  $('#bydate').click(function(){
    $('#bydateRange').toggle(1000);
  });
  $('#sideBtn').click(function(){
    $('#sidebar').toggle(1000);
    $(this).toggle(50);
  });
  $('#hideSide').click(function(){
    $('#sidebar').toggle(1000);
    $('#sideBtn').toggle(50);
  });
});
</script>
