<?php
namespace App\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger {
    private static ?Logger $logger = null;

    public static function getLogger(): Logger {
        if (self::$logger === null) {
            $logger = new Logger('app');
            $logPath = __DIR__ . '/../../logs/app.log';

            if (!is_dir(dirname($logPath))) {
                mkdir(dirname($logPath), 0777, true);
            }

            $logger->pushHandler(new StreamHandler($logPath, Logger::DEBUG));
            self::$logger = $logger;
        }

        return self::$logger;
    }
}
