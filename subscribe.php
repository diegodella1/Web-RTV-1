<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Destinatario (encriptado en base64)
        $to = base64_decode('ZGllZ29Acm94b20udHY='); // diego@roxom.tv encriptado
        
        // Asunto
        $subject = 'Nueva suscripción al newsletter de Roxom TV';
        
        // Mensaje en HTML
        $message = "
        <html>
        <head>
            <title>Nueva suscripción al newsletter</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { padding: 20px; }
                .header { background: #1ae784; color: #000; padding: 20px; }
                .content { padding: 20px; }
                .info { margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nueva suscripción al newsletter</h2>
                </div>
                <div class='content'>
                    <div class='info'>
                        <strong>Email del suscriptor:</strong> {$email}
                    </div>
                    <div class='info'>
                        <strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "
                    </div>
                    <div class='info'>
                        <strong>IP:</strong> {$_SERVER['REMOTE_ADDR']}
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Headers para enviar HTML
        $headers = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Roxom TV Subscriptions <noreply@roxom.tv>',
            'Reply-To: noreply@roxom.tv',
            'X-Mailer: PHP/' . phpversion()
        );
        
        // Enviar email
        if(mail($to, $subject, $message, implode("\r\n", $headers))) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Error al enviar el email']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid email']);
    }
    exit;
}
?> 