<?php

define('TITLE_MAX_CHARS', 50);
define('TITLE_MIN_CHARS', 5);
define('DATA_MAX_CHARS', 1000);
define('DATA_MIN_CHARS', 15);

class Controller_Comments extends Controller_Base
{
    protected $main;

    public function __construct($main)
    {
        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;
    }

    public function show()
    {
        $redirect_to_url = true;

        $this->comments_list();
        $this->template->view("comments/comments_list");
    }

    private function comments_list()
    {
        $m = new Model_Comments();
        if (!empty($_GET['page'])) {
            $userInfo = $m->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
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

        include_once('controllers/_menu.php');
        $menu = new Controller_Menu($this);
        $menu->show_menu();

        $this->template->vars('userInfo', $_SESSION['user']);

        ob_start();
        $toggle = true;
        if ($toggle) {
            $user = $_SESSION['user'];
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
        $this->template->vars('base_url', BASE_URL);

        $this->template->view_layout('menu/my_account_user_menu');
        $my_account_user_menu = ob_get_contents();
        ob_end_clean();
        $this->template->vars('my_account_user_menu', $my_account_user_menu);

        include_once('controllers/_paginator.php');
        $paginator = new Controller_Paginator($this->main);
        $paginator->user_comments_paginator($total, $page);

        $this->template->vars("content", $content);

    }

    public function comment_add()
    {

        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);

        $this->main->view('comments/comments_add_form');
    }

    public function comment_save()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);

        $comments_page = BASE_URL . '/comments';
        $main_page = BASE_URL . '/shop';

        $Data = htmlspecialchars($_POST['comment_data']);
        $Title = htmlspecialchars($_POST['comment_title']);
        $UserID = $_SESSION['_'];


        $errors = $this->validateCommentData($Data, $Title);
        if (count($errors) > 0) {
            $this->template->vars("errs", $this->validateCommentData($Data, $Title));
            $this->template->view_layout("comments/save_error");
            return 0;
        }
        $comm = new Model_Comment(0, $Title, $Data, NULL, $UserID, false);//Bug
        if (Model_Comments::getInstance()->add($comm)) {
            $this->template->vars('comments_page', $comments_page);
            $this->template->vars('main_page', $main_page);
            $this->template->view_layout("comments/save_complate");
            return 0;
        } else {
            $errors[] = "Unknown error!!!";
            $this->template->vars("errs", $errors);
            $this->template->view_layout("comments/save_error");
            return 0;
        }
    }

    public static function validateCommentData($Data, $Title)
    {
        $error_msg = array();

        if (strlen($Title) < TITLE_MIN_CHARS || strlen($Title) > TITLE_MAX_CHARS) {
            $error_msg[] = "Title length < " . TITLE_MIN_CHARS . " chars!!!! Maximum " . TITLE_MAX_CHARS . " chars!";
        }
        if (strlen($Data) < DATA_MIN_CHARS || strlen($Data) > DATA_MAX_CHARS) {
            $error_msg[] = "Comment text < " . DATA_MIN_CHARS . " chars!!! Maximum " . DATA_MAX_CHARS . " chars!";
        }
        return $error_msg;
    }

    public function show_comments()
    {
        $this->main->test_access_rights();
        $this->get_comments_list();
        $this->main->view_admin('comments/admin_comments');
    }

    public function get_comments_list()
    {
        $this->main->test_access_rights();

        $base_url = BASE_URL;

        $m = new Model_Comments();
        if (!empty($_GET['page'])) {
            $userInfo = $m->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;
        $start = (($page - 1) * $per_page);
        $this->template->vars('page', $page);

        $rows = $m->getAll($start, $per_page);
        $total = $m->getTotalCountComments();

        ob_start();
        foreach ($rows as $row) {
            $row['email'] = $m->getUserEmail($row['userid']);
            include('views/html/comments_list.php');
        }
        $comments_list = ob_get_contents();
        ob_end_clean();

        include_once('controllers/_paginator.php');
        $paginator = new Controller_Paginator($this->main);
        $paginator->comments_paginator($total, $page);


        $this->template->vars('comments_list', $comments_list);
    }

    public function delete()
    {
        $this->main->test_access_rights();

        $ID = $_GET['ID'];
        if (empty($ID)) exit(0);
        $model = new Model_Comments();
        $model->delete($ID);

        $this->get_comments_list();
        $this->main->view_layout('comments/admin_comments_list');
    }

    public function public_comment()
    {
        $this->main->test_access_rights();
        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];

            $model = new Model_Comments();
            $comment = new Model_Comment($model->get($ID));

            if ($comment->getModerated() == '1') {
                $comment->setModerated(false);
            } else {
                $comment->setModerated(true);
            }

            $model->update($comment);
        }
        $this->get_comments_list();
        $this->main->view_layout('comments/admin_comments_list');
    }

    public function show_comment()
    {
        $this->main->test_access_rights();
        $m = new Model_Comments();
        if (isset($_GET['ID'])) {
            $comment = $m->get($_GET['ID']);
            if (empty($comment)) exit(0);

            $update_url = BASE_URL . '/comment_update_save';

            $comment['username'] = $m->getUserName($comment['userid']);

            ob_start();
            include('views/html/comment_table.php');
            $content = ob_get_contents();
            ob_clean();
        }
        $this->template->vars("content", $content);
        $this->template->view_layout('comments/admin_view_comment');
    }

    public function edit()
    {
        $this->main->test_access_rights();
        $m = new Model_Comments();
        $ID = $_GET['ID'];
        if (empty($ID)) exit(0);
        $comment = new Model_Comment($m->get($ID));


        $this->template->vars('moderated', $comment->getModerated());
        $this->template->vars('title', $comment->getTitle());
        $this->template->vars('data', $comment->getData());
        $this->template->view_layout("comments/admin_edit_comment");
    }

    public function update_comment()
    {

        $this->main->test_access_rights();
        $m = new Model_Comments();
        $data = htmlspecialchars($_POST['comment_data']);
        $title = htmlspecialchars($_POST['comment_title']);
        $moderated = sprintf("%d", $_POST['publish']);

        //echo "Publish = $moderated";

        $ID = $_POST['ID'];
        if (empty($ID)) exit(0);

        $comment = new Model_Comment($m->get($ID));
        $comment->setTitle($title);
        $comment->setData($data);
        $comment->setModerated($moderated);

        $errors = $this->validateCommentData($data, $title);
        if (count($errors) > 0) {
            $this->template->vars("errs", $this->validateCommentData($data, $title));
            $this->template->view_layout("comments/save_error");
            return 0;
        }
        if ($m->update($comment)) {
            $this->template->view_layout("comments/admin_save_complate");
            return 0;
        }
    }

    public function update_comment_list()
    {
        $this->main->test_access_rights();
        $this->get_comments_list();
        $this->main->view_layout('comments/admin_comments_list');
    }

}