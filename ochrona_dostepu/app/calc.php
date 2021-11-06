<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';


// 1. pobranie parametrów

function getParams(&$x,&$y,&$z)
{
    $x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
    $y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
    $z = isset($_REQUEST['z']) ? $_REQUEST['z'] : null;
}

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

function validate($x,$y,$z,&$messages){
// sprawdzenie, czy parametry zostały przekazane
    if (!(isset($x) && isset($y) && isset($z))) {
//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
        return false;
    }

// sprawdzenie, czy potrzebne wartości zostały przekazane
    if ($x == "") {
        $messages [] = 'Nie podano kwoty kredytu';
    }
    if ($y == "") {
        $messages [] = 'Nie podano okresu kredytu';
    }
    if ($z == "") {
        $messages [] = 'Nie podano oprocentowania';
    }

//nie ma sensu walidować dalej gdy brak parametrów
    if (count ( $messages ) != 0) return false;

        // sprawdzenie, czy $x, $y, $z są liczbami
        if (!is_numeric($x)) {
            $messages [] = 'Kwota nie jest liczbą całkowitą';
        }
        if (!is_numeric($y)) {
            $messages [] = 'Okres kredytu nie jest liczbą całkowitą';
        }
        if (!is_numeric($z)) {
            $messages [] = 'Oprocentowanie nie jest liczbą';
        }

        if ($x <= 0 || $y <= 0) {
            $messages [] = 'Kwota i okres kredytu muszą być większe od zera';
        }
        if (count($messages) != 0) return false;
        else return true;
}


// 3. wykonaj zadanie jeśli wszystko w porządku

function process(&$x,&$y,&$z,&$messages,&$result,&$wynik){
    global $role;

    //konwersja parametrów na int i double (przy użyciu kropki)
    $x = doubleval($x);
    $y = intval($y);
    $z = doubleval($z);

    if ($role != 'admin' && $y >= 5) {
        $messages [] = 'Tylko admin może wziąć kredyt na więcej niż 5 lat!';
    } else {
        $wynik = ((($z / 100) * $x) + $x);
        $result = ((($z / 100) * $x) + $x) / ($y * 12);
    }

    if ($role != 'admin' && $x >= 10000) {
        $messages [] = 'Tylko admin może wziąć kredyt na więcej niż 10000 zł';
    } else {
        $wynik = ((($z / 100) * $x) + $x);
        $result = ((($z / 100) * $x) + $x) / ($y * 12);
    }
}
// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$kwota,$lata,$procent,$result,$kwota_calkowita)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';