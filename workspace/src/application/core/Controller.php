<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/03
 * Time: 13:10
 */

abstract class Controller
{
    /**
     * @var string
     */
    protected $controller_name;
    /**
     * @var
     */
    protected $action_name;
    /**
     * @var Application
     */
    protected $application;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var DbManager
     */
    protected $db_manager;

    protected $auth_actions = [];

    /**
     * Controller constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->controller_name = strtolower(substr(get_class($this), 0, -10));
        $this->application = $application;
        $this->request = $application->getRequest();
        $this->response = $application->getResponse();
        $this->session = $application->getSession();
        $this->db_manager = $application->getDbManager();
    }

    /**
     * FooActionなどのAction Methodを返す
     * @param string $action
     * @param array $params
     * @return mixed
     * @throws HttpNotFoundException
     * @throws UnauthorizedActionException
     */
    public function run(string $action, array $params = []): ?string
    {
        $this->action_name = $action;

        $action_method = $action . 'Action';
        if (!method_exists($this, $action_method)) {
            $this->forward404();
        }

        if ($this->needsAuthentication($action) && !$this->session->isAuthenticated()) {
            throw new UnauthorizedActionException();
        }

        // 可変関数
        $content = $this->$action_method($params);
        return $content;
    }

    protected function render(array $variables = [], ?string $template = null, string $layout = 'layout')
    {
        $defaults = [
            'request' => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session' => $this->session
        ];

        $view = new View($this->application->getViewDir(), $defaults);

        if (is_null($template)) {
            $template = $this->action_name;
        }

        $path = $this->controller_name . '/' . $template;
        return $view->render($path, $variables, $layout);
    }

    /**
     * @throws HttpNotFoundException
     */
    protected function forward404()
    {
        throw new HttpNotFoundException('Forward 404 page from');
    }

    protected function redirect(string $url): void
    {
        if (!preg_match('#https?://#', $url)) {
            $protcol = $this->request->isSsl() ? 'https://' : 'http://';
            $host = $this->request->getHost();
            $base_url = $this->request->getBaseUrl();

            $url = $protcol . $host . $base_url . $url;
        }

        $this->response->setStatusCode(302, 'Found');
        $this->response->setHttpHeader('Location', $url);
    }

    protected function generateCsrfToken(string $form_name): string
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, []);

        if (count($tokens) >= 10) {
            return array_shift($tokens);
        }

        $token = sha1($form_name . session_id() . microtime());
        $tokens[] = $token;

        $this->session->set($key, $tokens);

        return $token;
    }

    protected function checkCsrfToken(string $form_name, $token): bool
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, []);
        $pos = array_search($token, $tokens, true);
        if ($pos !== false) {
            unset($tokens[$pos]);
            $this->session->set($key, $tokens);
            return true;
        }

        return false;
    }

    protected function needsAuthentication($action): bool
    {
        if ($this->auth_actions === true ||
            (is_array($this->auth_actions)) && in_array($action, $this->auth_actions)) {
            return true;
        }
        return false;
    }
}
