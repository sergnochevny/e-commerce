<?php


class Controller_Comments extends Controller_Controller
{

    public function comments()
    {
        $redirect_to_url = true;
        $this->listof();
        $this->main->view("list");
    }

    private function listof()
    {
        $m = new Model_Comments();
        $page = !empty(_A_::$app->get('page'))?$m->validData(_A_::$app->get('page')):1;
        $per_page = 12;
        $start = (($page - 1) * $per_page);
        $this->template->vars('page', $page);
        $rows = $m->getAll($start, $per_page, 1);
        $total = $m->getTotalCountComments(1);

        ob_start();
        foreach ($rows as $comment) {
            include('views/html/comment_view.php');
        }
        $content = ob_get_contents();
        ob_end_clean();
        $this->template->vars('userInfo', _A_::$app->session('user'));

        ob_start();
        $toggle = true;
        if ($toggle) {
            $user = _A_::$app->session('user');
            $email = $user['email'];
            $firstname = ucfirst($user['bill_firstname']);
            $lastname = ucfirst($user['bill_lastname']);
            $user_name = '';
            if (!empty($firstname{0}) || !empty($lastname{0})) {
                if (!empty($firstname{0})) $user_name = $firstname . ' ';
                if (!empty($lastname{0})) $user_name .= $lastname;
            } else {
                $user_name = $email;
            }
            $this->template->vars('user_name', $user_name);
        }
        $this->template->vars('toggle', $toggle);
        (new Controller_Paginator($this))->paginator($total, $page, 'comments', $per_page);
        $this->main->template->vars("content", $content);
    }

    public function add()
    {

        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $this->main->view('add_form');
    }

    public function save()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);

        $comments_page = _A_::$app->router()->UrlTo('comments');
        $main_page = _A_::$app->router()->UrlTo('shop');

        $Data = htmlspecialchars(_A_::$app->post('comment_data'));
        $Title = htmlspecialchars(_A_::$app->post('comment_title'));
        $UserID = _A_::$app->session('_');


        $errors = $this->validateCommentData($Data, $Title);
        if (count($errors) > 0) {
            $this->template->vars("errs", $this->validateCommentData($Data, $Title));
            $this->template->view_layout("save_error");
            return 0;
        }
        $comm = new Model_Comment(0, $Title, $Data, NULL, $UserID, false);//Bug
        if (Model_Comments::getInstance()->add($comm)) {
            $this->template->vars('comments_page', $comments_page);
            $this->template->vars('main_page', $main_page);
            $this->template->view_layout("save_complete");
            return 0;
        } else {
            $errors[] = "Unknown error!!!";
            $this->template->vars("errs", $errors);
            $this->template->view_layout("save_error");
            return 0;
        }
    }

    public static function validateCommentData($Data, $Title)
    {
        $error_msg = array();

        if (strlen($Title) < TITLE_MIN_CHARS || strlen($Title) > TITLE_MAX_CHARS) {
            $error_msg[] = "Title length < " . TITLE_MIN_CHARS . " chars! Maximum " . TITLE_MAX_CHARS . " chars!";
        }
        if (strlen($Data) < DATA_MIN_CHARS || strlen($Data) > DATA_MAX_CHARS) {
            $error_msg[] = "Comment text < " . DATA_MIN_CHARS . " chars! Maximum " . DATA_MAX_CHARS . " chars!";
        }
        return $error_msg;
    }

    public function admin()
    {
        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_admin('admin');
    }

    public function get_list()
    {
        $this->main->test_access_rights();

        $page = !empty(_A_::$app->get('page')) ? (new Model_Comments())->validData(_A_::$app->get('page')) : 1;
        $per_page = 12;
        $start = (($page - 1) * $per_page);
        $this->template->vars('page', $page);

        $rows = Model_Comments::getAll($total,$start, $per_page);

        ob_start();
            foreach ($rows as $row) {
                $row['email'] = Model_User::get_user_by_id($row['userid'])['email'];
                include('views/html/comments_list.php');
            }
            $comments_list = ob_get_contents();
        ob_end_clean();
        (new Controller_Paginator($this))->paginator($total, $page, 'comments/admin', $per_page);
        $this->main->template->vars('comments_list', $comments_list);
    }

    public function delete()
    {
        $this->main->test_access_rights();

        $ID = _A_::$app->get('ID');
        if (empty($ID)) exit(0);
        (new Model_Comments())->delete($ID);
        $this->get_list();
        $this->main->view_layout('admin_list');
    }

    public function get_index()
    {
        $this->main->test_access_rights();
        if (!is_null(_A_::$app->get('ID'))) {
            $ID = _A_::$app->get('ID');

            $model = new Model_Comments();
            $comment = new Model_Comment($model->get($ID));

            if ($comment->getModerated() == '1') {
                $comment->setModerated(false);
            } else {
                $comment->setModerated(true);
            }

            $model->update($comment);
        }
        $this->get_list();
        $this->main->view_layout('admin_list');
    }

    public function comment()
    {
        $this->main->test_access_rights();
        $m = new Model_Comments();
        if (!is_null(_A_::$app->get('ID'))) {
            $comment = $m->get(_A_::$app->get('ID'));
            if (empty($comment)) exit(0);

            $update_url = _A_::$app->router()->UrlTo('comments/update_save');

            $comment['username'] = $m->getUserName($comment['userid']);

            ob_start();
            include('views/html/comment_table.php');
            $content = ob_get_contents();
            ob_clean();
        }
        $this->template->vars("content", $content);
        $this->template->view_layout('admin_view');
    }

    public function edit()
    {
        $this->main->test_access_rights();
        $m = new Model_Comments();
        $ID = _A_::$app->get('ID');
        if (empty($ID)) exit(0);
        $comment = new Model_Comment($m->get($ID));


        $this->template->vars('moderated', $comment->getModerated());
        $this->template->vars('title', $comment->getTitle());
        $this->template->vars('data', $comment->getData());
        $this->template->view_layout("admin_edit");
    }

    public function update()
    {

        $this->main->test_access_rights();
        $m = new Model_Comments();
        $data = htmlspecialchars(_A_::$app->post('comment_data'));
        $title = htmlspecialchars(_A_::$app->post('comment_title'));
        $moderated = sprintf("%d", _A_::$app->post('publish'));

        //echo "Publish = $moderated";

        $ID = _A_::$app->get('ID');
        if (empty($ID)) exit(0);

        $comment = new Model_Comment($m->get($ID));
        $comment->setTitle($title);
        $comment->setData($data);
        $comment->setModerated($moderated);

        $errors = $this->validateCommentData($data, $title);
        if (count($errors) > 0) {
            $this->template->vars("errs", $this->validateCommentData($data, $title));
            $this->template->view_layout("save_error");
            return 0;
        }
        if ($m->update($comment)) {
            $this->template->view_layout("admin_save_complete");
            return 0;
        }
    }

    public function update_list()
    {
        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_layout('admin_list');
    }

}