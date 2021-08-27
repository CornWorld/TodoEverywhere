<?php
	
	require_once "sql.php";
	require_once "random.php";
	require_once "crypto.php";
	
	require_once "page.php";
	require_once "usr.php";
	require_once "node.php";
	require_once "api.php";
	
	sql::init();
	echo api::parse($_GET);