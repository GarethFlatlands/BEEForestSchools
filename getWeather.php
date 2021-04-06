<?php
if(!isset($_SESSION))
{
session_start();
}
//If no session variable exists for the main weather, get it
if ($_SESSION["main_weather"] === null) {
  $apikey = '89555058c09838b3c5455e52a205f9a6';
  $open_weather = fopen("http://api.openweathermap.org/data/2.5/weather?lat=53.3821&lon=-1.5614&appid=$apikey", 'r');
  $json_weather = stream_get_contents($open_weather);
  fclose($open_weather);
  //JSONify the data
  $weather_data = json_decode($json_weather);
  //Pass the general and temperature data to the session
  $_SESSION["main_weather"] = $weather_data->weather[0]->main;
  $_SESSION["current_temp"] = round($weather_data->main->temp - 273.15, 2);
}
?>
