<?php

namespace Ask\Wikitext\Serializers;

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
		$serializer->addSerializer( new \Ask\Wikitext\Serializers\Description\AnyValueSerializer() );
		$serializer->addSerializer( new \Ask\Wikitext\Serializers\Description\SomePropertySerializer() );
		$serializer->addSerializer( new \Ask\Wikitext\Serializers\Description\ValueDescriptionSerializer() );
		$serializer->addSerializer( new \Ask\Wikitext\Serializers\Description\ConjunctionSerializer() );
		$serializer->addSerializer( new \Ask\Wikitext\Serializers\Description\DisjunctionSerializer() );
		return $serializer;
	}

}
