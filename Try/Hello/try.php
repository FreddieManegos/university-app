<?php 
function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}

function php_to_postgres_array( $phpArray){

	return "{".join(",",$phpArray)."}";

}

$tmp = "{1,2,3}";
print_r (postgres_to_php_array($tmp))
?>