<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\Serializer;
use InvalidArgumentException;
use Ask\Language\Description\SomeProperty;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class SomePropertySerializer implements Serializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $someProperty ) {
		if ( $someProperty instanceof SomeProperty ) {
			return $this->serializeSomeProperty( $someProperty );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of SomeProperty' );
	}

	private function serializeSomeProperty( SomeProperty $someProperty ) {
		$serializer = new AnyValueSerializer();
		return '[[' . $someProperty->getPropertyId()->getValue() .
			'::' . $serializer->serialize( $someProperty->getSubDescription() ) . ']]';
	}

}
