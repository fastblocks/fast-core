<?php
include "app.lib/hostmatch/Smtp.class.php";

class SendMailAdapterHostMatch
{

    private $email = null;

    function __construct($destinatario, $assunto, $corpo)
    {
        $this->email = new SMTPSendMail();
        
        $this->email->Servidor = "mail.h.com.br";
        $this->email->Autenticado = TRUE;
        $this->email->Usuario = "postmaster@h.com.br"; // Digite o Usu�rio de e-mail voc�@seudominio
        $this->email->Senha = ""; // Digite a Senha do email voc�@seudominio
        $this->email->EmailDe = "postmaster@h.com.br"; // Digite o e-mail do remetente
        
        $this->email->EmailPara = $destinatario; // Digite o Destino
        
        $this->email->Assunto = $assunto; // Digite o Assunto
        $this->email->Corpo = $corpo; // Digite o Corpo
    }

    function send()
    {
        if (! $this->email->Enviar()) {
            throw new Exception("O E-mail n�o pode ser entregue."); // , "SMTPERR001");
        }
    }
}
?>
