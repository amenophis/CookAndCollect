<?php

declare(strict_types=1);

namespace Tests\App\Security\Func\Application\AUserWantsToLogin;

use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Tests\App\Security\FixturesConstants;

class AUserWantsToLoginTest extends BaseTestCase
{
    public function testUserCanLoginSuccessfully(): void
    {
        $client = $this->createClient();

        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'email'    => FixturesConstants::USER_ACTIVATED_EMAIL,
            'password' => FixturesConstants::USER_ACTIVATED_PASSWORD,
        ]);
        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('[data-test="page-title"]', 'Welcome jeremy@cook-and-collect.fr !');
    }

    /**
     * @dataProvider provideLoginFormValidationErrors
     */
    public function testSignupFormValidationErrors(string $fieldname, string $value, string $expectedError): void
    {
        $formData = [
            'email'    => FixturesConstants::USER_ACTIVATED_EMAIL,
            'password' => FixturesConstants::USER_ACTIVATED_PASSWORD,
        ];

        $formData[$fieldname] = $value;

        $client = $this->createClient();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', $formData);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('[data-test="sign-in-error"]', $expectedError);
    }

    /**
     * @return iterable<array>
     */
    public function provideLoginFormValidationErrors(): iterable
    {
        yield 'email not found' => [
            'email',
            'bad@cook-and-collect.fr',
            'Username could not be found.',
        ];

        yield 'bad password' => [
            'password',
            'bad',
            'Invalid credentials.',
        ];
    }
}
