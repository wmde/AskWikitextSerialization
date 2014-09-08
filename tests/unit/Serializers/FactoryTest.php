<?php

namespace Ask\Tests\Ask\Wikitext\Serializers;

use Ask\Wikitext\Serializers\Factory;
use Ask\Language\Selection\PropertySelection;
use DataValues\StringValue;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;

/**
 * @covers Ask\Wikitext\Serializers\Factory
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class FactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Factory
	 */
	private $factory;

	public function setUp() {
		$this->factory = new Factory();
	}

	public function testDescriptionSerializerGivenNotDescription_serializeThrowsException() {
		$serializer = $this->factory->createDescriptionSerializer();
		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( new PropertySelection( new StringValue( 'foo' ) ) );
	}

	public function testDescriptionSerializerWithAnyValue() {
		$serializer = $this->factory->createDescriptionSerializer();
		$anyValue = new AnyValue();
		$this->assertInternalType( 'string', $serializer->serialize( $anyValue ) );
	}

	public function testDescriptionSerializerWithSomeProperty() {
		$serializer = $this->factory->createDescriptionSerializer();
		$propertyId = new StringValue( 'P42' );
		$someProperty = new SomeProperty( $propertyId, new AnyValue() );

		$this->assertInternalType( 'string', $serializer->serialize( $someProperty ) );
	}

	public function testDescriptionSerializerWithValueDescription() {
		$serializer = $this->factory->createDescriptionSerializer();
		$stringValue = new StringValue( 'foo' );
		$valueDescription = new ValueDescription( $stringValue );

		$this->assertInternalType( 'string', $serializer->serialize( $valueDescription ) );
	}


}
