<?php
#!/bin/bash
$mysqli = new mysqli('127.0.0.1', 'api', 'EHxJaY4XeY5bz7', 'modxscantour', 3307);
$mysqli_api = new mysqli('localhost', 'root', 'E*N3zNsuM23r', 'test_database');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}


$res = $mysqli->query("select c.TNAME, c.AVAIL, c.TNAME_ID, c.HREF, c.DISLACATION, c.TIME, c.col_day from AVAIL_TOURS as c WHERE c.col_day=1 AND c.TIME != '' AND c.DATE > CURDATE() - INTERVAL 1 day GROUP BY TNAME_ID");

$res_api = $mysqli_api->query("TRUNCATE excursions");
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
    if (!$mysqli_api->query("INSERT into excursions (id, name, link, description, start_place, start_time, days, scantour_tour_id) VALUES ('$scantour_id', '$name', '$link', '$description', '$start_place', '$start_time', '$days', '$scantour_id')")) {
     echo "Local database error: ".$mysqli_api->error;
    }
}

$res_api = $mysqli_api->query("TRUNCATE excursion_dates");
$res = $mysqli->query("select c.id, c.DATE, c.AVAIL, c.TNAME_ID from AVAIL_TOURS as c WHERE c.DATE > CURDATE() - INTERVAL 1 day");
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    $date = $row['DATE'];
    $scantour_id = $row['TNAME_ID'];
    if (!$mysqli_api->query("INSERT into excursion_dates (id, excursion_date2, excursion_id, excursion_date) VALUES ('$id', '$date', '$scantour_id', '$date')")) {
     echo "Local database error: ".$mysqli_api->error;
    }
}

$res_api = $mysqli_api->query("TRUNCATE excursion_tariffs");
$res = $mysqli->query("select c.id, c.DATE, c.TIME, c.comment_price, c.comment_price1, c.comment_price2, c.comment_price3, c.comment_price4, c.actions, c.actions1, c.actions2, c.actions3, c.actions4, c.PRICE, c.PRICE1, c.PRICE2, c.PRICE3, c.PRICE4, c.AVAIL, c.AVAIL1, c.AVAIL2, c.AVAIL3, c.AVAIL4 from AVAIL_TOURS as c WHERE c.DATE > CURDATE() - INTERVAL 1 day AND c.TIME != ''");
$updated_at = new DateTime('now', new DateTimeZone('Europe/Moscow'));
$updated_at = $updated_at->format('Y-m-d H:i:s');
while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $id = $row['id'];
    $comment_price = array();
    $price = array();
    $avail = array();
    $actions = array();
    array_push($comment_price, $row['comment_price']);
    array_push($comment_price, $row['comment_price1']);
    array_push($comment_price, $row['comment_price2']);
    array_push($comment_price, $row['comment_price3']);
    array_push($comment_price, $row['comment_price4']);
    
    array_push($price, $row['PRICE']);
    array_push($price, $row['PRICE1']);
    array_push($price, $row['PRICE2']);
    array_push($price, $row['PRICE3']);
    array_push($price, $row['PRICE4']);
    
    array_push($actions, intval($row['actions']));
    array_push($actions, intval($row['actions1']));
    array_push($actions, intval($row['actions2']));
    array_push($actions, intval($row['actions3']));
    array_push($actions, intval($row['actions4']));
    
    array_push($avail, $row['AVAIL']);
    array_push($avail, $row['AVAIL1']);
    array_push($avail, $row['AVAIL2']);
    array_push($avail, $row['AVAIL3']);
    array_push($avail, $row['AVAIL4']);
    
    
    for ($i=0; $i<5; $i++) {
        if ($comment_price[$i] != "") {
            $name = $comment_price[$i];
            $priceVal = $price[$i];
            $availVal = $avail[$i];
            $actionsVal = $actions[$i];
            if (is_numeric($priceVal)) {
                if (!$mysqli_api->query("INSERT into excursion_tariffs (name, excursion_date_id, price, price_sale, availability, updated_at) VALUES ('$name', '$id', '$priceVal', '$actionsVal', '$availVal', '$updated_at')")) {
                    echo "Local database error: ".$mysqli_api->error;
                }
            } else {
                if (!$mysqli_api->query("INSERT into excursion_tariffs (name, excursion_date_id, price, price_sale, availability, updated_at) VALUES ('$name', '$id', 0, '$actionsVal', '$availVal', '$updated_at')")) {
                    echo "Local database error: ".$mysqli_api->error;
                }
            }
        }
    }
}

/*
$res = $mysqli->query("select c.id, c.PRICE, c.PRICE_sngl, c.PRICE_trpl, c.PRICE1, c.PRICE1_sngl, c.PRICE1_trpl, c.PRICE2, c.PRICE2_sngl, c.PRICE2_trpl, c.PRICE3, c.PRICE3_sngl, c.PRICE3_trpl, c.PRICE4, c.PRICE4_sngl, c.PRICE4_trpl, c.AVAIL, c.AVAIL1, c.AVAIL2, c.AVAIL3, c.AVAIL4 from AVAIL_TOURS as c");
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
    
    $price_sngl = array();
    array_push($price_sngl, $row['PRICE_sngl']);
    array_push($price_sngl, $row['PRICE1_sngl']);
    array_push($price_sngl, $row['PRICE2_sngl']);
    array_push($price_sngl, $row['PRICE3_sngl']);
    array_push($price_sngl, $row['PRICE4_sngl']);
    
    $price_trpl = array();
    array_push($price_trpl, $row['PRICE_trpl']);
    array_push($price_trpl, $row['PRICE1_trpl']);
    array_push($price_trpl, $row['PRICE2_trpl']);
    array_push($price_trpl, $row['PRICE3_trpl']);
    array_push($price_trpl, $row['PRICE4_trpl']);
    
    $res1 = $mysqli_api->query("select k.id as co from tariffs as k WHERE tour_date_id='$id'");
    $tariff_count = $res1->num_rows;
    $flag = 0;
    while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
            //echo $res1->num_rows;
            $tariff_id = $row1['co'];
            if ($flag < $tariff_count) {
                if ($price_sngl[$flag] <> 0) {
                    echo  $row1['co']."> Single: ".$price_sngl[$flag]." - AVAIL ".$available[$flag]."<br />";
                    if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, availability) VALUES ('Single', '$tariff_id', '$price_sngl[$flag]', '$available[$flag]')")) {
                        echo $mysqli_api->error;
                    }
                }
                if ($price_double[$flag] <> 0) {
                    echo  $row1['co']."> Double: ".$price_double[$flag]." - AVAIL ".$available[$flag]."<br />";
                    if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, availability) VALUES ('Double', '$tariff_id', '$price_double[$flag]', '$available[$flag]')")) {
                        echo $mysqli_api->error;
                    }
                }
                if ($price_trpl[$flag] <> 0) {
                    echo  $row1['co']."> Triple: ".$price_trpl[$flag]." - AVAIL ".$available[$flag]."<br />";
                    if (!$mysqli_api->query("INSERT into accomodations (name, tariff_id, price, availability) VALUES ('Triple', '$tariff_id', '$price_trpl[$flag]', '$available[$flag]')")) {
                        echo $mysqli_api->error;
                    }
                }
            
            }
            $flag++;
    }
}
*/

?>