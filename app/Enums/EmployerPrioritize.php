<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class EmployerPrioritize extends Enum implements LocalizedEnum
{
    const NONE = 0;
    const PARTNER = 1;
}
