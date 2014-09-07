<?php

namespace Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\ValueDescription;
use InvalidArgumentException;
use Serializers\Serializer;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class ValueDescriptionSerializer implements Serializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $valueDescription ) {
		if ( $valueDescription instanceof ValueDescription ) {
			return $this->serializeValueDescription( $valueDescription );
		}

		throw new InvalidArgumentException( 'Can only serialize instances of ValueDescription' );
	}

	private function serializeValueDescription( ValueDescription $valueDescription ) {
		return $this->getComparatorSerialization( $valueDescription->getComparator() )
			. $valueDescription->getValue()->getValue();
	}

	private function getComparatorSerialization( $comparator ) {
		$comparators = array(
			ValueDescription::COMP_EQUAL => '',
			ValueDescription::COMP_LEQ => '≤',
			ValueDescription::COMP_GEQ => '≥',
			ValueDescription::COMP_NEQ => '!',
			ValueDescription::COMP_LIKE => '~',
			ValueDescription::COMP_NLIKE => '!~',
			ValueDescription::COMP_LESS => '<<',
			ValueDescription::COMP_GREATER => '>>',
		);

		return $comparators[$comparator];
	}

}
