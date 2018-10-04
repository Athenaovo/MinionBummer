<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/16
 * Time: 15:29
 */

namespace Bummer;


class CardView
{
    public function __construct() {
    }
    public function presentClass($num){
        $this->cardNum = $num;
        $html="card";
        if($this->cardNum ==1){
            $html .= '1';
        }
        elseif ($this->cardNum ==2){
            $html .= '2';
        }
        elseif($this->cardNum ==3){
            $html .= '3';
        }
        elseif ($this->cardNum ==4){
            $html .= '4';
        }
        elseif ($this->cardNum ==5){
            $html .= '5';
        }
        elseif ($this->cardNum ==7){
            $html .= '7';
        }
        elseif ($this->cardNum ==8){
            $html .= '8';
        }
        elseif ($this->cardNum ==10){
            $html .= '10';
        }
        elseif ($this->cardNum ==11){
            $html .= '11';
        }
        elseif ($this->cardNum ==12){
            $html .= '12';
        }
        elseif ($this->cardNum ==13){
            $html .= 'bummer';
        }
        else{
            $html .= 'back';
        }
        return $html;
    }



    private $cardNum;
}
