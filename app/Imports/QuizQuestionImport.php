<?php

namespace App\Imports;

use ErrorException;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class QuizQuestionImport implements ToModel, WithStartRow, WithBatchInserts
{

    public $quiz;

    public function  __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        foreach(explode(config('questions.import_separator'), $row[2]) as $index => $option){
            $optionArray[$index + 1] = trim($option);
        }

        if(count($optionArray) == 0){
            throw new ErrorException("");
        }

        $question = new Question;
        $question->quiz_id = $this->quiz->id;
        $question->body = $row[0];
        $question->type = strtolower($row[1]);
        $question->options = (object) $optionArray;
        $question->answer = $this->getAnswerIndexOutOfOptions(trim($row[2]), trim($row[3]));
        $question->explanation = $row[4];
        $question->case_sensitive = $row[5] = 'Yes' ? 1 : 0;
        $question->save();
    }

    private function getAnswerIndexOutOfOptions($text, $answer){
        $exploded = explode(config('questions.import_separator'), $text);
        if(count($exploded) < 1){
            return $answer;
        }
        foreach($exploded as $index => $value){
            if($value == $answer){
                return $index;
            }
        };
    }

    public function startRow(): int
    {
        return 3;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures)
    {
        return abort();
    }
}
