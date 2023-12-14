<?php
  
function dateTimeFormat($date){
    return \Carbon\Carbon::parse($date)->format('d/m/Y g:i A');    
}

function trimString($string, $repl, $limit) 
{
  if(strlen($string) > $limit) 
  {
    return substr($string, 0, $limit) . $repl; 
  }
  else 
  {
    return $string;
  }
}

function sluggify($string)
{
   return strtolower(str_replace(" ","-",$string));
}

function generateUuid()
{
   return Illuminate\Support\Str::uuid();
}

function numberSpacer($str, $separator = ' ') {
  return wordwrap($str, 4, $separator, true);
}

function formatAmount($str, $separator = '.') {
  return 'Rp '.number_format($str,0,".",".");
}

function generateCode($prefix, $suffix = '-') {
  $characters = '0123456789';
  $suffix = $suffix === '-' ? substr(str_shuffle($characters), 0, 3) : $suffix;
  $date = \Carbon\Carbon::now()->format('ymdHi');
  return $prefix.$date.$suffix;
}

function dateTimeRangeFormatToSave($date){
  return \Carbon\Carbon::createFromFormat('d/m/Y g:i A', trim($date))->toDateTimeString();
}