<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupSQLiteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backups:sqlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the SQLite database to a file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Define the database file path
        $database = database_path('database.sqlite');

        // Define backups file path
        $backupFile = public_path('backups/' . now()->format('Y_m_d_His') . '.sqlite');

        // Copy the SQLite database file to the backups location
        if (copy($database, $backupFile)) {
            $this->info('SQLite database backups created successfully.');
        } else {
            $this->error('Failed to create SQLite database backups.');
        }
    }
}
