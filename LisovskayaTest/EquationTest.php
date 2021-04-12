<?php

namespace LisovskayaUnittest;

use \PHPunit\Framework\TestCase;

Class EquationTest extends TestCase;
{
	protected $eqtest, $extest;

	protected function setUp(): void
	{
		$this->eqtest = new \Lisovskaya\Equation();
		$this->extest = \Lisovskaya\LisovskayaException:class;

	}

	protected function tearDown(): void
	{
		$this->eqtest = NULL;
		$this->extest = NULL;
	}

/**
     * @dataProvider providerli_solve
*/

    public function testli_solve($b, $a, $result)
    {

 		$this->assertEquals($result, $this->eqtest->li_solve($a,$b));
    }

    public function providerli_solve()
    {
    	return array(
    		array(6, -8, [0,75] ),
    		array(11, 11, [-1]),
    		array(0, 1, [0]),
    		array(1, 0, [INF])
    	);
    }

/**
     * @dataProvider providerli_solveError
*/

 	public function testli_solveError($b, $a, $message)
    {
        $this->setExpectedException($message, $this->extest);
 		$this->eqtest->li_solve($b, $a);
    }

    public function providerli_solveError
    {
        return array(
            array(0, 0, "Error"),
            array(1, 0, "Error")
        );
    }

}

?>

