<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class Languages extends Enum implements LocalizedEnum
{
    const ENG = 0;
    const JP = 1;
    const CN = 2;
    const KP = 3;
}
