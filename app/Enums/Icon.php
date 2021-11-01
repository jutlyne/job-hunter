<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class Icon extends Enum implements LocalizedEnum
{
    const DEVELOP = 0;
    const INTERNET = 1;
    const MONEY = 2;
    const CHIP = 3;
}
