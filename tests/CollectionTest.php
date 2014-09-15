<?php namespace Cartalyst\Support\Tests;
/**
 * Part of the Support package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Support
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use PHPUnit_Framework_TestCase;
use Cartalyst\Support\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function a_collection_can_be_instantiated()
	{
		$collection = new Collection('main');
	}

	/** @test */
	public function it_can_get_all_the_items_from_the_collection()
	{
		$collection = new Collection('main');
		$this->assertEmpty($collection->all());

		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');
		$this->assertEquals([
			'foo' => 'Foo',
			'bar' => 'Bar',
		], $collection->all());
	}

	/** @test */
	public function it_can_get_the_total_items_from_the_collection()
	{
		$collection = new Collection('main');
		$this->assertCount(0, $collection);

		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');
		$this->assertCount(2, $collection);
	}

	/** @test */
	public function it_can_check_an_item_exists_on_the_collection()
	{
		$collection = new Collection('main');
		$this->assertFalse($collection->exists('foo'));

		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');
		$this->assertTrue($collection->exists('foo'));
	}

	/** @test */
	public function it_can_find_an_item_from_the_collection()
	{
		$collection = new Collection('main');
		$this->assertNull($collection->find('foo'));

		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');
		$this->assertEquals('Foo', $collection->find('foo'));
	}

	/** @test */
	public function it_can_return_the_first_item_from_the_collection()
	{
		$collection = new Collection('main');
		$collection->put('name', 'Bar');

		$this->assertEquals('Bar', $collection->first());
	}

	/** @test */
	public function it_can_get_a_collection_attribute()
	{
		$collection = new Collection('main');
		$this->assertEquals(null, $collection->get('foo'));
		$collection->foo = 'Foo';
		$this->assertEquals('Foo', $collection->get('foo'));
	}

	/** @test */
	public function it_can_get_all_the_attributes_from_the_collection()
	{
		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->name = 'Foo';

		$this->assertEquals([
			'id'   => 'main',
			'name' => 'Foo',
		], $collection->getAttributes());
	}

	/** @test */
	public function it_can_check_if_the_collection_has_an_item()
	{
		$collection = new Collection('main');
		$this->assertFalse($collection->has('foo'));
		$collection->put('foo', 'Foo');
		$this->assertTrue($collection->has('foo'));
	}

	/** @test */
	public function it_can_check_that_a_collection_is_empty()
	{
		$collection = new Collection('main');

		$this->assertTrue($collection->isEmpty());
	}

	/** @test */
	public function it_can_check_that_a_collection_is_not_empty()
	{
		$collection = new Collection('main');
		$collection->put('foo', 'Foo');

		$this->assertFalse($collection->isEmpty());
	}

	/** @test */
	public function it_can_return_the_last_item_from_the_collection()
	{
		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');

		$this->assertEquals('Bar', $collection->last());
	}

	/** @test */
	public function it_can_retrieve_the_collection_items_as_an_array()
	{
		$collection = new Collection('main');
		$this->assertEquals(null, $collection->get('foo'));
		$this->assertEquals([
			'id' => 'main',
		], $collection->getAttributes());
		$collection->put('foo', 'Foo');
		$this->assertEquals(['foo' => 'Foo'], $collection->toArray());
	}

	/** @test */
	public function it_can_pull_an_item_from_the_collection()
	{
		$collection = new Collection('main');
		$collection->put('foo', 'Foo');
		$collection->put('bar', 'Bar');
		$collection->put('baz', 'Baz');
		$collection->put('bat', 'Bat');

		$this->assertCount(4, $collection);

		$collection->pull('bar');

		$this->assertCount(3, $collection);
	}

	/** @test */
	public function it_can_test_the_offset_methods()
	{
		$collection = new Collection('main');
		$collection['name'] = 'Foo';
		$this->assertTrue(isset($collection['name']));
		$this->assertEquals('Foo', $collection['name']);
		unset($collection['name']);
		$this->assertFalse(isset($collection['name']));


		$collection = new Collection('main');
		$collection->name = 'Foo';
		$this->assertTrue(isset($collection->name));
		unset($collection->name);
		$this->assertFalse(isset($collection->name));


		$collection = new Collection('main');
		$collection->put('foo.bar', 'baz');
		$this->assertEquals('baz', $collection['foo.bar']);
		unset($collection['foo.bar']);
		$this->assertFalse($collection->exists('foo.bar'));


		$collection = new Collection('main');
		$collection->put('foo.bar.baz', 'bat');
		$this->assertEquals('bat', $collection['foo.bar.baz']);
		$this->assertTrue($collection->exists('foo.bar.baz'));
	}

	/** @test */
	public function a_collection_can_have_attributes()
	{
		$collection = new CollectionStub('main');
		$collection->name = 'Foo';

		$this->assertEquals('Test Foo', $collection->name);
	}

	/** @test */
	public function it_can_use_magic_methods_to_set_items()
	{
		$collection = new Collection('main');
		$collection->id = 'foo';
		$this->assertEquals('foo', $collection->id);

		$collection = new Collection('main');
		$collection->id = 'foo';
		$this->assertEquals('foo', $collection->id);

		$collection = new Collection('main', function($collection)
		{
			$collection->id = 'foo';
		});
		$this->assertEquals('foo', $collection->id);
	}

	/** @test */
	public function it_can_sort_the_collection_items()
	{
		$collection = new Collection('main');
		$collection->put('foo', ['name' => 'Foo']);
		$collection->put('bar', ['name' => 'Bar']);
		$collection->put('baz', ['name' => 'Baz']);

		$this->assertEquals([
			'foo' => [
				'name' => 'Foo',
			],
			'bar' => [
				'name' => 'Bar',
			],
			'baz' => [
				'name' => 'Baz',
			],
		], $collection->all());

		$this->assertEquals([
			'bar' => [
				'name' => 'Bar',
			],
			'baz' => [
				'name' => 'Baz',
			],
			'foo' => [
				'name' => 'Foo',
			],
		], $collection->sortBy('name')->all());

		$expected = [
			'foo' => [
				'name' => 'Foo',
			],
			'baz' => [
				'name' => 'Baz',
			],
			'bar' => [
				'name' => 'Bar',
			],
		];

		$output = $collection->sortByDesc('id')->all();

		$this->assertTrue($expected === $output);
	}

}

class CollectionStub extends Collection {

	public function nameAttribute($name)
	{
		return "Test {$name}";
	}

}
