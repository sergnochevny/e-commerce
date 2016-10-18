<?php

  abstract class Controller_FormSimple extends Controller_Simple {

    protected function edit_add_handling($url, $title, $back_url = null) {
      $this->template->vars('form_title', $title);
      $data = null;
      $this->load($data);
      if($this->form_handling($data) && _A_::$app->request_is_post()) {
        $this->save($data);
        exit($this->form($url, $data));
      }
      ob_start();
      $this->form($url);
      $form = ob_get_contents();
      ob_end_clean();
      $prms = null;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms);
      $this->template->vars('back_url', $back_url);
      $this->template->vars('form', $form);
      $this->main->view_admin('edit');
    }

  }