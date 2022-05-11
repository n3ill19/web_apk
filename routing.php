<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('start'); // akcja/ścieżka domyślna
App::getRouter()->setLoginRoute('login'); // akcja/ścieżka na potrzeby logowania (przekierowanie, gdy nie ma dostępu)

Utils::addRoute('start',    'StartCtrl');
Utils::addRoute('reservation',    'StartCtrl',	[1, 2, 3]);
Utils::addRoute('registration',    'RegistrationCtrl');
Utils::addRoute('adduser',    'RegistrationCtrl');
Utils::addRoute('login',    'LoginCtrl');
Utils::addRoute('logout',    'LoginCtrl');
Utils::addRoute('logged',    'LoginCtrl');
Utils::addRoute('admin',    'AdminCtrl',	[1]);
Utils::addRoute('changerole',    'AdminCtrl',	[1]);
Utils::addRoute('moder',    'ModerCtrl',	[2]);
Utils::addRoute('resAccept',    'ModerCtrl',	[2]);
Utils::addRoute('resDelete',    'ModerCtrl',	[2]);
Utils::addRoute('search',    'SearchCtrl',	[2]);
Utils::addRoute('search_result',    'SearchCtrl',	[2]);
