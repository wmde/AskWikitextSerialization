<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\DispatchableSerializer;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\Description;
use InvalidArgumentException;
use Ask\Wikitext\Serializers\Description\DescriptionCollectionSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class DisjunctionSerializer implements DispatchableSerializer {

	/**
	 * @var DescriptionCollectionSerializer
	 */
	private $collectionSerializer = null;

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return ( $object instanceof Disjunction );
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->serializeDisjunction( $object );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of Disjunction' );
	}

	/**
	 * @return DescriptionCollectionSerializer
	 */
	private function serializer() {
		if ( is_null( $this->collectionSerializer ) ) {
			$this->collectionSerializer = new DescriptionCollectionSerializer( ' OR ' );
		}
		return $this->collectionSerializer;
	}

	private function serializeDisjunction( Disjunction $disjunction ) {
		return $this->serializer()->serialize( $disjunction );
	}

}
