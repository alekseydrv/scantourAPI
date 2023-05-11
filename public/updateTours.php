<?php
#!/bin/bash
/*echo "Hello World";

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
CloseTestBaseCon($TBconn);*/

//exec('mysql -h127.0.0.1 --port=3307 -uapi -pEHxJaY4XeY5bz7');
//$mysqli = new mysqli('127.0.0.1', 'uapi', 'pEHxJaY4XeY5bz7', 'modxscantour', '3307');

 $dbhost = "localhost";
 $dbuser = "uapi";
 $dbpass = "pEHxJaY4XeY5bz7";
 $db = "modxscantour";
// $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "E*N3zNsuM23r";
 $db = "modxscantour";
/*
$ssh_conn = ssh2_connect('localhost', 22);
if ($ssh_conn) {
    print "connection successful<br />";
} else {
    print "connection failed<br />";
    die();
}

$ssh_auth = ssh2_auth_password($ssh_conn, 'root', 'E*N3zNsuM23r');
if ($ssh_auth) {
    print "authentication successful<br />";
} else {
    print "authentication failed<br />";
    die();
}

$ssh_tunnel = ssh2_tunnel($ssh_conn, '127.0.0.1', 3307);
if ($ssh_tunnel) {
    print "tunnel successful<br />";
} else {
    print "tunnel failed<br />";
    die();
}*/

//$mysqli = new mysqli('127.0.0.1', 'uapi', 'pEHxJaY4XeY5bz7', 'modxscantour', '3307');
$mysqli = new mysqli('127.0.0.1', 'api', 'EHxJaY4XeY5bz7', 'modxscantour', 3307);
$mysqli_api = new mysqli('localhost', 'root', 'E*N3zNsuM23r', 'test_database');
//$dblink = new mysqli('localhost', 'uapi', 'EHxJaY4XeY5bz7', 'modxscantour', 3307);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
//echo $mysqli->host_info;

//$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
$res_api = $mysqli_api->query("TRUNCATE tours");
$res = $mysqli->query("select c.id, c.DATE, c.TNAME, c.AVAIL, c.TNAME_ID, c.HREF, c.DISLACATION, c.TIME, c.col_day from AVAIL_TOURS as c WHERE c.col_day>1 AND c.TIME != '' AND c.DATE > CURDATE() - INTERVAL 1 day GROUP BY TNAME_ID");


// апдейтим основную инфу по турам
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    $name = $row['TNAME'];
    $scantour_id = $row['TNAME_ID'];
    $link = $row['HREF'];
    $description = NULL;
    $start_place = $row['DISLACATION'];
    $start_time = $row['TIME'];
    $days = $row['col_day'];
    if (!$mysqli_api->query("INSERT into tours (id, name, link, description, start_place, start_time, days, scantour_tour_id) VALUES ('$scantour_id', '$name', '$link', '$description', '$start_place', '$start_time', '$days', '$scantour_id')")) {
     echo $mysqli_api->error;
    }
}


$res_api = $mysqli_api->query("TRUNCATE tour_dates");
$res = $mysqli->query("select c.id, c.DATE, c.AVAIL, c.TNAME_ID from AVAIL_TOURS as c where CAST(c.DATE AS datetime) > subdate(now(),1) ORDER BY `id` ASC");
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    $date = $row['DATE'];
    $scantour_id = $row['TNAME_ID'];
    if (!$mysqli_api->query("INSERT into tour_dates (id, tour_date2, tour_id, tour_date) VALUES ('$id', '$date', '$scantour_id', '$date')")) {
     echo $mysqli_api->error;
    }
}

$res_api = $mysqli_api->query("TRUNCATE tariffs");
$res = $mysqli->query("select c.id, c.comment_price, c.comment_price1, c.comment_price2, c.comment_price3, c.comment_price4, c.AVAIL from AVAIL_TOURS as c where CAST(c.DATE AS datetime) > subdate(now(),1)");
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    $comment_price = array();
    array_push($comment_price, $row['comment_price']);
    array_push($comment_price, $row['comment_price1']);
    array_push($comment_price, $row['comment_price2']);
    array_push($comment_price, $row['comment_price3']);
    array_push($comment_price, $row['comment_price4']);
    for ($i=0; $i<5; $i++) {
        if ($comment_price[$i] != "") {
            $name = $comment_price[$i];
            if (!$mysqli_api->query("INSERT into tariffs (name, tour_date_id) VALUES ('$name', '$id')")) {
                echo $mysqli_api->error;
            }
        }
    }
}


$res_api = $mysqli_api->query("TRUNCATE accomodations");
$res = $mysqli->query("select c.id, c.PRICE, c.TIME, c.PRICE_sngl, c.PRICE_trpl, c.PRICE1, c.PRICE1_sngl, c.PRICE1_trpl, c.PRICE2, c.PRICE2_sngl, c.PRICE2_trpl, c.PRICE3, c.PRICE3_sngl, c.PRICE3_trpl, c.PRICE4, c.PRICE4_sngl, c.PRICE4_trpl, c.actions, c.actions1, c.actions2, c.actions3, c.actions4, c.actions1_sngl, c.actions2_sngl, c.actions3_sngl, c.actions4_sngl, c.actions1_trpl, c.actions2_trpl, c.actions3_trpl, c.actions4_trpl, c.AVAIL, c.AVAIL1, c.AVAIL2, c.AVAIL3, c.AVAIL4 from AVAIL_TOURS as c where CAST(c.DATE AS datetime) > subdate(now(),1) AND c.TIME != ''");
$updated_at = new DateTime('now', new DateTimeZone('Europe/Moscow'));
$updated_at = $updated_at->format('Y-m-d H:i:s');
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    
    $available = array();
    array_push($available, $row['AVAIL']);
    array_push($available, $row['AVAIL1']);
    array_push($available, $row['AVAIL2']);
    array_push($available, $row['AVAIL3']);
    array_push($available, $row['AVAIL4']);
    
    $price_double = array();
    array_push($price_double, $row['PRICE']);
    array_push($price_double, $row['PRICE1']);
    array_push($price_double, $row['PRICE2']);
    array_push($price_double, $row['PRICE3']);
    array_push($price_double, $row['PRICE4']);
    
    // sale price for double
    $price_double_sale = array();
    array_push($price_double_sale, intval($row['actions']));
    array_push($price_double_sale, intval($row['actions1']));
    array_push($price_double_sale, intval($row['actions2']));
    array_push($price_double_sale, intval($row['actions3']));
    array_push($price_double_sale, intval($row['actions4']));
    
    $price_sngl = array();
    array_push($price_sngl, $row['PRICE_sngl']);
    array_push($price_sngl, $row['PRICE1_sngl']);
    array_push($price_sngl, $row['PRICE2_sngl']);
    array_push($price_sngl, $row['PRICE3_sngl']);
    array_push($price_sngl, $row['PRICE4_sngl']);
    
    // sale price for single
    $price_sngl_sale = array();
    array_push($price_sngl_sale, 0);
    array_push($price_sngl_sale, intval($row['actions1_sngl']));
    array_push($price_sngl_sale, intval($row['actions2_sngl']));
    array_push($price_sngl_sale, intval($row['actions3_sngl']));
    array_push($price_sngl_sale, intval($row['actions4_sngl']));
    
    $price_trpl = array();
    array_push($price_trpl, $row['PRICE_trpl']);
    array_push($price_trpl, $row['PRICE1_trpl']);
    array_push($price_trpl, $row['PRICE2_trpl']);
    array_push($price_trpl, $row['PRICE3_trpl']);
    array_push($price_trpl, $row['PRICE4_trpl']);
    
    // sale price for triple
    $price_trpl_sale = array();
    array_push($price_trpl_sale, 0);
    array_push($price_trpl_sale, intval($row['actions1_trpl']));
    array_push($price_trpl_sale, intval($row['actions2_trpl']));
    array_push($price_trpl_sale, intval($row['actions3_trpl']));
    array_push($price_trpl_sale, intval($row['actions4_trpl']));
    
    $res1 = $mysqli_api->query("select k.id as co from tariffs as k WHERE tour_date_id='$id'");
    $tariff_count = $res1->num_rows;
    $flag = 0;
    while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
            //echo $res1->num_rows;
            $tariff_id = $row1['co'];
            if ($flag < $tariff_count) {
                if ($price_sngl[$flag] <> 0) {
                    echo  $row1['co']."> Single: ".$price_sngl[$flag]." - SALE_PRICE:".$price_sngl_sale[$flag]." AVAIL ".$available[$flag]."<br />";
                    if ($price_sngl_sale[$flag] <> 0) {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Single', '$tariff_id', '$price_sngl[$flag]', $price_sngl_sale[$flag], '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    } else {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Single', '$tariff_id', '$price_sngl[$flag]', 0, '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    }
                }
                if ($price_double[$flag] <> 0) {
                    //var_dump(intval($price_double_sale[$flag]));
                    echo  $row1['co']."> Double: ".$price_double[$flag]." - SALE_PRICE:".$price_double_sale[$flag]." AVAIL ".$available[$flag]."<br />";
                    if ($price_double_sale[$flag] <> 0) {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Double', '$tariff_id', '$price_double[$flag]', $price_double_sale[$flag], '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    } else {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Double', '$tariff_id', '$price_double[$flag]', 0, '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    }
                }
                if ($price_trpl[$flag] <> 0) {
                    echo  $row1['co']."> Triple: ".$price_trpl[$flag]." - SALE_PRICE:".$price_trpl_sale[$flag]." AVAIL ".$available[$flag]."<br />";
                    if ($price_trpl_sale[$flag] <> 0) {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Triple', '$tariff_id', '$price_trpl[$flag]', $price_trpl_sale[$flag], '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    } else {
                        if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, price_sale, availability, updated_at) VALUES ('Triple', '$tariff_id', '$price_trpl[$flag]', 0, '$available[$flag]', '$updated_at')")) {
                            echo $mysqli_api->error;
                        }
                    }
                }
            
            }
            $flag++;
    }
}


?>