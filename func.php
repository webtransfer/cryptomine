<?
	function clean($var){
        $replace = array(
						'"' => '', 
						"'" => '', 
						'`' => '', 
						'{' => '', 
						'}' => '', 
						'<' => '', 
						'>' => '',
						'%' => '',
						'[' => '',
						']' => ''
						
						
						);
        
        return @htmlspecialchars(str_replace(array_keys($replace), array_values($replace), trim($var)));
        unset($var, $replace);
    }
	
	function IsMail($mail){
		
		if(is_array($mail) && empty($mail) && strlen($mail) > 255 && strpos($mail,'@') > 64) return false;
			return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) ? false : strtolower($mail);
			
	}
	
	
	function md5pass($var)
	{
		return md5('dsdswqeqgsdwegsdqww'.$var);
	}
	
	function success($var)
	{
		return '<div class="alert alert-success">'.$var.'</div>';
	}
	
	function error($var)
	{
		return '<div class="alert alert-danger">'.$var.'</div>';
	}
	
function generate_password($number)
{
$arr = array('a','b','c','d','e','f',
			 'g','h','i','j','k','l',
			 'm','n','o','p','r','s',
			 't','u','v','x','y','z',
			 'A','B','C','D','E','F',
			 'G','H','I','J','K','L',
			 'M','N','O','P','R','S',
			 'T','U','V','X','Y','Z',
			 '1','2','3','4','5','6',
			 '7','8','9','0');
// Генерируем пароль
$pass = "";
for($i = 0; $i < $number; $i++)
{
  // Вычисляем случайный индекс массива
  $index = rand(0, count($arr) - 1);
  $pass .= $arr[$index];
}
return $pass;
}
	
?>