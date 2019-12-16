<?php

namespace Wefabric\Cart\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Wefabric\Cart\GumballMachine;

class GumballMachineTest extends TestCase
{
    public function testWhen_MachineHasTenGumballs_Expect_ToObtainOneGumBall(): void {
        $cut = new GumballMachine(10);
        $cut->turnWheel();

        Assert::assertFalse($cut->isEmpty());
    }
}