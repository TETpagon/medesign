<?php 

namespace MeDesign\core;

class Model
{
    protected $configDb;

    public function __construct()
    {
        $this->configDb = \MeDesign\core\Application::$config['db'];
    }

    public function getPDO() : \PDO 
    {
        $host = '127.0.0.1';
        $db   = 'medesign';
        $user = 'anicomic';
        $pass = 'anicomic';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new \PDO($dsn, $user, $pass, $opt);
    }
}
