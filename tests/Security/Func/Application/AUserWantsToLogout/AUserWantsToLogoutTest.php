<?php

declare(strict_types=1);

namespace Tests\App\Security\Func\Application\AUserWantsToLogout;

use App\Security\Domain\Data\Repository\Users;
use App\Security\Infrastructure\Symfony\Security\User;
use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Tests\App\Security\FixturesConstants;

class AUserWantsToLogoutTest extends BaseTestCase
{
    public function testUserCanLogoutSuccessfully(): void
    {
        $client = $this->createClient();

        $user = static::$container->get(Users::class)->get(FixturesConstants::USER_ACTIVATED_ID);
        $client->loginUser(User::createFromUser($user));

        $client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('[data-test="page-title"]', 'Homepage');
        $this->assertSelectorTextContains('[data-test="sign-in-button"]', 'Sign in');
    }
}
