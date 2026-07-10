<?php

$pass = 12345678;

$pass = password_hash($pass, PASSWORD_DEFAULT);

echo $pass;



?>