<?php
namespace App\Services;

class GrammarCheckerService{
    private $key;
    public $response, $text;

    function __construct(){
        $this->key = config('textgears.key');
        $this->endpoint = config('textgears.endpoint');
    }

    function generate(){
        $validated = $this->validateGrammar();
        return [
            'text' => $this->text,
            'textErrors' => $validated->formatedTextWithErrors(),
            'errorList' => $validated->formattedErrors()
        ];
    }

    function text($text){
        $this->text = $text;
        return $this;
    }

    function key($key){
        $this->key = $key;
        return $this;
    }

    function validateGrammar(){
        $params = http_build_query([
            'key' => $this->key,
            'text' => $this->text,
        ]);

        $url =  $this->endpoint . '?'. $params;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        $this->response = json_decode($response);
        return $this;
    }

    function formattedErrors(){
        $formatedErrors = [];

        foreach($this->response->errors as $errors){
            $formatedErrors[$errors->bad] = array_slice($errors->better, 0, 5, true);
        }

        return $formatedErrors;
    }


    function formatedTextWithErrors(){
        $text = trim(strip_tags($this->text));
        $addedChar = 0;
        foreach($this->response->errors as $error){
            $offset = $error->offset + $addedChar;
            $text = substr_replace($text, "<span style='color:#ff1818;'>", $offset, 0);
            $text = substr_replace($text, "</span>", ($offset + $error->length) + 29, 0);
            $addedChar += 36;
        }
        // foreach($this->formattedErrors() as $index => $value){
        //     $key = $index;
        //     $pattern = "/\b$key\b/i";
        //     $replacement = "<span style='color:#ff1818;'>" . $key . "</span>";
        //     $text =  preg_replace($pattern, $replacement, $text);
        // }

        return $text;
    }
}
