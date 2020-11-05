<?php

namespace Source\Controllers;

use Exception;

/**
 * Class Upload
 * @package Source\Controllers
 */
class Upload
{

    /** @var Arquivo */
    private $file;

    /** @var string */
    private string $fileName;

    /** @var string */
    private string $destiny = URL_BLOG . DS . 'upload' . DS;

    /** @var */
    private string $link;

    /**
     * Upload constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param mixed $file
     *
     * @throws Exception
     */
    public function setFile($file): void
    {
        $this->file = $file;

        if ($this->file != 0) {
            throw new Exception("Erro ao realizar o upload do arquivo");
        }

        $name = date("YmdHis") . "." . $this->getType();
        $this->fileName = $name;
    }

    /**
     * @param mixed $destiny
     */
    public function setDestiny(string $destiny): void
    {
        $this->destiny .= $destiny . DS;
    }

    /**
     * @return string
     */
    public function getDestiny(): string
    {
        return $this->destiny;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function upload(): string
    {
        if (! move_uploaded_file($this->file["file"]["tmp_name"], $this->destiny . DS . $this->fileName)) {
            throw new Exception("Erro ao realizar o upload do arquivo");
        }

        $this->link = $this->destiny . DS . $this->fileName;

        return $this->fileName;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string|null
     */
    private function getType(): ?string
    {
        $type = null;
        switch ($this->file["file"]["type"]) {
            case "image/jpeg":
                $type = "jpg";
                break;
            default:
                $fail = new Exception("Formato de arquivo inválido !");
        }

        return $type;
    }

    public static function fileDestroy($file): bool
    {
        return unlink($file);
    }
}
