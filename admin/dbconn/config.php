<?php
 define('DB_HOST','localhost:3307');
 define('DB_USER','root');
 define('DB_PASSWORD','');
 define('DB_NAME','bpa_system');

   

   $conn = new mysqli(DB_HOST,DB_USER, DB_PASSWORD, DB_NAME);

   if($conn->connect_error){
      die("Conneciton failed:".$conn->connect_error);
   }

/*
 define('DB_HOST','localhost');
 define('DB_USER','bpa_db');
 define('DB_PASSWORD','oLtxJc8lIy+djioy');
 define('DB_NAME','bpa_system');
*/





