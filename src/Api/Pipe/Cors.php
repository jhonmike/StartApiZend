<?php

namespace Api\Pipe;

use Neomerx\Cors\Analyzer;
use Neomerx\Cors\Contracts\AnalysisResultInterface;
use Neomerx\Cors\Strategies\Settings;

use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class Cors implements MiddlewareInterface
{
    private $options = [
        "origin" => "*",
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => [],
        "headers.expose" => [],
        "credentials" => false,
        "cache" => 0,
        "error" => null
    ];

    private $settings;

    protected $logger;

    public static function factory(ContainerInterface $container) : Cors
    {
        return new self($container->get('config')['cors']);
    }

    public function __construct($options)
    {
        $this->settings = new Settings;

        /* Store passed in options overwriting any defaults. */
        $this->hydrate($options);
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $analyzer = Analyzer::instance($this->buildSettings($request, $delegate));
        if ($this->logger) {
            $analyzer->setLogger($this->logger);
        }
        $cors = $analyzer->analyze($request);

        switch ($cors->getRequestType()) {
            case AnalysisResultInterface::ERR_ORIGIN_NOT_ALLOWED:
                return $this->error($request, $delegate, [
                    "message" => "CORS request origin is not allowed.",
                ])->withStatus(401);
            case AnalysisResultInterface::ERR_METHOD_NOT_SUPPORTED:
                return $this->error($request, $delegate, [
                    "message" => "CORS requested method is not supported.",
                ])->withStatus(401);
            case AnalysisResultInterface::ERR_HEADERS_NOT_SUPPORTED:
                return $this->error($request, $delegate, [
                    "message" => "CORS requested header is not allowed.",
                ])->withStatus(401);
            case AnalysisResultInterface::TYPE_PRE_FLIGHT_REQUEST:
                $cors_headers = $cors->getResponseHeaders();
                foreach ($cors_headers as $header => $value) {
                    /* Diactoros errors on integer values. */
                    if (false === is_array($value)) {
                        $value = (string)$value;
                    }
                    $delegate = $delegate->withHeader($header, $value);
                }
                return $delegate->withStatus(200);
            case AnalysisResultInterface::TYPE_REQUEST_OUT_OF_CORS_SCOPE:
                return $delegate->process($request);
            default:
                /* Actual CORS request. */
                $delegate = $delegate->process($request);
                $cors_headers = $cors->getResponseHeaders();
                foreach ($cors_headers as $header => $value) {
                    /* Diactoros errors on integer values. */
                    if (false === is_array($value)) {
                        $value = (string)$value;
                    }
                    $delegate = $delegate->withHeader($header, $value);
                }
                return $delegate->process($request);
        }
    }

    private function hydrate(array $data = []) : Cors
    {
        foreach ($data as $key => $value) {
            /* https://github.com/facebook/hhvm/issues/6368 */
            $key = str_replace(".", " ", $key);
            $method = "set" . ucwords($key);
            $method = str_replace(" ", "", $method);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
            }
        }
        return $this;
    }

    private function buildSettings(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $origin = array_fill_keys((array) $this->options["origin"], true);
        header('Access-Control-Allow-Origin: '.$this->options['origin'][0]);
        $this->settings->setRequestAllowedOrigins($origin);

        if (is_callable($this->options["methods"])) {
            $methods = (array) $this->options["methods"]($request, $delegate);
        } else {
            $methods = $this->options["methods"];
        }
        $methods = array_fill_keys($methods, true);
        $this->settings->setRequestAllowedMethods($methods);

        $headers = array_fill_keys($this->options["headers.allow"], true);
        $headers = array_change_key_case($headers, CASE_LOWER);
        $this->settings->setRequestAllowedHeaders($headers);

        $headers = array_fill_keys($this->options["headers.expose"], true);
        $this->settings->setResponseExposedHeaders($headers);

        $this->settings->setRequestCredentialsSupported($this->options["credentials"]);

        $this->settings->setPreFlightCacheMaxAge($this->options["cache"]);

        return $this->settings;
    }

    public function setOrigin($origin) : Cors
    {
        $this->options["origin"] = $origin;
        return $this;
    }

    public function setMethods($methods) : Cors
    {
        if (is_callable($methods)) {
            $this->options["methods"] = $methods->bindTo($this);
        } else {
            $this->options["methods"] = $methods;
        }

        return $this;
    }

    public function setHeadersAllow(array $headers) : Cors
    {
        $this->options["headers.allow"] = $headers;
        return $this;
    }

    public function setHeadersExpose(array $headers) : Cors
    {
        $this->options["headers.expose"] = $headers;
        return $this;
    }

    public function setCredentials($credentials) : Cors
    {
        $credentials = !!$credentials;
        $this->options["credentials"] = $credentials;
        return $this;
    }

    public function setCache($cache) : Cors
    {
        $this->options["cache"] = $cache;
        return $this;
    }

    public function setLogger(LoggerInterface $logger = null) : Cors
    {
        $this->logger = $logger;
        return $this;
    }

    public function getLogger() : \Psr\Log\LoggerInterface
    {
        return $this->logger;
    }

    public function getError() : string
    {
        return $this->options["error"];
    }

    public function setError($error) : Cors
    {
        $this->options["error"] = $error;
        return $this;
    }

    public function error(
        ServerRequestInterface $request,
        DelegateInterface $delegate,
        $arguments
    ) : DelegateInterface
    {
        if (is_callable($this->options["error"])) {
            $handler_response = $this->options["error"]($request, $delegate, $arguments);
            if (is_a($handler_response, DelegateInterface::class)) {
                return $handler_response;
            }
        }
        return $delegate;
    }
}
