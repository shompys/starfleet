<?php
    use phpmailer\PHPMailer\PHPMailer;
    use phpmailer\PHPMailer\Exception;
    require 'Exception.php';
    require 'PHPMailer.php';
    require 'SMTP.php';

    class emails{
        
        public static function enviar_pin($pin, $objUser){
            $send = false;
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
                $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = NOMBRE_HOST;                      // El mail que utilizo
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = NOMBRE_MAIL;                // SMTP mail de la web
                $mail->Password   = CLAVE_MAIL;                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;
                
                $mail->setFrom(NOMBRE_MAIL, 'StarFleet');
                $mail->addAddress($objUser -> getUs_email());

                $mail->isHTML(true);                                                            // Set email format to HTML
                $mail->Subject = 'Recuperacion de clave';                                  // Asunto
                $mail->Body    = $pin;

                $send = $mail -> send();

            }catch (Exception $e){
                echo "El mensaje no salio porque: {$mail->ErrorInfo}";
            }
            return $send;
        }

        public static function aviso_alta_usuario($objUser){
            $send = false;
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
                $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = NOMBRE_HOST;                      // El mail que utilizo
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = NOMBRE_MAIL;                // SMTP mail de la web
                $mail->Password   = CLAVE_MAIL;                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;
                
                $mail->setFrom(NOMBRE_MAIL, 'StarFleet');
                $mail->addAddress($objUser -> getUs_email());

                $mail->isHTML(true);                                                            // Set email format to HTML
                $mail->Subject = 'Bienvenido a StarFleet';                                // Asunto
                $mail->Body    = $objUser -> getUs_nombre() . '<br>'.
                                 $objUser -> getUs_apellido() . '<br>'.
                                 $objUser -> getUs_usuario() . '<br>'.
                                 $objUser -> getUs_email() . '<br>'.
                                 $objUser -> getUs_fecha() . '<br>'.
                                 $objUser -> getUs_dni() . '<br>'.
                                 $objUser -> getUs_sexo() . '<br>'.
                                 $objUser -> getUs_calle() . '<br>'.
                                 $objUser -> getUs_altura() . '<br>'.
                                 $objUser -> getUs_piso() . '<br>'.
                                 $objUser -> getUs_dpto() . '<br>'.
                                 $objUser -> getUs_ciudad() . '<br>'.
                                 $objUser -> getUs_pais() . '<br>'.
                                 $objUser -> getUs_permiso() . '<br>'.
                                 $objUser -> getUs_activo() . '<br>' .
                                 $objUser -> getempresa_id()
                ;

                $send = $mail -> send();

            }catch (Exception $e){
                echo "El mensaje no salio porque: {$mail->ErrorInfo}";
            }
            return $send;
        }
        
        public static function aviso_modificado_usuario($objUser){

            $send = false;
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
                $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = NOMBRE_HOST;                      // El mail que utilizo
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = NOMBRE_MAIL;                // SMTP mail de la web
                $mail->Password   = CLAVE_MAIL;                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;
                
                $mail->setFrom(NOMBRE_MAIL, 'StarFleet');
                $mail->addAddress($objUser -> getUs_email());

                $mail->isHTML(true);                                                            // Set email format to HTML
                $mail->Subject = 'Bienvenido a StarFleet';                                // Asunto
                $mail->Body    = 'su usuario ha sido modificado.'
                ;

                $send = $mail -> send();

            }catch (Exception $e){
                echo "El mensaje no salio porque: {$mail->ErrorInfo}";
            }
            return $send;


        }

        public static function aviso_alta_empresa($objEmpresa){
            $send = false;
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
                $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = NOMBRE_HOST;                      // El mail que utilizo
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = NOMBRE_MAIL;                // SMTP mail de la web
                $mail->Password   = CLAVE_MAIL;                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;
                
                $mail->setFrom(NOMBRE_MAIL, 'StarFleet');
                $mail->addAddress($objEmpresa -> getEm_email());

                $mail->isHTML(true);                                                            // Set email format to HTML
                $mail->Subject = 'Bienvenido a StarFleet';                                // Asunto
                $mail->Body    = 'Dado de ALTA';
                ;

                $send = $mail -> send();

            }catch (Exception $e){
                echo "El mensaje no salio porque: {$mail->ErrorInfo}";
            }
            return $send;
        }

        public static function aviso_modificado_empresa($objEmpresa){

            $send = false;
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
                $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = NOMBRE_HOST;                      // El mail que utilizo
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = NOMBRE_MAIL;                // SMTP mail de la web
                $mail->Password   = CLAVE_MAIL;                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;
                
                $mail->setFrom(NOMBRE_MAIL, 'StarFleet');
                $mail->addAddress($objEmpresa -> getEm_email());

                $mail->isHTML(true);                                                            // Set email format to HTML
                $mail->Subject = 'Bienvenido a StarFleet';                                // Asunto
                $mail->Body    = 'su empresa ha sido modificado.'
                ;

                $send = $mail -> send();

            }catch (Exception $e){
                echo "El mensaje no salio porque: {$mail->ErrorInfo}";
            }
            return $send;


        }

    }
