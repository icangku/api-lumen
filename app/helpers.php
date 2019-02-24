<?php

function addTime($interval, $unit){
    return date("Y-m-d H:i:s", strtotime("+".$interval." ".$unit.'s'));
}