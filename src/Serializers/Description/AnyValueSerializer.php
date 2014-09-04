<?php

namespace Ask\Wikitext\Serializers\Description;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class AnyValueSerializer {

	public function format( $anyValue ) {
		return '+';
	}
}