<?php
/**
 * Created by PhpStorm.
 * User: Usmon
 * Date: 13.03.2019
 * Time: 20:24
 */

Class SiteController extends Controller {

    public function home() {
        //Get all items
        $news = new NewsModel();
        $data['list_news'] = $news->getAll();

        //Begin Render
        $this->render('_header', ['title'=>'Bosh sahifa']); // Head side
        $this->render('home', $data); // Content
        $this->render('_footer'); // Footer side
    }

    public function news() {
        $news = new NewsModel();
        $data['list_news'] = $news->getAll();
        $this->render('news', $data);
    }

    public function about() {

        $this->render('_header', ['title'=>'Biz haqimizda']); // Head side
        $this->render('about'); // Content
        $this->render('_footer'); // Footer side
    }

    public function contact() {
        if ($_POST) {
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $subject = $_POST['Subject'];
            $message = $_POST['Message'];
            $fullText = 'Name: '.$name;
            $fullText .= 'Email: '.$email;
            $fullText .= 'Message: '.$message;
            global $params;
            if (mail($params['adminMail'], $subject, $fullText)) {
                header('Location: index.php?route=contact');
            }
            else {
                echo 'Xatolik!';
            }

        }

        $this->render('_header', ['title'=>'Bog`lanish']);
        $this->render('contact');
        $this->render('_footer');
    }

    public function createNews(){
        $title = trim(isset($_GET['title']) ? $_GET['title'] : '');
        $body = trim(isset($_GET['body']) ? $_GET['body'] : '');
        if (!empty($title) && !empty($body) )
        {
            $new = new NewsModel();
            $new->create($title, $body);
        }
        else
        {
            echo "Bo`sh bo`lmasligi kerak!";
        }

    }

    public function searchNews() {
        $key = $_GET['key'];
        $news = new NewsModel();
        $items = $news->search($key);
        var_dump($items);
    }

    public function updateNews() {
        $id = $_GET['id'];
        $title = trim(isset($_GET['title']) ? $_GET['title'] : '');
        $body = trim(isset($_GET['body']) ? $_GET['body'] : '');
        $news = new NewsModel();
        $news->update($id, $title, $body);
    }

    public function deleteNews() {
        $id = $_GET['id'];
        $news = new NewsModel();
        $news->deleteById($news->table, $id);
    }

}