<?php


namespace App\Controller;


use App\Model\Task;

class Tasks
{

    private static function clean($value)
    {
        $value = trim($value);
        $value = preg_replace('/(<script>.*<\/script>)/s', '', $value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    public function indexAction()
    {

        $admin = $_SESSION['admin'];

        if(!empty($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
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

    public function saveAction()
    {

        $user_name = $this::clean($_POST['user_name']);
        $email = $this::clean($_POST['email']);
        $description = $this::clean($_POST['description']);


        if (!empty($user_name && $email && $description)) {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $task = new Task();

                $task->user_name    = $this::clean($_POST['user_name']);
                $task->email        = $this::clean($_POST['email']);
                $task->description  = $this::clean($_POST['description']);
                $task->status       = 0;

                $task->save();

                $_SESSION['message'] = '???????????? ??????????????????';

                header("Location: " . APP_WEB_PAGE . '/save/..');

            } else {
                $error_message[] = 'no valid email';
            }

        } else {
            $error_message[] = '?????????????????? ?????? ????????';
        }

        include_once PROGECT_VIEW_DIR . DIRECTORY_SEPARATOR . 'tasklist.phtml';
    }

    public function redactAction()
    {

        $admin = $_SESSION['admin'];

        if (!empty($_POST['id'] && $admin)) {

            $task = Task::getById($this::clean($_POST['id']));

            $oldDescription = $task->description;
            $newDescription =  $this::clean($_POST['description']);

            if ($oldDescription != $newDescription) {
                $task->description  = $newDescription;
                $task->redact       = 1;

                $_SESSION['message'] = '???????????? ????????????????';
            }

            $task->status       = $this::clean($_POST['status']);


            $task->save();

            header("Location: " . APP_WEB_PAGE . '/redact/..');
        } else {
            header("Location: " . APP_WEB_PAGE . '/login');
        }
    }


    public function loginAction()
    {
        if (!empty($_POST['login'] && $_POST['password'])) {

            $login   = $_POST['login'];
            $passwod = $_POST['password'];

            if ($login == APP_ADMIN_LOGIN && $passwod == APP_ADMIN_PASS) {
                $_SESSION['admin'] = true;
                header("Location: " . APP_WEB_PAGE . '/login/..');
            } else {
                $error_message[] = '???????????? ??????????????????????';
            }

        } elseif (isset($_POST['login'])) {

            $error_message[] = '?????????????????? ?????? ????????';
        }
        include_once PROGECT_VIEW_DIR . DIRECTORY_SEPARATOR . 'login.phtml';
    }

    public function outAction()
    {
        $_SESSION['admin'] = false;
        header("Location: " . APP_WEB_PAGE . '/out/..');
    }
}