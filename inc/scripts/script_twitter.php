<?php

setlocale(LC_ALL, 'fr_FR');

//Actualités Twitter

//1 - Configuration
$consumer_key='73ScsBGIJ25wK4YNA4guVQ'; //Provide your application consumer key
$consumer_secret='T4ffzc6J9BGCxPZh3vwRkiIv1ZLBUTZHbsqjD3ejRs'; //Provide your application consumer secret
$oauth_token = '516726609-8B75YPlPRuCI1PSjeJCxdjdgH8utelkSFmiKjNEf'; //Provide your oAuth Token
$oauth_token_secret = 'BOqw2kxT2RWfj6PvFdQHOrJaomlN6bVKHFR6I0zydx2jI'; //Provide your oAuth Token Secret


if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {

    //2 - Inclut la librairie twitterOAuth
    require_once 'twitteroauth/twitteroauth.php';

    //3 - Authentification
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

    //4 - Start Querying
    $query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=timcsf&count=3'; //Your Twitter API query
    $content = $connection->get($query);
    $arrTwitter = $content;

}

//Transform Tweet plain text into clickable text

function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '@<a  target="_blank" href="http://twitter.com/$1">$1</a>', $text); //usernames
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Links
    return $text;
}

$strActualite = "";


foreach($arrTwitter as $tweet){
    $dateTweet= rtrim(strftime('%e %B %G',strtotime($tweet->created_at)),'.');
    $bonneDateTweet = utf8_encode($dateTweet);

    $strActualite .= '
        <div class="col">
                <p class="date icon-clock">' . $bonneDateTweet . '</p>
                <p>' . parseTweet($tweet->text) . '</p>
                

            </div>';
}

echo $strActualite;

?>