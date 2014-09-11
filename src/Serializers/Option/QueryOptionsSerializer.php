<?php

namespace Ask\Wikitext\Serializers\Option;

use Ask\Language\Option\QueryOptions;
use InvalidArgumentException;
use Serializers\DispatchableSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class QueryOptionsSerializer implements DispatchableSerializer {

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return ( $object instanceof QueryOptions );
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->serializeQueryOptions( $object );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of QueryOptions.' );
	}

	private function serializeQueryOptions( QueryOptions $options ) {
		$result = '';
		$this->appendOneOption( $result, 'limit', $options->getLimit() );
		$this->appendOneOption( $result, 'offset', $options->getOffset() );
		return $result;
	}

	private function appendOneOption(&$result, $name, $value) {
		if ($value !== 0) {
			if ( isset( $result[0] ) ) {
				$result .= ' ';
			}
			$result .= $name.'='.$value;
		}
		return $result;
	}

}
