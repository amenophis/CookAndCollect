<?php

declare(strict_types=1);

namespace Tests\App\User\Func\Application\UserActivate;

use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Fixtures\User\Constants;

class UserActivateTest extends BaseTestCase
{
    /**
     * @dataProvider provideUserActivateSuccessfully
     */
    public function testUserActivateSuccessfully(string $userId, string $activationToken): void
    {
        $client = $this->createClient();
        $client->request('GET', "/user/{$userId}/activate/{$activationToken}");
        $client->submitForm('Activate', [
            'form[plainPassword][first]'  => 'aaaaaaaa',
            'form[plainPassword][second]' => 'aaaaaaaa',
        ]);
        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Your user is activated !');
    }

    /**
     * @return iterable<array>
     */
    public function provideUserActivateSuccessfully(): iterable
    {
        yield 'Not activated user' => [
            Constants::USER_NOT_ACTIVATED_ID,
            Constants::USER_NOT_ACTIVATED_ACTIVATION_TOKEN,
        ];
        yield 'Already activated user' => [
            Constants::USER_ACTIVATED_ID,
            Constants::USER_ACTIVATED_ACTIVATION_TOKEN,
        ];
        yield 'Not existing user' => [
            '7cf23e15-6ea7-46c5-9232-e53d6b2bb272',
            '51f2fed6493e4ca09121ae29db4e3d5dbce2784fb0e54e52a1e6e714be3d9387',
        ];
    }

    /**
     * @dataProvider provideUserActivateFormValidationErrors
     */
    public function testUserActivateFormValidationErrors(string $first, string $second, ?string $expectedFirstError = null, ?string $expectedSecondError = null): void
    {
        $userId              = Constants::USER_NOT_ACTIVATED_ID;
        $userActivationToken = Constants::USER_NOT_ACTIVATED_ACTIVATION_TOKEN;

        $client = $this->createClient();
        $client->request('GET', "/user/{$userId}/activate/{$userActivationToken}");
        $client->submitForm('Activate', [
            'form[plainPassword][first]'  => $first,
            'form[plainPassword][second]' => $second,
        ]);

        $this->assertResponseStatusCodeSame(200);
        if (null !== $expectedFirstError) {
            $this->assertSelectorTextContains('#form_plainPassword_first_errors', $expectedFirstError);
        }
        if (null !== $expectedSecondError) {
            $this->assertSelectorTextContains('#form_plainPassword_second_errors', $expectedSecondError);
        }
    }

    /**
     * @return iterable<array>
     */
    public function provideUserActivateFormValidationErrors(): iterable
    {
        yield 'password should not be blank' => [
            '',
            '',
            'This value should not be blank.',
        ];

        yield 'second password must match second password' => [
            'a',
            '',
            'This value is not valid.',
        ];

        yield 'first password must match first password' => [
            '',
            'a',
            'This value is not valid.',
        ];

        yield 'password should be at least 8 chars' => [
            'a',
            'a',
            'This value is too short. It should have 8 characters or more.',
        ];

        yield 'password should be at most 8 chars' => [
            str_repeat('a', 65),
            str_repeat('a', 65),
            'This value is too long. It should have 64 characters or less.',
        ];
    }
}
