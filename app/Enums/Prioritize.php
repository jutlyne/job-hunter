<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class Prioritize extends Enum implements LocalizedEnum
{
    const ACTIVE = 1;
    const IN_ACTIVE = 0;
}
