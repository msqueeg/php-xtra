<?php
function pageHeader($title) {
	$ret = '<!doctype html>
	<html>
	<head>
		<title>' . $title . '</title>
		<link href="styles.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>';
	if($_SERVER['PHP_SELF'] != "/index.php") {
		$ret .= '<p><a href="index.php">back</a></p>';
	}

	$ret .= '<header><h1>'.$title.'</h1></header>';

	if(!headers_sent()) {
		session_start();
	}

	return $ret;
}

function pageFooter($file = null) {
	$ret = '';
	if($file) {
		$ret .= '<h3>Code:</h3>';
		$ret .= '<pre class="code">';
		$ret .= htmlspecialchars(file_get_contents($file));
		$ret .= '</pre>';
	}
	$ret .= '</html>';

	return $ret;
}