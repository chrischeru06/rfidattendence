<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Devices</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  <script type="text/javascript" src="js/bootbox.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
  .highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

input[type="number"] {
    min-width: 50px;
}

</style>

</head>
<body>
	 
<?php include'header.php';?>


<?php
 
        require 'connectDB.php';
                 
				$lesdonnees = '';
                $value=0;

		    $sql = "SELECT  COUNT(id) AS NBRE,checkindate FROM users_logs WHERE checkindate=CURRENT_DATE()";
            //$sqls = "SELECT COUNT(id) AS nbre FROM users WHERE 1";
				$result = mysqli_stmt_init($conn);
             //   $resultx = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($result, $sql)) {
				    echo '<p class="error">SQL Error</p>';
				}else{
				    mysqli_stmt_execute($result);
                   //  mysqli_stmt_execute($resultx);
				    $resultl = mysqli_stmt_get_result($result);
                    //$resulty= mysqli_stmt_get_result($resultx);

				while ($row = mysqli_fetch_assoc($resultl)){
                // || $row1 = mysqli_fetch_assoc($resulty)){

          $value=$row['NBRE'];
			  $lesdonnees.="{
          name: 'TODAY',
          y: ".$row['NBRE']."
         }";					
					 
				}
        //$lesdonnees.='@';
        //$lesdonnees = str_replace(",@","",$lesdonnees);
        
				}


?>
<section class="content">

        <div class="col-md-12">

       
        <div class="row">
                      
  <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>
 
 <div class="col-md-6" id="container1" style="border: 1px solid #d2d7db;"></div> 



 <div class="row">
                      
                      
                     
                     
<div class="col-md-6" id="container2" style="border: 1px solid #d2d7db;"></div>    
  <div class="col-md-6" id="container3" style="border: 1px solid #d2d7db;"></div>                 
</div>                      

                      
 


  </div>
                 </div>





            


</section>
                      
</body>
</html>


<!-- /*<figure class="highcharts-figure">
    <div id="container"></div>
     
</figure>*/ -->


<script>
  // Data retrieved from https://netmarketshare.com
  const chart = new Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Comparaison des présence'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
       type:'category'
    },
    yAxis: {
        title: {
            useHTML: true,
            text: 'nbre des présences'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {  
    column: {
       cursor:'pointer',
       depth: 25,
                       
           dataLabels: {
               enabled: true
            },
            showInLegend: true
        }
    },
             credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
    series: [{
        name: 'présence aujourd\'hui',
        data: [3]

    },
    {
        name: 'total des vigile',
        data: [19],
        color:'orange'

    }]
});
  </script>

