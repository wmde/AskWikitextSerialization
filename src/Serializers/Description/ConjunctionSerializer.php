<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\DispatchableSerializer;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use InvalidArgumentException;
use Ask\Wikitext\Serializers\Description\DescriptionCollectionSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class ConjunctionSerializer implements DispatchableSerializer {

	/**
	 * @var DescriptionCollectionSerializer
	 */
	private $collectionSerializer = null;

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return ( $object instanceof Conjunction );
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->serializeConjunction( $object );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of Conjunction' );
	}

	/**
	 * @return DescriptionCollectionSerializer
	 */
	private function serializer() {
		if (is_null($this->collectionSerializer)) {
			$this->collectionSerializer = new DescriptionCollectionSerializer(' ');
		}
		return $this->collectionSerializer;
	}

	private function serializeConjunction( Conjunction $conjunction ) {
		return $this->serializer()->serialize( $conjunction );
	}

}
