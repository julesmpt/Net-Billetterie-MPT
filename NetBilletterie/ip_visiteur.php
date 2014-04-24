<?php
header('Content-Type: text/html; charset=ISO-8859-1');
header('X-UA-Compatible: IE=edge');
setcookie('traceur', 'espion', (time() + 43200));
?>
<?php
function get_ip()
{
    global $REMOTE_ADDR;
    global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
    global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;
    if (empty($REMOTE_ADDR) && PMA_getenv('REMOTE_ADDR')) {
        $REMOTE_ADDR = PMA_getenv('REMOTE_ADDR');
    }
    if (empty($HTTP_X_FORWARDED_FOR) && PMA_getenv('HTTP_X_FORWARDED_FOR')) {
        $HTTP_X_FORWARDED_FOR = PMA_getenv('HTTP_X_FORWARDED_FOR');
    }
    if (empty($HTTP_X_FORWARDED) && PMA_getenv('HTTP_X_FORWARDED')) {
        $HTTP_X_FORWARDED = PMA_getenv('HTTP_X_FORWARDED');
    }
    if (empty($HTTP_FORWARDED_FOR) && PMA_getenv('HTTP_FORWARDED_FOR')) {
        $HTTP_FORWARDED_FOR = PMA_getenv('HTTP_FORWARDED_FOR');
    }
    if (empty($HTTP_FORWARDED) && PMA_getenv('HTTP_FORWARDED')) {
        $HTTP_FORWARDED = PMA_getenv('HTTP_FORWARDED');
    }
    if (empty($HTTP_VIA) && PMA_getenv('HTTP_VIA')) {
        $HTTP_VIA = PMA_getenv('HTTP_VIA');
    }
    if (empty($HTTP_X_COMING_FROM) && PMA_getenv('HTTP_X_COMING_FROM')) {
        $HTTP_X_COMING_FROM = PMA_getenv('HTTP_X_COMING_FROM');
    }
    if (empty($HTTP_COMING_FROM) && PMA_getenv('HTTP_COMING_FROM')) {
        $HTTP_COMING_FROM = PMA_getenv('HTTP_COMING_FROM');
    }
    if (!empty($REMOTE_ADDR)) {
        $direct_ip = $REMOTE_ADDR;
    }
    $proxy_ip     = '';
    if (!empty($HTTP_X_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_X_FORWARDED_FOR;
    } elseif (!empty($HTTP_X_FORWARDED)) {
        $proxy_ip = $HTTP_X_FORWARDED;
    } elseif (!empty($HTTP_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_FORWARDED_FOR;
    } elseif (!empty($HTTP_FORWARDED)) {
        $proxy_ip = $HTTP_FORWARDED;
    } elseif (!empty($HTTP_VIA)) {
        $proxy_ip = $HTTP_VIA;
    } elseif (!empty($HTTP_X_COMING_FROM)) {
        $proxy_ip = $HTTP_X_COMING_FROM;
    } elseif (!empty($HTTP_COMING_FROM)) {
        $proxy_ip = $HTTP_COMING_FROM;
    }
    if (empty($proxy_ip)) {
        return $direct_ip;
    } else {
        $is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
        if ($is_ip && (count($regs) > 0)) {
            return $regs[0];
        } else {
          return FALSE;
        }
    } 
}
function PMA_getenv($var_name) {
    if (isset($_SERVER[$var_name])) {
        return $_SERVER[$var_name];
    } elseif (isset($_ENV[$var_name])) {
        return $_ENV[$var_name];
    } elseif (getenv($var_name)) {
        return getenv($var_name);
    } elseif (function_exists('apache_getenv')
     && apache_getenv($var_name, true)) {
        return apache_getenv($var_name, true);
    }

    return '';
}
$ip = get_ip();
$fournisseur = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$calendrier = date ("d-m-y");
$jours = date (z);
$horaire = date ("H:i:s");
$langage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$port_client = $_SERVER['REMOTE_PORT'];
$port_serveur = $_SERVER['SERVER_PORT'];
$ip_client = get_ip();
$ip_serveur = $_SERVER['SERVER_ADDR'];
$connection = $_SERVER['HTTP_CONNECTION'];
$name_serveur = $_SERVER['SERVER_NAME'];
$protocol = $_SERVER['SERVER_PROTOCOL'];
$admin = $_SERVER['SERVER_ADMIN'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$v6 = preg_match("/^[0-9a-f]{1,4}:([0-9a-f]{0,4}:){1,6}[0-9a-f]{1,4}$/", $ip);
$v4 = preg_match("/^([0-9]{1,3}\.){3}[0-9]{1,3}$/", $ip);
if ( $v6 != 0 )
$format = "adresse IP_v6";
elseif ( $v4 != 0 )
$format = "adresse IP_v4";
else
$format = "non identifier";
?>
<?php
// formattage de la page
$save = "";
$save = ('<div class="gauche">'.'heure de visite :&nbsp;'.$horaire.'<br />'.'date de visite :&nbsp;'.$calendrier.'<br />'.'langue du visiteur :&nbsp;'.$langage.'<br />'.'port pc client :&nbsp;'.$port_client.'<br />'.'adresse ip client :&nbsp;'.$ip_client.'<br />'.'type d\'adresse'.$format.'<br />'.'fournisseur client :&nbsp;'.$fournisseur.'<br />'.'connection client :&nbsp;'.$connection.'<br />'.'protocol client :&nbsp;'.$protocol.'<br />'.'user-agent :&nbsp;'.$agent.'<hr style="color:#ff0000;background-color:#ff0000;border-color:#ff0000;width:80%;size:2px">'.'</div>'."\n");
if($_COOKIE['traceur'])
{
}
elseif (preg_match("/msnbot/i", $fournisseur))
{
return false;
}
elseif (preg_match("/crawl/i", $fournisseur))
{
return false;
}
elseif($agent == 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)')//bots google
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; SLCC1; .NET CLR 1.1.4322; .NET CLR 2.0.40607; .NET CLR 3.0.30729; .NET CLR 3.5.30707)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; SV1; .NET CLR 1.1.4325; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SLCC1; .NET CLR 1.1.4325; .NET CLR 2.0.40607; .NET CLR 3.0.04506.648)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.40607; .NET CLR 3.0.04506.648)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; SLCC1; .NET CLR 1.1.4322; .NET CLR 2.0.40607; .NET CLR 3.0.30729)')// bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SLCC1; .NET CLR 1.1.4325; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)')//bots bing
{
return false;
}
elseif($agent == 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b')//bots msn
{
return false;
}
elseif($agent == 'msnbot/2.0b (+http://search.msn.com/msnbot.htm)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Win64; x64; Trident/4.0)')//bots msn
{
return false;
}
elseif($agent == 'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1) VoilaBot BETA 1.2 (support.voilabot@orange-ftgroup.com)')//bots voila
{
return false;
}
elseif($agent == 'DoCoMo/2.0 N905i(c100;TB;W24H16) (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)')//bots google mobile
{
return false;
}
elseif($agent == 'SAMSUNG-SGH-E250/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/6.2.3.3.c.1.101 (GUI) MMP/2.0 (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)')//bots google mobile
{
return false;
}
else
{
// partie enregistrement de la page
$fp = fopen('/ip.html',a);
fwrite($fp,$save);
fclose($fp);
}
?>
