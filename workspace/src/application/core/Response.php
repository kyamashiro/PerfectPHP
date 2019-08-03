<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/02
 * Time: 15:32
 */

/**
 * HTMLヘッダとHTMLなどのコンテンツを返す
 */
class Response
{
    /**
     * @var
     */
    protected $content;
    /**
     * @var int
     */
    protected $status_code = 200;
    /**
     * @var string
     */
    protected $status_text = 'OK';
    /**
     * @var array
     */
    protected $http_headers = [];

    /**
     * 各プロパティに設定された値を元にレスポンスを送信する
     */
    public function send(): void
    {
        header("HTTP/1.1 {$this->status_code} {$this->status_text}");

        foreach ($this->http_headers as $name => $http_header) {
            header("{$name}: {$http_header}");
        }

        echo $this->content;
    }

    /**
     * HTMLなどクライアントに返す内容をセットする
     * @param $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @param $status_code
     * @param string $status_text
     */
    public function setStatusCode(int $status_code, string $status_text = ''): void
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setHttpHeader($name, $value): void
    {
        $this->http_headers[$name] = $value;
    }
}
