<?php

namespace Ask\Tests\Ask\Wikitext\Serializers;

use Ask\Language\Query;
use Ask\Wikitext\Serializers\QuerySerializer;
use Serializers\Serializer;
use Ask\Language\Description\AnyValue;
use DataValues\StringValue;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Language\Option\QueryOptions;

/**
 * @covers Ask\Wikitext\Serializers\QuerySerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class QuerySerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new QuerySerializer();
	}

	public function testGivenNonQuery_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testFormatQuery() {
		$propertyId = new StringValue( 'P42' );
		$description = new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'brett' ) ) );
		$options = new QueryOptions(0, 0);
		$query = new Query( $description, array(), $options );

		$this->assertEquals( '[[P42::brett]]', $this->serializer->serialize( $query ) );
	}

	public function testQueryWithNonDefaultOption() {
		$propertyId = new StringValue( 'P42' );
		$description = new SomeProperty( $propertyId, new ValueDescription( new StringValue( 'brett' ) ) );
		$options = new QueryOptions(21, 42);
		$query = new Query( $description, array(), $options );

		$this->assertEquals( '[[P42::brett]] limit=21 offset=42', $this->serializer->serialize( $query ) );
	}

	public function testQueryWithSelectionRequest() {
		$this->markTestIncomplete();
	}
}
