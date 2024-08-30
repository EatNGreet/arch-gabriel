<?php
namespace Johnoye742\ArchGabriel;

use Predis\Client;

class Server {
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

  public function create() {
    // instantiate a socket connection
    if(($this -> socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) == false) {
      echo "Damn an error!";
    }
    if((socket_bind($this -> socket, $this -> hostname, $this -> port) == false)) {
      echo socket_strerror(socket_last_error());
    }
    $result = socket_connect($this -> socket, $this -> hostname, $this -> port);

    if($result == false) {
      echo "Couldn't connect to Gabriel Server";
    }
  }

  public function listen() {
  }
  
}
