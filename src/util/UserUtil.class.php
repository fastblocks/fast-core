<?php
namespace fastblocks\core\util;

use fastblocks\core\context\Context;

class UserUtil
{

    /**
     * Verifica se o usu�rio esta logado
     */
    final static function isUserLogged($variable)
    {
        $session_context = new Context($_SESSION);
        $client = $session_context->$variable;
        if ($client == NULL) {
            return false;
        }
        return true;
    }

    /**
     * Registra o usu�rio logado
     *
     * @param unknown_type $object            
     */
    final static function registerUser($object)
    {}
}

?>