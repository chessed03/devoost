<?php
namespace App\Traits;

trait Number {

    protected $list;

    public function setList(array $list)
    {
        $this->list = $list;
    }

    public function find(int $num)
    {
        $lower  = 'X';
        $higher = 'X';

        foreach ($this->list as $n) {
            if ($n < $num) {
                $lower = $n;
            } elseif ($n > $num) {
                $higher = $n;
                break;
            }
        }

        $newLower  = trim($lower);
        $newHigher = trim($higher);

        return "{$newLower} {$newHigher}";
    }

}
