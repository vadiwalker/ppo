<?php

class Server {
    protected $base;

    public function __construct($base) {
        $this->base = $base;
    }

    public function getBase() {
        return $this->base;
    }
}

class BinanceServer extends Server {

    public function __construct($base = 'https://api.binance.com/api/') {
        $this->base = $base;
    }

    public function getBase() {
        return $this->base;
    }
}

class BinanceMethodManager {
    public function __construct() {}

    public function allPricesMethod() {
        return 'v1/ticker/allPrices';
    }
}

class Connection {
    public $server;

    public function __construct($server) {
        $this->server = $server;
    }

    public function request($url, $params = [], $method = "GET") {
        $opt = [
            "http" => [
                "method" => $method,
                "header" => "User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\n"
            ]
        ];
        $context = stream_context_create($opt);
        $query = http_build_query($params, '', '&');

        return json_decode(file_get_contents($this->server->getBase().$url.'?'.$query, false, $context), true);
    }
}

class Binance {
    protected $connection, $api_key, $api_secret;
    protected $methodManager;

    public function __construct($api_key, $api_secret, $connection, $methodManager) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->connection = $connection;
        $this->methodManager = $methodManager;
    }

    public function price($coin) {
        $prices = $this->prices();
        return $prices[$coin];
    }

    private function prices() {
        return $this->priceData($this->connection->request($this->methodManager->allPricesMethod()));
    }
    
    private function priceData($array) {
        $prices = [];
        foreach ( $array as $obj ) {
            $prices[$obj['symbol']] = $obj['price'];
        }
        return $prices;
    }
}

?>