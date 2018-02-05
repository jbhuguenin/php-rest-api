<?php
namespace Rest;


use Rest\Server;


class ViewModel {


    protected $format = Response::HTML_FORMAT;
    protected $layout;

    protected $template;

    protected $variables = [];

    protected $response;

    protected $renderer;

    public function __construct($variables, $options = []) {
        $this->variables = $variables;

        if (isset($options['template'])) {
            $this->setTemplate($options['template']);
        }

        $this->init();
        return $this;
    }

    protected function init() {
        if(!$this->response) {
            $this->response = new Response('', 200, [], $this->format);
        }

        if (!$this->renderer) {
            $this->renderer = new PhpRenderer(Server::$config['view']['templatePath']);
        }
    }

    public function getContent() {
        $content = $this->getRenderer()->render($this->getLayout(), ['content' => $this->getRenderer()->getContent($this->getTemplate(), $this->getVariables())]);
        return $content;
    }

    public function getResponse() {
        if (!$this->getTemplate()) {
            throw new \RuntimeException('Template is not defined');
        }
        $this->response->setContent($this->getContent());
        return $this->response;
    }

    public function setResponse($response) {
        $this->response = $response;
        return $this;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

    public function getTemplate() {
        return $this->template;
    }

    protected function setVariables($variables) {
        $this->variables = $variables;
        return $this;
    }

    protected function getVariables() {
        return $this->variables;
    }

    protected function getRenderer() {
        return $this->renderer;
    }
}