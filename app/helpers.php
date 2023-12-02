<?php
  
function dateFormat($date,$format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($format);    
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

function getMenu($onlyParent = false)
{
    $result = App\Models\Menu::select('id','title','url','icon')
    ->where('parent_id','=',NULL)
    ->orWhere('parent_id','=',0)
    ->orderBy('order')
    ->get();

    if (!$onlyParent) {
        foreach ($result as $key => $value) {
            $child = getChildMenu($value->id);
            if (!$child->isEmpty()) {
                $value->child = $child;
            }
        }
    }

    return $result;
}

function getChildMenu($parent_id)
{
    
    $result = App\Models\Menu::select('title','url','icon')
    ->where('parent_id','=',$parent_id)
    ->orderBy('order')
    ->get();

    return $result;
}