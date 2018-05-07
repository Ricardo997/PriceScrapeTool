<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Register;
use App\Entity\Update;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;

class PriceScrapeController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
        $login = new Login();
        $form = $this->createFormBuilder($login)
            ->setAction('/')
            ->setMethod('POST')
            ->add('mail', EmailType::class, array('label' => 'Redeem email'))
            ->add('password', PasswordType::class)
            ->add('go', SubmitType::class, array('label' => 'Login', 'attr' => array('class' => 'btn btn-primary btn-block')))
            ->getForm();
        return $this->render('price_scrape/login.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/", name="index");
     */
    public function index(Request $request)
    {
        require 'functions.php';
        $session = $request->getSession();
        $form = $request->request->get('form');
        $login = false;
        if ($session->get('name') == null) {
            $users = getUsers();
            $mail = $form['mail'];
            $pass = $form['password'];
            for ($i = 0; $i < count($users); $i++) {
                if ($users[$i]['mail'] == $mail) {
                    if (password_verify($form['password'], $users[$i]['password'])) {
                        $session->set('userID', $users[$i]['userID']);
                        $session->set('name', $users[$i]['firstName']);
                        $login = true;
                    }
                }
            }
        } else {
            $items = getItems();
            return $this->render('price_scrape/index.html.twig', array('name' => $session->get('name'), 'items' => $items));
        }
        if (!$login) {
            return $this->redirect('/login');
        } else {
            $items = getItems();
            return $this->render('price_scrape/index.html.twig', array('name' => $session->get('name'), 'items' => $items, 'users' => $users));
        }
    }
    /**
     * @Route("/add", name="addDevice");
     */
    public function addDevice(Request $request)
    {
        $session = $request->getSession();
        if ($session->get('name') == null) {
            return $this->redirect('/login');
        } else {
            return $this->render('price_scrape/add-device.html.twig', array('name' => $session->get('name')));
        }
    }
    /**
     * @Route("/update", name="update");
     */
    public function update(Request $request)
    {
        $session = $request->getSession();
        if ($session->get('name') == null) {
            return $this->redirect('/login');
        } else {
            return $this->render('price_scrape/update.html.twig', array('name' => $session->get('name')));
        }
    }
    /**
     * @Route("/register", name="register");
     */
    public function register(Request $request)
    {
        require 'functions.php';
        $register = new Register();
        $form = $this->createFormBuilder($register)
            ->setMethod('POST')
            ->add('firstName', TextType::class, array('label' => 'First Name'))
            ->add('lastName', TextType::class, array('label' => 'Last Name'))
            ->add('mail', EmailType::class, array('label' => 'Email address'))
            ->add('password', PasswordType::class, array('label' => 'Password'))
            ->add('go', SubmitType::class, array('label' => 'Register', 'attr' => array('class' => 'btn btn-primary btn-block')))
            ->getForm();
        if ($request->request->get('form') == null) {

            return $this->render('price_scrape/register.html.twig', array(
                'form' => $form->createView(),
                'error' => false,
            ));
        } else {
            $con = new PDO("mysql:host=localhost;dbname=scrapeprices", 'Ricardo', 'admin');
            $users = getUsers();
            $exists = false;
            $data = $request->request->get('form');
            for ($i = 0; $i < count($users); $i++) {
                if ($data['mail'] == $users[$i]['mail']) {
                    $exists = true;
                }
            }
            if (!$exists) {
                $ins = "INSERT INTO `users`(`userID`,`firstName`,`lastName`,`mail`,`password`) VALUES (null, '" . $data['firstName'] . "', '" . $data['lastName'] . "', '" . $data['mail'] . "', '" . password_hash($data['password'], PASSWORD_BCRYPT) . "')";
                $con->query($ins);
                return $this->redirect('/login');
            } else {
                $error = true;
                return $this->render('price_scrape/register.html.twig', array(
                    'form' => $form->createView(),
                    'error' => $error,
                ));
            }
        }
    }

    /**
     * @Route("/delete", name="delete");
     */
    public function deleteDevice(Request $request){
        require 'functions.php';
        $session = $request->getSession();
        if ($session->get('name') == null) {
            return $this->redirect('/login');
        } else {
            $items = getItems();
            return $this->render('price_scrape/delete-device.html.twig', array('name' => $session->get('name'), 'items' => $items));
        }
    }

    /** 
     * @Route("/history", name="history");
     */
    public function history(Request $request){
        require 'functions.php';
        $session = $request->getSession();
        if ($session->get('name') == null) {
            return $this->redirect('/login');
        } else {
            $items = getItems();
            return $this->render('price_scrape/history.html.twig', array('name' => $session->get('name'), 'items' => $items));
        }
    }
}
?>