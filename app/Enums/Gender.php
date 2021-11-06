<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class Gender extends Enum implements LocalizedEnum
{
    const MALE_FEMALE = 0;
    const FEMALE = 1;
    const MALE = 2;
}
