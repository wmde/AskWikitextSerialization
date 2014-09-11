<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\DispatchableSerializer;
use Ask\Language\Description\DescriptionCollection;
use Ask\Language\Description\Description;
use InvalidArgumentException;
use Ask\Wikitext\Serializers\SerializerFactory;
use Serializers\DispatchingSerializer;
use Serializers\Serializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionCollectionSerializer implements DispatchableSerializer {

	/**
	 * @var string[]
	 */
	private $separators;

	/**
	 * @param Serializer $descriptionSerializer
	 */
	public function __construct( Serializer $descriptionSerializer ) {
		$this->descriptionSerializer = $descriptionSerializer;

		$this->separators = array(
			'conjunction' => ' ',
			'disjunction' => ' OR ',
		);
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
		$serializations = array();

		foreach ( $collection->getDescriptions() as $description) {
			$serializations[] = $this->descriptionSerializer->serialize( $description );
		}

		return implode( $this->getSeparator( $collection ), $serializations );
	}

	private function getSeparator( DescriptionCollection $collection ) {
		return $this->separators[$collection->getType()];
	}

}
