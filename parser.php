<?
define ("IS_PARSER_INCLUDED", true);

$jsonSrc = 'https://www.sknt.ru/job/frontend/data.json';
$jsonData = file_get_contents($jsonSrc);
$decodedJson = json_decode($jsonData, true);

/*
echo '<pre>';
print_r($decodedJson);
echo '</pre>';
*/