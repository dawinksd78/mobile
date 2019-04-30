<?php
function priceFormat($mny, $default_price = 10000)
{
    $mny = floor((int)$mny*$default_price/10000);
    
    if($mny == 0) return "0";
    
    $mny = (string)$mny;
    $len = strlen($mny);
    if($len <= 4) return $mny;
    
    $price1 = substr($mny, 0, ($len-4));
    $price2 = substr($mny,-4);
    if((int)$price2 == 0) return $price1."억";
    else if((int)$price2[1]==0 && (int)$price2[2]==0 && (int)$price2[3]==0) return $price1.".".$price2[0]."억";
    else return $price1."억".( (int)$price2 );
}
?>
