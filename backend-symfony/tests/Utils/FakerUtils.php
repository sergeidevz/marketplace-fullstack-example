<?php


declare(strict_types=1);


namespace App\Tests\Utils;

use Faker\Factory;

trait FakerUtils
{
    public function getFaker() {
        return Factory::create();
    }
}
