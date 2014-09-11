<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Wikitext\Serializers\Description\SomePropertySerializer;
use DataValues\StringValue;
use Serializers\Serializer;

/**
 * @covers Ask\Wikitext\Serializers\Description\SomePropertySerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SomePropertySerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new SomePropertySerializer();
	}

	public function testGivenNotSomeProperty_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testFormatSomeProperty() {
		$propertyId = new StringValue( 'P42' );
		$someProperty = new SomeProperty( $propertyId, new AnyValue() );

		$this->assertEquals( '[[P42::+]]', $this->serializer->serialize( $someProperty ) );
	}

	public function testGivenSomePropertyWithAnotherDescription() {
		$propertyId = new StringValue( 'P42' );
		$anotherDescription = new SomeProperty( new StringValue( 'P21' ), new AnyValue() );
		$someProperty = new SomeProperty( $propertyId, $anotherDescription );

		$this->assertEquals( '[[P42::<q>[[P21::+]]</q>]]', $this->serializer->serialize( $someProperty ) );
	}

	public function testGivenSomePropertyWithEscapingOfLiteralValueLikeSubquery() {
		$this->markTestIncomplete();
	}

	public function testGivenSomePropertyWithValueThatDoesNotCastToString() {
		$this->markTestIncomplete();
	}

	public function testGivenSomePropertyWithIsSubProperty() {
		$propertyId = new StringValue( 'P42' );
		$someProperty = new SomeProperty( $propertyId, new AnyValue(), true );

		$this->markTestIncomplete();
		$this->assertEquals( 'TODO[[P42::+]]', $this->serializer->serialize( $someProperty ) );
	}

}
