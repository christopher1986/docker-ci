<?php

namespace Wefabric\Cart;

use Wefabric\Cart\Exception\IllegalStateException;

/**
 * The GumballMachine with which to obtain those delicious gumballs.
 *
 * @package Wefabric\Cart
 */
class GumballMachine {

    /**
     * The number of gumballs in this machine.
     *
     * @var int
     */
    private $gumballs;

    /**
     * Initialize a new GumballMachine.
     *
     * @param int $gumballs The initial number of gumballs, which must be greater than zero.
     */
    public function __construct(int $gumballs) {
        $this->gumballs = max($gumballs, 0);
    }

    /**
     * Returns true if the machine is out of gumballs.
     *
     * @return bool True if the machine is empty.
     */
    public function isEmpty(): bool {
        return $this->gumballs === 0;
    }

    /**
     * Turn the wheel of the machine to obtain a gumball.
     *
     * @throws IllegalStateException If the machine is empty.
     */
    public function turnWheel(): void {
        if ($this->isEmpty()) {
            throw new IllegalStateException("Unable to obtain gumball from empty machine.");
        }

        $this->gumballs--;
    }

}