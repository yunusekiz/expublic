<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('unLinkFile'))
{
	
	function unLinkFile($denek)
	{
		if (is_array($denek)) 
		{	
			$c = count($denek);
			$a = 0;
			
			foreach ($denek as $d)
			{ 
				//$full_victim = strstr(dirname(__FILE__),'application',TRUE).'/'.$d; 
				$full_victim = FCPATH.'/'.$d;

				if (unlink($full_victim)) 
				{
					$a = $a+1;
					if ($a == $c)
						return TRUE;
				}
			}

		}
		else
		{
			//$full_victim = strstr(dirname(__FILE__),'application',TRUE).'/'.$denek;
			$full_victim = FCPATH.'/'.$denek;
			if (unlink($full_victim))
				return TRUE;
			else
				return FALSE;			
		}

	}

}	