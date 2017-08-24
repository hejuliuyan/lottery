<?php

/**
 * JS class.
 *
 * Please known that this class is come from cd 6.2.stable
 * visit this the website bellow for more information.
 * http://www.zentao.net/
 *
 * lasted modify by jiang at 2014-9-8
 * 
 * @package Libraries
 */

namespace App\Libraries;

class Js
{
   /**
     * Import a js file.
     * 
     * @param  string $url 
     * @param  string $version 
     * @access public
     * @return string
     */
    public static function import($url, $version = '')
    {
        if(!$version) $version = filemtime(__FILE__);
        echo "<script src='$url?v=$version'></script>\n";
    }

    /**
     * The start of javascript. 
     * 
     * @static
     * @access private
     * @return string
     */
    static private function start($full = true)
    {
        if($full) return "<html><meta charset='utf-8'/><style>body{background:white}</style><script>";
        return "<script>";
    }

    /**
     * The end of javascript. 
     * 
     * @static
     * @access private
     * @return void
     */
    static private function end()
    {
        return "\n</script>\n";
    }

    /**
     * Show a alert box. 
     * 
     * @param  string $message 
     * @static
     * @access public
     * @return string
     */
    static public function alert($message = '')
    {
        return self::start() . "if(window.top) window.top.alertNotic('" . $message . "')" . self::end() . self::resetForm();
    }

    /**
     * Show error info.
     * 
     * @param  string|array $message 
     * @param  boolean $back
     * @static
     * @access public
     * @return string
     */
    static public function error($message, $back = false)
    {
        $alertMessage = '';
        if(is_array($message))
        {
            foreach($message as $item)
            {
                is_array($item) ? $alertMessage .= join('<br/>', $item) . '<br/>' : $alertMessage .= $item . '<br/>';
            }
        }
        else
        {
            $alertMessage = $message;
        }
        if($back) return self::alert($alertMessage).self::locate('back');
        return self::alert($alertMessage);
    }

    /**
     * Reset the submit form. 
     * 
     * @static
     * @access public
     * @return string
     */
    static public function resetForm()
    {
        return self::start() . 'if(window.parent) window.parent.document.body.click();' . self::end();
    }

    /**
     * show a confirm box, press ok go to okURL, else go to cancleURL.
     *
     * @param  string $message       the text to be showed.
     * @param  string $okURL         the url to go to when press 'ok'.
     * @param  string $cancleURL     the url to go to when press 'cancle'.
     * @param  string $okTarget      the target to go to when press 'ok'.
     * @param  string $cancleTarget  the target to go to when press 'cancle'.
     * @return string
     */
    static public function confirm($message = '', $okURL = '', $cancleURL = '', $okTarget = "self", $cancleTarget = "self", $Echo = true)
    {
        $js = self::start();

        $confirmAction = '';
        if(strtolower($okURL) == "back")
        {
            $confirmAction = "history.back(-1);";
        }
        elseif(!empty($okURL))
        {
            $confirmAction = "$okTarget.location = '$okURL';";
        }

        $cancleAction = '';
        if(strtolower($cancleURL) == "back")
        {
            $cancleAction = "history.back(-1);";
        }
        elseif(!empty($cancleURL))
        {
            $cancleAction = "$cancleTarget.location = '$cancleURL';";
        }

        $js .= <<<EOT
if(confirm("$message"))
{
    $confirmAction
}
else
{
    $cancleAction
}
EOT;
        $js .= self::end();
        return $js;
    }

    /**
     * change the location of the $target window to the $URL.
     *
     * @param   string $url    the url will go to.
     * @param   string $target the target of the url.
     * @return  string the javascript string.
     */
    static public function locate($url, $target = "self")
    {
        /* If the url if empty, goto the home page. */
        if(!$url)
        {
            $url = '/';
        }

        $js  = self::start();
        if(strtolower($url) == "back")
        {
            $js .= "history.back(-1);\n";
        }
        else
        {
            $js .= "$target.location='$url';\n";
        }
        return $js . self::end();
    }

    /**
     * Close current window.
     * 
     * @static
     * @access public
     * @return string
     */
    static public function closeWindow()
    {
        return self::start(). "window.close();" . self::end();
    }

    /**
     * Goto a page after a timer.
     *
     * @param   string $url    the url will go to.
     * @param   string $target the target of the url.
     * @param   int    $time   the timer, msec.
     * @return  string the javascript string.
     */
    static public function refresh($url, $target = "self", $time = 3000)
    {
        $js  = self::start();
        $js .= "setTimeout(\"$target.location='$url'\", $time);";
        $js .= self::end();
        return $js;
    }

    /**
     * Reload a window.
     *
     * @param   string $window the window to reload.
     * @return  string the javascript string.
     */
    static public function reload($window = 'self')
    {
        $js  = self::start();
        $js .= "var href = $window.location.href;\n";
        $js .= "$window.location.href = href.indexOf('#') < 0 ? href : href.substring(0, href.indexOf('#'));";

        $js .= self::end();
        return $js;
    }

    /**
     * Execute some js code.
     * 
     * @param string $code 
     * @static
     * @access public
     * @return string
     */
    static public function execute($code)
    {
        $js = self::start($full = false);
        $js .= $code;
        $js .= self::end();
        echo $js;
    }

    /**
     * Set js value.
     * 
     * @param  string   $key 
     * @param  mix      $value 
     * @static
     * @access public
     * @return void
     */
    static public function set($key, $value)
    {
        $js  = self::start(false);
        if(is_numeric($value))
        {
            $js .= "$key = $value";
        }
        elseif(is_array($value) or is_object($value) or is_string($value))
        {
            /* Fix for auto-complete when user is number.*/
            if(is_array($value) or is_object($value))
            {
                $value = (array)$value;
                foreach($value as $k => $v)
                {
                    if(is_numeric($v)) $value[$k] = (string)$v;
                }
            }
            
            $value = json_encode($value);
            $js .= "$key = $value";
        }
        elseif(is_bool($value))
        {
            $value = $value ? 'true' : 'false';
            $js .= "$key = $value";
        }
        else
        {
            $value = addslashes($value);
            $js .= "$key = '$value'";
        }
        $js .= self::end();
        echo $js;
    }
}