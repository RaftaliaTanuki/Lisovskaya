<?php
namespace Lisovskaya;

use core\LogAbstract;
use core\LogInterface;

Class MyLog extends LogAbstract implements LogInterface {

    public function _log(String $str){
        $this->log[]=$str;
    }

    /**
     * @param String $str строка для записи в массив лога
     */
    public static function log(String $str){
        self::Instance()->_log($str);
    }

    public function _write()
    {

        $log_str='';
        foreach($this->log as $v){
            $log_str.= "{$v}\r\n";
        }
        if(!file_exists("log")){
            mkdir("log");
        }
        file_put_contents("log\\".date('d-m-Y\TH.i.s.u').'.log',rtrim($log_str));
        echo $log_str;

    }

    public static function write(){
        self::Instance()->_write();
    }

}

?>
