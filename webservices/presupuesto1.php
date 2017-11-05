<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");


$data = json_decode(file_get_contents("php://input"));

//recibe un arreglo de objetos
if(isset($data)) {
$result = 0;
foreach ($data as $objeto) {
	$result += strlen($objeto->nombre) * intval($objeto->cantidad);
}

$response = [
	"resultado" => $result
];
	echo json_encode($response);

} 
else{
	echo json_encode(
        array("message" => "No products found.")
    );
}
?>
