<?php

class SwetestTest extends \Codeception\TestCase\Test
{
    public function testConstruct()
    {
        $swetest = new DestinyLab\Swetest();
        $this->assertInstanceOf("DestinyLab\\Swetest", $swetest);
    }

}