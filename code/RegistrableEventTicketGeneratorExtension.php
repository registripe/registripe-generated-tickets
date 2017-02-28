<?php

class RegistrableEventTicketGeneratorExtension extends DataExtension
{

	private static $db = array(
		'TicketGenerator' => 'Varchar(255)',
	);

	public function getCMSFields(FieldList $fields) {
		$generators = ClassInfo::implementorsOf('EventRegistrationTicketGenerator');
		if (self::config()->generate_ticket_files && $generators) {
			foreach ($generators as $generator) {
				$instance = new $generator();
				$generators[$generator] = $instance->getGeneratorTitle();
			}
			$generator = new DropdownField(
				'TicketGenerator',
				_t('EventRegistration.TICKET_GENERATOR', 'Ticket generator'),
				$generators
			);
			$generator->setEmptyString(_t('Registripe.NONE', '(None)'));
			$generator->setDescription(_t(
				'Registripe.TICKET_GENERATOR_NOTE',
				'The ticket generator is used to generate a ticket file for the user to download.'
			));
			$fields->addFieldToTab('Root.Tickets', $generator);
		}
	}
	
}
