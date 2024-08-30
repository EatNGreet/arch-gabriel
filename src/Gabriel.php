<?php
namespace Johnoye742\ArchGabriel;

use Dotenv\Dotenv;

class Gabriel {
  public $server;
  public function __construct()
  {
    // Load the env file from the the root dir without exceptions
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv -> safeLoad();

    // Set the hostname and port from env
    $hostname = "127.0.0.1";
    $port = 2907;

    $this -> server = new Server($hostname, $port);

    $this -> server -> create();

  }

  public function message(string $msg, string $identifier, string $from) : int|bool {
    $event = "new message " . $identifier;
    $this -> server -> redis -> lpush("message:" . $identifier, json_encode(["message" => $msg, "from" => $from]));

    echo "Sent $event";
    return socket_write($this -> server -> socket, $event, strlen($event));
  }


}
