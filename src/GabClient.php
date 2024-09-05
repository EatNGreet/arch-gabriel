<?php
namespace Johnoye742\ArchGabriel;

use Predis\Client;

class GabClient {
  public Client $redis;
  public $socket;

  /**
   * @param $port
   * @param $hostname
   */
  public function __construct(public $hostname, public $port)
  {
    // Set the redis client connection
    $this -> redis = new Client();
  }

  /**
   * @return void
   */
  public function create(): void {
    // instantiate a socket connection
    if(($this -> socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) == false) {
      echo "Damn an error!";
    }
    $result = socket_connect($this -> socket, $this -> hostname, $this -> port);

    if($result == false) {
      echo "Couldn't connect to Gabriel Server";
    }

  }

  /**
   * @param $on
   * @param $callback
   */
  public function listen($on, $callback) : void {
    while(true) {
        $data = "";
        socket_recv($this -> socket, $data, 1024, MSG_DONTWAIT);

        if(trim($data) == $on) {
          $callback();
        }
      }
      

  }
  
}
