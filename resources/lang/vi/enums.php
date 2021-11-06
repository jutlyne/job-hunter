<?php

use App\Enums\ApplicationStatus;
use App\Enums\Icon;
use App\Enums\LimitEnums;
use App\Enums\EducationLevels;
use App\Enums\ExperienceEnums;
use App\Enums\Languages;
use App\Enums\Prioritize;

return [

    ApplicationStatus::class => [
        ApplicationStatus::PENDING => 'Applied',
        ApplicationStatus::FINISHED => 'Accept',
        ApplicationStatus::CANCELED => 'Refuse',
        ApplicationStatus::OUTDATED => 'Expired',
    ],

    Icon::class => [
        Icon::DEVELOP => 'fa fa-code',
        Icon::INTERNET => 'fab fa-internet-explorer',
        Icon::MONEY => 'fa fa-money-bill-alt',
        Icon::CHIP => 'far fa-microchip',
    ],

    LimitEnums::class => [
        LimitEnums::LITTLE_PAGE => '12 Per Page',
        LimitEnums::MEDIUM_PAGE => '24 Per Page',
        LimitEnums::HIGHT_PAGE => '36 Per Page'
    ],

    EducationLevels::class => [
        EducationLevels::JUNIOR_HIGHT_SCHOOL => 'Junior Hight School',
        EducationLevels::HIGHT_SCHOOL => 'Hight School',
        EducationLevels::COLLEGE => 'College',
        EducationLevels::UNIVERSITY => 'University'
    ],

    ExperienceEnums::class => [
        ExperienceEnums::LITTLE => 'From 6 months - 1 year',
        ExperienceEnums::MEDIUM => 'From 1 year - 3 years',
        ExperienceEnums::HIGHT => 'From 3 years - 5 years',
        ExperienceEnums::MASTER => 'Over 5 years'
    ],

    Languages::class => [
        Languages::ENG => 'English',
        Languages::JP => 'Japanese',
        Languages::CN => 'Chinese',
        Languages::KP => 'Korean'
    ],

    Prioritize::class => [
        Prioritize::ACTIVE => 'On Prioritize',
        Prioritize::IN_ACTIVE => 'Off Prioritize'
    ]
];