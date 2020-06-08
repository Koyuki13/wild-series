<?php

namespace App\Service;

class Slugify
{
    public function generate(string $input): string
    {

        $input = preg_replace(' ', '-', $input);

    }
}