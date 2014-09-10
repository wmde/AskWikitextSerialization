<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\Disjunction;
use Ask\Wikitext\Serializers\Description\DisjunctionSerializer;
use Serializers\Serializer;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use DataValues\StringValue;

/**
 * @covers Ask\Wikitext\Serializers\Description\DisjunctionSerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class DisjunctionSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new DisjunctionSerializer();
	}

	public function testGivenNonDisjunction_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testFormatDisjunction() {
		$propertyId = new StringValue( 'P42' );
		$conjunction = new Disjunction(
			array(
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'foobar' ) ) ),
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'mubuz' ) ) ),
			)
		);

		$this->assertEquals( '[[P42::foobar]] OR [[P42::mubuz]]', $this->serializer->serialize( $conjunction ) );
	}

}
