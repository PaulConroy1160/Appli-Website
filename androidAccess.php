<?php
mysql_connect("localhost", "root", "");
mysql_select_db("appli");

$select = mysql_query('SELECT * FROM jobs');

$rows =array();

while($row=  mysql_fetch_array($select))
{
    $rows[] = array('title'=>$row['title'], 'company'=>$row['company'], 'salary'=>$row['rPackage'], 'summary'=>$row['summary'], 'location'=>$row['location']);
}


echo json_encode(array('Jobs'=> $rows));

?>


