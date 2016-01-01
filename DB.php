<?php

class DB {

    const host = 'daneel';
    const database = "n00090048";
    const user = 'N00090048';
    const password = 'N00090048';

    public static function getConnection($host, $database, $user, $password) {

        $dsn = 'mysql:host='.$host.';dbname='.$database.';';
        $connection = new PDO($dsn, $user, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    }

}

