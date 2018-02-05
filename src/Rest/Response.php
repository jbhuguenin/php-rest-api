<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 12:30
 */

namespace Rest;


class Response
{

    const JSON_FORMAT = "Json";

    const HTML_FORMAT = "Html";

    protected $headers;

    protected $content;

    protected $statusCode;

    protected $statusText = [
        200 => 'OK',
        201 => 'Created',
        405 => 'Method No Allowed',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',

    ];
    
    protected $format;


    /**
     * Response constructor.
     * @param string $content
     * @param int $status
     * @param array $headers
     * @param string $format
     */
    public function __construct($content = '', $status = 200, $headers = [], $format = 'Json')
    {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setHeaders($headers);
        $this->setFormat($format);
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Response
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;

        if (!isset($this->statusText[$statusCode])) {
            throw new \InvalidArgumentException(sprintf('The status code %s is invalid', $statusCode));
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function sendHeaders()
    {
        header(sprintf('HTTP/1.0 %s %s', $this->getStatusCode(), $this->statusText[$this->getStatusCode()]));
        foreach ($this->getHeaders() as $header) {
            header(sprintf('%s : %s', $header['name'], $header['value']));

        }

        switch ($this->getFormat()) {
            case self::JSON_FORMAT:
                header('Content-type: application/json;');
                break;
        }

        return $this;
    }

    /**
     *
     */
    protected function sendContent()
    {
        switch ($this->getFormat()) {
            case self::JSON_FORMAT:
                $content = json_encode($this->getContent());
                break;
            case self::HTML_FORMAT:
                $content = $this->getContent();
                break;
            default:
                $content = json_encode($this->getContent());
        }

        echo $content;
    }

    /**
     * @return $this
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }
}