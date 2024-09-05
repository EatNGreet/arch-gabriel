<?php
namespace Johnoye742\ArchGabriel;

use Dotenv\Dotenv;

class Gabriel {
  public $client;
  public function __construct()
  {
    // Load the env file from the the root dir without exceptions
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv -> safeLoad();

    // Set the hostname and port from env
    $hostname = $_ENV["GAB_HOST"];
    $port = $_ENV["GAB_PORT"];

    $this -> client = new GabClient($hostname, $port);

  }

  /**
   * @param $msg
   * @param $identifier
   * @param $from
   */
  public function message(string $msg, string $identifier, string $from) : int|bool {
    $event = "new message " . $identifier . "\n";
    $this -> client -> redis -> lpush("message:" . $identifier, json_encode(["message" => $msg, "from" => $from]));

    echo "Sent $event";
    return socket_write($this -> client -> socket, $event, strlen($event));
  }


}
