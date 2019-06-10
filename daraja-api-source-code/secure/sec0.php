<?php
# prevent access and allow access to dev env 
header('Access-Control-Allow-Origin: http://localhost/mPESA-API-Tutorial/');
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	die('Access Denied');
}

