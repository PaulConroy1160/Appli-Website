<?php

mysql_connect("daneel", "N00090048", "N00090048");
mysql_select_db("n00090048");


$select = mysql_query('SELECT * FROM seekerAccounts');

$rows = array();

while($row = mysql_fetch_array($select))
{
    $rows[] = array('id'=> $row['id'], 'fName'=>$row['fName'], 'lName'=>$row['lName'], 'email'=>$row['email'], 'password'=>$row['password']);
}

echo json_encode(array('Users'=> $rows));
?>


