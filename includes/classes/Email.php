<?php  
    namespace Classes;

    use PHPMailer\PHPMailer\PHPMailer;

    class Email{
        public $email;
        public $nombre;
        public $token;

        public function __construct($email, $nombre, $token)
        {
            $this->email=$email;
            $this->nombre=$nombre;
            $this->token=$token;
        }
        public function enviarConfirmacion(){
//crear obj mail
            $email= new PHPMailer();
            $email->isSMTP();
            $email->Host = 'sandbox.smtp.mailtrap.io';
            $email->SMTPAuth = true;
            $email->Port = 2525;
            $email->Username = 'c20fc8989472f9';
            $email->Password = '07754e70f5d1b0';

            $email->setFrom('cuentas@appsalon.com');
            $email->addAddress('cuentas@appsalon.com','appsalon.com'/*dominio*/);
            $email->Subject='Confirma tu cuenta';

            $email->isHTML(true);
            $email->CharSet='UTF-8';

//cuerpo del mensaje
            $contenido="<html>";
            $contenido .="<p> Hola " .$this->nombre ."! Gracias por crear tu cuenta en appSalon, solo queda confirmar tu cuenta.</P>";
            $contenido .= "<p> presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token ."'>Confirmair cuenta</a> </p>";
            $contenido .= "<p> Si no solicitaste esta cuenta puedes ignorar el mensaje </p>"; 
            $contenido .="</html>";
//lo agrego al body

        $email->Body=$contenido;
//enviar
        $email->send();
        }
        public function enviarInstrucciones(){
            //crear obj mail
            $email= new PHPMailer();
            $email->isSMTP();
            $email->Host = 'sandbox.smtp.mailtrap.io';
            $email->SMTPAuth = true;
            $email->Port = 2525;
            $email->Username = 'c20fc8989472f9';
            $email->Password = '07754e70f5d1b0';

            $email->setFrom('cuentas@appsalon.com');
            $email->addAddress('cuentas@appsalon.com','appsalon.com'/*dominio*/);
            $email->Subject='Reestablece tu contraseña';

            $email->isHTML(true);
            $email->CharSet='UTF-8';

//cuerpo del mensaje
            $contenido="<html>";
            $contenido .="<p> Hola " .$this->nombre ."! Reestablece aquí tu contraseña.</P>";
            $contenido .= "<p> presiona aqui: <a href='http://localhost:3000/recuperar?token=".$this->token ."'>reestablecer contraseña</a> </p>";
            $contenido .= "<p> Si no solicitaste esta cuenta puedes ignorar el mensaje </p>"; 
            $contenido .="</html>";
//lo agrego al body

        $email->Body=$contenido;
//enviar
        $email->send();
        }
    }

?> 