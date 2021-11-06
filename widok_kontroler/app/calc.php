<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$x = $_REQUEST ['x'];
$y = $_REQUEST ['y'];
$z = $_REQUEST ['z'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($x) && isset($y) && isset($z))) {
    //sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
    $messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $x == "") {
    $messages [] = 'Nie podano kwoty kredytu';
}
if ( $y == "") {
    $messages [] = 'Nie podano okresu kredytu';
}
if ( $z == "") {
    $messages [] = 'Nie podano oprocentowania';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {

    // sprawdzenie, czy $x, $y, $z są liczbami
    if (! is_numeric( $x )) {
        $messages [] = 'Kwota nie jest liczbą całkowitą';
    }
    if (! is_numeric( $y )) {
        $messages [] = 'Okres kredytu nie jest liczbą całkowitą';
    }
    if (! is_numeric( $z )) {
        $messages [] = 'Oprocentowanie nie jest liczbą';
    }

    if ($x <= 0 || $y <= 0 ) {
        $messages [] = 'Kwota i okres kredytu muszą być większe od zera';
    }
}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów

    //konwersja parametrów na int i double (przy użyciu kropki)
    $x = doubleval($x);
    $y = intval($y);
    $z = doubleval($z);

    $wynik = ((($z /100) * $x)+$x);
    $result = ((($z /100) * $x)+$x)/($y * 12);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$kwota,$lata,$procent,$result,$kwota_calkowita)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';