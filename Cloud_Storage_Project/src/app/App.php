<?php

declare(strict_types=1);

namespace App;

use App\Exception\RouteNotFoundException;
use PDOException;

class App
{
    private static DB $db;

    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config
    ) {
        static::$db = new DB($config->db ?? null);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            print_r($this->router->resolve(
                $this->request['uri'],
                $this->request['method']
            ));
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            echo View::make('error/404');
        } catch (PDOException $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
    }
}
