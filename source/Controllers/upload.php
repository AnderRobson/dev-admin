<?php

namespace Source\Controllers;

use Exception;

/**
 * Class Upload
 * @package Source\Controllers
 */
class Upload
{
    /** @var $fail Exception */
    private $fail;

    /**
     * @var
     */
    private $file;

    /**
     * @var
     */
    private $fileName;

    /**
     * @var string
     */
    private $destiny = ROOT . DS . 'theme' . DS . 'upload' . DS;

    /**
     * @var
     */
    private $link;

    /**
     * Upload constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param mixed $file
     */
    public function setArquivo($file): void
    {
        $this->file = $file;

        $name = date("YmdHis") . "." . $this->getType();
        $this->fileName = $name;
    }

    /**
     * @param mixed $destiny
     */
    public function setDestinho(string $destiny): void
    {
        $this->destiny .= $destiny . DS;
    }

    /**
     * @return mixed
     */
    public function getNomeArquivo()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function upload(): string
    {
        move_uploaded_file($this->file["file"]["tmp_name"], $this->destiny . DS . $this->fileName);

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
                $this->fail = new Exception("Formato de arquivo inválido !");
        }

        return $type;
    }
}
