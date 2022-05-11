<?php
require_once 'init.php';
use core\App;
header("Location: ". App::getConf()->app_url);