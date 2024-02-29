<?php
// https://developer.paypal.com/developer/accounts
//Example array.
$array = $_POST;
//Encode the array into a JSON string.
$encodedString = json_encode($array);
//Save the JSON string to a text file.
file_put_contents('myfile.txt', $encodedString);
// //Retrieve the data from our text file.
// $fileContents = file_get_contents('myfile.txt');
// //Convert the JSON string back into an array.
// $decoded = json_decode($fileContents, true);
// //The end result.
// var_dump($decoded);
