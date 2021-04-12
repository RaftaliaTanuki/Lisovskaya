<?php

namespace LisovskayaUnittest;

use \PHPunit\Framework\TestCase;
use \Lisovskay\MyLog;

class MyLogTest extends MyLog{
    public static function getLog()
    {
        return self::LogInterface()->log;
    }
}
class MyLogTest extends TestCase{
    public static $log=[];
    /**
     * Scans dir with additional params
     * @param dir path
     * @param exp req_exp
     * @param how string
     * @param dis bool
     * @return array
     */
    protected function _scandir($dir, $exp, $how='name', $dis=0)
    {
        $r = array();
        $dh = @opendir($dir);
        if ($dh){
            while(($fname = readdir($dh)) !== false) {
                if (preg_match($exp, $fname)) {
                    $stat = stat("$dir/$fname");
                    $r[$fname] = ($how == 'name')? $fname: $stat[$how];
                }
            }
            closedir($dh);
            if ($dis){
                arsort($r);
            }else{
                asort($r);
            }
        }
        return(array_keys($r));
    }
    public function testInstance()
    {
        $this->assertInstanceOf(\core\LogAbstract::class, MyLog::LogInterface());
    }
    /**
    * @dataProvider providerLog
    */
    public function testLog($msg)
    {
        MyLog::log($msg);
        self::$log[]=['msg'=>$msg];
        $this->assertSame(self::$log,MyLog::getLog());
    }
    public function providerLog()
    {
        return array(
            array("teststr"),
            array("test?te_123"),
            array("teststr..znhui30::\\}{;'~")
        );
    }
    /**
     * @depends testLog
     */
    public function testWrite()
    {
        $_tmpLogTxt='';
        foreach(self::$log as $value){
            $_tmpLogTxt.="{$value['msg']}\r\n";
        }
        $this->expectOutputString($_tmpLogTxt);
        MyLog::write();
        $_tmpLogTxt=rtrim($_tmpLogTxt);
        $this->assertDirectoryExists('log');
        $_tmpLogFile=$this->_scandir(
            'log\\',
            '/'.date('d-m-Y\TH').'[0-9T.]*\.log$/',
            'ctime',
            1
        )[0];
        $this->assertFileExists('log/'.$_tmpLogFile);
        $this->assertIsReadable('log/'.$_tmpLogFile);
        $this->assertStringEqualsFile('log/'.$_tmpLogFile,$_tmpLogTxt);
    }
}
?>