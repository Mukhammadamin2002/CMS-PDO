<?php
$arr = [4,5,6,7,8,2,9];
$val = $arr[0];
$n = count($arr);

for($i=1;$i<$n;$i++) {
if($val<$arr[$i]) {
    $val = $val;        
	} else {
	    $val = $arr[$i];
	}
}
print($val);