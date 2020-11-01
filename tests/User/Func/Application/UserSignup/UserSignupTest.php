<?php

declare(strict_types=1);

namespace Tests\App\User\Func\Application\UserSignup;

use App\Shared\Infrastructure\PHPUnit\BaseTestCase;

class UserSignupTest extends BaseTestCase
{
    public function testSignupFarmSuccess(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/signup');
        $client->submitForm('Register', [
            'form[firstname]' => 'Jeremy',
            'form[lastname]'  => 'Leherpeur',
            'form[email]'     => 'jeremy@click-and-collect.com',
        ]);

        $this->assertResponseStatusCodeSame(302);

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'Jeremy Leherpeur <jeremy@click-and-collect.com>');
        $this->assertEmailTextBodyContains($email, 'Welcome Jeremy Leherpeur !');

        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Registration successful, please check your inbox !');
    }

    /**
     * @dataProvider provideSignupFarmFormValidationErrors
     */
    public function testSignupFarmFormValidationErrors(string $fieldname, string $value, string $expectedError): void
    {
        $formData = [
            'form[firstname]' => 'Jeremy',
            'form[lastname]'  => 'Leherpeur',
            'form[email]'     => 'jeremy@click-and-collect.com',
        ];

        $formData["form[{$fieldname}]"] = $value;

        $client = $this->createClient();
        $client->request('GET', '/signup');
        $client->submitForm('Register', $formData);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains("#form_{$fieldname}_errors", $expectedError);
    }

    /**
     * @return iterable<array>
     */
    public function provideSignupFarmFormValidationErrors(): iterable
    {
        yield 'firstname should not be blank' => [
            'firstname',
            '',
            'This value should not be blank.',
        ];

        yield 'firstname should be at least 2 chars' => [
            'firstname',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'firstname should be at most 64 chars' => [
            'firstname',
            str_repeat('a', 65),
            'This value is too long. It should have 64 characters or less.',
        ];

        yield 'lastname should not be blank' => [
            'lastname',
            '',
            'This value should not be blank.',
        ];

        yield 'lastname should be at least 2 chars' => [
            'lastname',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'lastname should be at most 64 chars' => [
            'lastname',
            str_repeat('a', 65),
            'This value is too long. It should have 64 characters or less.',
        ];

        yield 'email should not be blank' => [
            'email',
            '',
            'This value should not be blank.',
        ];

        yield 'email should be a valid email address' => [
            'email',
            'a',
            'This value is not a valid email address.',
        ];
    }
}
