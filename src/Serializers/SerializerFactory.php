<?php

namespace Ask\Wikitext\Serializers;

use Ask\Wikitext\Serializers\Description\AnyValueSerializer;
use Ask\Wikitext\Serializers\Description\DescriptionCollectionSerializer;
use Ask\Wikitext\Serializers\Description\SomePropertySerializer;
use Ask\Wikitext\Serializers\Description\ValueDescriptionSerializer;
use Serializers\DispatchingSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class SerializerFactory {

	/**
	 * @return DispatchingSerializer
	 */
	public function newDescriptionSerializer() {
		$serializer = new DispatchingSerializer();

		$serializer->addSerializer( new AnyValueSerializer() );
		$serializer->addSerializer( new SomePropertySerializer() );
		$serializer->addSerializer( new ValueDescriptionSerializer() );
		$serializer->addSerializer( new DescriptionCollectionSerializer( $serializer ) );

		return $serializer;
	}

}
