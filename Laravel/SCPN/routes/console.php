<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('backups:sqlite', function () {
    $database = database_path('database.sqlite');
    $backupFile = public_path('backups/' . now()->format('Y_m_d_His') . '.sqlite');

    if (copy($database, $backupFile)) {
        $this->info('SQLite database backups created successfully.');
    } else {
        $this->error('Failed to create SQLite database backups.');
    }
})->everyOddHour();

