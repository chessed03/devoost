<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Traits\Number;

class NumberTest extends TestCase
{

    private $objectUsingTrait;

    protected function setUp(): void
    {

        $this->objectUsingTrait = new class {
            use Number;
        };

    }

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_find_numbers()
    {
        $this->objectUsingTrait->setList([2, 4, 5, 7, 9]);
        // dd($this->objectUsingTrait->find(2)); // Output: X 4

        $this->objectUsingTrait->setList([2, 4, 5, 7, 9]);
        // dd($this->objectUsingTrait->find(5)); // Output: 4 7

        $this->objectUsingTrait->setList([2, 4, 5, 7, 9]);
        // dd($this->objectUsingTrait->find(6)); // Output: 5 7

        $this->objectUsingTrait->setList([2, 4, 5, 7, 9]);
        // dd($this->objectUsingTrait->find(10)); // Output: 9 X
    }

    public function test_process_array()
    {
        $result         = [];
        $eval_number    = 5;
        $base_numbers   = "2, 4, 5, 7, 9";
        $eval_iteration = 4;
        $list_numbers   = "2 5 6 10";

        $this->objectUsingTrait->setList(explode(",", $base_numbers));

        $array_numbers = explode(" ", $list_numbers);

        for ($i = 0; $i < $eval_iteration; $i++) {

            $result[] = $this->objectUsingTrait->find($array_numbers[$i]);

        }

        dd($result);
    }

}
