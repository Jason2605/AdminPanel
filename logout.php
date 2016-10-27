<?php

session_start();
if (isset($_COOKIE['logged'])):
  setcookie('logged', '', time() - 7000000, '/');
endif;

setcookie('fail', '0');

if (isset($_COOKIE['conecFail'])):
  setcookie('conecFail', '', time() - 7000000, '/');
endif;

if (isset($_COOKIE['adminLevel'])):
  setcookie('adminLevel', '', time() - 7000000, '/');
endif;
session_destroy();
header('location: index.php');
