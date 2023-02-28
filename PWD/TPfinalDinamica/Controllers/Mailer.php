<?php

trait Mailer {
    
    /**
     * Método que notifica con un mail el cambio de estado de una compra
     * @param string $mailUsuario
     */
    public static function notificarCambioEstado( $mailUsuario, $mensaje ){
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();                                             // Envío usando SMTP
            
            $mail->SMTPDebug = 0;                                        // Desactivo salida detallada del debugger
            $mail->SMTPAuth   = true;                                    // Activa autenticación SMTP
            $mail->Host       = 'smtp.gmail.com';                        // Setea el servidor SMTP para envíos
            $mail->Username   = 'gonzalo.marin@est.fi.uncoma.edu.ar';    // SMTP mail
            $mail->Password   = '44238101';                              // SMTP contraseña
            $mail->SMTPSecure = 'ssl';                                   // Activa encriptación TLS implícita
            $mail->Port       = 465;      
            
            // Setea el mail de la libería
            $mail->setFrom( 'gonzalo.marin@est.fi.uncoma.edu.ar' );
    
            // Recuperar el mail del usuario logueado y lo guardo en una variable
            // Setea el mail del usuario que recibirá el mensaje
            $mail->addAddress( $mailUsuario );
            $mail->Subject = 'Su compra en Yonny Libreria';
            $mail->Body = $mensaje;

            $mail->send();
        } catch( Exception $e ){
            echo "El mensaje no pudo ser enviado. Mailer error: {$mail->ErrorInfo}";
        }
    }
}
