<?php

if(!isset($_SESSION))
{
session_start();
echo "The session ID is " . session_id();
} else {
  echo "Session was unable to be started.";
}

?>
