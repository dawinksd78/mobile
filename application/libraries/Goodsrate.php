<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodsrate
{
    function init($price1, $price2, $price3, $complex_type, $saletype, $area=0)
    {
        $ret = array();
        if($complex_type == 'OFT')
        {
            if($area <= 85.0) {
                if($saletype == '1') $rate = $this->getRateOftBelowSale($price1);
                else $rate = $this->getRateOftBelowCharter( ($price2 + $price3*100) );
            }
            else {
                if($saletype == '1') $rate = $this->getRateOftOver($price1);
                else $rate = $this->getRateOftOver(($price2 + $price3 * 100));
            }
        }
        else
        {
            if($saletype == '1') $rate = $this->getRateAptSale($price1);
            else if($saletype == '2') {
                $rate = $this->getRateAptCharter($price2);
            }
            else {
                $price = $price2 + ($price3 * 100);
                $rate = $this->getRateAptCharter($price);
            }
        }
        
        $ret['rate'] = $rate['rate'];
        $ret['price'] = array($rate['price'] * $rate['rate'][0] / 100, $rate['price'] * $rate['rate'][1] / 100);
        $ret['percent'] = (int)($rate['rate'][1] * 100 / $rate['rate'][0]);
        
        return $ret;
    }
    
    function getRateAptSale($price)
	{
		if($price < 5000) $rateArr = array(0.6, 0.6);
        else if($price < 20000) $rateArr = array(0.5, 0.3);
        else if($price < 60000) $rateArr = array(0.4, 0.25);
        else if($price < 90000) $rateArr = array(0.5, 0.25);
        else $rateArr = array(0.9, 0.4);
        
        return array("price"=>$price, 'rate'=>$rateArr);
    }
    
    function getRateAptCharter($price)
    {
        if($price < 5000) $rateArr=array(0.5, 0.5);
        else if($price < 10000) $rateArr = array(0.4, 0.25);
        else if($price < 30000) $rateArr = array(0.3, 0.2);
        else if($price < 60000) $rateArr = array(0.4, 0.2);
        else $rateArr = array(0.8, 0.35);
        
        return array("price"=>$price, 'rate'=>$rateArr);
    }
    
    function getRateOftBelowSale($price)
    {
        if($price < 10000) $rateArr = array(0.5, 0.4);
        else $rateArr = array(0.5, 0.3);
        return array("price"=>$price, 'rate'=>$rateArr);
    }
    
    function getRateOftBelowCharter($price)
    {
        if($price < 10000) $rateArr = array(0.4, 0.3);
        else $rateArr = array(0.4, 0.25);
        
        return array("price"=>$price, 'rate'=>$rateArr);
    }
    
    function getRateOftOver($price)
    {
        if($price < 3000) $rateArr = array(0.9, 0.9);
        else if($price < 10000) $rateArr = array(0.9, 0.6);
        else $rateArr = array(0.9, 0.6);
        
        return array("price"=>$price, 'rate'=>$rateArr);
    }
}
