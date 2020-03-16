<?php 

namespace MeDesign\controller;

class MainController extends \MeDesign\core\Controller
{
    public function actionIndex()
    {
        $this->render();
        exit();
    }

    public function actionGenerateSentence() {
        $model = new \MeDesign\model\Sentence();

        if (!empty($_POST['expression'])) {
            $expression = $_POST['expression'];

            $sentences = $model->generateSentencesByExpression($expression);

            $model->addMultiple($sentences);
            // $model->add($expression);
            $sentences = $model->getAll();
            $this->render('sentences', ['sentences' => $sentences]);
        } else {
            $this->render('index', ['message' => 'Введите выражение!']);
        }

        exit();
    }

    public function action404() 
    {
        $this->render("404");
        exit();
    }

    public function action500() 
    {
        $this->render("500");
        exit();
    }
}
