<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\Serializer;
use Ask\Language\Description\AnyValue;
use InvalidArgumentException;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class AnyValueSerializer implements Serializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $object instanceof AnyValue ) {
			return '+';
		}

		throw new InvalidArgumentException( 'Can only serialize instances of AnyValue' );
	}

}
