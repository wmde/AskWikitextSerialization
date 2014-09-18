<?php

namespace Ask\Wikitext\Serializers;

use Serializers\DispatchableSerializer;
use Ask\Language\Query;
use InvalidArgumentException;
use Serializers\DispatchingSerializer;
use Ask\Wikitext\Serializers\SerializerFactory;
use Ask\Wikitext\Serializers\Option\QueryOptionsSerializer;

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
	 * @var QueryOptionsSerializer
	 */
	private $optionsSerializer = null;

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
		if ( is_null( $this->descriptionSerializer ) ) {
			$factory = new SerializerFactory();
			$this->descriptionSerializer = $factory->newDescriptionSerializer();
		}
		return $this->descriptionSerializer;
	}

	/**
	 * @return QueryOptionsSerializer
	 */
	private function optionsDispatcher() {
		if ( is_null( $this->optionsSerializer ) ) {
			$this->optionsSerializer = new QueryOptionsSerializer();
		}
		return $this->optionsSerializer;
	}

	public function serializeQuery( Query $query ) {
		$result = $this->descriptionDispatcher()->serialize( $query->getDescription() );
		$options = $this->optionsDispatcher()->serialize( $query->getOptions() );
		if ( isset( $options[0] ) ) {
			$result .= ' '.$options;
		}
		return $result;
	}

}
