<?php

namespace App\Contracts;


interface Steps
{
    public function askQuestion();

    public function askExtended();
}