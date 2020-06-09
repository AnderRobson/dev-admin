<?php

namespace Source\Controllers;

class Upload
{
    private $arquivo;

    private $nomeArquivo;

    private $destinho = ROOT . DS . 'theme' . DS . 'upload' . DS;

    private $link;

    public function __construct()
    {

    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo): void
    {
        $this->arquivo = $arquivo;

        $name = date("YmdHis");
        $this->nomeArquivo = $name . $arquivo["file"]["name"];
    }

    /**
     * @param mixed $destinho
     */
    public function setDestinho(string $destinho): void
    {
        $this->destinho .= $destinho . DS;
    }

    /**
     * @return mixed
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    public function upload(): string
    {
        move_uploaded_file($this->arquivo["file"]["tmp_name"], $this->destinho . DS . $this->nomeArquivo);

        $this->link = $this->destinho . DS . $this->nomeArquivo;

        return $this->nomeArquivo;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }
}