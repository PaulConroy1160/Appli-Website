<?php

mysql_connect("daneel", "N00090048", "N00090048");
mysql_select_db("n00090048");


$select = mysql_query('SELECT * FROM jobs');

$rows = array();

while($row = mysql_fetch_array($select))
{
    $rows[] = array('id'=> $row['id'], 'title'=>$row['title'],'company'=>$row['company'], 'rPackage'=>$row['rPackage'], 'summary'=>$row['summary'], 'location'=>$row['location'], 'contractType'=>$row['contractType']);
}

echo json_encode(array('Jobs'=> $rows));
?>


