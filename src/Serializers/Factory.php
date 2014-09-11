<?php

namespace Ask\Wikitext\Serializers;

use Ask\Wikitext\Serializers\Description\AnyValueSerializer;
use Ask\Wikitext\Serializers\Description\ConjunctionSerializer;
use Ask\Wikitext\Serializers\Description\DisjunctionSerializer;
use Ask\Wikitext\Serializers\Description\SomePropertySerializer;
use Ask\Wikitext\Serializers\Description\ValueDescriptionSerializer;
use Serializers\DispatchingSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class Factory {

	/**
	 * @return DispatchingSerializer
	 */
	public function createDescriptionSerializer() {
		$serializer = new DispatchingSerializer();
		$serializer->addSerializer( new AnyValueSerializer() );
		$serializer->addSerializer( new SomePropertySerializer() );
		$serializer->addSerializer( new ValueDescriptionSerializer() );
		$serializer->addSerializer( new ConjunctionSerializer() );
		$serializer->addSerializer( new DisjunctionSerializer() );
		return $serializer;
	}

}
