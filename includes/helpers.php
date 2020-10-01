<?php
/**
 * info about current page, example: index.php
 * @return string
 */

function curPage(){
	$archivos = explode("/", $_SERVER["PHP_SELF"]);
	$curPage = $archivos[count($archivos) -1];
	
	return $curPage;
}

/**
 * @x (int)
 * @y (int)
 * regresa un rango de números dentro de un array, usualmente para ser usados en campos tipo <select>, ejemplo rango de años
 * @return (array)
 */

function rango($x,$y){
	$arr = array();
	
	if($y > $x){
		while($x <= $y){
			$arr[] = $x;
			$x++;	
		}		
	} else {
		while($x >= $y){
			$arr[] = $x;
			$x--;	
		}		
	}
	
	return $arr;
}

/**
 * @valor (int) maximo dos digitos
 * en ocasiones ocupas regresar valores tipo "09" en lugar de "9", pero si tienes "19" debes regresar el mismo "19"
 * @return (string)
 */
function zeroLeft($valor){
	if(strlen($valor) < 2){
		return "0" . $valor;
	}
	
	return $valor;
}

/**
 * envía email html con la función mail del servidor
 */
function sendEmail($asunto, $email, $body, $from){
	$cabeceras = "From: {$from}\r\nContent-type: text/html\r\n";	
	mail($email,$asunto,$body,$cabeceras);	
}

/**
 * @text (string) texto con correos electrónicos dentro
 * retorna un array de emails obtenidos del texto recibido
 * @return (array<string>)
 */
function extract_emails($text) {
	$res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $text, $matches);

	if ($res) {
		foreach(array_unique($matches[0]) as $email) {
			$emails[] = $email;
		}
	}
	else
		return null;
		
	return $emails;
}

/**
 * @file (string)
 * forza la descarga de un archivo viva en el servidor
 */
function DownloadFile($file) {
    if(file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

function getMonth($month){
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

	return $meses[$month - 1];
}

$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );

function isMobile(){
    $device = '';
    if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
        $device = "ipad";
    } else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
        $device = "iphone";
    } else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
        $device = "blackberry";
    } else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
        $device = "android";
    }
    if( $device ) {
        return $device; 
    } 
    return false; 
}

$device = isMobile();

function file_get_contents_curl($url, $retries=5){
    $ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36';
    
    if (extension_loaded('curl') === true){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_USERAGENT, $ua); 
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
        $result = curl_exec($ch);
        curl_close($ch);
    } else {
        $result = file_get_contents($url);
    }        
    if (empty($result) === true){
        $result = false;
        if ($retries >= 1){
            sleep(1);
            return file_get_contents_curl($url, --$retries);
        }
    }    
    return $result;
}

function validate_username($str){
    $allowed = array(".", "-", "_");
    
    if(strlen($str) < 5 || strlen($str) > 15){
    	return false;
    } else {
		return ctype_alnum(str_replace($allowed, '', $str ));
    }
}

function validate_name($str){
	return preg_match('/^[\p{L}\p{N}_\' -]+$/u', $str);
	//return $res == 1 ? true : false;
}

function validate_email($str){
	return !!filter_var($str, FILTER_VALIDATE_EMAIL);
}