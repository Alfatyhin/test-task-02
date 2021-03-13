<?php


namespace App\Controller;


use App\Model\Task;

class Tasks
{

    private static function clean($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    public function indexAction()
    {

        if(empty($_SESSION['admin'])) {
            $_SESSION['admin'] = false;
        }
        $admin = $_SESSION['admin'];


        if (!empty($_POST['user_name'] && $_POST['email'] && $_POST['description'])) {

            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $task = new Task();

                $task->user_name    = $this::clean($_POST['user_name']);
                $task->email        = $this::clean($_POST['email']);
                $task->description  = $this::clean($_POST['description']);
                $task->status       = 0;

                if (!empty($_POST['id'] && $admin)) {

                    $task = Task::getById($this::clean($_POST['id']));

                    $oldDescription = $task->description;
                    $newDescription =  $this::clean($_POST['description']);

                    if ($oldDescription != $newDescription) {
                        $task->description  = $newDescription;
                        $task->redact       = 1;
                    }

                    $task->status       = $this::clean($_POST['status']);

                }



                if (!empty($_POST['id'] && empty($admin))) {

                    header("Location: " . APP_WEB_PAGE . "/login");

                }  else {
                    $task->save();
                }

                header("Location: " . APP_WEB_PAGE);
            } else {
                $error_message[] = 'no valid email';
            }


        } elseif (isset($_POST['user_name']) && empty($_POST['user_name'] && $_POST['email'] && $_POST['description'])) {

            $error_message[] = 'заполните все поля';
        }

        if (empty($_POST['sort_name'])) {
            $sort_name = 'id';
        } else {
            $sort_name = $_POST['sort_name'];
        }

        if (empty($_POST['sort_by'])) {
            $sort_by = 'DESC';
        } else {
            $sort_by = $_POST['sort_by'];
        }

        if (isset($_POST['thisPage'])) {
            $thisPage = $_POST['thisPage'];
        } else {
            $thisPage = 0;
        }

        if (isset($_POST['next'])) {
            $thisPage = $_POST['next'];
        }


        $count = 3;
        $skip = $count * $thisPage;
        $paginate = Task::paginate($count);
        $paginate['this_class'][$thisPage] = 'page_active';

        $taskList = Task::getTasks($skip, $count, $sort_name, $sort_by);


        include_once PROGECT_VIEW_DIR . DIRECTORY_SEPARATOR . 'tasklist.phtml';
    }


    public function loginAction()
    {
        if (!empty($_POST['login'] && $_POST['password'])) {

            $login   = $_POST['login'];
            $passwod = $_POST['password'];

            if ($login == APP_ADMIN_LOGIN && $passwod == APP_ADMIN_PASS) {
                $_SESSION['admin'] = true;
                header("Location: " . APP_WEB_PAGE);
            } else {
                $error_message[] = 'ошибка авторизации';
            }

        } elseif (isset($_POST['login'])) {

            $error_message[] = 'заполните все поля';
        }
        include_once PROGECT_VIEW_DIR . DIRECTORY_SEPARATOR . 'login.phtml';
    }

    public function outAction()
    {
        $_SESSION['admin'] = false;
        header("Location: " . APP_WEB_PAGE);
    }
}