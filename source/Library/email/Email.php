<?php


namespace Source\Library\email;


use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Source\Controllers\Controller;
use stdClass;

/**
 * Class Email
 * @package Source\Library\email
 */
class Email extends Controller
{
    /** @var PHPMailer */
    private $mail;

    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    /** @var Nome da pessoa que vai receber o E-mail */
    private $fromName;

    /** @var E-mail cujo qual vai ser enviado */
    private $fromEmail;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $configure = $this->getConfigure('email');

        if (empty($configure)) {
            printrx("Email não configurado !");
        }

        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();

        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "tls";
        $this->mail->CharSet = "utf-8";

        $this->mail->Host = $configure->host;
        $this->mail->Port = $configure->port;
        $this->mail->Username = $configure->user;
        $this->mail->Password = $configure->password;
        $this->fromName = $configure->from_name;
        $this->fromEmail = $configure->from_email;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient_name
     * @param string $recipient_email
     * @return Email
     */
    public function add(string $subject, string $body, string $recipient_name, string $recipient_email): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_name = $recipient_name;
        $this->data->recipient_email = $recipient_email;

        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return Email
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    /**
     * @param string $from_name
     * @param string $from_email
     * @return bool
     */
    public function send(): bool
    {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($this->fromEmail, $this->fromName);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $exception) {
            $this->error = $exception;
            return false;
        }
    }

    /**
     * @return Exception|null
     */
    public function error(): ?Exception
    {
        return $this->error;
    }
}
