<?php

namespace MeDesign\model;

class Sentence extends \MeDesign\core\Model
{
    public function add(string $sentence)
    {
        $pdo = $this->getPDO();
        $sql = "INSERT INTO sentences SET sentence = :sentence";
        $stm = $pdo->prepare($sql);
        $stm->execute([':sentence' => $sentence]);
    }

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

    public function getAll()
    {
        $pdo = $this->getPDO();
        $sql = "SELECT * FROM sentences ORDER BY created DESC";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function generateSentencesByExpression(string $expression) 
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
