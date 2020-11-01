<?php

declare(strict_types=1);

namespace Tests\App\Shared\Func\Application\Homepage;

use App\Shared\Infrastructure\PHPUnit\BaseTestCase;

class HomepageTest extends BaseTestCase
{
    public function testPageLoad(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
