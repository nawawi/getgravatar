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
    if ( !is_null($size) && $size !== '' ) $gravatar_url .= "&s={$size}";
    $gravatar_url .= "&_=".time();

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

    // https://www.gravatar.com/avatar/00000000000000000000000000000000?d=blank&f=y
    $blank_image = "iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAIAAAC2BqGFAAAABnRSTl";
    $blank_image .= "MAAAAAAABupgeRAAAAQElEQVR4nO3BAQEAAACCIP+vbkhAAQAAAAA";
    $blank_image .= "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALwapO";
    $blank_image .= "AABLz73LwAAAABJRU5ErkJggg==";

    // https://www.gravatar.com/avatar/00000000000000000000000000000000
    $default_image = "/9j/4AAQSkZJRgABAQAAAQABAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh";
    $default_image .= "1c2luZyBJSkcgSlBFRyB2NjIpLCBxdWFsaXR5ID0gOTAK/9sAQwADAgIDAgIDAw";
    $default_image .= "MDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4LCxAWEBETFBUVFQwPF";
    $default_image .= "xgWFBgSFBUU/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQUFBQUFBQUFBQUFBQUFBQU";
    $default_image .= "FBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU/8AAEQgAUABQAwEiAAIRAQM";
    $default_image .= "RAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBA";
    $default_image .= "MFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJC";
    $default_image .= "hYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3";
    $default_image .= "eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycr";
    $default_image .= "S09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAA";
    $default_image .= "AAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQ";
    $default_image .= "VEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpD";
    $default_image .= "REVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5i";
    $default_image .= "ZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6v";
    $default_image .= "Lz9PX29/j5+v/aAAwDAQACEQMRAD8A8hooor+iD+YQo/CiigAo9a+h/wBmn9ku4";
    $default_image .= "+OOmXOvapqkmjeH4pjbxGCMPNcyAAttzwqjIGSDk5GODXsOuf8ABOPSHt2OkeM7";
    $default_image .= "63mA4F7aJMp/75KYrwa+eYHDVXRqT1W+jdvuPosPw/mOKoqvSp+69tUr/ez4Xor";
    $default_image .= "2T4qfsoePvhZDNeT2Met6RHlmvtLJkEa+roQGX3OCB6142DkZr1aGJo4qHPRkpL";
    $default_image .= "yPHxOFr4Sfs68HF+Yd6PSiiuk5Qoor2v8AZF+FUPxU+MNjFfQibR9JQ6jeIwysm";
    $default_image .= "0gRxn1DOVyO6hq5sTXhhaMq09oq51YXDzxdeFCnvJ2Pa/2bf2JtK1vwxb+JPiHb";
    $default_image .= "3Ez3yCW00dZXhEcR5DylSG3N1CgjA65JwPPv2sv2ddA+FsEGu+FPOt9OacW1zYT";
    $default_image .= "SmURlgSrozZbHGCCT1GK/QfX9UXSbB5CcHHFfnR+1n8aF8Za1J4U04h7SxuRJeX";
    $default_image .= "APDzKCBGPZcnJ9eO3P5vlmYZhj8xUlJ8vVfZS9P6Z+qZtlmW5blbhKC5tk/tOXr";
    $default_image .= "+a2sfV/7Dox+zrof/Xzd/8Ao969uu9WhtHCu4Uk45NeJfsPf8m66F/183f/AKPe";
    $default_image .= "uQ/bdvpoPhXqnlSvE6XNsyujEMpE6YII6GvExdH6xmk6N7c02vvZ9Bg6/wBVyen";
    $default_image .= "Xtflpp29In048ceoQkjBzXxZ+1f8Ass24gvPF3hGzW2vIgZr7TYFwk69WkjUdHH";
    $default_image .= "UqPvdev3l/ZC/avv7nXLLwR40vGuxdsIdN1adsyCQ/dhlP8W7orHnOAc5BH2X4g";
    $default_image .= "sFu7NzjkCraxeQYtd/wkv6+4yjLBcSYJ6afjF/195+MgYMMiivUv2k/h3H8Ofin";
    $default_image .= "fQWkQi0zUV+3WyKMKm4kOg+jA4HYFa8tr9gw1eGKoxrQ2krn4jisNPB150Km8XY";
    $default_image .= "K+6v+Cceixx+G/GerbQZp7uC13dwqIzY/OT9K+Fa+6v8AgnHrUUvhvxnpOQJoLu";
    $default_image .= "C629yroy5/OP8AWvD4i5v7NqW8vzR9Bwvy/wBqU+btK33M9r/aD8Sy+GfBWt6jF";
    $default_image .= "9+ysZp0B7sqEgfmBX5Uq7ylpJGMkjks7sclieSTX6v/AB58JyeLfBOuaZCP3t7Y";
    $default_image .= "zW6E9mZCFP5kV+UJjeFmjlRo5UJR0YYKkcEEeteJwlyclX+a6+7+rn0HGnP7Sj/";
    $default_image .= "LZ/fpf9D9Lv2G72B/2dtKVZVY293dRygH7jeaWwfwZT+NcH+25qkE3wx1KMOA0l";
    $default_image .= "zbogP8R81WwPwUn8K+SPhh8bvFvwhkuh4evkS0uyGnsblPMgkYDAbbkENjjKkH1";
    $default_image .= "zVP4jfFjxJ8VLyGbXruNoYSWitLZPLhRj1bGSSfck1o8hr/ANqfWuZcnNzee97W";
    $default_image .= "MlxHh1lH1PlftOXl8trXv6ficnBNJbSxzQu0U0bB0dDhlYHIIPrmv2D+G/iR/G3";
    $default_image .= "wz8N65MB52paZb3UuBgB2jUsPzJr8fIIJLmaOGGNpZpGCIiDJZicAAeua/YL4c+";
    $default_image .= "HH8EfDLw5oc2PO03TILaUg8F1jAb/x4Go4t5PZ0f5rv7tL/oXwXz+1rW+Gy++7t";
    $default_image .= "+p8Z/t56VGIfDmoBQJIrqa3z6h0Df8AtP8AWvkavrP9u3Wo5U8PaeGBkkupbjHs";
    $default_image .= "iBf/AGpXyZXscOc39nQv3f5s8Pinl/tSduyv9yD8a9q/ZF+K0Pwr+MNjLfziHR9";
    $default_image .= "WQ6deOxwse8gxyH0CuFyeylq8VoPNe9iaEMVRlRntJWPnMLiJ4SvCvT3i7n7Sal";
    $default_image .= "ZJfW7IcH0r4Y/aj/ZP1U6zeeLvB9k16twxlv8AS4FzJv7yxL/FnqVHOeRnJx1H7";
    $default_image .= "Jv7XVtd6bZeCvG16Le+gVYNO1W4bCXCDhYpGPRxwAx4YYB+b731+Jre5HJFfkCe";
    $default_image .= "LyDF7a/hJf19x+3tYLiTBLXT8Yv+vkz8XZYngmeKVGilQlXjcbWUjqCD0NLBDJc";
    $default_image .= "zRwwo8ssjBUjjBZmJ6AAdTX7A+Ivhf4M8YSebrnhnSNXmxgTXlnHJIB/vEZ/Wne";
    $default_image .= "G/hv4N8ES+dofhrR9HmxjzrOzjjkx/vAZ/Wvqf9bafJ/BfN66fl+h8f/qXV57e2";
    $default_image .= "XL6a/df9T5P/ZH/AGSNR0/WrLxx44smsvsrCbTdIuFxL5n8M0q/w7eqqec4Jxjn";
    $default_image .= "638Za4mmac67hvYdM1JrXiy102Ftrhnx618PftO/tNLqAu/DXhq7E91JmK8v4Wy";
    $default_image .= "sC9CiEdXPQkfd+vT5WUsXn+LWmv4RX9fefYxjguHME9dPxk/6+48W/aD8fp8Qvi";
    $default_image .= "Ze3FvL5unWA+x27g8PtJLuPqxOD3AFecfjSKoRQAMAUtfr+Fw8cLRjRhtFWPxDF";
    $default_image .= "4meMrzr1N5O4UUUV1HIIRkc16/8NP2pvHnwzt4rKG/XWtJjAVLLUwZPLX0RwQyj";
    $default_image .= "0GSB6V5DRXNXw1HFR5K0VJeZ14bFV8JP2lCbi/I+y9L/AOCgdq8A/tLwte28uOf";
    $default_image .= "sl0kqk/8AAguKqa5+3xBLCw03w1ezSEcfarlIgP8AvkNXx/RXhf6uZdzX5H97/w";
    $default_image .= "Az6L/WjNOXl9ovWy/yPTfiJ+0X40+IyS21xerpWmycNaaflN49HcksfcZAPpXmK";
    $default_image .= "qFGAMD2paK93D4ajhYclGKivI+dxOLr4uftK83J+YUUUV0nKf/Z";
 
    if ( $blob ) {
        $test_image = base64_encode($result);

        if ( $test_image !== $blank_image && $test_image !== $default_image ) {
            return $blob;
        }

    }

    return false;
}
