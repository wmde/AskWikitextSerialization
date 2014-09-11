<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\DispatchableSerializer;
use Ask\Language\Description\DescriptionCollection;
use Ask\Language\Description\Description;
use InvalidArgumentException;
use Ask\Wikitext\Serializers\SerializerFactory;
use Serializers\DispatchingSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class DescriptionCollectionSerializer implements DispatchableSerializer {

	/**
	 * @var string
	 */
	private $separator = '';

	/**
	 * @var DispatchingSerializer
	 */
	private $descriptionSerializer = null;

	/**
	 * @param string $operator used to concatenate the parts
	 */
	public function __construct( $operator ) {
		$this->separator = $operator;
	}

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return ( $object instanceof DescriptionCollection );
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->serializeCollection( $object );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of DescriptionCollection.' );
	}

	private function serializeCollection( DescriptionCollection $collection ) {
		$result = '';
		$firstItem = true;
		foreach ( $collection->getDescriptions() as $description) {
			if (!$firstItem) {
				$result .= $this->separator;
			} else {
				$firstItem = false;
			}
			$result .= $this->serializeDescription( $description );
		}
		return $result;
	}

	/**
	 * @return DispatchingSerializer
	 */
	private function serializer() {
		if ( is_null( $this->descriptionSerializer ) ) {
			$factory = new SerializerFactory();
			$this->descriptionSerializer = $factory->createDescriptionSerializer();
		}
		return $this->descriptionSerializer;
	}

	private function serializeDescription( Description $description ) {
		return $this->serializer()->serialize( $description );
	}

}
