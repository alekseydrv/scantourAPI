<?php
echo "Hello World";

global $toursNames;

function OpenScantourCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "E*N3zNsuM23r";
 $db = "modxscantour";


 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
 
 function OpenTestBaseCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "E*N3zNsuM23r";
 $db = "test_database";


 $TBconn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 
 return $TBconn;
 }
 
function CloseTestBaseCon($TBconn)
 {
 $TBconn -> close();
 }
   
$conn = OpenScantourCon();
echo "Connected Successfully";
$res = $conn->query("SELECT * FROM AVAIL_TOURS GROUP BY TNAME_ID");
$i = 0;
while ($row = $res->fetch_object()) {
    $toursNames[$i]["name"] = $row->TNAME;
    $toursNames[$i]["tour_id"] = $row->id;
    $toursNames[$i]["link"] = $row->HREF;
    $toursNames[$i]["start_place"] = $row->DISLACATION;
    $toursNames[$i]["start_time"] = $row->TIME;
    $toursNames[$i]["days"] = $row->col_day;
    $toursNames[$i]["scantour_tour_id"] = $row->TNAME_ID;
    echo $toursNames[$i][$row->id];
    $i++;
}
CloseCon($conn);

$TBconn = OpenTestBaseCon();
echo "Connected Successfully2";
//$TNAME = $toursNames[0][$row->TNAME];
foreach ($toursNames as $key => $marray) {
    $tour_id = $marray["tour_id"];
    $name = $marray["name"];
    $link = $marray["link"];
    $start_place = $marray["start_place"];
    $start_time = $marray["start_time"];
    $days = $marray["days"];
    $scantour_tour_id = $marray["scantour_tour_id"];
    $res = $TBconn->query("INSERT INTO tours (tour_id,name,link,start_place,start_time,days,scantour_tour_id) VALUES ('$tour_id','$name','$link','$start_place','$start_time','$days','$scantour_tour_id')");
    
}
CloseTestBaseCon($TBconn);
?>