<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Salary Constants
    |--------------------------------------------------------------------------
    |
    | These values must be used everywhere (service, controllers, reporting).
    | Do not hardcode salary math in any other place.
    |
    */
    'basic_salary' => 20000,
    'allowance' => 8000,

    // Commission tiers
    'tier1_cap' => 1200000,
    'tier1_rate' => 0.02,
    'tier2_rate' => 0.03,

    // Bonus
    'bonus_threshold' => 1500000,
    'bonus_amount' => 20000,

    // Profitability rule
    'cost_ratio' => 0.60,
];

