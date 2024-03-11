<?php

enum Dir: string {
	const PORTAL = dirname($_SERVER['SCRIPT_FILENAME']);
	case ROOT = dirname(DIR_PORTAL);
}

require_once '../vendor/autoload.php';

Freeway\Freeway::hit();
# #0f173f
include '../app/View/signin.phtml';
