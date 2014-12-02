<?php
ini_set('memory_limit','256M');
ini_set('max_execution_time', 900); 
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>PseudoAj GeoStay</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
		<script
src="http://maps.googleapis.com/maps/api/js">
</script>


	</head>
	<body>
<div class="container-full">

      <div class="row">
       
        <div class="col-lg-12 text-center v-center">
          
          <h1>PseudoAj Geo Stay</h1>
          <p class="lead">An implementation of Stay Points. Open application for research purpose only.<br/>Dev: Ajay Krishna Teja Kavuri| Email: ajkavuri@mix.wvu.edu| Web Page: <a href="http://www.pseudoaj.com">PseudoAj</a> |</p>
          
          <br><br><br>
          <p class="lead">Results:</p>
          
<?php
//Author: Ajay Krishna Teja Kavuri
//Function: Uploads the text file.
  
  $target = "tmp/";  
  $target = $target . basename( $_FILES['file']['name']) ;  
  $ok=1;
  $isStart=1;
  $ftype = $_FILES['file']['type']; 
  $numPoint=0;
  //This is our size condition  
  //This is our limit file type condition  
  //Here we check that $ok was not set to 0 by an error  
  //echo $ftype;
  if($ftype=="text/plain")
  {
  	$ok=1;
  }
  else {
  	
  	$ok=0;
      
  }
  
  if ($ok==0)  
  {
  	  Echo "Sorry your file was not uploaded";  
  }   
  //If everything is ok we try to upload it  
  else  
  {
  	  if(move_uploaded_file($_FILES['file']['tmp_name'], $target))  
  	  {
  	  	  //echo "The file ". basename( $_FILES['file']['name']). " has been uploaded";  
	  }  
  	  else  
  	  {
  	  	  echo "Sorry, there was a problem uploading your file.";  
	  }
	}
 
 function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}


//$tryDist = distance(32.9697, -96.80322, 29.46786, -98.53506, "M");
//echo $tryDist;
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
 
  
  //Author: Ajay Krishna Teja Kavuri
  //Function Parses the GPS File into the latitute and longitute
  
  	$fileLoc=$target;
  	$myfile = fopen($fileLoc, "r") or die("Unable to open file!");
	$token=",";
	$prevlat=0.0;
  	$prevlong=0.0;
	$pnum=0;
	$i=0;
	$j=0;
	
	$prevtime=strtotime("now");
	
	if($myfile)
	{
		while(!feof($myfile))
		{
			$points[]=fgets($myfile,4089);
			$pnum++;
			}
			fclose($myfile);
	}
	
	/*
		$curline=$points[8];
		$nexline=$points[56];
		$curDivLine=explode($token, $curline);
		$curTmplat=doubleval($curDivLine[1]);
		$curTmplong=doubleval($curDivLine[2]);
		$curTmptime=strtotime($curDivLine[0]);
		$nexDivLine=explode($token, $nexline);
		$nexTmplat=doubleval($nexDivLine[1]);
		$nexTmplong=doubleval($nexDivLine[2]);
		$nexTmptime=strtotime($nexDivLine[0]); 
		$tryDist = distance($curTmplat, $curTmplong, $nexTmplat, $nexTmplong, "K");
		$diffTime=($nexTmptime-$curTmptime) / 60;
		echo "Distance between".$curTmplat.$curTmplong."and".$nexTmplat.$nexTmplong."is".$tryDist."time is".$diffTime;
		*/		
	
	//echo $points[1333];
	//echo $pnum;
	
	
	/*while(!feof($myfile)) 
	{
		$tmpline=fgets($myfile);
		$pnum++;
	}*/
	
	//echo $pnum;
	
	//Main login for calculation of staypoints
	$starray= array();
		
		
	$i=0;
	$j=0;
	$staypoint=0;
	$actCount=0;
	while($i<$pnum)
	{
		//$curline=fgets($myfile);
		$j=$i+1;
		$curline=$points[$i];
		//echo $curline;
		//$nexline=$points[$j];
		$curDivLine=explode($token, $curline);
		$curTmplat=doubleval($curDivLine[1]);
		$curTmplong=doubleval($curDivLine[2]);
		$curTmptime=strtotime($curDivLine[0]);
		$sumlat=$curTmplat;
		$sumlon=$curTmplong;
		$meanLat=$sumlat;
		$meanLon=$sumlon;
		$sumcount=0;
		//$nexDivLine=explode($token, $nexline);
		//$nexTmplat=doubleval($nexDivLine[1]);
		//$nexTmplong=doubleval($nexDivLine[2]);
		//$nexTmptime=strtotime($nexDivLine[0]); 
		while($j<$pnum)
		{
			$nexline=$points[$j];
			//echo $nexline;
			$nexDivLine=explode($token, $nexline);
			$nexTmplat=doubleval($nexDivLine[1]);
			$nexTmplong=doubleval($nexDivLine[2]);
			$nexTmptime=strtotime($nexDivLine[0]); 
			
			
			$dist=$tryDist = distance($curTmplat, $curTmplong, $nexTmplat, $nexTmplong, "K");
			$dist=$dist*1000;
			//echo $dist;
			if($dist<100)
			{
				$diffTime=($nexTmptime-$curTmptime) / 60;
				if($diffTime>30 && $diffTime<35)
				{
					//echo "StayPoint# ".$staypoint." |Coordinates: Source: ".$curTmplat." and ".$curTmplong." Destination: ".$nexTmplat." and ".$nexTmplong." |Distance Between: ".$dist." meters and Time Stayed: ".$diffTime." Min| <br>";
					$sumlat=$sumlat+$nexTmplat;
					$sumlon=$sumlon+$nexTmplong;
					$sumcount++;
					//$starray[$staypoint]=array('index'=> $staypoint, 'lat' => $curTmplat, 'lon' => $curTmplong, 'nexlat' => $nexTmplat, 'nexlon' => $nexTmplong, 'time' => $diffTime, 'dist' => $dist);
						$staypoint++;
						
				}
				if($i==$j)
				{
					break;
				}
			}
			$j++;
		}
		if($sumcount>0)
		{
			$meanLat=($sumlat/($sumcount+1));
			$meanLon=($sumlon/($sumcount+1));
			//echo "SumLat: ".$sumlat." SumLong: ".$sumlon." count: ".($sumcount+1)."<br>";
			//echo "Mean Lat and Lon: ".$meanLat.",".$meanLon."<br>";
			$actCount++;
			$starray[$actCount]=array('lat'=>$meanLat, 'lon'=>$meanLon, 'size'=>$sumcount);
		}

		$i++;
		
	}
	//var_dump($starray);
	
	echo "Total Number of Stay Points:".$staypoint;
	/*while(!feof($myfile)) 
	{
  		 $tmpline=fgets($myfile);
		 $divline=explode($token, $tmpline);
		 $tmplat=doubleval($divline[1]);
		 $tmplong=doubleval($divline[2]);
		 //$tmplat=$divline[1];
		 //$tmplong=$divline[2];
		 $tmptime=strtotime($divline[0]);
		 if($isStart==1)
		 {
			$prevlat=$tmplat;
			$prevlong=$tmplong;
			$prevtime=$tmptime;
			//echo distance($tmplat, $tmplong, $prevlat, $prevlong, "M")."<br>";
			$isStart=0; 
		}
		 //echo $distBtw+"<br>";
		 //$distBtw = distance($tmplat, $tmplong, $prevlat, $prevlong, "K");
		 //echo $distBtw+"<br>";
		 //echo $tmplat."aj".$tmplong."aj".$tmptime."<br>";
		 //echo $tmpline."<br/>";
			 $prevlat=$tmplat;
			$prevlong=$tmplong;
			$prevtime=$tmptime;
			$numPoint++;
  		
	}*/
	//echo fread($myfile,filesize($fileLoc));
	//fclose($myfile);
	/*
	$sumlat=0.0;
	$sumlong=0.0;
	for($i=0;$starray[$i]['index'] < $staypoint;$i++)
	{
			$sumlat=$starray[$i]['lat']+$sumlat;
			$sumlong=$starray[$i]['lon']+$sumlong;
	}
	$meanlat=$sumlat/$staypoint;
	$meanlon=$sumlong/$staypoint;
	echo $meanlat.$meanlon;
    */
	//echo json_encode($starray[1]['lat']);
?>
<script>
<?php //for($i=0;$i<$actCount;$i++)
//{
	?>
//var lat=<?php //echo json_encode($starray[1]['lat']); ?>;
//var lon=<?php //echo json_encode($starray[1]['lon']); ?>;
//var size=<?php //echo json_encode($starray[1]['size']); ?>;
//alert(lat);
//var loc=new google.maps.LatLng(lat,lon);
/*
var lat2=<?php //echo json_encode($starray[18]['lat']); ?>;
var lon2=<?php //echo json_encode($starray[18]['lon']); ?>;
var size2=<?php //echo json_encode($starray[18]['size']); ?>;
//alert(lat);
var loc2=new google.maps.LatLng(lat2,lon2);
*/

function initialize()
{
	
var lat=<?php echo json_encode($starray[1]['lat']); ?>;
var lon=<?php echo json_encode($starray[1]['lon']); ?>;
var size=<?php echo json_encode($starray[1]['size']); ?>;
//alert(lat);
var loc=new google.maps.LatLng(lat,lon);

var mapProp = {
  center:loc,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var myCity = new google.maps.Circle({
  center:loc,
  radius:size*10,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2,
  fillColor:"#0000FF",
  fillOpacity:0.4
  });

myCity.setMap(map);
}

/*function initialize2()
{
var mapProp = {
  center:loc2,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var myCity = new google.maps.Circle({
  center:loc2,
  radius:size2*10,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2,
  fillColor:"#0000FF",
  fillOpacity:0.4
  });

myCity.setMap(map);
}
*/
//initialize();
google.maps.event.addDomListener(window, 'load', initialize);
//google.maps.event.addDomListener(window, 'load', initialize);
//google.maps.event.addDomListener(window, 'load', initialize2);
<?php
//}
?>

</script>

        
      </div> <!-- /row -->
      <div class="row" id="googleMap" style="width:100%;height:500px;"></div>

        </div>

  
  	  <div class="row">
       
        <div class="col-lg-12 text-center v-center" style="font-size:39pt;">
          <a href="https://plus.google.com/+ajaykrishnatejakavuri"><i class="icon-google-plus"></i></a> <a href="https://www.facebook.com/ajaykrishnateja"><i class="icon-facebook"></i></a>  <a href="https://twitter.com/PseudoAj"><i class="icon-twitter"></i></a> <a href="https://github.com/PseudoAj"><i class="icon-github"></i></a> 
        </div>
      
      </div>
       <div class="row">
       
      
      </div>
  
  	<br><br><br><br><br>

</div> <!-- /container full -->



	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>