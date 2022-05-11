<?php
require_once 'init.php';

// Projekt 8 zrealizowany we frameworku Amelia
// - brak zmian funkcjonalności

require_once 'routing.php';

\core\SessionUtils::loadMessages();

\core\App::getRouter()->go();