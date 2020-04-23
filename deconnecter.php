<?php
	require 'config.php';

	session_destroy();
	session_unset();
	header("location: login.php");
?>