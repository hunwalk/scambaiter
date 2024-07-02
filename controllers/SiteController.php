<?php

namespace app\controllers;

use app\records\Visitor;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // create a visitor record

        $userAgent = Yii::$app->request->userAgent;
        $browser = '';
        $os = '';
        $language = '';
        $device = '';

        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        }

        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            $os = 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Unix/i', $userAgent)) {
            $os = 'Unix';
        } elseif (preg_match('/FreeBSD/i', $userAgent)) {
            $os = 'FreeBSD';
        } elseif (preg_match('/SunOS/i', $userAgent)) {
            $os = 'SunOS';
        } elseif (preg_match('/BeOS/i', $userAgent)) {
            $os = 'BeOS';
        }

        if (preg_match('/iPhone/i', $userAgent)) {
            $device = 'iPhone';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $device = 'Android';
        } elseif (preg_match('/BlackBerry/i', $userAgent)) {
            $device = 'BlackBerry';
        } elseif (preg_match('/Tablet/i', $userAgent)) {
            $device = 'Tablet';
        } elseif (preg_match('/Mobile/i', $userAgent)) {
            $device = 'Mobile';
        } else {
            $device = 'Computer';
        }

        $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        $visitor = new Visitor();
        $visitor->ip = Yii::$app->request->userIP;
        $visitor->user_agent = $userAgent;

        $visitor->language = $language;
        $visitor->os = $os;
        $visitor->browser = $browser;
        $visitor->device = $device;

        $visitor->created_at = date('Y-m-d H:i:s');
        $visitor->updated_at = date('Y-m-d H:i:s');
        $visitor->save();

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
