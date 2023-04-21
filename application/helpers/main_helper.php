<?php 	


function test()
{
	echo "hdhc";
	exit;
}

function pret($data=[],$status=false){
	echo '<pre>';
	print_r($data);
	if($status){
		exit;
	}
}

 ?>