<?php
/**
 * $Id: CCTemplate.class.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
final class CCTemplate {
	var $version = " Manejo de templates CCTemplate [PHP]";
	var $MAIN = array ( );
	var $AREAINDEX = array ( );
	var $VALUETYPES = array ( );
	var $TAGVALUES = array ( );
	var $TAGDEFAULTS = array ( );
	var $ITEMID;
	var $basepath;
	var $filename;
	
	function CCTemplate($path) {
		$this->basepath = $path . "/";
	}
	
	function cInit($filename) {
		$BUFFER = "";
		if (! file_exists ( $this->basepath . $filename )) {
			echo "<font color=red><B>CCTemplate_Error_Handler:</B> No se puede encontrar el archivo $filename </font>";
			exit ();
		}
		$this->filename = $filename;
		$fd = fopen ( $this->basepath . $filename, "r" );
		$BUFFER = fread ( $fd, filesize ( $this->basepath . $filename ) );
		fclose ( $fd );
		$pos_con = strpos ( $BUFFER, "<?php" );
		if ($pos_con !== FALSE and $pos_con == 0)
			$BUFFER = cEval ( $BUFFER );
		
		$this->ITEMID = 0;
		$this->MAIN = $this->cInitPriv ( $BUFFER );
		$BUFFER = "";
	}
	function cInitPriv($area) {
		$Mypos = 0;
		$Mypos2 = 0;
		$Mypos3 = 0;
		$tag = "";
		$lastpos = 0;
		$str = "";
		$dic = array ( );
		$dic2 = array ( );
		$i = 0;
		
		$dic [0] = "";
		$Mypos = strpos ( $area, "{", 0 );
		if ($Mypos != 0)
			while ( 1 ) {
				$str = substr ( $area, $lastpos, ($Mypos - $lastpos) );
				$Mypos2 = strpos ( $area, "}", ($Mypos + 1) );
				$tag = substr ( $area, ($Mypos + 1), ($Mypos2 - $Mypos - 1) );
				//echo("Primero Encontrado: " . $tag . "<br>");
				while ( (! $this->isValidTag ( $tag )) ) {
					if (! $Mypos = strpos ( $area, "{", ($Mypos + 1) ))
						break 2;
					$str = substr ( $area, $lastpos, ($Mypos - $lastpos) );
					$Mypos2 = strpos ( $area, "}", $Mypos );
					$tag = substr ( $area, ($Mypos + 1), ($Mypos2 - $Mypos - 1) );
					//echo("Subsiguientes: " . $tag . "<br>");
				}
				//echo("Valido : " . $tag . "<br>");
				if ($str != "") {
					$dic [$this->ITEMID] = $str;
					$this->VALUETYPES [$this->ITEMID] = "Text";
					$this->ITEMID ++;
				}
				$Mypos3 = strpos ( $area, "{/" . $tag . "}", $Mypos );
				
				if ($Mypos3 != 0) {
					if (Chr ( 10 ) != substr ( $area, ($Mypos2 + 1), 1 )) {
						$str = substr ( $area, $Mypos2 + 1, ($Mypos3 - $Mypos2 - 1) );
					} else {
						$str = substr ( $area, $Mypos2 + 2, ($Mypos3 - $Mypos2 - 2) );
					}
					// Recursivo
					$dic2 = $this->cInitPriv ( $str );
					$dic [$this->ITEMID] = $tag;
					$this->VALUETYPES [$this->ITEMID] = "Area";
					$this->ITEMID ++;
					$this->AREAINDEX [$tag] = $dic2;
					$this->TAGDEFAULTS [$tag] = "";
					
					$lastpos = strpos ( $area, "}", $Mypos3 ) + 1;
					if (substr ( $area, $lastpos, 1 ) == Chr ( 10 ))
						$lastpos ++;
				} else {
					$dic [$this->ITEMID] = $tag;
					
					$this->VALUETYPES [$this->ITEMID] = "Tag";
					$this->ITEMID ++;
					$this->TAGVALUES [$tag] = "";
					$this->TAGDEFAULTS [$tag] = "";
					$lastpos = $Mypos2 + 1;
				}
				
				if (! $Mypos = strpos ( $area, "{", $lastpos ))
					break;
			}
		
		$dic [$this->ITEMID] = substr ( $area, $lastpos );
		$this->VALUETYPES [$this->ITEMID] = "Text";
		$this->ITEMID ++;
		
		return $dic;
	}
	function cSet($tag, $val) {
		$this->TAGVALUES [$tag] = $val;
	}
	
	function cParse($area) {
		$areaobj = array ( );
		$i = 0;
		
		if ($area == "MAIN") {
			$areaobj = $this->MAIN;
		} else {
			$areaobj = $this->AREAINDEX [$area];
		}
		if (! empty ( $areaobj )) {
			//echo("Area:" . $area . "<br>");
			$pru = each ( $areaobj );
			while ( $temp = each ( $areaobj ) ) {
				switch ( $this->VALUETYPES [$temp [0]]) {
					case "Tag" :
						if (isset ( $this->TAGVALUES [$temp [1]] )) //							if($this->TAGVALUES[$temp[1]]!="")
						{
							$areaobj [0] = $areaobj [0] . $this->TAGVALUES [$temp [1]];
						} else {
							$areaobj [0] = $areaobj [0] . $this->TAGDEFAULTS [$temp [1]];
						}
					break;
					case "Text" :
						$areaobj [0] = $areaobj [0] . $temp [1];
					break;
					
					case "Area" :
						if ($this->AREAINDEX [$temp [1]] [0] != "") {
							$areaobj [0] = $areaobj [0] . $this->AREAINDEX [$temp [1]] [0];
							$this->AREAINDEX [$temp [1]] [0] = "";
						} else {
							$areaobj [0] = $areaobj [0] . $this->TAGDEFAULTS [$temp [1]];
						}
					break;
					case "Buff" :
					break;
					default :
						echo ("Error, tipo de tag/valor desconocido");
				}
			}
			if ($area == "MAIN") {
				$this->MAIN [0] = $areaobj [0];
			} else {
				$this->AREAINDEX [$area] [0] = $areaobj [0];
			}
		}
	}
	
	function cPrint() {
		$this->cparse ( "MAIN" );
		
		$cadena = $this->MAIN [0];
		
		while ( strlen ( $cadena ) > 14000 ) {
			echo substr ( $cadena, 0, 14000 );
			$cadena = substr ( $cadena, 14000 );
		}
		echo ($cadena);
		
		$this->MAIN [0] = "";
		
		$this->MAIN = "";
		$this->TAGVALUES = "";
		$this->AREAINDEX = "";
	}
	
	function cGetString() {
		$this->cparse ( "MAIN" );
		$cadena = $this->MAIN [0];
		
		$this->MAIN [0] = "";
		
		$this->MAIN = "";
		$this->TAGVALUES = "";
		$this->AREAINDEX = "";
		return $cadena;
	}
	
	function cGetContenido($area = "MAIN") {
		if ($area == "MAIN") {
			$this->cparse ( "MAIN" );
			$cadena = $this->MAIN [0];
		} else {
			$cadena = $this->AREAINDEX [$area] [0];
		}
		return $cadena;
	}
	
	function cversion() {
		return $this->version;
	}
	
	function isValidTag($tag) {
		$res = preg_match ( "/^[A-Za-z0-9_]*$/", $tag );
		//			echo("Resultado de la validacion: " . $res . "<br>");
		return $res;
	}
	function cinclude($tag, $archivo) {
		if (! file_exists ( $this->basepath . $archivo )) {
			echo ("CCTemplate_Error_Handler: No se puede encontrar el archivo " . $archivo . " para incluirlo en el texto");
			exit ();
		}
		$incbuf = "";
		$fd = fopen ( $this->basepath . $archivo, "r" );
		$incbuf = fread ( $fd, filesize ( $this->basepath . $archivo ) );
		fclose ( $fd );
		$areainc = $this->cInitPriv ( $incbuf );
		$this->AREAINDEX [$tag] = $areainc;
		
		$this->alteratag ( $tag, "MAIN", "Area" );
	}
	function alteratag($tag, $area, $tipo) {
		if ($area == "MAIN") {
			$areabus = $this->MAIN;
		} else {
			$areabus = $this->AREAINDEX [$area];
		}
		
		while ( $au = each ( $areabus ) ) {
			if ($au [1] == $tag) {
				$this->VALUETYPES [$au [0]] = $tipo;
				break;
			} else {
				if ($this->VALUETYPES [$au [0]] == "Area")
					$this->alteratag ( $tag, $au [1], $tipo );
			}
		}
	}
	
	function cEmpty($area, $texto) {
		$this->TAGDEFAULTS [$area] = $texto;
	}
	// Borra un tag seteado
	function cUnset($tag) {
		$this->TAGVALUES [$tag] = "";
	}
	// Borra todo lo parseado para el area que recibe
	function cClear($area) {
		if ($area == "MAIN") {
			$this->MAIN [0] = "";
		} else {
			$this->AREAINDEX [$area] [0] = "";
		}
	}
	// Borra todo lo parseado en todas las areas y los set en los tags.
	function cClear_All() {
		foreach ( $this->TAGDEFAULTS as $tag )
			$tag = "";
		foreach ( $this->TAGVALUES as $tag )
			$tag = "";
		foreach ( $this->AREAINDEX as $area )
			$area [0] = "";
		$this->MAIN [0] = "";
	}
	// Borra la estructura armada y realiza nuevamente el Init ( Se utiliza ante cambios en el html que genero la estructura
	function cUpdate() {
		$this->MAIN = "";
		$this->AREAINDEX = "";
		$this->VALUETYPES = "";
		$this->TAGVALUES = "";
		$this->TAGDEFAULTS = "";
		$this->cInit ( $this->filename );
	}
	/// Evalua el buffer recibido como un php y devuelve el resultado de la evaluacion al llamador
	function cEval($buffer) {
		ob_start ();
		eval ( $buffer );
		$buffer = ob_get_contents ();
		ob_end_clean ();
		return $buffer;
	}
}
?>