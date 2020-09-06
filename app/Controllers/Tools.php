<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Tools extends Controller
{
    public function message(string $to = 'World')
    {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function migrateCreate(string $migrate = 'TestMigration')
    {
        echo command('migrate:create ' . $migrate);
    }
}