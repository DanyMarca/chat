<?php
namespace BE;

require_once 'BE\config.php';
require_once 'BE\database\Migration.php';
require_once 'BE\seeding\Seeder.php';

use BE\database\Migration;
use BE\seeding\Seeder;

class cli{
    private $commandList = [
        'list' => 'Visualizza la lista dei comandi',
        'migrate' => 'Esegui la migrazione',
        'dropTables' => 'Droppa tutte le tabelle',
        'seed' => 'Esegui il seeding dei dati'
    ];

    private $flagsList = [
        '--seed' => 'flag per il seeding',
        '--fresh' => 'flag per droppare le tabelle',
    ];

    public function handle($argv){
        $command = $argv[1] ?? null;
        $options = $this->parseOption($argv);

        switch($command){
            case 'list':
                $this->listcommands();
                break;

            case 'migrate':
                $this->migrate($options);
                break;

            case 'dropTables':
                $this->dropTables();
                break;

            case 'seed':
                $this->seed();
                break;

            case 'test':
                require 'BE\test_json.php';
                break;

            case 'dir':
                echo BASE_PATH;
                break;

            default:
                $this->invalidCommand($command);
                break;
        }
    }

    private function parseOption($argv){
        $options = [];

        foreach($argv as $index => $arg){
            if($index>1 && strpos($arg, '--') === 0 ){
                $options[] = substr($arg, 2);
            }
        }
        return $options;
    }

    private function migrate($options){
        $migrate = new Migration;

        if(in_array('fresh',$options)){
            $migrate->dropDB();
        }
        $migrate->migrateDB();

        if(in_array('seed',$options)){
            $this->seed();
        }
    }

    private function dropTables(){
        $migrate = new Migration;
        $migrate->dropDB();
    }

    private function seed(){
        Seeder::factoryDB();
    }

    private function listCommands(){
        echo "Comandi disponibili:\n";
        foreach($this->commandList as $cmd => $desc){
            echo "$cmd: $desc\n";
        }
        echo "\nflags disponibbili:\n";
        foreach($this->flagsList as $flag => $desc){
            echo "$flag: $desc\n";
        }
    }

    private function invalidCommand($command) {
        echo "\nComando non riconosciuto: $command\n";
        $this->listCommands();
    }
}

$cli = new CLI();
$cli->handle($argv);
unset($cli);