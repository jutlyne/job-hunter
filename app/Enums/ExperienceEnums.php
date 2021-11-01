<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class ExperienceEnums extends Enum implements LocalizedEnum
{
    const LITTLE = 0;
    const MEDIUM = 1;
    const HIGHT = 2;
    const MASTER = 3;
}
