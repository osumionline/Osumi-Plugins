<?php declare(strict_types=1);

namespace OsumiFramework\OFW\Plugins;

use OsumiFramework\OFW\Log\OLog;

/**
 * Utility class to create a WebSocketServer
 */
class OWebSocket extends WebSocketServer {
  private bool    $debug     = false;
  private ?Olog   $l         = null;
  private array   $smtp_data = [];

  /**
	 * Load debugger and server configuration on startup.
	 */
	function __construct() {
		global $core;
		$this->debug = ($core->config->getLog('level') == 'ALL');
		if ($this->debug) {
			$this->l = new OLog();
		}
		$this->config_data = $core->config->getPluginConfig('websocket');

    parent::__construct($this->config_data['address'], $this->config_data['port'], $this->config_data['bufferLength']);
	}

  /**
   * Function that processes the message sent by a certain user
   * The custom class that implements OWebSocket should have this function.
   *
   * @param WebSocketUser $user User that send the message.
   *
   * @param string $message Message or information sent by the user.
   *
   * @return void
   */
  //protected function process (WebSocketUser $user, string $message): void {
    // Function's content
  //}

  /**
   * Function executed when a new user starts using the server.
   * The custom class that implements OWebSocket should have this function.
   *
   * @param WebSocketUser $user User that just connected.
   *
   * @return void
   */
  //protected function connected (WebSocketUser $user): void {
    // Function's content
  //}

  /**
   * Function executed when a user closes the connection with the server.
   * The custom class that implements OWebSocket should have this function.
   *
   * @param WebSocketUser $user User that just disconnected.
   *
   * @return void
   */
  //protected function closed (WebSocketUser $user): void {
    // Function's content
  //}
}
