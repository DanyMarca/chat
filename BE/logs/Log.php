<?php
namespace BE\logs;

class Log{
    
    private static $logdir = BASE_PATH . 'BE\logs\app.log';
    private static $errorlogdir = BASE_PATH . 'BE\logs\app-error.log';

    public static function info($content){
        self::write('INFO', $content);
    }

    public static function error($content){
        self::write('ERROR', $content);
    }

    private static function write($level, $content){
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date][$content]\n";
        switch ($level){

            case 'INFO':
                file_put_contents(self::$logdir, $formattedMessage, FILE_APPEND);
                break;
            case 'ERROR':
                file_put_contents(self::$errorlogdir, $formattedMessage, FILE_APPEND);
                break;
            }
        
    }
}