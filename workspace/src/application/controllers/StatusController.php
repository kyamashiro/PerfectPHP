<?php


class StatusController extends Controller
{
    protected $login_action = ['index', 'post'];

    public function indexAction()
    {
        $user = $this->session->get('user');
        /* @var $status_repository StatusRepository */
        $status_repository = $this->db_manager->get('Status');
        $statuses = $status_repository->fetchAllPersonalArchvesByUserId($user['id']);

        return $this->render([
            'statuses' => $statuses,
            'body' => '',
            '_token' => $this->generateCsrfToken('status/post')
        ]);
    }

    public function postAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/post', $token)) {
            return $this->redirect('/');
        }

        $errors = [];
        $body = $this->request->getPost('body');
        if (!strlen($body)) {
            $errors[] = 'ひとことを入力してください';
        } elseif (mb_strlen($body) > 200) {
            $errors[] = 'ひとことは200字以内で入力してください';
        }

        if (!count($errors)) {
            $user = $this->session->get('user');
            $this->db_manager->get('Status')->insert($user['id'], $body);

            return $this->redirect('/');
        }

        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

        return $this->render([
            'errors' => $errors,
            'body' => $body,
            'statuses' => $statuses,
            '_token' => $this->generateCsrfToken('status/post'),
        ], 'index');
    }

    public function userAction($params)
    {
        /* @var $user_repository UserRepository */
        $user_repository = $this->db_manager->get('User');
        $user = $user_repository->fetchByUserName($params['user_name']);

        if (!$user) {
            $this->forward404();
        }
        /* @var $status_repository StatusRepository */
        $status_repository = $this->db_manager->get('Status');
        $statuses = $status_repository->fetchAllByUserId($user['id']);

        $following = null;
        if ($this->session->isAuthenticated()) {
            $user_session = $this->session->get('user');
            if ($user_session['id'] !== $user['id']) {
                $following = $this->db_manager->get('Following')
                    ->isFollowing($user_session['id'], $user['id']);
            }
        }

        return $this->render([
            'user' => $user,
            'statuses' => $statuses,
            'following' => $following,
            '_token' => $this->generateCsrfToken('account/follow')
        ]);
    }

    public function showAction($params)
    {
        /* @var $status_repository StatusRepository */
        $status_repository = $this->db_manager->get('Status');
        $status = $status_repository->fetchByIdAndUserName($params['id'], $params['user_name']);

        if (!$status) {
            $this->forward404();
        }

        return $this->render(['status' => $status]);
    }
}