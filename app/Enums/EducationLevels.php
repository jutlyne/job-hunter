<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class EducationLevels extends Enum implements LocalizedEnum
{
    const JUNIOR_HIGHT_SCHOOL = 0;
    const HIGHT_SCHOOL = 1;
    const COLLEGE = 2;
    const UNIVERSITY = 3;
}
