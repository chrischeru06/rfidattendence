<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <link rel="icon" type="image/png" href="images/favicon.png"> -->
  <link rel="stylesheet" type="text/css" href="css/devices.css"/>
   
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />


    <script type="text/javascript" src="js/bootbox.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
   
   
  <style>


#mapinfo { top: 0; bottom: 0; width: 80%;height:600px;}
#info{
 
 
  width: 20%; 
  text-align: center;
  border-radius: 55px;
  
}
  </style>

</head>
<body>
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />

<?php include'header.php';?>
<?php
 
                require'connectDB.php';
          $value;       
        $lesdonnees1 = '';
         $lesdonnees = '';
$nb=0;

	$value=$_GET["device_uid"];
	$coordonnee=$_GET["coordonnee"];
	 

    $sql = "SELECT LAT,LON,CARD_UID,ACTION_TIME FROM `mouvement`WHERE CARD_UID='".$value."' AND date_format(ACTION_TIME,'%Y-%m-%d')=CURRENT_DATE()";

         
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);

        while ($row = mysqli_fetch_assoc($resultl)){
     
   $lesdonnees = $lesdonnees.$row["CARD_UID"].'<>'.$row["LAT"].'<>'.$row["LON"].'<>'.$row["ACTION_TIME"].'<>@';         
  $lesdonnees1=$lesdonnees1.'['.$row["LAT"].','.$row["LON"].'],';  
  
        }

        }

       
    
?>
<?php
 
                require'connectDB.php';
          $value;       
        $lesdonnees1 = '';
         $name= '';
$nb=0;

	$value=$_GET["device_uid"];

	 

    $sql = "SELECT COUNT(ID_MOUVEMENT)AS NB,USERNAME,CARD_UID,ACTION_TIME FROM `mouvement`WHERE CARD_UID='".$value."' AND date_format(ACTION_TIME,'%Y-%m-%d')=CURRENT_DATE()";

         
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);

        while ($row = mysqli_fetch_assoc($resultl)){
     $nb=$nb+$row["NB"];
     $name=$row["USERNAME"];
  //  $lesdonnees = $lesdonnees.$row["NB"].'<>'.$row["CARD_UID"].'<>'.$row["LAT"].'<>'.$row["LON"].'<>'.$row["ACTION_TIME"].'<>@';         
  // $lesdonnees1=$lesdonnees1.'['.$row["LAT"].','.$row["LON"].'],';  
  
        }
       

        }
 
    
?>


	<div class="nav">
    <div id="mapinfo"></div>
    <div id="info" >
    	<div style="top: 0;background-color: black;color: white;">
    	<h4>Infos du Vigile</h4><hr>
    	</div>
    	<div style="text-align: left;background-color: transparent;">
    	<h8><b>Name:</b><b style="color:red;"><?=$name;?></b></h8><br>
    	<h8><b>Nombre de ronde:</b><b style="color:red;"><?=$nb;?></b></h8><br>
    	<h8><b></b></h8><br>
    	</div>
    </div>
    	</div>
    </div>

</body>

<script>
 
L.mapbox.accessToken = 'pk.eyJ1IjoiY2hyaXNjaGVydTA1IiwiYSI6ImNrdnMyNzRhODRrODYydnE1YTd5Z28yODgifQ.RufIImYGCRr9NxwiVI11UQ';
var map = L.mapbox.map('mapinfo')
    .setView(<?=$coordonnee;?>, 11);
	var layers = {
      Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'),
      Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v11'),
    };
	var markers = new L.MarkerClusterGroup();

    layers.Streets.addTo(map);
    L.control.layers(null,layers,{position: 'topleft'}).addTo(map);

	var datajs = '<?= $lesdonnees; ?>';
	var datajs = datajs.split('@');
   
	for (i=0; i < (datajs.length)-1; i++){
 
	var a = datajs[i].split("<>");
    var polygone = L.polygon([<?=$lesdonnees1;?>],{color:'orange'}).addTo(map);
	
	 

	var marker = L.marker([a[1], a[2]], {
    icon: L.mapbox.marker.icon({
    'marker-color': 'red'
    })
    }).bindPopup('<h5>'+a[3]+'</h5>').addTo(map);
	markers.addLayer(marker).addTo(map);;

	}
	map.addLayer(markers);


</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"
	        integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
	        crossorigin="anonymous">
<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
  
</html>

