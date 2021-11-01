<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class BlogStatus extends Enum implements LocalizedEnum
{
    const ACTIVE = 0;
    const IN_ACTIVE = 1;
    const DRAFT = 2;
}
