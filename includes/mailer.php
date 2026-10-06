<?php
/**
 * Lightweight SMTP mailer — pure PHP, koi composer/dependency nahi.
 * Shared hosting par bina PHPMailer ke kaam karta hai.
 * (Chahein toh PHPMailer se replace kar sakte hain — send_mail() signature same rakhein.)
 *
 * Supports: smtp/ssl (465), smtp+starttls (587), AUTH LOGIN, UTF-8, HTML+plain.
 */
declare(strict_types=1);

class SmtpMailer
{
    private string $host;
    private int $port;
    private string $user;
    private string $pass;
    private string $secure; // 'tls' | 'ssl' | 'none'
    public string $error = '';

    public function __construct(string $host, int $port, string $user, string $pass, string $secure = 'tls')
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->secure = strtolower($secure);
    }

    private function read($sock): string
    {
        $data = '';
        while ($line = fgets($sock, 515)) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') break;
        }
        return $data;
    }

    private function cmd($sock, string $command, array $expect): bool
    {
        fwrite($sock, $command . "\r\n");
        $resp = $this->read($sock);
        $code = (int) substr($resp, 0, 3);
        if (!in_array($code, $expect, true)) {
            $this->error = trim("SMTP [$command] => $resp");
            return false;
        }
        return true;
    }

    public function send(string $from, string $fromName, string $to, string $subject, string $html, string $text = ''): bool
    {
        $remote = ($this->secure === 'ssl' ? 'ssl://' : '') . $this->host;
        $sock = @fsockopen($remote, $this->port, $errno, $errstr, 20);
        if (!$sock) {
            $this->error = "Connect failed: $errstr ($errno)";
            return false;
        }
        stream_set_timeout($sock, 20);

        $this->read($sock);
        $ehlo = $_SERVER['SERVER_NAME'] ?? 'localhost';

        if (!$this->cmd($sock, "EHLO $ehlo", [250])) { fclose($sock); return false; }

        if ($this->secure === 'tls') {
            if (!$this->cmd($sock, 'STARTTLS', [220])) { fclose($sock); return false; }
            if (!stream_socket_enable_crypto($sock, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT)) {
                $this->error = 'STARTTLS crypto failed';
                fclose($sock);
                return false;
            }
            if (!$this->cmd($sock, "EHLO $ehlo", [250])) { fclose($sock); return false; }
        }

        if ($this->user !== '') {
            if (!$this->cmd($sock, 'AUTH LOGIN', [334])) { fclose($sock); return false; }
            if (!$this->cmd($sock, base64_encode($this->user), [334])) { fclose($sock); return false; }
            if (!$this->cmd($sock, base64_encode($this->pass), [235])) { fclose($sock); return false; }
        }

        if (!$this->cmd($sock, "MAIL FROM:<$from>", [250])) { fclose($sock); return false; }
        if (!$this->cmd($sock, "RCPT TO:<$to>", [250, 251])) { fclose($sock); return false; }
        if (!$this->cmd($sock, 'DATA', [354])) { fclose($sock); return false; }

        $text = $text !== '' ? $text : trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html)));
        $boundary = '=_dm_' . md5((string) microtime(true));
        $headers = [];
        $headers[] = 'Date: ' . date(DATE_RFC2822);
        $headers[] = 'From: ' . $this->encodeHeader($fromName) . " <$from>";
        $headers[] = 'To: <' . $to . '>';
        $headers[] = 'Subject: ' . $this->encodeHeader($subject);
        $headers[] = 'Message-ID: <' . md5(uniqid((string) mt_rand(), true)) . '@' . $ehlo . '>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';

        $body  = "--$boundary\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
               . chunk_split(base64_encode($text));
        $body .= "--$boundary\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
               . chunk_split(base64_encode($html));
        $body .= "--$boundary--\r\n";

        $data = implode("\r\n", $headers) . "\r\n\r\n" . $body;
        // Dot-stuffing
        $data = preg_replace('/\r\n\./', "\r\n..", $data);

        fwrite($sock, $data . "\r\n.\r\n");
        $resp = $this->read($sock);
        $ok = ((int) substr($resp, 0, 3)) === 250;
        if (!$ok) $this->error = trim("DATA => $resp");

        $this->cmd($sock, 'QUIT', [221]);
        fclose($sock);
        return $ok;
    }

    private function encodeHeader(string $str): string
    {
        return '=?UTF-8?B?' . base64_encode($str) . '?=';
    }
}

/**
 * Global send helper — config constants + admin settings (DB) dono se values leta hai.
 */
function send_mail(string $to, string $subject, string $html, string $type = 'general', string $text = ''): bool
{
    $host   = dm_setting('smtp_host', defined('SMTP_HOST') ? SMTP_HOST : '');
    $port   = (int) dm_setting('smtp_port', defined('SMTP_PORT') ? (string) SMTP_PORT : '587');
    $user   = dm_setting('smtp_user', defined('SMTP_USER') ? SMTP_USER : '');
    $pass   = dm_setting('smtp_pass', defined('SMTP_PASS') ? SMTP_PASS : '');
    $secure = dm_setting('smtp_secure', defined('SMTP_SECURE') ? SMTP_SECURE : 'tls');
    $from   = dm_setting('smtp_from_email', defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : $user);
    $fname  = dm_setting('smtp_from_name', defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : SITE_NAME);

    if ($host === '' || $from === '') {
        log_email($to, $subject, $type, false, 'SMTP not configured');
        return false;
    }

    $mailer = new SmtpMailer($host, $port, $user, $pass, $secure);
    $ok = $mailer->send($from, $fname, $to, $subject, $html, $text);
    log_email($to, $subject, $type, $ok, $mailer->error);
    return $ok;
}

/** Branded HTML email wrapper */
function email_template(string $title, string $bodyHtml): string
{
    return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#F5F8FC;font-family:Arial,Helvetica,sans-serif;">
  <div style="max-width:600px;margin:0 auto;padding:24px;">
    <div style="background:#0C3285;border-bottom:4px solid #199C3C;border-radius:16px 16px 0 0;padding:24px 28px;">
      <span style="color:#ffffff;font-size:18px;font-weight:700;">Deccan Malti Neuro &amp; Superspeciality Hospital</span>
    </div>
    <div style="background:#ffffff;padding:28px;border:1px solid #DCE7F4;border-top:none;">
      <h1 style="font-size:20px;color:#0C3285;margin:0 0 16px;">' . $title . '</h1>
      <div style="font-size:15px;line-height:1.65;color:#000000;">' . $bodyHtml . '</div>
    </div>
    <div style="background:#F5F8FC;border-radius:0 0 16px 16px;padding:16px 28px;border:1px solid #DCE7F4;border-top:none;">
      <p style="margin:0;font-size:12px;color:#6b7a80;">
        Opp. Ambassador Hotel, Besides Sushil Hospital, Sangli–Miraj Road, Vishrambag, Sangli, Maharashtra – 416415<br>
        Phone: +91 883 000 6879 &nbsp;|&nbsp; 0233-2324834
      </p>
    </div>
  </div>
</body></html>';
}
