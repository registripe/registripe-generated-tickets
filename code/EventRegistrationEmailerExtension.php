<?php


class EventRegistrationEmailerExtension extends Extension {

	// TODO: hook in attaching ticket file

	/**
		* Attach a ticket file, if it exists
		*/
	protected function attachTicketFile($email){
		if ($generator = $this->registration->Event()->TicketGenerator) {
			$generator = new $generator();
			$path = $generator->generateTicketFileFor($this->registration);
			$name = $generator->getTicketFilenameFor($this->registration);
			$mime = $generator->getTicketMimeTypeFor($this->registration);
			if ($path) {
				$email->attachFile($path, $name, $mime);
			}
		}
	}

}