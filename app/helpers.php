<?php

if(!function_exists('formatDate')){
  function formatDate($date){
    return Carbon\Carbon::createFromFormat('Y-m-d',$date)->format("d/m/Y");
  }
}


if(!function_exists('formatDateTime')){
  function formatDateTime($date){
    if($date == null)
    return '';
    return Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$date)->format("d/m/Y h:m:s");
  }
}
