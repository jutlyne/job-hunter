<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class UserStatus extends Enum implements LocalizedEnum
{
    const ACTIVE = 1;
    const PENDING = 0;
}
