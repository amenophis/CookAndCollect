<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\PHPUnit;

use App\Security\Infrastructure\Symfony\Security\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\App\Security\FixturesConstants;

abstract class BaseTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;
    use ProphecyTrait;

    protected function getUser(): User
    {
        return new User(
            FixturesConstants::USER_ACTIVATED_ID,
            FixturesConstants::USER_ACTIVATED_EMAIL,
            FixturesConstants::USER_ACTIVATED_PASSWORD,
            false
        );
    }
}
