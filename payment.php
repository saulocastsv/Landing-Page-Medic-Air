<?php
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    require_once 'vendor/autoload.php'; // You have to require the library from your Composer vendor folder
    require_once("autenvio/PHPMailerAutoload.php");

    MercadoPago\SDK::setAccessToken("APP_USR-7730597942774369-090816-fc7e00ca735399cbfe6769fc42c3e8ef-1138789815"); // Either Production or SandBox AccessToken

    $payment = new MercadoPago\Payment();

    if (!isset($data->installments))
    {
        $data->installments = 1;
    }
    
    if (!isset($data->token))
    {
        $data->token = "1";
    }
    
    $payment->transaction_amount = $data->transaction_amount;
    $payment->token = $data->token;
    $payment->description = "CAMA ELÉTRICA 3 MOVIMENTOS SEMI LUXO + COLCHÃO D28 - Landing Page";
    $payment->installments = $data->installments;
    $payment->payment_method_id = $data->payment_method_id;
    $payment->payer = $data->payer;

    $payment->save();

    $myObj = new stdClass();


    if ($data->payment_method_id == "pix")
    {
        $myObj->qr_code = $payment->point_of_interaction->transaction_data->qr_code;
    }
    else
    {
        $myObj = $payment;
    }

    // echo var_dump($nota[0]);
    // Close the file handle

        
    $mail = new PHPMailer();

    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = "smtp.kinghost.net"; // Seu endereço de host SMTP
    $mail->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
    $mail->Port = 587; // Porta de comunicação SMTP - Mantenha o valor "587"
    $mail->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
    $mail->SMTPAutoTLS = true; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"

    $mail->Username = 'marketing04@vitalscheffer.com.br'; // Conta de email existente e ativa em seu domínio
    $mail->Password = 'hDdv1vF!y'; // Senha da sua conta de email

    //==================================================== 

    // DADOS DO REMETENTE
    $mail->Sender = "marketing04@vitalscheffer.com.br"; // Conta de email existente e ativa em seu domínio
    $mail->From = "marketing04@vitalscheffer.com.br"; // Sua conta de email que será remetente da mensagem
    $mail->FromName = "Vital Scheffer"; // Nome da conta de email

    //==================================================== 

    // DADOS DO DESTINATÁRIO
    $mail->AddAddress($data->payer->email); // $data->payer->email

    $mail->Subject  = "Compra de Cama Hospitalar Vital Scheffer";
    $mail->isHTML(true);
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
    $mail->Body     = file_get_contents("email.html");
    $mail->AltBody = "Esse email não foi renderizado.\n\nPor favor entre em contato por este email.";

    if($mail->send()) {
       
    } 
    else {
        echo "Error: " . $mail->ErrorInfo;
    }   

    echo json_encode($myObj);
  ?>