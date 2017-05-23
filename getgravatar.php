<?php
/**
 * Get gravatar
 *
 * @author Nawawi Jamili <nawawi@rutweb.com>
 */

if ( !defined('INDEX_PATH') ) define('INDEX_PATH', dirname(realpath(__FILE__)) . '/' );
if ( !defined('CACERT_FILE') ) define('CACERT_FILE', INDEX_PATH.'cacert.pem' );

/**
 * Retrieve avatar/profile image from gravatar.com
 *
 * @param string $email user email
 * @param string $uagent browser user-agent
 * @param int $size image size
 * @return mixed Return image binary if success, False otherwise
 */
function _get_gravatar($email, $uagent = "Mozilla/5.0", $size = null) {
    $email_hash = md5(strtolower(trim($email)));
    $gravatar_url = "https://gravatar.com/avatar/{$email_hash}?d=blank";
    if ( is_null($size) || $size !== '' ) $gravatar_url .= "&s={$size}";
    $gravatar_url .= "&_".time();

    $options = array(
        "http" => array( 
            "method" => "GET",
            "header" => array( "Content-type: application/x-www-form-urlencoded; charset=UTF-8"),
            "user_agent" => $uagent,
            "timeout" => 15
        ), 
    );

    // php 5.6+
    putenv("SSL_CERT_FILE=".CACERT_FILE);
    $ssl_options = array(
        'ssl' => array( 
            'cafile' => CACERT_FILE,
            'verify_peer' => false, 'verify_peer_name' => false
        )
    );

    $context = stream_context_create($options, $ssl_options);
    $blob = file_get_contents($gravatar_url, false, $context);

    $blank_image = 'iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAIAAAABc2X6AAAABnRSTlMAAAAAAABupge';
    $blank_image .= 'RAAAAKklEQVR4nO3BAQ0AAADCoPdPbQ43oAAAAAAAAAAAAAAAAAAAAAAAAODXAEtQAAGPJpE5AAAAAElFTkSuQmCC';
    $default_image = 'eyJzdWNjZXNzIjpmYWxzZSwibXNnIjoiSW52YWxpZCByZXF1ZXN0In0=';
 
    if ( $blob ) {
        $test_image = base64_encode($result);

        if ( $test_image !== $blank_image && $test !== $default_image ) {
            return $blob;
        }

    }

    return false;
}
