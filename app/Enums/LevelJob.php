<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class LevelJob extends Enum implements LocalizedEnum
{
    const INTERN = 0;
    const FRESHER = 1;
    const JUNIOR = 2;
    const SENIOR = 3;
    const LEADER = 4;
    const MANAGER = 5;
    const SENIOR_LEADER = 6;
}
