<?php declare(strict_types=1);
class OPaypal {
	private bool    $sandbox = false;
	private ?string $paypal_url = null;
	private string  $lc = 'ES';
	private string  $currency = 'EUR';
	private ?string $business = null;
	private ?string $cancel_return = null;
	private ?string $ok_return = null;
	private ?string $notify_url = null;
	private array   $items = [];
	
	public function __construct(bool $sandbox = false) {
		$this->sandbox = $sandbox;
		$this->paypal_url = $sandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	}

	/**
	 * Set the Paypal URL (to use in Sandbox or Production)
	 *
	 * @param string $url Paypal URL
	 *
	 * @return void
	 */
	public function setPaypalUrl(string $url): void {
		$this->paypal_url = $url;
	}

	/**
	 * Get the defined Paypal URL
	 *
	 * @return string Paypal URL
	 */
	public function getPaypalUrl(): ?string {
		return $this->paypal_url;
	}

	/**
	 * Set the Language Code
	 *
	 * @param string $lc Language Code
	 *
	 * @return void
	 */
	public function setLC(string $lc): void {
		$this->lc = $lc;
	}

	/**
	 * Get the Language Code
	 *
	 * @return string LanguageCode
	 */
	public function getLC(): string {
		return $this->lc;
	}

	/**
	 * Set the Currency code (EUR / USD...)
	 *
	 * @param string $cur Currency code
	 *
	 * @return void
	 */
	public function setCurrency(string $cur): void {
		$this->currency = $cur;
	}

	/**
	 * Get the Currency code
	 *
	 * @return string Currency code
	 */
	public function getCurrency(): string {
		return $this->currency;
	}

	/**
	 * Set the business email address used to identify on Paypal
	 *
	 * @param string $bus Business email address
	 *
	 * @return void
	 */
	public function setBusiness(string $bus): void {
		$this->business = $bus;
	}

	/**
	 * Get the business email address used to identify on Paypal
	 *
	 * @return string Business email address
	 */
	public function getBusiness(): string {
		return $this->business;
	}

	/**
	 * Set the URL where the user will be sent if operation is cancelled
	 *
	 * @param string $url URL in case of cancelled operation
	 *
	 * @return void
	 */
	public function setCancelReturn(string $url): void {
		$this->cancel_return = $url;
	}

	/**
	 * Get the URL where the user will be sent if operation is cancelled
	 *
	 * @return string URL in case of cancelled operation
	 */
	public function getCancelReturn(): string {
		return $this->cancel_return;
	}

	/**
	 * Set the URL where the user will be sent if operation is successful
	 *
	 * @param string $url URL in case of successful operation
	 *
	 * @return void
	 */
	public function setOKReturn(string $url): void {
		$this->ok_return = $url;
	}

	/**
	 * Get the URL where the user will be sent if operation is successful
	 *
	 * @return string URL in case of successful operation
	 */
	public function getOKReturn(): string {
		return $this->ok_return;
	}

	/**
	 * Set the URL where Paypal will notify of the operation result
	 *
	 * @param string $url URL where Paypal will notify
	 *
	 * @return void
	 */
	public function setNotifyUrl(string $url): void {
		$this->notify_url = $url;
	}

	/**
	 * Get the URL where Paypal will notify of the operation result
	 *
	 * @return string URL where Paypal will notify
	 */
	public function getNotifyUrl(): string {
		return $this->notify_url;
	}

	/**
	 * Set the the list of purchased items
	 *
	 * @param array $list List of purchased items
	 *
	 * @return void
	 */
	public function setItems(array $list): void {
		$this->items = $items;
	}

	/**
	 * Get the the list of purchased items
	 *
	 * @return array List of purchased items
	 */
	public function getItems(): array {
		return $this->items;
	}

	/**
	 * Add an item to the list of purchased items
	 *
	 * @param array Item to be added
	 *
	 * @return void
	 */
	public function addItem(array $item): void {
		array_push($this->items, $item);
	}

	/**
	 * Set up and return the data object that will be sent to Paypal
	 *
	 * @return array Paypal data object
	 */
	private function getProcessData(): array {
		$data = [
			'cmd'			=> '_cart',
			'upload'        => '1',
			'lc'			=> $this->getLC(),
			'business' 		=> $this->getBusiness(),
			'cancel_return'	=> $this->getCancelReturn(),
			'notify_url'	=> $this->getNotifyUrl(),
			'currency_code'	=> $this->getCurrency(),
			'return'        => $this->getOKReturn()
		];

		for ($i = 0; $i < count($this->items); $i++) {
			$data['item_number_' . ($i+1)] = $this->items[$i]['id'];
			$data['item_name_' . ($i+1)] = $this->items[$i]['name'];
			$data['quantity_' . ($i+1)] = $this->items[$i]['num'];
			$data['amount_' . ($i+1)] = $this->items[$i]['amount'];
		}

		return $data;
	}

	/**
	 * Get Paypal Url with all the information for the checkout
	 *
	 * @return string Paypal Url
	 */
	public function getRequestUrl(): string {
		return $this->getPaypalUrl() . '?' . http_build_query($this->getProcessData());
	}

	/**
	 * Process the request and send the user to Paypal
	 *
	 * @return void
	 */
	public function process(): void {
		// Send the user to the paypal checkout screen
		header('Location:' . $this->getRequestUrl());

		// End the script don't need to execute anything else
		exit;
	}
}