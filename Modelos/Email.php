<?php 
namespace Modelos;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
include '../APIs/PHPMailer/vendor/autoload.php';

class Email
{
    private $vkey,$email;

    public function setEmail($email)
    {
        $this->email = $email;
        $this->vkey = hash('sha256', time() . $email);
        return $this->vkey;
    }


    public function enviarEmailConfirmacion($nombre)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'escuelauniline@gmail.com';               // SMTP username
            $mail->Password   = 'tnccpaaizbqbfaad';                         // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('ceo@escuelaalreves.com', 'Equipo de soporte UNILINE');
            $mail->addAddress($this->email);     // Add a recipient
            $mail->addReplyTo('ceo@escuelaalreves.com', 'Equipo de soporte UNILINE');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Verificacion de correo UNILINE';
            $mail->Body    = "<div style='margin: 0 auto;'>
                                    <img class='img-fluid' src='http://escuelaalreves.com/img/uniline3.png' alt='uniline' width='30%' style='display:block; margin: auto;'>
                                    <br>
                                    <h3 style='text-align: center; font-family: sans-serif; font-size: 19px; color: #428bca;'>¡Te damos la bienvenida $nombre!</h3>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Gracias por elegir UNILINE para desarrollarte y crecer profesionalmente.</p>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Para acceder a nuestros cursos, solo haz clic en el siguiente botón y comienza a disfrutar de todos los beneficios que tenemos para ti.</p>
                                    <br>
                                    <p style='font-size: 24px; text-align: center; display:block; margin: auto; font-family: sans-serif; background-color: #337ab7;
                                        border-color: #2e6da4; max-width: 15rem; padding: 1rem;'><a style='text-decoration: none; color: #fff;' href='https://www.escuelaalreves.com/controllers/confirm.php?vkey=$this->vkey'>¡Activa tu cuenta ahora!</a></p>
                                </div>";
            $mail->AltBody = "<div style='margin: 0 auto;'>
                                    <img class='img-fluid' src='http://escuelaalreves.com/img/uniline3.png' alt='uniline' width='30%' style='display:block; margin: auto;'>
                                    <br>
                                    <h3 style='text-align: center; font-family: sans-serif; font-size: 19px; color: #428bca;'>¡Te damos la bienvenida $nombre!</h3>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Gracias por elegir UNILINE para desarrollarte y crecer profesionalmente.</p>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Para acceder a nuestros cursos, solo haz clic en el siguiente botón y comienza a disfrutar de todos los beneficios que tenemos para ti.</p>
                                    <br>
                                    <p style='font-size: 24px; text-align: center; display:block; margin: auto; font-family: sans-serif; background-color: #337ab7;
                                        border-color: #2e6da4; max-width: 15rem; padding: 1rem;'><a style='text-decoration: none; color: #fff;' href='https://www.escuelaalreves.com/controllers/confirm.php?vkey=$this->vkey'>¡Activa tu cuenta ahora!</a></p>
                                </div>";

            $mail->send();

            //echo 'Message has been sent';

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function enviarEmailRecuperarPass()
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'escuelauniline@gmail.com';               // SMTP username
            $mail->Password   = 'tnccpaaizbqbfaad';                         // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('ceo@escuelaalreves.com', 'Equipo de soporte Uniline');
            $mail->addAddress($this->email);     // Add a recipient
            $mail->addReplyTo('ceo@escuelaalreves.com', 'Equipo de soporte Uniline');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Recuperar contraseña Uniline';
            $mail->Body    = "
                                    <!DOCTYPE html>
                                    <html lang='en'>
                                    <head>
                                    	<meta charset='UTF-8'>
                                    	<title>Verificacion</title>
                                    </head>
                                    <body>
                                    <div style='margin: 0 auto;'>
                                    <h3 style='text-align: center; font-family: sans-serif; font-size: 19px;'>¡Hola!</h3>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Si tienes algún tipo de problema con tu contraseña
                                    o la olvidaste, haz clic en el siguiente enlace.</p>
                                    <br>
                                    <p style='font-size: 24px; text-align: center; font-family: sans-serif;'><a href='https://www.escuelaalreves.com/controllers/resetPass.php?correo=$this->email&vkey=$this->vkey'>Recuperar contrasena</a></p>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Si tienes algún otro problema no ovlides contactar al equipo de soporte de UNILINE. 
                                    Mandanos un correo electrónico a atencionaclientes@escuelaalreves.com</p>
                                    <br>
                                    <img class='img-fluid' src='http://escuelaalreves.com/img/uniline3.png' alt='uniline' width='30%' style='display:block; margin: auto;'>
                            
                                </div>
                                </body>
                                </html>";
            $mail->AltBody = "
            
                                    <!DOCTYPE html>
                                    <html lang='en'>
                                    <head>
                                    	<meta charset='UTF-8'>
                                    	<title>Verificacion</title>
                                    </head>
                                    <body>
                                    <div style='margin: 0 auto;'>
                                    <h3 style='text-align: center; font-family: sans-serif; font-size: 19px;'>¡Hola!</h3>
                                    <br>
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Si tienes algún tipo de problema con tu contraseña
                                    o la olvidaste, haz clic en el siguiente enlace.</p>
                                    <br>
                                    <p style='font-size: 24px; text-align: center; font-family: sans-serif;'><a href='https://www.escuelaalreves.com/controllers/resetPass.php?correo=$this->email&vkey=$this->vkey'>Recuperar contrasena</a></p>
                                    
                                    <p style='text-align: center; font-family: sans-serif; font-size: 19px;'>Si tienes algún otro problema no ovlides contactar al equipo de soporte de UNILINE. 
                                    Mandanos un correo electrónico a atencionaclientes@escuelaalreves.com</p>
                                    <br>
                                    <img class='img-fluid' src='http://escuelaalreves.com/img/uniline3.png' alt='uniline' width='30%' style='display:block; margin: auto;'>
                            
                                </div>
                                </body>
                                </html>";

            $mail->send();

            //echo 'Message has been sent';

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    
    public function generarNewPass(){
        //Carácteres para la contraseña
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890@#$%$?!<>_-";
        $password = "";
        //Reconstruimos la contraseña segun la longitud que se quiera
        for($i=0;$i < 8;$i++) {
            //obtenemos un caracter aleatorio escogido de la cadena de caracteres
            $password .= substr($str,rand(0,62),1);
        }
        //Mostramos la contraseña generada
        return $password;
    }

}