<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2019/02/03
 * Time: 11:01
 */

/**
 * コアクラス
 */
abstract class Application
{
    /**
     * @var bool
     */
    protected $debug = false;
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
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $login_action = [];

    /**
     * Application constructor.
     * @param bool $debug
     */
    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
        $this->initialize();
        $this->configure();
    }

    /**
     * @param bool $debug
     */
    protected function setDebugMode(bool $debug): void
    {
        if ($debug) {
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(1);
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    /**
     *
     */
    protected function initialize(): void
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->db_manager = new DbManager();
        $this->router = new Router($this->registerRoutes());
    }

    /**
     *
     */
    protected function configure()
    {

    }

    /**
     * @return mixed
     */
    abstract public function getRootDir();

    /**
     * @return mixed
     */
    abstract protected function registerRoutes();

    /**
     * @return bool
     */
    public function isDebugMode(): bool
    {
        return $this->debug;
    }

    /**
     * @return mixed
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getDbManager(): DbManager
    {
        return $this->db_manager;
    }

    /**
     * @return string
     */
    public function getControllerDir(): string
    {
        return $this->getRootDir() . '/controllers';
    }

    /**
     * @return string
     */
    public function getViewDir(): string
    {
        return $this->getRootDir() . '/views';
    }

    /**
     * @return string
     */
    public function getModelDir(): string
    {
        return $this->getRootDir() . '/models';
    }

    /**
     * @return string
     */
    public function getWebDir(): string
    {
        return $this->getRootDir() . '/web';
    }

    /**
     *  ルーティングパラメータを取得、コントローラ名とアクション名を特定し、アクションを実行してレスポンスを返す
     */
    public function run(): void
    {
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if ($params === false) {
                throw new HttpNotFoundException('No route found for' . $this->request->getPathInfo());
            }

            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action, $params);
        } catch (HttpNotFoundException $e) {
            $this->render404Page($e);
        } catch (UnauthorizedActionException $e) {
            list($controller, $action) = $this->login_action;
            $this->runAction($controller, $action);
        }
        $this->response->send();
    }

    /**
     * @param string $controller_name
     * @param string $action
     * @param array $params
     * @throws HttpNotFoundException
     * @throws UnauthorizedActionException
     */
    public function runAction(string $controller_name, string $action, array $params = []): void
    {
        $controller_class = ucfirst($controller_name) . 'Controller';
        $controller = $this->findController($controller_class);
        if ($controller === false) {
            throw new HttpNotFoundException($controller_class . ' controller is not found');
        }

        $content = $controller->run($action, $params);
        $this->response->setContent($content);
    }

    /**
     * @param string $controller_class
     * @return bool|Controller
     */
    protected function findController(string $controller_class)
    {
        if (!class_exists($controller_class)) {
            $controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';

            if (!is_readable($controller_file)) {
                return false;
            } else {
                require_once $controller_file;

                if (!class_exists($controller_class)) {
                    return false;
                }
            }
        }

        return new $controller_class($this);
    }

    /**
     * @param HttpNotFoundException $e
     */
    public function render404Page(HttpNotFoundException $e): void
    {
        $this->response->setStatusCode(404, 'Not Found');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Page not Found';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->response->setContent("
            <!doctype html>
            <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
                    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
                    <title>Document</title>
                </head>
                <body>
                    {$message}   
                </body>
            </html>
            ");
    }
}
