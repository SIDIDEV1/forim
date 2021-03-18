<?php 

class Message{
    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;

    public static function fromJSON(string $json): Message
    {
        $data = json_decode($json, true);
        return new self($data['username'], $data['message'], new DateTime("@" .  $data['date']));
    }
    
    public function __construct(string $username, string $message, ?DateTime  $date =null) 
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function getErrors() : array
    {
        $error = [];
        if(strlen($this->username) < self::LIMIT_USERNAME)
        {
            $error['username'] = 'Votre nom est court';
        }
        if(strlen($this->message) < self::LIMIT_MESSAGE)
        {
            $error['message'] = 'Votre message est trop petit';
        }
        return $error;
    }

    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $this->date->setTimezone(new DateTimeZone('Europe/Paris'));
        $date = $this->date->format('d/m/Y à H:i:s');
        $message = htmlentities($this->message);
        return <<<SIDI
        <p>
            <strong>{$username}</strong> : le <em>{$date}</em> <br>
            {$message}
        <p>
SIDI;
    }

    public function toJSON():string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }
}