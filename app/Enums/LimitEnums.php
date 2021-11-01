<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class LimitEnums extends Enum implements LocalizedEnum
{
    const LITTLE_PAGE = 12;
    const MEDIUM_PAGE = 24;
    const HIGHT_PAGE = 36;
}
