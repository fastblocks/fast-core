<?php

/**
 * Description of TSQLInsertClass
 *
 * @author Silvio Pereira
 */
class TSQLDelete extends TSQLInstruction
{

    /**
     * retorna a instru��o de DELETE em forma de string.
     */
    public function getInstruction()
    {
        // monta a string de DELETE
        $this->sql = "DELETE FROM {$this->getEntity()}";
        
        // retorna a cl�usula WHERE do objeto $this->criteria
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }
        }
        return $this->sql;
    }
}
?>
