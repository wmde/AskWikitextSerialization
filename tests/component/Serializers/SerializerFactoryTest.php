<?php

namespace Ask\Tests\Ask\Wikitext\Serializers;

use Ask\Wikitext\Serializers\SerializerFactory;
use Ask\Language\Selection\PropertySelection;
use DataValues\StringValue;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Disjunction;

/**
 * @covers Ask\Wikitext\Serializers\SerializerFactory
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class SerializerFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var SerializerFactory
	 */
	private $factory;

	public function setUp() {
		$this->factory = new SerializerFactory();
	}

	public function testDescriptionSerializerGivenNotDescription_serializeThrowsException() {
		$serializer = $this->factory->newDescriptionSerializer();
		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( new PropertySelection( new StringValue( 'foo' ) ) );
	}

	public function testDescriptionSerializerWithAnyValue() {
		$serializer = $this->factory->newDescriptionSerializer();
		$anyValue = new AnyValue();
		$this->assertInternalType( 'string', $serializer->serialize( $anyValue ) );
	}

	public function testDescriptionSerializerWithSomeProperty() {
		$serializer = $this->factory->newDescriptionSerializer();
		$propertyId = new StringValue( 'P42' );
		$someProperty = new SomeProperty( $propertyId, new AnyValue() );

		$this->assertInternalType( 'string', $serializer->serialize( $someProperty ) );
	}

	public function testDescriptionSerializerWithValueDescription() {
		$serializer = $this->factory->newDescriptionSerializer();
		$stringValue = new StringValue( 'foo' );
		$valueDescription = new ValueDescription( $stringValue );

		$this->assertInternalType( 'string', $serializer->serialize( $valueDescription ) );
	}

	public function testDescriptionSerializerWithConjunction() {
		$serializer = $this->factory->newDescriptionSerializer();
		$propertyId = new StringValue( 'P42' );
		$conjunction = new Conjunction(
			array(
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'foobar' ) ) ),
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'mubuz' ) ) ),
			)
		);

		$this->assertEquals( '[[P42::foobar]] [[P42::mubuz]]', $serializer->serialize( $conjunction ) );
	}

	public function testDescriptionSerializerWithDisjunction() {
		$serializer = $this->factory->newDescriptionSerializer();
		$propertyId = new StringValue( 'P42' );
		$conjunction = new Disjunction(
			array(
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'foobar' ) ) ),
				new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'mubuz' ) ) ),
			)
		);

		$this->assertEquals( '[[P42::foobar]] OR [[P42::mubuz]]', $serializer->serialize( $conjunction ) );
	}


}
