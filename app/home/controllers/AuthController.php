<?php
namespace App\Home\Controllers;

use App\Common\Controllers\BaseController;
use App\Common\Services\Auth;

class AuthController extends BaseController
{

    public function initialize() {
        parent::initialize();
        $this->assets->addCss("res/home/index.css");
    }

    public function indexAction() {
        $this->dispatcher->forward(array(
            "controller" => "auth",
            "action" => "signin"
        ));
    }

    protected function signinPost() {
        if (!$this->security->checkToken()) {
            $this->view->setVar("errors", "表单已过期，请重新输入");
            return false;
        }
        $request = $this->request;
        $username = trim($request->getPost("username"));
        $password = trim($request->getPost("password"));
        $remember = $request->getPost("remember");

        $result = $this->auth->signinFromForm($username, $password, $remember?TRUE:FALSE);

        $errcode = $result["errcode"];

        if ($errcode != Auth::ERR_NONE) {
            if ($errcode == Auth::ERR_PASSWORD_ERROR)
                $this->view->setVar("passwordError", true);
            else
                $this->view->setVar("usernameError", true);
            $this->view->setVar("errors", $result["errmsg"]);
            return false;
        }

        return true;
    }

    public function signinAction() {
        $request = $this->request;
        $redirect_uri = $request->get("redirect_uri");
        if (empty($redirect_uri)) $redirect_uri = "console";

        $this->view->setVar("passwordError", false);
        $this->view->setVar("usernameError", false);

        if ($request->isPost() && $this->signinPost()) {
            $this->view->disable();
            $this->response->redirect($redirect_uri);
            return;
        }

        $this->tag->setTitle("登录");
        $this->view->setVar("username", trim($request->getPost("username")));
        $this->view->setVar("redirect_uri", $redirect_uri);

        $this->assets->addCss("res/home/auth/signin.css");
    }

    public function signoutAction() {
        $this->auth->signout();
        $this->response->redirect("");
    }

    public function signupAction() {

    }

    public function signedAction() {

    }

    public function getPasswordAction() {

    }
}