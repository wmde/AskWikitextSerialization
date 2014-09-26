<?php

namespace Ask\Wikitext\Serializers\Option;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortOptions;
use Ask\Language\Option\SortExpression;
use Ask\Language\Option\PropertyValueSortExpression;
use InvalidArgumentException;
use Serializers\DispatchableSerializer;

/**
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class QueryOptionsSerializer implements DispatchableSerializer {

	/**
	 * @var string
	 */
	private $result = '';

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
			$this->serializeQueryOptions( $object );
			return $this->result;
		}

		throw new InvalidArgumentException( 'Can only serialize instances of QueryOptions.' );
	}

	private function serializeQueryOptions( QueryOptions $options ) {
		$this->appendOneOption( 'limit', $options->getLimit() );
		$this->appendOneOption( 'offset', $options->getOffset() );
		$this->appendSortExpressions( $options->getSort() );
	}

	private function appendSortExpressions( SortOptions $sort ) {
		$sorts = array();
		$orders = array();
		foreach ( $sort->getExpressions() as $expression ) {
			$sorts[] = $this->getSortFromExpression( $expression );
			$orders[] = $this->getOrderFromExpression( $expression );
		}
		if ( count( $sorts ) <= 0 ) {
			return;
		}
		$this->appendOneOption( 'sort', implode( ',', $sorts ) );
		$this->appendOneOption( 'order', implode( ',', $orders ) );
	}

	private function getSortFromExpression( PropertyValueSortExpression $expression ) {
		return $expression->getPropertyId()->getValue();
	}

	private function getOrderFromExpression( SortExpression $expression ) {
		return $expression->getDirection();
	}

	private function appendOneOption( $name, $value ) {
		if ($value !== 0) {
			if ( isset( $this->result[0] ) ) {
				$this->result .= ' ';
			}
			$this->result .= $name.'='.$value;
		}
	}

}
