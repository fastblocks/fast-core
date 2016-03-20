<?php
require_once (FAST_PATH . '/orm/TSQLSelect.class.php');
require_once (FAST_PATH . '/orm/TCriteria.class.php');
require_once (FAST_PATH . '/orm/TFilter.class.php');
require_once (FAST_PATH . '/orm/TRecord.class.php');

class TRepository
{

    protected $class;

    protected $logger = null;

    function __autoload($class)
    {
        Application::autoLoad($class);
    }

    function __construct($class)
    {
        $this->class = $class;
        $this->logger = TLoggerFactory::getLogger(get_class($this));
    }

    final function get($id)
    {
        $clazz = $this->class . TRecord::SUFIX;
        return new $clazz($id);
    }

    /**
     * recupera um todos os registros de uma tabela.
     */
    final function loadAll($page = 1, $criteria = NULL, $qtdElements = null)
    {
        $initial_page = 1;
        if (is_null($criteria)) {
            $criteria = new TCriteria();
        }
        if ($qtdElements != null) {
            $criteria->setProperties('offset', $qtdElements * ($page - 1));
            $criteria->setProperties('limit', ($qtdElements));
        }
        return $this->load($criteria);
    }

    /**
     * Recuperar um conjunto de objetos (collection) da base de dados
     * atrav�s de um crit�rio de sele��o, e instanci�-los em mem�ria
     *
     * @param TCriteria $criteria            
     */
    final function load(TCriteria $criteria)
    {
        // instancia a instru��o SELECT
        $sql = new TSQLSelect();
        $sql->addColumn('*');
        $sql->setEntity($this->class);
        // atribui o criterio de sele��o passado por parametro
        $sql->setCriteria($criteria);
        
        // obt�m transa��o ativa
        if ($conn = TTransaction::get()) {
            // executa a consulta no banco de dados
            $result = $conn->Query($sql->getInstruction());
            
            if ($result) {
                // percorre os resultados da consulta, retornando um objeto
                while ($row = $result->fetchObject($this->class . TRecord::SUFIX)) {
                    // armazena no array $results
                    $results[] = $row;
                }
                return $results;
            } else {
                // se n�o tiver transa��o ativa, retorna uma exce��o
                throw new Exception('N�o h� transa��o ativa!');
            }
        }
    }

    /**
     * Excluir um conjunto de objetos (collection) de base de dados
     * atrav�s de um crit�rio de sele��o.
     *
     * @param $criteria =
     *            objeto do tipo TCriteria
     */
    final function delete(TCriteria $criteria)
    {
        // instancia uma instru��o DELETE
        $sql = new TSQLDelete();
        $sql->setEntity($this->class);
        // atribui o crit�rio passado como par�metro
        $sql->setCriteria($criteria);
        
        // obtem um transa��o ativa
        if ($conn = TTransaction::get()) {
            // registra mensagem de log
            $this->logger->logInfo("SHOW-SQL :: " . $sql->getInstruction());
            // executa instru��o de DELETE
            $result = $connn->exec($sql->getInstruction());
            return $result;
        } else {
            // se n�o houver transa��o, retorna exce��o
            throw new Exception('N�o h� transa��o ativa!');
        }
    }

    /**
     *
     * Retorna a quantidade de objetos da base de dados
     * que satisfazem um determinado crit�rio de sele��o.
     *
     * @param TCriteria $critiria            
     */
    final function count(TCriteria $critiria)
    {
        // instancia instru��o de SELECT
        $sql = new TSQLSelect();
        $sql->addColumn('count(*)');
        $sql->setEntity($this->class);
        // atribui o crit�rio passado por par�metro
        $sql->setCriteria($critiria);
        
        // obtem a transa��o ativa
        if ($conn = TTransaction::get()) {
            // registra mensagem de log
            $this->logger->logInfo("SHOW-SQL :: " . $sql->getInstruction());
            // executa instru��o de SELECT
            $result = $conn->Query($sql->getInstruction());
            if ($result) {
                $row = $result->fetch();
            }
            // retorna o resultado
            return $row[0];
        } else {
            $this->logger->logInfo('N�o h� transa��o ativa!');
            // se n�o houver transa��o, retorna exce��o
            throw new Exception('N�o h� transa��o ativa!');
        }
    }
}

?>
