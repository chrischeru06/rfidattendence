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
<!--    <link rel="icon" type="image/png" href="images/favicon.png"> -->
  <link rel="stylesheet" type="text/css" href="css/devices.css"/>
   
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />


    <script type="text/javascript" src="js/bootbox.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
   
   
  <style>

#mapinfo { top: 0; bottom: 0; width: 100%;height:600px;}

  </style>
</head>
<body>
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />
<?php include'header.php';?>

    <div id="mapinfo"></div>
 
</body>
 


<?php
 
                require'connectDB.php';
                 
        $lesdonnees = '';

        $lesdonnees1='';



          $sql = "SELECT devices.`device_name`,users.`card_uid`,`lat`,`lon`,users.username,users_logs.checkindate FROM `devices` JOIN users ON devices.device_uid=users.device_uid JOIN users_logs ON devices.device_uid=users_logs.device_uid WHERE 1 GROUP BY users.username";

         
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);

        while ($row = mysqli_fetch_assoc($resultl)){
                 
      $lesdonnees = $lesdonnees.$row["device_name"].'<>'.$row["card_uid"].'<>'.$row["lat"].'<>'.$row["lon"].'<>'.$row["username"].'<>@';          
       // $lesdonnees1=$lesdonnees1.'[' .$row["lat"].','.$row["lon"].'],';  
  
        }
                
  // print_r($lesdonnees);
  // exit();
        }
      
     
?>


<script>
L.mapbox.accessToken = 'pk.eyJ1IjoiY2hyaXNjaGVydTA1IiwiYSI6ImNrdnMyNzRhODRrODYydnE1YTd5Z28yODgifQ.RufIImYGCRr9NxwiVI11UQ';
var map = L.mapbox.map('mapinfo')
    .setView([-3.4578, 29.584878],9);

  var layers = {
      Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'),
      Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v11'),
    };

    layers.Streets.addTo(map);
    L.control.layers(null,layers,{position: 'topleft'}).addTo(map);

  var datajs = '<?= $lesdonnees; ?>';
  var datajs = datajs.split('@');
 var markers = new L.MarkerClusterGroup();

  for (i=0; i < datajs.length; i++){
 
  var a = datajs[i].split("<>");

  // var polygon = L.polyline(longs, {color: 'red'}).addTo(map);
 
var marker = L.marker([a[2],a[3]],{
    icon: L.mapbox.marker.icon({'marker-color': 'red'})
    }).bindPopup('<h1 >'+a[0]+'</h1><hr><u>numero carte:<a href="mappingID.php?device_uid='+a[1]+'&coordonnee=['+a[2]+','+a[3]+']">'+a[1]+'</a></li><h4><a href="">Name:'+a[4]+'</u></h4>').addTo(map);
 markers.addLayer(marker).addTo(map);
 

  }
//polygon.addLayer(marker).addTo(map); 
 //map.addLayer(markers);
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"
          integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
          crossorigin="anonymous">
<script type="text/javascript" src="js/jquery-2.2.3.min.js">
  
</script>
  
</html>