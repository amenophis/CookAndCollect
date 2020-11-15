<?php

declare(strict_types=1);

namespace Tests\App\Security\Func\Application\AUserWantsToShowHisProfile;

use App\Security\Domain\Data\Repository\Users;
use App\Security\Infrastructure\Symfony\Security\User;
use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Tests\App\Security\FixturesConstants;

class AUserWantsToShowHisProfileTest extends BaseTestCase
{
    public function testUserCanShowHisProfileSuccessfully(): void
    {
        $client = $this->createClient();

        $user = static::$container->get(Users::class)->get(FixturesConstants::USER_ACTIVATED_ID);
        $client->loginUser(User::createFromUser($user));

        $client->request('GET', '/profile');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', "Welcome {$user->getEmail()} !");
    }
}
