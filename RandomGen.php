<?php
/**
 * RandomGen.php
 *
 * This file contains the RandomGen class.
 *
 * @file       RandomGen.php
 * @author     Bill Parrott <bill@chimericdream.com>
 * @date       09/18/2013
 * @version    1.1
 */

class RandomGen
{
    private $seed;

    /**
     * __construct()
     *
     * This constructor initializes the pseudo-random number generator with
     * either a user-specified seed or a random one chosen by PHP.
     *
     * @return self Returns itself to allow method chaining
     */
    public function __construct($s = NULL) {
        $this->setSeed($s);
        return $this;
    } //end __construct


    /**
     * getBetween()
     *
     * Gets a random number between the specified min and max numbers.
     *
     * @param int max The high end of the range
     * @param int min The low end of the range; defaults to 0
     * @return int A pseudo-random number between min and max
     */
    public function getBetween($max, $min = 0) {
        $rangeSize = $max - $min;
        return $this->get() % $rangeSize + $min;
    } //end getBetween


    /**
     * getPercent()
     *
     * Gets a random number between 0 and 1.
     *
     * @return double A pseudo-random number between 0 and 1
     */
    public function getPercent() {
        return ($this->getBetween(0, 100) / 100.0);
    } //end getPercent


    /**
     * get()
     *
     * Gets a random number between 0 and RAND_MAX.
     *
     * @return int A pseudo-random number
     */
    public function get() {
        if (function_exists('mt_rand')) {
            return mt_rand();
        } else {
            return rand();
        }
    } //end get


    /**
     * scramble()
     *
     * This function sets the seed to a random number.
     *
     * @return self Returns itself to allow method chaining
     */
    public function scramble() {
        if (function_exists('mt_srand')) {
            mt_srand();
        } else {
            srand();
        }
        $this->setSeed($this->get());
        return $this;
    } //end scramble


    /**
     * setSeed()
     *
     * This function sets a new seed to be used used by the generator.
     *
     * @param int s The new seed for srand()/mt_srand().
     * @return self Returns itself to allow method chaining
     */
    public function setSeed($s = NULL) {
        $this->seed = $s;
        if (function_exists('mt_srand')) {
            mt_srand($this->seed);
        } else {
            srand($this->seed);
        }
        return $this;
    } //end setSeed


    /**
     * getSeed()
     *
     * This function returns the seed currently being used by the generator.
     *
     * @return int The current seed.
     */
    public function getSeed() {
        return $this->seed;
    } //end getSeed


    /**
     * fillArray()
     *
     * This function fills an array of size n with random numbers between
     * min and max.
     *
     * @param array arr The array to fill with random values.
     * @param int min   The lower bound of the random numbers; defaults to 0
     * @param int max   The upper bound of the random numbers; defaults to
     *                  RAND_MAX
     * @return array    The array filled with random numbers.
     */
    public function fillArray(array $arr, $min = 0, $max = NULL) {
        if (is_null($max)) {
            if (function_exists('mt_getrandmax')) {
                $max = mt_getrandmax();
            } else {
                $max = getrandmax();
            }
        }
        $size = count($arr);
        for ($i = 0; $i < $size; $i++) {
            $arr[$i] = $this->getBetween($min, $max);
        }
        return $arr;
    } //end fillArray
} //end class RandomGen