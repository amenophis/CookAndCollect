<?php

declare(strict_types=1);

namespace Tests\App\Restaurant\Func\Application\AUserWantsToCreateARestaurant;

use App\Restaurant\Domain\Data\Exception\UnableToAddRestaurant;
use App\Restaurant\Domain\Data\Repository\Restaurants;
use App\Restaurant\Infrastructure\Doctrine\ORM\Repository\RestaurantRepository;
use App\Shared\Infrastructure\PHPUnit\BaseTestCase;
use Prophecy\Argument;

class AUserWantsToCreateARestaurantTest extends BaseTestCase
{
    public function testRegisterSuccess(): void
    {
        $client = $this->createClient();
        $client->loginUser($this->getUser());

        $client->request('GET', '/restaurant/register');
        $client->submitForm('Register', [
            'form[restaurantName]' => 'La casinière',
        ]);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('.flash', 'Your restaurant is registered !');
    }

//    public function testRegisterAddFail(): void
//    {
//        $client = $this->createClient();
//
//        $mock = $this->prophesize(Restaurants::class);
//        $mock->add(Argument::any())->willThrow(new UnableToAddRestaurant(new \Exception('Exception')));
////        $mock->findByOwner(Argument::any())->willReturn(null)->shouldBeCalled();
//
//        $client->getContainer()->set('test.'.RestaurantRepository::class, $mock->reveal());
//
//        $client->loginUser($this->getUser());
//
//        $client->request('GET', '/restaurant/register');
//        $client->submitForm('Register', [
//            'form[restaurantName]' => 'La casinière',
//        ]);
//
//        $this->assertResponseStatusCodeSame(302);
//        $client->followRedirect();
//
//        $this->assertResponseStatusCodeSame(200);
//        $this->assertSelectorTextContains('[data-test="flash-success"]', 'Your restaurant is registered !');
//    }

    /**
     * @dataProvider provideSignupFormValidationErrors
     */
    public function testRegisterValidationErrors(string $fieldname, string $value, string $expectedError): void
    {
        $formData = [
            'form[restaurantName]' => 'La Casinière',
        ];

        $formData["form[{$fieldname}]"] = $value;

        $client = $this->createClient();
        $client->loginUser($this->getUser());
        $client->request('GET', '/restaurant/register');
        $client->submitForm('Register', $formData);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains("#form_{$fieldname}_errors", $expectedError);
    }

    /**
     * @return iterable<array>
     */
    public function provideSignupFormValidationErrors(): iterable
    {
        yield 'restaurantName should not be blank' => [
            'restaurantName',
            '',
            'This value should not be blank.',
        ];

        yield 'restaurantName should be at least 2 chars' => [
            'restaurantName',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'restaurantName should be at most 64 chars' => [
            'restaurantName',
            str_repeat('a', 65),
            'This value is too long. It should have 64 characters or less.',
        ];
    }
}
