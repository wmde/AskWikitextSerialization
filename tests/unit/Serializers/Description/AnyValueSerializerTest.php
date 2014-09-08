<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\AnyValue;
use Ask\Wikitext\Serializers\Description\AnyValueSerializer;
use Ask\Language\Description\ValueDescription;
use DataValues\StringValue;
use Serializers\Serializer;

/**
 * @covers Ask\Wikitext\Serializers\Description\AnyValueSerializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class AnyValueSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new AnyValueSerializer();
	}

	public function testGivenNotAnyValue_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new ValueDescription( new StringValue( 'foo' ) ) );
	}

	public function testFormatAnyValue() {
		$anyValue = new AnyValue();
		$this->assertEquals( '+', $this->serializer->serialize( $anyValue ) );
	}

}
