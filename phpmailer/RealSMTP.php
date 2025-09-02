<?php
/**
 * Gerçek SMTP Bağlantısı - Gmail ile çalışır
 */
class RealSMTP {
    private $smtp_host;
    private $smtp_port;
    private $smtp_username;
    private $smtp_password;
    private $smtp_secure;
    private $connection;
    private $from_email;
    private $from_name;
    private $debug = false;
    
    public function __construct($host = 'smtp.gmail.com', $port = 587, $secure = 'tls') {
        $this->smtp_host = $host;
        $this->smtp_port = $port;
        $this->smtp_secure = $secure;
    }
    
    public function setAuth($username, $password) {
        $this->smtp_username = $username;
        $this->smtp_password = $password;
    }
    
    public function setFrom($email, $name = '') {
        $this->from_email = $email;
        $this->from_name = $name;
    }
    
    public function setDebug($debug = true) {
        $this->debug = $debug;
    }
    
    public function sendMail($to_email, $subject, $html_body) {
        try {
            // SMTP bağlantısı kur
            if (!$this->connect()) {
                return false;
            }
            
            // E-posta gönder
            $result = $this->send($to_email, $subject, $html_body);
            
            // Bağlantıyı kapat
            $this->disconnect();
            
            return $result;
            
        } catch (Exception $e) {
            if ($this->debug) {
                echo "SMTP Hatası: " . $e->getMessage() . "\n";
            }
            return false;
        }
    }
    
    private function connect() {
        // Socket bağlantısı oluştur
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $this->connection = stream_socket_client(
            "tcp://{$this->smtp_host}:{$this->smtp_port}",
            $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context
        );
        
        if (!$this->connection) {
            if ($this->debug) {
                echo "Bağlantı hatası: $errstr ($errno)\n";
            }
            return false;
        }
        
        // Hoş geldin mesajını oku
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '220')) {
            return false;
        }
        
        // EHLO komutu
        $this->sendCommand("EHLO {$this->smtp_host}");
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '250')) {
            return false;
        }
        
        // STARTTLS (TLS şifreleme)
        if ($this->smtp_secure == 'tls') {
            $this->sendCommand("STARTTLS");
            $response = $this->readResponse();
            if (!$this->checkResponse($response, '220')) {
                return false;
            }
            
            // TLS'e geç
            if (!stream_socket_enable_crypto($this->connection, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                if ($this->debug) {
                    echo "TLS başlatılamadı\n";
                }
                return false;
            }
            
            // Tekrar EHLO
            $this->sendCommand("EHLO {$this->smtp_host}");
            $response = $this->readResponse();
            if (!$this->checkResponse($response, '250')) {
                return false;
            }
        }
        
        // Kimlik doğrulama
        $this->sendCommand("AUTH LOGIN");
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '334')) {
            return false;
        }
        
        // Kullanıcı adı gönder
        $this->sendCommand(base64_encode($this->smtp_username));
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '334')) {
            return false;
        }
        
        // Şifre gönder
        $this->sendCommand(base64_encode($this->smtp_password));
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '235')) {
            if ($this->debug) {
                echo "Kimlik doğrulama başarısız: $response\n";
            }
            return false;
        }
        
        if ($this->debug) {
            echo "SMTP bağlantısı başarılı!\n";
        }
        
        return true;
    }
    
    private function send($to_email, $subject, $html_body) {
        // Gönderen
        $this->sendCommand("MAIL FROM:<{$this->from_email}>");
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '250')) {
            return false;
        }
        
        // Alıcı
        $this->sendCommand("RCPT TO:<{$to_email}>");
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '250')) {
            return false;
        }
        
        // Veri gönderme başlat
        $this->sendCommand("DATA");
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '354')) {
            return false;
        }
        
        // E-posta içeriği
        $headers = [];
        $headers[] = "From: {$this->from_name} <{$this->from_email}>";
        $headers[] = "To: <{$to_email}>";
        $headers[] = "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=";
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers[] = "Content-Transfer-Encoding: 8bit";
        $headers[] = "Date: " . date('r');
        $headers[] = "Message-ID: <" . uniqid() . "@{$this->smtp_host}>";
        
        $email_content = implode("\r\n", $headers) . "\r\n\r\n" . $html_body . "\r\n.";
        
        $this->sendCommand($email_content);
        $response = $this->readResponse();
        if (!$this->checkResponse($response, '250')) {
            return false;
        }
        
        if ($this->debug) {
            echo "E-posta başarıyla gönderildi!\n";
        }
        
        return true;
    }
    
    private function disconnect() {
        if ($this->connection) {
            $this->sendCommand("QUIT");
            fclose($this->connection);
            $this->connection = null;
        }
    }
    
    private function sendCommand($command) {
        if ($this->debug) {
            echo ">>> $command\n";
        }
        fwrite($this->connection, $command . "\r\n");
    }
    
    private function readResponse() {
        $response = '';
        while (($line = fgets($this->connection, 515)) !== false) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        
        if ($this->debug) {
            echo "<<< " . trim($response) . "\n";
        }
        
        return trim($response);
    }
    
    private function checkResponse($response, $expected_code) {
        return substr($response, 0, 3) == $expected_code;
    }
}
?>
