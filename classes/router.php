<?php


Class Router
{

    public $base_url;
    public $route;
    public $controller;
    public $action;
    public $args = [];

    private $path;

    private $exclude_params = ['page', 'back'];

    public function start()
    {
        $this->init();

        $file = null;
        $this->getController();
        $this->setBaseUrl();
        try {
            $class = 'Controller_' . $this->controller;
            _A_::$app->registry()->set('controller', $this->controller);
            _A_::$app->registry()->set('action', $this->action);

            $controller = new $class();

            if (is_callable([$controller, $this->action]) == false) {
                $main = new Controller_Main($controller);
                $main->error404();
            } else {
                call_user_func([$controller, $this->action]);
            }
        } catch (Exception $e) {
            (new Controller_Main())->error404($e->getMessage());
        }
    }

    protected function init()
    {
        if (!function_exists('http_build_url')) {
            define('HTTP_URL_REPLACE', 1);                // Replace every part of the first URL when there's one of the second URL
            define('HTTP_URL_JOIN_PATH', 2);            // Join relative paths
            define('HTTP_URL_JOIN_QUERY', 4);            // Join query strings
            define('HTTP_URL_STRIP_USER', 8);            // Strip any user authentication information
            define('HTTP_URL_STRIP_PASS', 16);            // Strip any password authentication information
            define('HTTP_URL_STRIP_AUTH', 32);            // Strip any authentication information
            define('HTTP_URL_STRIP_PORT', 64);            // Strip explicit port numbers
            define('HTTP_URL_STRIP_PATH', 128);            // Strip complete path
            define('HTTP_URL_STRIP_QUERY', 256);        // Strip query string
            define('HTTP_URL_STRIP_FRAGMENT', 512);        // Strip any fragments (#identifier)
            define('HTTP_URL_STRIP_ALL', 1024);            // Strip anything but scheme and host
        }

        $this->parse_url();
        $this->route = (empty(_A_::$app->get('route'))) ? '' : _A_::$app->get('route');
        if (empty($this->route)) $this->route = 'index';
        $this->route = trim($this->route, '/\\');
        $this->setPath(SITE_PATH . 'controllers' . DS);

    }

    private function parse_url()
    {
        $query_string = _A_::$app->server('QUERY_STRING');
        $request_uri = _A_::$app->server('REQUEST_URI');
        parse_str($query_string, $query);
        $query_sef_url = $query['route'];
        $query_path = str_replace('?', '&', $this->revert_sef_url($query_sef_url));
        $query_string = str_replace($query_sef_url, $query_path, $query_string);
        $request_uri = str_replace($query_sef_url, $query_path, $request_uri);
        parse_str($query_string, $query);
        _A_::$app->server('QUERY_STRING', $query_string);
        _A_::$app->server('REQUEST_URI', $request_uri);
        _A_::$app->setGet($query);
    }

    private function revert_sef_url($sef_url, $suff = null, $pref = null)
    {
        $url = $sef_url;
        if (strlen(trim($pref))) {
            $pref = $this->convert($pref);
            if (strlen(trim($pref))) $sef_url = str_replace(trim($pref), '', $sef_url);
        }
        if (strlen(trim($suff))) {
            $suff = $this->convert($suff);
            if (strlen(trim($suff))) $sef_url = str_replace(trim($suff), '', $sef_url);
        }
        $sef_url = preg_replace('/-$/i', '', preg_replace('/^-/i', '', $sef_url));
        $url = Model_Router::get_url($sef_url, $url);
        return $url;
    }

    private function convert($in)
    {
        $out = preg_replace('/[^a-zA-Z0-9]+/i', ' ', $in);
        $out = trim(preg_replace('/\s{2,}/', ' ', $out));
        $out = str_replace(' ', '-', $out);
        return strtolower($out);
    }

    private function setPath($path)
    {
        $path = rtrim($path, '/\\');
        $path .= DS;

        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    function getController()
    {
        $parts = explode('/', $this->route);
        $cmd_path = $this->path;
        foreach ($parts as $part) {
            if (is_dir($cmd_path . $part)) {
                $cmd_path .= $part . DS;
                array_shift($parts);
                continue;
            }
            if (is_file($cmd_path . '_' . $part . '.php')) {
                $this->controller = $part;
                array_shift($parts);
                break;
            }
        }
        if (empty($this->controller)) $this->controller = 'index';
        $this->action = array_shift($parts);
        if (empty($this->action)) $this->action = $this->controller;
        $this->args = $parts;
    }

    private function setBaseUrl()
    {
        $end_uri = explode(DS, _A_::$app->server('REQUEST_URI'));
        $end_get = explode(DS, _A_::$app->get('route'));
        array_pop($end_uri);
        $end_uri = array_filter(array_diff($end_uri, $end_get));
        if ($this->action == 'post') array_pop($end_uri);
        $this->base_url = strtolower(explode(DS, _A_::$app->server('SERVER_PROTOCOL'))[0]) .
            "://" . _A_::$app->server('SERVER_NAME') .
            (_A_::$app->server('SERVER_PORT') == '80' ? '' : ':' . _A_::$app->server('SERVER_PORT'));
        if (count($end_uri)) $this->base_url .= DS . implode(DS, $end_uri);
        define('BASE_URL', $this->base_url);
    }

    public function redirect($url)
    {
        exit("<script>window.location='" . $url . "';</script>");
    }

    public function RefTo($path, $params = null)
    {
        $url = http_build_url($path, ['query', http_build_query($params)]);
        return $url;
    }

    public function UrlTo($path, $params = null, $to_sef = null, $sef_exclude_params = [])
    {
        $sef_exclude_params = array_merge($this->exclude_params, $sef_exclude_params);
        $path = rtrim(trim($path), DS);
        if (strpos($path, '{base_url}') !== false) {
            $path = str_replace('{base_url}', $this->base_url, $path);
        }
        $_path = $path;
        if (strpos($_path, $this->base_url) !== false) $_path = trim(str_replace($this->base_url, '', $path), '/\\');
        if (preg_match('#(.*)\?(.*)#i', $_path, $matches)) $_path = $matches[1];
        if (count($matches) > 2) {
            parse_str($matches[2], $_params);
            $params = array_merge($params, $_params);
        }
        $sef_include_params = isset($params) ? array_diff_key($params, array_flip($sef_exclude_params)) : [];
        $_path = $this->http_build_url(trim($_path, DS), ['query' => http_build_query($sef_include_params)]);
        if (isset($to_sef)) {
            $path = $this->build_sef_url($to_sef, $_path);
        } else {
            $path = Model_Router::get_sef_url($_path);
        }
        $params = isset($params) ? array_intersect_key($params, array_flip($sef_exclude_params)) : [];
        if (strpos($path, $this->base_url) == false) $path = $this->base_url . DS . $path;
        if (!is_null($params) && is_array($params) && (count($params) > 0)) $url = $this->http_build_url($path, ['query' => http_build_query($params)]);
        else $url = $this->http_build_url($path);
        return $url;
    }

    private function http_build_url($url, $parts = array(), $flags = null, &$new_url = false)
    {
        if (!function_exists('http_build_url')) {

            if (is_null($flags)) $flags = HTTP_URL_REPLACE;
            $keys = ['user', 'pass', 'port', 'path', 'query', 'fragment'];

            // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
            if ($flags & HTTP_URL_STRIP_ALL) {
                $flags |= HTTP_URL_STRIP_USER;
                $flags |= HTTP_URL_STRIP_PASS;
                $flags |= HTTP_URL_STRIP_PORT;
                $flags |= HTTP_URL_STRIP_PATH;
                $flags |= HTTP_URL_STRIP_QUERY;
                $flags |= HTTP_URL_STRIP_FRAGMENT;
            } // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
            else if ($flags & HTTP_URL_STRIP_AUTH) {
                $flags |= HTTP_URL_STRIP_USER;
                $flags |= HTTP_URL_STRIP_PASS;
            }

            // Parse the original URL
            $parse_url = parse_url($url);

            // Scheme and Host are always replaced
            if (isset($parts['scheme']))
                $parse_url['scheme'] = $parts['scheme'];
            if (isset($parts['host']))
                $parse_url['host'] = $parts['host'];

            // (If applicable) Replace the original URL with it's new parts
            if ($flags & HTTP_URL_REPLACE) {
                foreach ($keys as $key) {
                    if (isset($parts[$key]))
                        $parse_url[$key] = $parts[$key];
                }
            } else {
                // Join the original URL path with the new path
                if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
                    if (isset($parse_url['path']))
                        $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
                    else
                        $parse_url['path'] = $parts['path'];
                }

                // Join the original query string with the new query string
                if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
                    if (isset($parse_url['query']))
                        $parse_url['query'] .= '&' . $parts['query'];
                    else
                        $parse_url['query'] = $parts['query'];
                }
            }

            // Strips all the applicable sections of the URL
            // Note: Scheme and Host are never stripped
            foreach ($keys as $key) {
                if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
                    unset($parse_url[$key]);
            }


            $new_url = $parse_url;

            return
                ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
                . ((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') . '@' : '')
                . ((isset($parse_url['host'])) ? $parse_url['host'] : '')
                . ((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
                . ((isset($parse_url['path'])) ? $parse_url['path'] : '')
                . ((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
                . ((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '');
        } else {
            return http_build_url($url, $parts = array(), $flags = HTTP_URL_REPLACE, $new_url);
        }

    }

    private function build_sef_url($to_url, $url, $suff = null, $pref = null)
    {
        $sef_url = $this->convert(trim($to_url));
        $url = Model_Router::set_sef_url($sef_url, $url);
        if (strlen(trim($pref))) {
            $pref = $this->convert($pref);
            if (strlen(trim($pref))) $url = $pref . '-' . trim($url);
        }
        if (strlen(trim($suff))) {
            $suff = $this->convert($suff);
            if (strlen(trim($suff))) $url = $url . '-' . trim($suff);
        }
        $url = strtolower($url);
        return $url;
    }
}
