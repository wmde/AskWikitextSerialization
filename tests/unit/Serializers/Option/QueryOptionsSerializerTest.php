<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Option;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortOptions;
use Ask\Language\Option\SortExpression;
use Ask\Language\Option\PropertyValueSortExpression;
use Serializers\Serializer;
use Ask\Wikitext\Serializers\Option\QueryOptionsSerializer;
use Ask\Language\Description\AnyValue;
use DataValues\StringValue;

/**
 * @covers Ask\Wikitext\Serializers\Option\QueryOptionsSerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class QueryOptionsSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new QueryOptionsSerializer();
	}

	public function testGivenNonQuery_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testFormatQueryOptions() {
		$options = new QueryOptions(0, 0);

		$this->assertEquals( '', $this->serializer->serialize( $options ) );
	}

	public function testQueryOptionsWithNotZeroLimitAndOffset() {
		$options = new QueryOptions(1, 1);

		$this->assertEquals( 'limit=1 offset=1', $this->serializer->serialize( $options ) );
	}

	public function testQueryOptionsWithOffset() {
		$options = new QueryOptions(0, 23);

		$this->assertEquals( 'offset=23', $this->serializer->serialize( $options ) );
	}

	public function testQueryOptionsWithSortOption() {
		$expressions = array(
			new PropertyValueSortExpression( new StringValue( 'P42' ), SortExpression::DIRECTION_ASCENDING ),
			new PropertyValueSortExpression( new StringValue( 'P23' ), SortExpression::DIRECTION_DESCENDING ),
		);
		$options = new QueryOptions(0, 0, new SortOptions( $expressions ) );

		$this->assertEquals( 'sort=P42,P23 order=asc,desc', $this->serializer->serialize( $options ) );
	}

}
