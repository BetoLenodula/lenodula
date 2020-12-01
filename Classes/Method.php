<?php 
	namespace Classes;


	class Method{

		public function normalize($string){
    		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
			ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
			bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    		$string = utf8_decode($string);
    		$string = strtr($string, utf8_decode($originales), $modificadas);
    		$string = strtolower($string);
    		$string = str_replace(" ", "_", $string);
    		return utf8_encode($string);
		}

		public function remove_accents_marks($string){
			$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
			ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
			bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    		$string = utf8_decode($string);
    		$string = strtr($string, utf8_decode($originales), $modificadas);
    		return utf8_encode($string);
		}

		public function stars_points($arg){
			if($arg < 50){
				return 0;
			}
			if($arg >= 50 && $arg <= 79){
				return  1;
			}
			if($arg >= 80 && $arg <=199){
				return  2;
			}
			if($arg >= 200 && $arg <=399){
				return  3;
			}
			if($arg >= 400 && $arg <=799){
				return  4;
			}
			if($arg >= 800){
				return  5;
			}
		}

		public function findReplaceURL($text){
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			$reg_ExYT = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";

			preg_match($reg_ExYT, $text, $idv);

			if(!empty($idv[7])){
				$youtubeId = substr($idv[7], 0, 11);
			}
			else{
				$youtubeId = null;
			}

      		if(!empty($youtubeId) && strlen($youtubeId) == 11){
      			$com = preg_replace($reg_ExYT, "<br><iframe src=https://www.youtube.com/embed/".$youtubeId." frameborder=0></iframe><br>", $text);
      			$text = preg_replace($reg_exUrl, '', $text);
				return array($com.$text, "<a href=https://www.youtube.com/watch?v=$youtubeId>youtube.com/".$youtubeId." </a>".$text);
			}
			else{
      			return preg_replace($reg_exUrl, "<a href=$0>$0</a> ", $text);	
			}

		}


		function findHashTags($text){
			$reg_exHash = "/(^|\s)#([a-zA-Z0-9_]+)/";  
			
					  preg_match_all($reg_exHash, $text, $matches,  PREG_PATTERN_ORDER);
			$strhas = implode(",", $matches[0]);
      		$strurl = preg_replace($reg_exHash, '<a href="/comentarios/destacar/$2">$0</a>', $text);  

      		return array($strurl, $strhas);
		}

		public function  returnClassExt($arg){
			$arg = strtolower($arg);
			
			$ext = explode(".", $arg);
			$ext = end($ext);
			$ext = ".".$ext;
			
			if($ext == '.doc' || $ext == '.docx'){
                return  'attach_word';
            }
            else if($ext == '.xls' || $ext == '.xlsx'){
                return  'attach_excel';
            }
            else if($ext == '.ppt' || $ext == '.pptx'){
                return  'attach_ppoint';
            }
            else if($ext == '.pdf'){
                return  'attach_pdf';
            }
            else if($ext == '.txt' || $ext == '.rtf'){
                return  'attach_txt';
            }
            else if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.gif'){
            	return  'attach_image';
            }
            else if($ext == '.html' || $ext == '.cpp' || $ext == '.c' || $ext == '.css' || $ext == '.js' || $ext == '.sql' || $ext =='.java'){
                return  'attach_code';
            }
            else if($ext == '.zip' || $ext == '.rar'){
                return  'attach_cab';
            }
            else if($ext == '.mp3' || $ext == '.ogg' || $ext == '.m4a'){
                return  'attach_audio';
            }
            else if($ext == '.mp4'){
            	return 'attach_video';
            }
            else{
                return 'attach_file';
            }
		}

		public function alfa_months($arg){

			$arg = explode("-", $arg);
			$mes = $arg[1];

			switch ($mes) {
				case '01':
					$return = "Ene";
					break;
				case '02':
					$return = "Feb";
					break;
				case '03':
					$return = "Mar";
					break;
				case '04':
					$return = "Abr";
					break;
				case '05':
					$return = "May";
					break;
				case '06':
					$return = "Jun";
					break;
				case '07':
					$return = "Jul";
					break;
				case '08':
					$return = "Ago";
					break;
				case '09':
					$return = "Sep";
					break;
				case '10':
					$return = "Oct";
					break;
				case '11':
					$return = "Nov";
					break;
				case '12':
					$return = "Dic";
					break;
			}
			$return = $arg[2]."/".$return."/".$arg[0]; 
			return $return;
		}
	}


 ?>