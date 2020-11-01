<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\PHPUnit;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;
}
