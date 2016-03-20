<?php
namespace fastblocks\logger;

use fastblocks\core\application\Configuration;

class LoggerFactory
{

    private static $configPath = "app.config/log.ini";

    const LEVEL_PROPERTY = "level";

    const TYPE_PROPERTY = "type";

    const PATH_PROPERTY = "path";

    private static $level;

    private static $type;

    private static $path;

    private static $logger;

    public static function getLogger($clazz = null)
    {
        // TODO: o padr�o do log deve ser melhorado para identificar a classe que esta inserindo o log.
        // TODO: deve ser removido o padr�o singleton. cada classe deve ter seu log.
        if (self::$logger == null) {
            // load definitions
            $log_properties = Configuration::CONNECTION_PROPERTIES();
            // adicionar verifica��o de n�vel debug para apresenta��o dos dados na p�gina debug
            echo 'load definitions <br/>';
            echo '$LOG_PROPERTIES::level : ' . $log_properties["level"];
            echo '$log_properties::level : ' . $log_properties["level"];
            self::$level = $log_properties[self::LEVEL_PROPERTY];
            echo $log_properties[self::TYPE_PROPERTY];
            self::$type = $log_properties[self::TYPE_PROPERTY];
            self::$path = $log_properties[self::PATH_PROPERTY];
            echo LoggerFactory::$type;
            // create logger
            self::$logger = new LoggerFactory::$type(self::$path);
            self::$logger->setLevel(self::$level);
            self::$logger->setClazz($clazz);
        }
        return self::$logger;
    }
}

?>