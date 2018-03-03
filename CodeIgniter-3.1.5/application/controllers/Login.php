<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////

        // без данных - рисовать форму
        if (empty($_POST)) {
            $form = $this->load->view('front/login/viewLoginForm', FALSE, TRUE);
            $this->mymodal('Login Form', $form);
            Jquery::getResponse();
            return;
        }

        // Проверить данные из формы логинизации
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'email',
                'label' => 'EMAIL',
                'rules' => 'required|valid_email'
            ),
            array(
                'field' => 'password',
                'label' => 'PASSWORD',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            
            // Есть ошибка email?
            $error = form_error('email');
            if (empty($error)) {
                Jquery("#lEmailError")
                        ->hide();
            } else {
                Jquery("#lEmailError")
                        ->html($error)
                        ->show();
            }
            
            // Есть ошибка Пароля?
            $error = form_error('password');
            if (empty($error)) {
                Jquery("#lPasswordError")
                        ->hide();
            } else {
                Jquery("#lPasswordError")
                        ->html($error)
                        ->show();
            }
            
            Jquery::getResponse();
        } else {
            
            $email = set_value('email');
            $password = set_value('password');
            $user = $this->db
                    ->where('email', $email)
                    ->where('md5password', md5(trim($password)))
                    ->get('users')
                    ->row();
            if (empty($user)) {
                $error = 'Пользователь с таким логином и/или паролем не зарегистрирован';
                Jquery("#lEmailError")
                        ->html($error)
                        ->show();
                Jquery("#lPasswordError")
                        ->hide();
                Jquery::getResponse();
            } else {
                
                // Пользователь опознан
                // Пометить сессию пользователя
                $this->db
                        ->where('id', session_id())
                        ->set('user_id', $user->id)
                        ->update('ci_sessions');
                
                // Скрыть приветствие
                // Показать приложение
                $js = $this->load->view('front/app/js/viewJsShowApp', FALSE, TRUE);
                Jquery::evalScript($js);
                $this->jgrowl('Successful login. Welcome ' . $user->nickname . '!', 'green');
                Jquery::getResponse();
            }
        }
    }

}
