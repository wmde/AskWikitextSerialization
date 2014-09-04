<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\Serializer;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class SomePropertySerializer implements Serializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		$formatter = new AnyValueSerializer();
		return '[[' . $object->getPropertyId()->getValue() . '::' . $formatter->serialize( $object->getSubDescription() ) . ']]';
	}

}