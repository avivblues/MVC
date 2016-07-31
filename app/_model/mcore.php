<?php 
class mcore{
	protected $result;
	/* __set Function for magic method */
	public function __set($property, $value){
		if(property_exists($this,$property))$this->$property = $value;
	}
	/* __get Function for magic method */
	public function __get($property){
		if(property_exists($this,$property)) return $this->$property;
	}

	public static function getconfigfile($xfile,$mode=false){
		$this->result = parse_ini_file($xfile,$mode);
	} 
	/*	@base Date_function model for application
		============================
	*/
	public function Date2String($inputDate,$dateFormat) {
		switch ($dateFormat){
		   case 1:
				$this->result = date('d F Y', strtotime($inputDate));
		   break;
		   case 2:
				$this->result = date('F d, Y G:i:s', strtotime($inputDate));
		   break;
		   case 3:
				$this->result = date('M d, Y h:i:s A', strtotime($inputDate));
		   break;
		   case 4:
				$this->result = date('M d, Y G:i:s', strtotime($inputDate));
		   break;
		   case 5:
				$this->result = date('Y-m-d H:i:s',strtotime($inputDate));
		   break;
		   case 6:
				$this->result = date('d-m-Y H:i:s',strtotime($inputDate));
		   break;
		   case 7:
				$this->result = date('H:i:s',strtotime($inputDate));
		   break;
		   case 8:
				$this->result = date('d-m-Y',strtotime($inputDate));
		   break;
		}
	}
	public function selisihjam($timeAwal,$timeAkhir){
		list($h,$m,$s) = explode(":",$timeAwal);
		$dAwal = mktime($h,$m,$s,"0","0","0");
		list($h,$m,$s) = explode(":",$timeAkhir);
		$dAkhir = mktime($h,$m,$s,"0","0","0");
		$dSelisih = $dAkhir - $dAwal;
		$dJum = ($dSelisih/60) / 60;
		if ($dJum < 0) {
		   $dJum = 24 - abs($dJum);
		}
		$this->result = $dJum;
	}
	public function selisihhari($tgl1,$tgl2){
		date_default_timezone_set('Asia/Jakarta');
		$selisih = strtotime($tgl2) -  strtotime($tgl1);
		$hari = $selisih/(60*60*24);
		$this->result = $hari;
	}
	/*
		@base Array_function model for application
		============================
	*/
	// sum total nilai dalam array
	public function sumtotalnilaiarray($arry){
		$sum = 0;
		foreach($arry as $item){
			$sum += $item-1;
		}
		$this->result = $sum;
	}
	//mencari value array dua dimensional
	public function valueForKey($array, $key){
		$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
		foreach ($iterator as $arrayKey => $arrayValue) {
			if ($arrayKey == $key) {
				$this->result = $arrayValue;
			}
		}
		$this->result = FALSE;
	}
	// cek exist array value
	public function CekExistArray($array,$key){
		if(in_array($key, $array)) {
			$this->result = TRUE;
		}else{
			$this->result = FALSE;
		}
	}
	// Cek exist value in array multidimensional
	// contoh search_in_array_r($arysel,"kata",0)
	public function search_in_array_r($array,$needle,$arraykey) {
		$found = array();
		foreach ($array as $key => $val) {
			if ($val[$arraykey] == $needle) {
				array_push($found, $val[$arraykey]);
			}
		}
		if (count($found) != 0)
			$this->result = count($found);
		else
			$this->result = FALSE;
	}
	
	public function ArrWordsearch($array, $key, $value) {
		$results = array();
		if (is_array($array))
		{
			if (isset($array[$key]) && $array[$key] == $value)
				$results[] = $array;

			foreach ($array as $subarray)
				$results = array_merge($results, $this->Com_Wordsearch($subarray, $key, $value));
		}
		$this->result = ($results);
	}
	public function Com_Arr_sort($a,$subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		$this->result = $c;
	}
	public function msort($array, $key, $sort_flags = SORT_REGULAR) {
		if (is_array($array) && count($array) > 0) {
			if (!empty($key)) {
				$mapping = array();
				foreach ($array as $k => $v) {
					$sort_key = '';
					if (!is_array($key)) {
						$sort_key = $v[$key];
					} else {
						foreach ($key as $key_key) {
							$sort_key .= $v[$key_key];
						}
						$sort_flags = SORT_STRING;
					}
					$mapping[$k] = $sort_key;
				}
				asort($mapping, $sort_flags);
				$sorted = array();
				foreach ($mapping as $k => $v) {
					$sorted[] = $array[$k];
				}
				$this->result = $sorted;
			}
		}
		$this->result = $array;
	}
		public function terbilang($angka) {
        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            return sprintf('Seratus %s', $this->terbilang($angka - 100));
        } else if ($angka < 1000) {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
        } else if ($angka < 1000000) {
            $hasil_bagi = (int)($angka / 1000); 
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }
}
?>