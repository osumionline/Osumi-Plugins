<?php declare(strict_types=1);
class OTranslate {
	private string $page         = '';
	private ?array $data         = null;
	private array  $translations = [];

	/**
	 * Set key name of the loaded page
	 *
	 * @param string $p Key name of the loaded page
	 *
	 * @return void
	 */
	public function setPage(string $p): void {
		$this->page = $p;
		$this->loadTranslations();
	}

	/**
	 * Get key name of the loaded page
	 *
	 * @return string Key name of the loaded page
	 */
	public function getPage(): string {
		return $this->page;
	}

	/**
	 * Set whole list translation strings
	 *
	 * @param array $d List of translation strings
	 *
	 * @return void
	 */
	public function setData(array $d): void {
		$this->data = $d;
	}

	/**
	 * Get whole list of translations strings
	 *
	 * @return array List of translation strings
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * Set list of translations strings to be used on loaded page
	 *
	 * @param array $t List of translation strings
	 *
	 * @return void
	 */
	public function setTranslations(array $t): void {
		$this->translations = $t;
	}

	/**
	 * Get list of translation strings to be used on loaded page
	 *
	 * @return array List of translation strings
	 */
	public function getTranslations(): array {
		return $this->translations;
	}

	/**
	 * Load list of translations from the translations file and filter for the loaded page
	 *
	 * @return void
	 */
	public function loadTranslations(): void {
		global $core;
		if (is_null($this->data)) {
			$data = json_decode( file_get_contents( $core->config->getDir('app_config').'translations.json' ), true );
			$this->data = $data;
		}
		if (array_key_exists($this->page, $this->data['translations'])) {
			$this->translations = $this->data['translations'][$this->page];
		}
		else {
			$this->translations = [];
		}
	}
}