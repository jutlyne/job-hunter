<?php
    if (!function_exists('listCategoryType')) {
        function listCategoryType() {
            return [
                \App\Enums\Icon::DEVELOP => 'Developer',
                \App\Enums\Icon::INTERNET => 'Network',
                \App\Enums\Icon::MONEY => 'Finance',
                \App\Enums\Icon::CHIP => 'Hardware'
            ];
        }
    }