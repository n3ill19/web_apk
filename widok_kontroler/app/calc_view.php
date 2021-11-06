<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator kredytowy</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_x">Kwota kredytu: </label>
	<input id="id_x" type="text" name="x" value="<?php if (! (isset($x))){$x=0;} print($x); ?>" /> zł<br />
    <label for="id_y">Okres kredytu: </label>
    <input id="id_y" type="text" name="y" value="<?php if (! (isset($y))){$y=0;} print($y); ?>" />
    <?php if ($y==1 || $y==2 || $y==3 || $y==4 || $y==5) ?><br />
    <label for="id_z">Oprocentowanie: </label>
    <input id="id_z" type="text" name="z" value="<?php if (! (isset($z))){$z=0;} print($z); ?>" /> %<br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result) && isset($wynik)){ ?>
    <div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
        <?php echo 'Kredyt wyniesie: '.$wynik; ?> zł
        <br />
        <?php echo 'Miesięczna rata: '.$result; ?> zł
    </div>
<?php } ?>

</body>
</html>