<?php

namespace LisovskayaUnittest;

use \PHPUnit\Framework\TestCase;

class QvaEquation extends \Lisovskaya\QvaEquation{
    public function getdis($a,$b,$c)
    {
        return $this->dis($a,$b,$c);
    }
}
class QvaEquationTest extends TestCase{
    protected $eqtest, $extest;

    protected function setUp(): void
    {
        $this->eqtest = new QvaEquation();
        $this->extest = \Lisovskaya\LisovskayaException::class;
    }

    protected function tearDown(): void
    {
        $this->eqtest = NULL;
        $this->extest=NULL;
    }
    /**
    * @dataProvider providerDis
    */
    public function testDis($a,$b,$c,$result)
    {
        $this->assertEquals($result,$this->eqtest->getDis($a,$b,$c));
    }
    public function providerDis()
    {
        return array(
            array(1, 10, 5, 80),
            array(5, 3, 10, -191)
        );
    }
   
    /**
    * @dataProvider providerSolve
    */
    public function testSolve($a,$b,$c,$result)
    {
        $this->assertEquals($result,$this->eqtest->solve($a,$b,$c));
    }
    public function providerSolve()
    {
        return array(
            array(1, 0, -9,[-3,3]),
            array(1, 2, 1,[-1]),
            array(4, 4, 1, [-0.5]),
            array(0, 2, 4, [-2]),
            array(0, 0, 0,[INF])
        );
    }
    /**
     * @dataProvider providerSolveError
     */
    public function testSolveError($a,$b,$c,$msg)
    {
        $this->expectExceptionMessage($msg,$this->extest);
        $this->eqtest->solve($a,$b,$c);
    }
    public function providerSolveError()
    {
        return array(
            array(5,3, 10, 'Error: no real roots'),
            array(1,10, 50, 'Error: no real roots'),
            array(0,0, 7, 'Error: eq not exist'),
            array(0,0, 8, 'Error: eq not exist')
        );
    }
}
?>