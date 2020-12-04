<?php

declare(strict_types=1);

namespace Tests\App\Security;

final class FixturesConstants
{
    public const USER_NOT_ACTIVATED_ID               = '9b206103-1d87-4642-be6a-12ebd1c709ef';
    public const USER_NOT_ACTIVATED_FIRSTNAME        = 'Aurelie';
    public const USER_NOT_ACTIVATED_LASTNAME         = 'LEHERPEUR';
    public const USER_NOT_ACTIVATED_EMAIL            = 'aurelie@cook-and-collect.fr';
    public const USER_NOT_ACTIVATED_ACTIVATION_TOKEN = '216676a7907f42a4a85b1dc7e064a2a93a8c6af27c314027a60f3741aa2bf011';

    public const USER_NOT_ACTIVATED_BIS_ID               = 'c1512f66-7123-4ad3-9ab3-960d22ad4aed';
    public const USER_NOT_ACTIVATED_BIS_FIRSTNAME        = 'Aurelie';
    public const USER_NOT_ACTIVATED_BIS_LASTNAME         = 'LEHERPEUR';
    public const USER_NOT_ACTIVATED_BIS_EMAIL            = 'aurelie2@cook-and-collect.fr';
    public const USER_NOT_ACTIVATED_BIS_ACTIVATION_TOKEN = '85218f2203514f1f9f423b1a207a1ba082c92a0b2ee64ed3ac2131f96b9f3ba7';

    public const USER_ACTIVATED_ID               = '356bb34c-e2eb-4e99-b88c-a20e1248452b';
    public const USER_ACTIVATED_FIRSTNAME        = 'Jeremy';
    public const USER_ACTIVATED_LASTNAME         = 'LEHERPEUR';
    public const USER_ACTIVATED_EMAIL            = 'jeremy@cook-and-collect.fr';
    public const USER_ACTIVATED_PASSWORD         = 'testtest';
    public const USER_ACTIVATED_ACTIVATION_TOKEN = '9ae2825df7f749f1b1f77c9013c0eee8bff99049853346858c7fd61e7b4da943';

    private function __construct()
    {
    }
}
