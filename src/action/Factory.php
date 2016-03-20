<?php
namespace fastblocks\core\action;

/**
 * Factory de Command
 * Respons�vel por retornar o Command que ser� executado
 *
 * @author Silvio Queiroz
 */
class Factory
{

    static function createAction($actionName)
    {
        // TODO: adicionar log ao factory.
        $sufixAction = "Action";
        $actionName = $actionName . $sufixAction;
        return new $actionName();
    }
}
?>