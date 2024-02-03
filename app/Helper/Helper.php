<?php

if(! function_exists('getVersion')){
    function getVersion(){
        return "2.5.2";
    }
}

if(! function_exists('checkThumbnailUrlFileTypeFixer')){
    function checkThumbnailUrlFileTypeFixer($fileUrl){
        $headers = @get_headers($fileUrl);
        if(strpos($headers[0], '404')) {
            $file = explode('.',basename($fileUrl));
            $replace = ctype_upper($file[1]) ? strtolower($file[1]) : strtoupper($file[1]);
            return str_replace($file[1], $replace, $fileUrl);
        }else{
            return $fileUrl;
        }
    }
}


if(! function_exists('youtubeEmbedFromUrl')){
    function youtubeEmbedFromUrl($source){
        return "https://www.youtube.com/embed/" . audioBookSourceFormat('youtube_video', $source);
    }
}

if(! function_exists('audioBookSourceFormat')){
    function audioBookSourceFormat($type, $source){
        if($type == "youtube_video"){
            
            foreach(config('audiobook.youtube_link_prefix') as $prefix){
                if(\Str::contains($source, $prefix)){
                    return str_replace('&list','?list', str_replace($prefix, '', $source));
                }

                continue;
            }
            return $source;
        }

        return $source;
    }
}


if(! function_exists('domainBranch')){
    function domainBranch(){
        return (new App\Services\BranchService)->branchFromRequest();
    }
}

if(! function_exists('notification_url')){
    function notification_url($url, $id){
        $url_parts = parse_url($url);
        if (isset($url_parts['query'])){
            return $url . '&n=' . $id;
        } else {
            return $url . "?n=" . $id;
        }
    }
}

function backEndView($file, $data = []){
    return view('back-end.' . $file, $data);
}


function validateGrammar($text){
    $key = "yfXYXGanjgRAW4oW";
    $url = 'https://api.textgears.com/check.php?text='.$text.'&key='.$key;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);

}


if(! function_exists('makeStarInString'))
{
    //return show
    function makeStarInString($label){
        if($label != ""){
            $secondLetter =  mb_substr($label, 1, 1, 'UTF-8');
            return str_replace($secondLetter, '*', $label);
        }
        return "";
    }
}

if(! function_exists('back_end_active_menu'))
{
    //return show
    function back_end_active_menu($label, $segment, String $return = 'menu-open'){
        if(is_array($label)){
            return  in_array(Request::segment($segment), $label) ? $return : '';
        }else{
            return  Request::segment($segment) == $label ? $return : '';
        }
    }
}



if(! function_exists('back_end_active_menu_true')){
    function back_end_active_menu_true($label, $segment){
        if(is_array($label)){
            return  in_array(Request::segment($segment), $label) ? 'style="display:block"' : '';
        }else{
            return  Request::segment($segment) == $label ? 'style="display:block"' : '';
        }
    }
}


