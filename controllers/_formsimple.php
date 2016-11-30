<?php

  abstract class Controller_FormSimple extends Controller_Simple {

    protected function edit_add_handling($url, $title) {
      $this->template->vars('form_title', $title);
      $data = null;
      $this->scenario(_A_::$app->get('method'));
      $this->load($data);
      if(_A_::$app->request_is_post() && $this->form_handling($data)) {
        $this->save($data);
        exit($this->form($url, $data));
      }
      ob_start();
      $this->form($url);
      $form = ob_get_contents();
      ob_end_clean();
      $this->set_back_url();
      $this->template->vars('form', $form);
      $this->main->view_admin('edit');
    }

  }