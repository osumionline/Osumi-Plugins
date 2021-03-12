<?php declare(strict_types=1);

namespace OsumiFramework\OFW\Plugins;

/**
 * Utility class with tools to create PDF files
 */
class OPDF {
	private string $creator  = '';
	private string $author   = '';
	private string $title    = '';
	private string $subject  = '';
	private string $keywords = '';
	private string $font     = 'helvetica';
	private array  $pages    = [];
	private ?TCPDF $pdf_obj  = null;
	private string $pdf_dir  = '';

	/**
	 * Set up PDF file information
	 *
	 * @param array Information of the PDF file
	 */
	function __construct(array $data=null) {
		if (!is_null($data) && is_array($data)) {
			$this->setCreator(  array_key_exists('creator',  $data) ? $data['creator']  : '' );
			$this->setAuthor(   array_key_exists('author',   $data) ? $data['author']   : '' );
			$this->setTitle(    array_key_exists('title',    $data) ? $data['title']    : '' );
			$this->setSubject(  array_key_exists('subject',  $data) ? $data['subject']  : '' );
			$this->setKeywords( array_key_exists('keywords', $data) ? $data['keywords'] : '' );
			$this->setFont(     array_key_exists('font',     $data) ? $data['font']     : 'helvetica' );
			$this->setPdfDir(   array_key_exists('path', $data)     ? $data['path']     : '' );
		}
	}

	/**
	 * Set the creator name of the PDF file
	 *
	 * @param string $c Name of the creator
	 *
	 * @return void
	 */
	public function setCreator(string $c): void {
		$this->creator = $c;
	}

	/**
	 * Get the PDF files creators name
	 *
	 * @return string Name of the creator
	 */
	public function getCreator(): string {
		return $this->creator;
	}

	/**
	 * Set the PDF files author name
	 *
	 * @param string $a Name of the author
	 *
	 * @return void
	 */
	public function setAuthor(string $a): void {
		$this->author = $a;
	}

	/**
	 * Get the PDF files authors name
	 *
	 * @return string Name of the author
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Set PDF files title
	 *
	 * @param string $t Title of the file
	 *
	 * @return void
	 */
	public function setTitle(string $t): void {
		$this->title = $t;
	}

	/**
	 * Get PDF files title
	 *
	 * @return string Title of the file
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * Set PDF files subject
	 *
	 * @param string $s Subject of the file
	 *
	 * @return void
	 */
	public function setSubject(string $s): void {
		$this->subject = $s;
	}

	/**
	 * Get PDF files subject
	 *
	 * @return string Subject of the file
	 */
	public function getSubject(): string {
		return $this->subject;
	}

	/**
	 * Set PDF files keyword list
	 *
	 * @param string $k String of comma separated keywords
	 *
	 * @return void
	 */
	public function setKeywords(string $k): void {
		$this->keywords = $k;
	}

	/**
	 * Get PDF files keyword list
	 *
	 * @return string List of files keywords
	 */
	public function getKeywords(): string {
		return $this->keywords;
	}

	/**
	 * Set PDF files font family
	 *
	 * @param string $f Name of the font to be used in the file
	 *
	 * @return void
	 */
	public function setFont(string $f): void {
		$this->font = $f;
	}

	/**
	 * Get the font family used in the PDF file
	 *
	 * @return string Name of the font to be used in the file
	 */
	public function getFont(): string {
		return $this->font;
	}

	/**
	 * Set array of pages of the PDF file
	 *
	 * @param array $p List of pages
	 *
	 * @return void
	 */
	public function setPages(array $p): void {
		$this->pages = $p;
	}

	/**
	 * Get array of pages of the PDF file
	 *
	 * @return array List of pages
	 */
	public function getPages(): array {
		return $this->pages;
	}

	/**
	 * Add a new page to the PDF file in HTML format
	 *
	 * @param string $p New page to be added
	 *
	 * @return void
	 */
	public function addPage(string $p): void {
		array_push($this->pages, $p);
	}

	/**
	 * Set the PDF resource object of the generated PDF
	 *
	 * @param resource $po PDF resource object
	 *
	 * @return void
	 */
	public function setPdfObj(resource $po): void {
		$this->pdf_obj = $po;
	}

	/**
	 * Get the PDF resource object ot the generated PDF
	 *
	 * @return ?resource PDF resource object
	 */
	public function getPdfObj(): ?resource {
		return $this->pdf_obj;
	}

	/**
	 * Set the path where the generated PDF file should be saved
	 *
	 * @param string $pd Path of the file
	 *
	 * @return void
	 */
	public function setPdfDir(string $pd): void {
		$this->pdf_dir = $pd;
	}

	/**
	 * Get the path where the generated PDF file should be saved
	 *
	 * @return string Path of the file
	 */
	public function getPdfDir(): string {
		return $this->pdf_dir;
	}

	/**
	 * Generate the PDF file
	 *
	 * @return void
	 */
	public function render(): void {
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator($this->getCreator());
		$pdf->SetAuthor($this->getAuthor());
		$pdf->SetTitle($this->getTitle());
		$pdf->SetSubject($this->getSubject());
		$pdf->SetKeywords($this->getKeywords());

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
		$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set font
		$pdf->SetFont($this->getFont(), '', 10);

		$pages = $this->getPages();
		foreach ($pages as $p) {
			// add a page
			$pdf->AddPage();

			// output the HTML content
			$pdf->writeHTML($p, true, false, true, false, '');
		}

		// reset pointer to the last page
		$pdf->lastPage();

		$this->setPdfObj($pdf);
	}

	/**
	 * Save generated PDF file to the previously specified path
	 *
	 * @return void
	 */
	public function getPdf(): void {
		$this->render();
		$pdf = $this->getPdfObj();
		$pdf->Output($this->getPdfDir(), 'I');
	}
}