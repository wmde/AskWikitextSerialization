<?php

namespace Ask\Tests\Ask\Wikitext\Formatter\Description;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\SomeProperty;
use Ask\Wikitext\Serializers\Description\SomePropertySerializer;
use DataValues\StringValue;

/**
 * @covers Ask\Wikitext\Serializers\Description\SomePropertySerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SomePropertySerializerTest extends \PHPUnit_Framework_TestCase {

	public function testFormatSomeProperty() {
		$propertyId = new StringValue( 'P42' );
		$someProperty = new SomeProperty( $propertyId, new AnyValue() );

		$formatter = new SomePropertySerializer();

		$this->assertEquals( '[[P42::+]]', $formatter->format( $someProperty ) );
	}

}
