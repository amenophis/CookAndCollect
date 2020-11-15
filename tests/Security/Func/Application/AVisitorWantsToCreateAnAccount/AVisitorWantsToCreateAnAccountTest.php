<?php

declare(strict_types=1);

namespace Tests\App\Security\Func\Application\AVisitorWantsToCreateAnAccount;

use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Tests\App\Security\FixturesConstants;

class AVisitorWantsToCreateAnAccountTest extends BaseTestCase
{
    public function testFirstSignupSuccess(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/signup');
        $client->submitForm('Register', [
            'form[firstname]' => 'Jean',
            'form[lastname]'  => 'Dupond',
            'form[email]'     => 'jd@hotmail.fr',
        ]);

        $this->assertResponseStatusCodeSame(302);

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'Jean Dupond <jd@hotmail.fr>');
        $this->assertEmailTextBodyContains($email, 'Welcome Jean Dupond !');

        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Registration successful, please check your inbox !');
    }

    public function testSignupWithNotActivatedUserSuccess(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/signup');
        $client->submitForm('Register', [
            'form[firstname]' => FixturesConstants::USER_NOT_ACTIVATED_BIS_FIRSTNAME,
            'form[lastname]'  => FixturesConstants::USER_NOT_ACTIVATED_BIS_LASTNAME,
            'form[email]'     => FixturesConstants::USER_NOT_ACTIVATED_BIS_EMAIL,
        ]);

        $this->assertResponseStatusCodeSame(302);

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', sprintf('%s %s <%s>', FixturesConstants::USER_NOT_ACTIVATED_BIS_FIRSTNAME, FixturesConstants::USER_NOT_ACTIVATED_BIS_LASTNAME, FixturesConstants::USER_NOT_ACTIVATED_BIS_EMAIL));
        $this->assertEmailTextBodyContains($email, sprintf('Welcome %s %s !', FixturesConstants::USER_NOT_ACTIVATED_BIS_FIRSTNAME, FixturesConstants::USER_NOT_ACTIVATED_BIS_LASTNAME));

        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Registration successful, please check your inbox !');
    }

    public function testSignupWithActivatedUserSuccess(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/signup');
        $client->submitForm('Register', [
            'form[firstname]' => FixturesConstants::USER_ACTIVATED_FIRSTNAME,
            'form[lastname]'  => FixturesConstants::USER_ACTIVATED_LASTNAME,
            'form[email]'     => FixturesConstants::USER_ACTIVATED_EMAIL,
        ]);

        $this->assertResponseStatusCodeSame(302);

        $this->assertEmailCount(0);

        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Registration successful, please check your inbox !');
    }

    /**
     * @dataProvider provideSignupFormValidationErrors
     */
    public function testSignupFormValidationErrors(string $fieldname, string $value, string $expectedError): void
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
    public function provideSignupFormValidationErrors(): iterable
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
