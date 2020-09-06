<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    /**
     * Clear cache
     *
     * @return string
     */
    public function clearCacheAction() {
        $artisanCalls     = [
            'cache:clear',
            'config:cache',
            'route:cache'
        ];

        // Call artisan commands without shell access
        foreach ( $artisanCalls as $call ) {
            echo 'Artisan call: ' . $call . '<br>';
            Artisan::call($call);
        }

        return 'DONE';
    }

    /**
     * Installation of Budgeteer
     *
     * @return string
     */
    public function installAction() {
        $fileFirstInstall = base_path() . '/FIRST_INSTALL';
        $fileDatabase     = base_path() . '/database/db.sqlite';
        $fileEnv          = base_path() . '/.env';

        $artisanCalls     = [
            'key:generate',
            'migrate:refresh',
            'db:seed',
            'cache:clear',
            'config:cache',
            'route:cache'
        ];

        $contentEnv       =
            #'APP_NAME=Budgeteer' . "\n" .
            'APP_ENV=production' . "\n" .
            'APP_KEY=base64:si+w68FdofmpRlXuRrEMw2K+C19F4Kpa6XRwV2P/wlE=' . "\n" .
            #'APP_DEBUG=true' . "\n" .
            'APP_URL=' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . "\n" .
            'APP_HOST=' . $_SERVER['HTTP_HOST'] . "\n" .
            #'' .  "\n" .
            #'LOG_CHANNEL=stack' . "\n" .
            #'' . "\n" .
            'DB_CONNECTION=sqlite' . "\n";# .
            #'DB_DATABASE=' . base_path() . '/database/db.sqlite' . "\n";



        if ( file_exists($fileFirstInstall) && (!file_exists($fileDatabase) || (filesize($fileDatabase) <= 0)) ) {
            // Create SQLite DB File
            if ( !file_exists($fileDatabase) ) {
                echo 'Creating DB File: ' . $fileDatabase . '<br>';
                touch($fileDatabase);
            }

            // Call artisan commands without shell access
            foreach ( $artisanCalls as $call ) {
                echo 'Artisan call: ' . $call . '<br>';
                Artisan::call($call);
            }

            // Create ENV File (AFTER artisan commands !!!!!!!)
            echo 'Creating .env file: ' . $fileEnv . '<br>';
            file_put_contents($fileEnv, $contentEnv);

            // Delete FIRST_INSTALL File
            echo 'Removing FIRST_INSTALL file<br>';
            unlink($fileFirstInstall);

            // Go to root page
            return '<b>DONE</b>';
        } elseif ( !file_exists($fileFirstInstall) ) {
            return "You need to create the FIRST_INSTALL file first";
        }

        return "Already installed";
    }
}
