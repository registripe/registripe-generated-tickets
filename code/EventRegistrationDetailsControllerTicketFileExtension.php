<?php


// extracted from EventRegistrationDetailsController

class EventRegistrationDetailsControllerTicketFileExtension extends Extension {

	public static $allowed_actions = array(
		'ticketfile'
	);

	public function ticketfile() {
		if ($this->registration->Status != 'Valid') {
			$this->httpError(404);
		}
		$generator = $this->registration->Event()->TicketGenerator;
		if(!$generator) {
			$generator = "EventRegistrationHtmlTicketGenerator";
		}
		if($generator == "EventRegistrationHtmlTicketGenerator") {
			return $this->registration->renderWith('EventRegistrationHtmlTicket');
		}
		$generator = new $generator();
		$path = $generator->generateTicketFileFor($this->registration);
		$path = Director::getAbsFile($path);
		$name = $generator->getTicketFilenameFor($this->registration);
		$mime = $generator->getTicketMimeTypeFor($this->registration);
		if (!$path || !file_exists($path)) {
			$this->httpError(404, 'The ticket file could not be generated.');
		}

		return SS_HTTPRequest::send_file(file_get_contents($path), $name, $mime);
	}

}