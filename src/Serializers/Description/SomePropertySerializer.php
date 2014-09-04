<?php

namespace Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\SomeProperty;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class SomePropertySerializer {

	public function format( SomeProperty $someProperty ) {
		$formatter = new AnyValueSerializer();
		return '[[' . $someProperty->getPropertyId()->getValue() . '::' . $formatter->format( $someProperty->getSubDescription() ) . ']]';
	}
}