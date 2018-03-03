<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MY_Controller {

    public function _remap() {

        if (!$this->input->is_ajax_request())
            die('Bad ajax_request status');
        //////////  ЭТО AJAX !!!  ///////////

        // без данных - рисовать форму
        if (empty($_POST)) {
            $form = $this->load->view('front/registration/viewRegistrationForm', FALSE, TRUE);
            $this->mymodal('Registration Form', $form);
            Jquery::getResponse();
            return;
        }

        // Проверить данные из формы логинизации
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'nickname',
                'label' => 'NICKNAME',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'EMAIL',
                'rules' => 'required|valid_email|is_unique[users.email]'
            ),
            array(
                'field' => 'password',
                'label' => 'PASSWORD',
                'rules' => 'required|min_length[3]|callback_passwordSuperRulesCheck'
            ),
            array(
                'field' => 'confirm',
                'label' => 'PASSWORD CONFIRM',
                'rules' => 'required|matches[password]'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {

            // Вопрос: есть ошибка nickname?
            $error = form_error('nickname');
            if (empty($error)) {
                Jquery("#rNicknameError")
                        ->hide();
            } else {
                Jquery("#rNicknameError")
                        ->html($error)
                        ->show();
            }

            // Вопрос: есть ошибка email?
            $error = form_error('email');
            if (empty($error)) {
                Jquery("#rEmailError")
                        ->hide();
            } else {
                Jquery("#rEmailError")
                        ->html($error)
                        ->show();
            }

            // Вопрос: есть ошибка Пароля?
            $error = form_error('password');
            if (empty($error)) {
                Jquery("#rPasswordError")
                        ->hide();
            } else {
                Jquery("#rPasswordError")
                        ->html($error)
                        ->show();
            }

            // Вопрос: есть ошибка подтверждалки Пароля?
            $error = form_error('confirm');
            if (empty($error)) {
                Jquery("#rConfirmError")
                        ->hide();
            } else {
                Jquery("#rConfirmError")
                        ->html($error)
                        ->show();
            }

            Jquery::getResponse();
            return;
        }


        $newUser = array(
            'nickname' => set_value('nickname'),
            'email' => set_value('email'),
            'md5password' => md5(set_value('password'))
        );
        $this->db
                ->set($newUser)
                ->insert('users');
        $form = $this->load->view('front/registration/viewSuccessForm', $newUser, TRUE);
        $this->mymodal('Congratulation!!!', $form);
        Jquery::getResponse();
    }

    public function passwordSuperRulesCheck($str) {
        $errors = FALSE;
        // Найти минимум одну большую букву
        // Найти минимум один спецсимвол
        // Найти минимум одну цифру


        if ($errors) {
            $this->form_validation->set_message('password_check', 'The {field} field must contains minimum 1 capital letter, minimum 1 scecial character, minimum 1 digit"');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
