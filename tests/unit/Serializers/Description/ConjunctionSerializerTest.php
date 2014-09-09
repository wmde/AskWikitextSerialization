<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\Conjunction;
use Ask\Wikitext\Serializers\Description\ConjunctionSerializer;
use Serializers\Serializer;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use DataValues\StringValue;

/**
 * @covers Ask\Wikitext\Serializers\Description\ConjunctionSerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class ConjunctionSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new ConjunctionSerializer();
	}

	public function testGivenNonConjunction_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testFormatConjunction() {
		$propertyId = new StringValue( 'P42' );
		$conjunction = new Conjunction(
			array(
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'foobar' ) ) ),
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'mubuz' ) ) ),
			)
		);

		$this->assertEquals( '[[P42::foobar]] [[P42::mubuz]]', $this->serializer->serialize( $conjunction ) );
	}

}
