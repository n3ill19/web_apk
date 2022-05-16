<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/calc/CalcForm.class.php';
require_once $conf->root_path.'/app/calc/CalcResult.class.php';

class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $hide_intro; //zmienna informująca o tym czy schować intro

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
		$this->hide_intro = false;
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
                $this->form->x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
                $this->form->y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
                $this->form->z = isset($_REQUEST['z']) ? $_REQUEST['z'] : null;
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
        
        function validate(){
            // sprawdzenie, czy parametry zostały przekazane
            if ( ! (isset($this->form->x) && isset($this->form->y) && isset($this->form->z) )) return false;
   
            $this->hide_intro = true;

            // sprawdzenie, czy potrzebne wartości zostały przekazane
            if ($this->form->x == "") {
			$this->msgs->addError('Nie podano kwoty');
		}
            if ($this->form->y == "") {
			$this->msgs->addError('Nie podano oprocentowania');
		}
            if ($this->form->z == "") {
			$this->msgs->addError('Nie podano liczby rat');
		}
                
            if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->x )) {
				$this->msgs->addError('Pierwsza wartość nie jest liczbą');
			}
			if (! is_numeric ( $this->form->y )) {
				$this->msgs->addError('Druga wartość nie jest liczbą');
			}
                        if (! is_numeric ( $this->form->z )) {
				$this->msgs->addError('Trzecia wartość nie jest liczbą');
			}
		}
		
		return ! $this->msgs->isError();
              
        }

	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
                
		if ($this->validate()) {
			
                        $this->msgs->addInfo('Parametry poprawne. Wykonuję obliczenia.');

                        //konwersja parametrów na int
                        $this->form->x = floatval($this->form->x);
                        $this->form->y = floatval($this->form->y);
                        $this->form->z = floatval($this->form->z);
                        
				
			//wykonanie operacji
                        $this->result->result = ($this->form->x + ($this->form->x * $this->form->y / 100)) / $this->form->z;
			
			$this->msgs->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Strona główna');
		$smarty->assign('page_description','Kontroler główny');
		$smarty->assign('page_header','Kontroler główny');
				
		$smarty->assign('hide_intro',$this->hide_intro);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/calc/calc_view.tpl');
	}
}