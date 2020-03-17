<?php

namespace MeDesign\model;

/**
 * Класс предотавляет функцонал по работе С Предложениями
 */
class Sentence extends \MeDesign\core\Model
{
    /**
     * Добавляет предложение в базу данных
     *
     * @param string $sentence
     * @return void
     */
    public function add(string $sentence)
    {
        $pdo = $this->getPDO();
        $sql = "INSERT INTO sentences SET sentence = :sentence";
        $stm = $pdo->prepare($sql);
        $stm->execute([':sentence' => $sentence]);
    }

    /**
     * Добавляет несколько предложений за раз.
     * Производит уникальную ставку, но только до 1024 символов.
     *
     * @param array $sentences
     * @return void
     */
    public function addMultiple(array $sentences)
    {
        $pdo = $this->getPDO();
        $sql = "INSERT IGNORE INTO sentences (sentence) VALUES ";
        foreach ($sentences as $sentence) {
            $sql .= " (?),";
        }
        $sql = substr($sql, 0, -1);
        $stm = $pdo->prepare($sql);
        $stm->execute($sentences);
    }

    /**
     * Выводит все Предложения из базы данных
     *
     * @return array
     */         
    public function getAll() : array
    {
        $pdo = $this->getPDO();
        $sql = "SELECT * FROM sentences ORDER BY created DESC, sentence";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll();
    }

    /**
     * Генерирует Предложения согласно преданному выражению.
     *
     * @param string $expression
     * @return array
     */
    public function generateSentencesByExpression(string $expression) : array
    {
        $expr = $expression;
        $i = 0;
        $matches = [];
        $patterns = [];

        do {
            preg_match_all("/{([^{]+?)}/", $expr, $matches);
            foreach ($matches[1] as $value) {
                $expr = str_replace("{" . $value . "}", "[[" . $i . "]]", $expr);
                ++$i;
            }
            $patterns = array_merge($patterns, $matches[1]);
        } while (!empty($matches[1]));

        $splitPatterns = [];
        foreach ($patterns as $key => $value) {
            $splitPatterns[$key] = explode('|', $value);
        }

        $sentences = [];
        $sentences[] = $expr;

        while (!empty($splitPatterns)) {
            $tmp = [];
            $key = array_key_last($splitPatterns);
            $pattern = array_pop($splitPatterns);
            foreach ($sentences as $value) {
                foreach ($pattern as $words) {
                    $tmp[] = str_replace("[[" . $key . "]]", $words, $value);
                }
            }
            $sentences = $tmp;
        }
        return $sentences;
    }
}
