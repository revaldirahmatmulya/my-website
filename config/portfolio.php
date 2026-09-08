<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Personal Portfolio Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for personal portfolio information.
    | Values can be customized here or via .env variables.
    |
    */

    'name' => env('PORTFOLIO_NAME', 'Aldi'),
    'role' => env('PORTFOLIO_ROLE', 'Full Stack Web Developer'),
    'bio' => env('PORTFOLIO_BIO', 'Passionate web developer specializing in building modern, performant, and elegant digital solutions with Laravel, modern frontend ecosystems, and clean architectural design.'),
    'email' => env('PORTFOLIO_EMAIL', 'aldi@example.com'),
    'github_url' => env('PORTFOLIO_GITHUB_URL', 'https://github.com'),
    'linkedin_url' => env('PORTFOLIO_LINKEDIN_URL', 'https://linkedin.com'),
    'status' => env('PORTFOLIO_STATUS', 'Available for new projects & opportunities'),
    'location' => env('PORTFOLIO_LOCATION', 'Indonesia'),
];
