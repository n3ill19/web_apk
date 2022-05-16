<?php
require_once dirname(__FILE__).'/config.php';

//przekazanie żądania do następnego dokumentu ("forward")
include $conf->root_path.'/app/ctrl.php';