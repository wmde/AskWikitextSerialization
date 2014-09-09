<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\ValueDescription;
use Ask\Wikitext\Serializers\Description\ValueDescriptionSerializer;
use DataValues\StringValue;
use Serializers\Serializer;
use Ask\Language\Description\AnyValue;

/**
 * @covers Ask\Wikitext\Serializers\Description\ValueDescriptionSerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValueDescriptionSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new ValueDescriptionSerializer();
	}

	public function testGivenNonValueDescription_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	/**
	 * @dataProvider comparatorProvider
	 */
	public function testFormatValueDescription( $comparator, $expectedSerialization ) {
		$valueDescription = new ValueDescription(
			new StringValue( 'foobar' ),
			$comparator
		);

		$this->assertEquals( $expectedSerialization, $this->serializer->serialize( $valueDescription ) );
	}

	public function comparatorProvider() {
		return array(
			array( ValueDescription::COMP_EQUAL, 'foobar' ),
			array( ValueDescription::COMP_LEQ, '≤foobar' ),
			array( ValueDescription::COMP_GEQ, '≥foobar' ),
			array( ValueDescription::COMP_NEQ, '!foobar' ),
			array( ValueDescription::COMP_LIKE, '~foobar' ),
			array( ValueDescription::COMP_NLIKE, '!~foobar' ),
			array( ValueDescription::COMP_LESS, '<<foobar' ),
			array( ValueDescription::COMP_GREATER, '>>foobar' ),
		);
	}

	public function testGivenValueDescriptionWithValueThatDoesNotCastToString() {
		$this->markTestIncomplete();
	}

}
