<?php

setlocale(LC_ALL, 'fr_FR');

//Actualités Facebook
$key = "618606544889881|Tze6Ov0h0QvOQQosKdn7ZR1_y3U";
$url = 'https://graph.facebook.com/timcsf?fields=posts.limit(3).fields(message,created_time,icon,name,id,link)&access_token='.$key;
$des = json_decode(file_get_contents($url));
$objPost = $des->posts->data;

$strActualite = "";
foreach($objPost as $valeur)
{
    $id = $valeur->id;
    $leBonId = substr($id,16,17);

    $date= rtrim(strftime('%e %B %G',strtotime($valeur->created_time)),'.');
    $bonneDate = utf8_encode($date);
    $message = limit_text($valeur->message,140);

	$name = isset($valeur->name) ? $valeur->name : "Consultez la nouvelle";

    $strActualite .= "<div class='col'><p class='date icon-clock'>" . $bonneDate . "</p><p>" . $message . " <a target='_blank' target=_blank href='" . $valeur->link . "'>" . $name . "</a></p>" .
        "</div>";
    //$strActualite .= "<div class='col'><p class='date icon-clock'>" . $bonneDate . "</p><p>" . $message . " <a target='_blank' href='" . $valeur->link . "'>" . $valeur->name . "</a></p>" .
   //     "</div>";
}

function limit_text($text, $len) {
    if (strlen($text) < $len) {
        return $text;
    }
    $text_words = explode(' ', $text);
    $out = null;


    foreach ($text_words as $word) {
        if ((strlen($word) > $len) && $out == null) {

            return substr($word, 0, $len) . "...";
        }
        if ((strlen($out) + strlen($word)) > $len) {
            return $out . "...";
        }
        $out.=" " . $word;
    }
    return $out;
}

echo $strActualite;

?>