<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datenumberconverter {

	function DateOnly($v_date){
	  $DateArray = explode (" ",$v_date);
	  $v_date = $DateArray[0] ;

      return $v_date;

	}

	function IdnDateFormat($v_date){	
		$DateArray = explode ("-",$v_date);
		$bln = "";
		if(!isset($DateArray[1])){
			$DateArray[1]=NULL;
		}
		if(!isset($DateArray[2])){
			$DateArray[2]=NULL;
		}
		$tahun = $DateArray[0] ;
		$bulan = $DateArray[1] ;
		$tanggal = $DateArray[2];
		
				switch ($bulan) {
					case  1 : $bln = "Januari" ; break ;  
					case  2 : $bln = "Februari" ; break ; 
					case  3 : $bln = "Maret" ; break ; 
					case  4 : $bln = "April" ; break ; 
					case  5 : $bln = "Mei" ; break ; 
					case  6 : $bln = "Juni" ; break ; 
					case  7 : $bln = "Juli" ; break ; 
					case  8 : $bln = "Agustus" ; break ; 
					case  9 : $bln = "September" ; break ; 
					case 10 : $bln = "Oktober" ; break ; 
					case 11 : $bln = "November" ; break ; 
					case 12 : $bln = "Desember" ; break ; 
				} 
		
		        if($tanggal<10){
				   $v_tanggal=substr($tanggal, -1, 1);
				}
				else{
					 $v_tanggal=$tanggal;
				}
		$v_date = $v_tanggal." ".$bln." ".$tahun ; 

		return $v_date ; 
	}


	function IdnDateSingkatFormat($v_date){	
		$DateArray = explode ("-",$v_date);
		$bln = "";
		if(!isset($DateArray[1])){
			$DateArray[1]=NULL;
		}
		if(!isset($DateArray[2])){
			$DateArray[2]=NULL;
		}
		$tahun = $DateArray[0] ;
		$bulan = $DateArray[1] ;
		$tanggal = $DateArray[2];

				switch ($bulan) {
					case  1 : $bln = "Jan" ; break ;  
					case  2 : $bln = "Feb" ; break ; 
					case  3 : $bln = "Mar" ; break ; 
					case  4 : $bln = "Apr" ; break ; 
					case  5 : $bln = "Mei" ; break ; 
					case  6 : $bln = "Jun" ; break ; 
					case  7 : $bln = "Jul" ; break ; 
					case  8 : $bln = "Agts" ; break ; 
					case  9 : $bln = "Sep" ; break ; 
					case 10 : $bln = "Okt" ; break ; 
					case 11 : $bln = "Nov" ; break ; 
					case 12 : $bln = "Des" ; break ; 
				} 
		
		        if($tanggal<10){
				   $v_tanggal=substr($tanggal, -1, 1);
				}
				else{
					 $v_tanggal=$tanggal;
				}
		$v_date = $v_tanggal." ".$bln." ".$tahun ; 

		return $v_date ; 
	}

	function IdnDateSingkatAngkaFormat($v_date){	
		$DateArray = explode ("-",$v_date);
		$bln = "";
		if(!isset($DateArray[1])){
			$DateArray[1]=NULL;
		}
		if(!isset($DateArray[2])){
			$DateArray[2]=NULL;
		}
		$tahun = substr($DateArray[0],-2);
		$bulan = $DateArray[1] ;
		$tanggal = $DateArray[2];

				switch ($bulan) {
					case  1 : $bln = "01" ; break ;  
					case  2 : $bln = "02" ; break ; 
					case  3 : $bln = "03" ; break ; 
					case  4 : $bln = "04" ; break ; 
					case  5 : $bln = "05" ; break ; 
					case  6 : $bln = "06" ; break ; 
					case  7 : $bln = "07" ; break ; 
					case  8 : $bln = "08" ; break ; 
					case  9 : $bln = "09" ; break ; 
					case 10 : $bln = "10" ; break ; 
					case 11 : $bln = "11" ; break ; 
					case 12 : $bln = "12" ; break ; 
				}
		$v_date = $tanggal."/".$bulan."/".$tahun ; 

		return $v_date ; 
	}

	function IdnDateMYAngkaFormat($v_date){	
		$DateArray = explode ("-",$v_date);
		$bln = "";
		if(!isset($DateArray[1])){
			$DateArray[1]=NULL;
		}
		if(!isset($DateArray[2])){
			$DateArray[2]=NULL;
		}
		$tahun = substr($DateArray[0],-2);
		$bulan = $DateArray[1] ;

				switch ($bulan) {
					case  1 : $bln = "01" ; break ;  
					case  2 : $bln = "02" ; break ; 
					case  3 : $bln = "03" ; break ; 
					case  4 : $bln = "04" ; break ; 
					case  5 : $bln = "05" ; break ; 
					case  6 : $bln = "06" ; break ; 
					case  7 : $bln = "07" ; break ; 
					case  8 : $bln = "08" ; break ; 
					case  9 : $bln = "09" ; break ; 
					case 10 : $bln = "10" ; break ; 
					case 11 : $bln = "11" ; break ; 
					case 12 : $bln = "12" ; break ; 
				} 
		$v_date = $bln."/".$tahun ; 

		return $v_date ; 
	}

	function GetNumberDate($v_year,$v_month,$v_day){
        $v_number_of_date=cal_to_jd(CAL_GREGORIAN,$v_month,$v_day,$v_year);
        $v_number = (jddayofweek($v_number_of_date,0));

		return $v_number;
	}

	function DayNameIdn($v_day_index)
	{
		switch ($v_day_index)
		{
			case 0	: return "Minggu"; break ; 
			case 1	: return "Senin";  break ; 
			case 2	: return "Selasa"; break ; 
			case 3	: return "Rabu";   break ; 
			case 4	: return "Kamis";  break ; 
			case 5	: return "Jumat";  break ; 
			case 6	: return "Sabtu";  break ; 
		}
	}

	function Percent($v_value, $v_total)
	{	
		$v_percent=($v_value/$v_total)*100;
		return $v_percent;
	}
	
	function ValuePercent($v_value, $v_percent)
	{		
		return ($v_percent / 100)*$v_value;
	}
	
	function Impv($v_first, $v_end)
	{
		$v_impv['value'] = $v_end -  $v_first;
		$v_impv['percent'] = Percent($v_impv['value'], $v_first + $v_end);
		return $v_impv;
	}
		
	function EngFormat($v_number)
	{	
		return number_format($v_number, 2, '.', ',');
	}	

	function IdnCurrencyFormat($v_number)
	{	
		$numeric = explode(",",$v_number);
		if(count($numeric)>1)
			return number_format($numeric[0], 0, '', '.').','.$numeric[1];	
		else
			return number_format($numeric[0], 2, ',', '.');	
	}

	function IdnCurrencyFormatV2($v_number)
	{	
		$numeric = explode(",",$v_number);
		if(count($numeric)>1)
			return number_format($numeric[0], 0, '', '.').','.$numeric[1];	
		else
			return number_format($numeric[0], 0, ',', '.');	
	}

	function IdnNumberFormat($v_number)
	{		
		return number_format($v_number, 0, '', '.');	
	}	
	
	function FraFormat($v_number)
	{	
		return number_format($v_number, 2, ',', ' ');
	}

	function GenerateTitik($v_number){
		$numeric = explode(",",$v_number);
		if(count($numeric)>1)
			return number_format($numeric[0], 0, '', '.').$numeric[1];	
		else
			return number_format($numeric[0], 0, ',', '.');
	}
	
	function TimeMinus($v_time1, $v_time2) //time
	{
	if (TimeToInt($v_time2)>=TimeToInt($v_time1))
		return IntToTime(TimeToInt($v_time2)-TimeToInt($v_time1));	
	else
		return "00:00:00";
	}

	function TimeToInt($v_time)
	{
	if ((isset($v_time)) AND ($v_time<>'-')){
		$v_new_time = explode(":",$v_time);
		$v_time = ($v_new_time[0]*60*60)+($v_new_time[1]*60)+$v_new_time[2];
		return $v_time;
	}
	else
		return 0;
	}

	function IntToTime($v_time) //time
	{
	if ($v_time>0){
		$v_jam   = floor($v_time/3600);
		$v_menit = floor(($v_time-($v_jam*3600))/60);
		$v_detik = $v_time-($v_jam*3600+$v_menit*60);
	
		if ($v_jam<10)
			$v_jam="0".$v_jam;
		if ($v_menit<10)
			$v_menit="0".$v_menit;
		if ($v_detik<10)
			$v_detik="0".$v_detik;
		$v_time = $v_jam.":".$v_menit.":".$v_detik;
	}
	else
		$v_time="00:00:00";
	return $v_time;
	}

	function NormalFormat($v_number){
		$number="";
		$numeric = explode(".",$v_number);
		$jum=count($numeric);
		for($i=0;$i<$jum;$i++){
			$number=$number.$numeric[$i];
		}
		return $number;
	}

	function NumberNoDecimal($v_number){
		$number="";
		$numeric = explode(".",$v_number);
        
		$number = $numeric[0];
		return $number;
	}

	function IndFormatToEngFormat($v_number){
	$v_number	= str_replace(".", "-", $v_number);
	$v_number_temp	= str_replace(",", ".", $v_number);
	$v_number	= str_replace("-", "", $v_number_temp);
	return $v_number;
	}

	function NumberToWordFormat($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";

          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = $this->NumberToWordFormat($x - 10). " belas";
          } else if ($x <100) {
              $temp = $this->NumberToWordFormat($x/10)." puluh". $this->NumberToWordFormat($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . $this->NumberToWordFormat($x - 100);
          } else if ($x <1000) {
              $temp = $this->NumberToWordFormat($x/100) . " ratus" . $this->NumberToWordFormat($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . $this->NumberToWordFormat($x - 1000);
          } else if ($x <1000000) {
              $temp = $this->NumberToWordFormat($x/1000) . " ribu" . $this->NumberToWordFormat($x % 1000);
          } else if ($x <1000000000) {
              $temp = $this->NumberToWordFormat($x/1000000) . " juta" . $this->NumberToWordFormat($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = $this->NumberToWordFormat($x/1000000000) . " milyar" . $this->NumberToWordFormat(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = $this->NumberToWordFormat($x/1000000000000) . " trilyun" . $this->NumberToWordFormat(fmod($x,1000000000000));
          }      
              return $temp;
      }

      function NumberToWordStyleFormat($x, $style=4) {
	   $temp = $this->NumberToWordFormat($x);
          if($x<0) {
              $hasil = "minus ". trim($this->NumberToWordFormat($x));
          } else {
              $hasil = trim($this->NumberToWordFormat($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }

	function TimeMinus2($v_time1, $v_time2) //time
	{
		"[1]".$date1=date('Y-m-d',strtotime($v_time1));
		"[2]".$date2=date('Y-m-d',strtotime($v_time2));
	
		$time1=date('H:i:s',strtotime($v_time1));
		$time2=date('H:i:s',strtotime($v_time2));
	
		if($date1==$date2){
			if (TimeToInt($time2)>=TimeToInt($time1))
				return IntToTime(TimeToInt($time2)-TimeToInt($time1));	
			else
				return "00:00:00";
		}else{
			$jam1=$time1;
			$jam2=date('H:i:s',strtotime("23:59:59"));
			$detik=date('H:i:s',strtotime("00:00:01"));
			"[3]".$tot_awal=IntToTime((TimeToInt($jam2)+TimeToInt($detik))-TimeToInt($time1));
			$tot_akhir=IntToTime(TimeToInt($tot_awal)+TimeToInt($time2));
			
			return $tot_akhir;
		}
	}

	function PembulatanNilaiNonDecimal ($v_number){
	   $v_round_up = ceil($v_number);

	   return $v_round_up;
    }

    function formatRupiah2($angka)
    {
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }

    function formatDecimal($angka, $comma)
    {
        $hasil_rupiah = number_format($angka,$comma);
        return $hasil_rupiah;
    }

    function formatRupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    }
    function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
        
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }     
        return $hasil;
    }

	function GetAgeToMonth($tgl){
		$birthDate = new DateTime($tgl);
		$today = new DateTime("today");
		if ($birthDate > $today) { 
			exit("0 tahun 0 bulan 0 hari");
		}
		$y = $today->diff($birthDate)->y;
		$m = $today->diff($birthDate)->m;
		$d = $today->diff($birthDate)->d;
		return $y." tahun ".$m." bulan ".$d." hari";
	}
}