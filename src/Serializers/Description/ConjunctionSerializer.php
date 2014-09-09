<?php

namespace Ask\Wikitext\Serializers\Description;

use Serializers\DispatchableSerializer;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use InvalidArgumentException;
use Ask\Wikitext\Serializers\Factory;
use Serializers\DispatchingSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class ConjunctionSerializer implements DispatchableSerializer {

	/**
	 * @var DispatchingSerializer
	 */
	private $descriptionSerializer = null;

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

		throw new InvalidArgumentException( 'Can only serialize instances of AnyValue' );
	}

	private function serializeConjunction( Conjunction $conjunction ) {
		$result = '';
		$firstItem = true;
		foreach ( $conjunction->getDescriptions() as $description) {
			if (!$firstItem) {
				$result .= ' ';
			} else {
				$firstItem = false;
			}
			$result .= $this->serializeDescription( $description );
		}
		return $result;
	}

	private function serializer() {
		if (is_null($this->descriptionSerializer)) {
			$factory = new Factory();
			$this->descriptionSerializer = $factory->createDescriptionSerializer();
		}
		return $this->descriptionSerializer;
	}

	private function serializeDescription( Description $description ) {
		return $this->serializer()->serialize( $description );
	}

}
