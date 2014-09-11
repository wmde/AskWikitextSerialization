<?php

namespace Ask\Wikitext\Serializers;

use Serializers\DispatchableSerializer;
use Ask\Language\Query;
use InvalidArgumentException;
use Serializers\DispatchingSerializer;
use Ask\Wikitext\Serializers\Factory;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class QuerySerializer implements DispatchableSerializer {

	/**
	 * @var DispatchingSerializer
	 */
	private $descriptionSerializer = null;

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return ( $object instanceof Query );
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->serializeQuery( $object );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of Query.' );
	}

	/**
	 * @return DispatchingSerializer
	 */
	private function descriptionDispatcher() {
		if (is_null($this->descriptionSerializer)) {
			$factory = new Factory();
			$this->descriptionSerializer = $factory->createDescriptionSerializer();
		}
		return $this->descriptionSerializer;
	}

	public function serializeQuery( Query $query ) {
		return $this->descriptionDispatcher()->serialize( $query->getDescription() );
	}

}
