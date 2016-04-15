<?php
include "set_sessionvars.php";
include "getsessionvars.php";
echo "USD=" . $user_photodir . "<BR>";
$target_dir=$user_photodir ;
echo "U dir=" . $user_photodir . "<BR>";
echo "T dir=" . $target_dir . "<BR>";
if (! file_exists($target_dir)){
	if(mkdir($target_dir)){
		echo "The directory " . $target_dir . " was created<BR>";
	}
	else {
		echo "The directory " . $target_dir . " failed<BR>";
	}
}
else {	
		echo "The directory " . $target_dir . " exists<BR>";
}

?>