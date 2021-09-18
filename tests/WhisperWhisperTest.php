<?php

namespace Ofcold\Component\WhisperTests;

use Mockery as m;
use Ofcold\Component\Whisper\Whisper;
use PHPUnit\Framework\TestCase;

class WhisperWhisperTest extends TestCase
{
	protected $whisper;
	protected function setUp(): void
	{
		parent::setUp();
$publickey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmwhhD1PyBT/HR58LmxY0
eEPeGWzpDWg4nlqjUu7NI1k8pWzWZoJw5l+VNk4HEkM9Z+6lmWLkCASPjiCx5tPW
QjqSjwpvyfaU//QawRjScejIIkYhzY6+zieOUbBXYGKE8wUvBCvc9VutK4whhiM9
3tqZesbeyYFj8702IYcWwmIGOgeWJTlDIvMlMUIY4vL+suNjg2264ten75p/1+/q
522T2pJ/1BsHRn/1ET6OntUUQ+ng8HSi9BMRjDp3JL8XDSPuHRVufqhIuMhbhvP9
Dqcce3Wo5zTB+6R0L4eAfUnCJhdsjlT0C99Za/PoQXipBOxSpMPiYwEe+ZF2yH9R
RwIDAQAB
-----END PUBLIC KEY-----
EOD;

$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAmwhhD1PyBT/HR58LmxY0eEPeGWzpDWg4nlqjUu7NI1k8pWzW
ZoJw5l+VNk4HEkM9Z+6lmWLkCASPjiCx5tPWQjqSjwpvyfaU//QawRjScejIIkYh
zY6+zieOUbBXYGKE8wUvBCvc9VutK4whhiM93tqZesbeyYFj8702IYcWwmIGOgeW
JTlDIvMlMUIY4vL+suNjg2264ten75p/1+/q522T2pJ/1BsHRn/1ET6OntUUQ+ng
8HSi9BMRjDp3JL8XDSPuHRVufqhIuMhbhvP9Dqcce3Wo5zTB+6R0L4eAfUnCJhds
jlT0C99Za/PoQXipBOxSpMPiYwEe+ZF2yH9RRwIDAQABAoIBABm2IQq+vFO8iRtK
uE0HOLp9XvdOhbQwhbtVguK9Mg5bvWAeFcy4c2rxjTiNZkTUG/oBrTssGG9v+jLz
Hy4OEem39xh7/aA8Ief1Hv7JVBWKKq7sfKyvsNtV2heYLFWS4UPAp1SExcd3Zdfk
DKdHbvpnvK6NDuPSbrY8uh6DXfXss8sGfQQ3r2mxpigx69xuuYbnZ5n1b5VwOaWJ
RiChUTi9m8R9G+1ST36cprIiMopv/xMV2H/BWVe8DVR8BBCcUJvNbDONEoszIJ5s
3EKPVr29rNq1ocefWFAaXvJFJb3YCUFZL+0V5JpYBq6eSdMesY8Uyd2L8+DtmiLv
8jVbj7ECgYEAzKU1Y6iAyj8JJkSfpRRSrWaGZUv7do1FjnNvhs+jKIQCgJvfp4dK
+wzBjiQjNcVgzlMC+YN5DJ4erC+jy6ozOM8UGlfWo7oN97/BDRMk1nd7wOJLajL/
yVI/upLHZgPXiRfn0AMvYgbIuc0ZjiSzhbHwak67HUk/plDlF4QFBskCgYEAwe/3
JreubHgD6GlAuo183vTFOkrUbIrmUunVY2aqyYwTO7UCZd5LnL/+Y5ArFppRo03Y
SYjHdi8DC2Y2s3jXcf0yDMsgjCg3leBhbbKWhY4jgCTS/gVSP+BHqMG0BTS/JTbs
Mhmf3bbgeVrbAEVRBzT4EdQ2kihk//WeqSWUz48CgYEAx8CTBn3ZiJBS+/mL4vSd
ZwhmMsYh5CwtMsjWmb5fQhLo5mQ/wSS8OaTP4VDA1aGdxoccpjSAmaJVyjiOJyQw
70iiFLyclB/ttmCDraF8GaNzNmkst7KkHfycnB7dZ2RkpDqjWVVikMqSb1oVkbud
R+jSBNJorkNrT4oys+t3hJECgYBGsIEVy734K4bBIBxH42qwmeeJ59yl87sgXbs6
ECIQdM5N5RyKpQxKhnDjOZl7E6TOMYG0y/ZoTZp+fTNTF6jwE6o6n4+thrs8Fh1t
LrtO0xB9lO6TSL1CKy3zhSdo/mDt36cYW965of8QPN22q41tYxFI7mE1xSOLaKv8
W4ZyYQKBgQCl+M+4Yw6wwhXcE+GRRoNi/NCQ34T6xq52hXKgQBPs8BNRC97TrHaz
Xgt48PKBR8kmsEwTQnNCM+i+uEsUQWE04l7vQFOpLWt55cVkwOB3vWEynHMkG5Hx
PdxY9sf+Iwf++kv5S+5sGySFGleKWZf3DQXUR1JpYJQ91ixbl9YyfA==
-----END RSA PRIVATE KEY-----
EOD;
		$this->whisper =  Whisper::make()
			->setPublicKey($publickey)
			->setPrivateKey($privateKey);
	}

	public function testMake()
	{
		$this->assertInstanceOf(Whisper::class, $this->whisper);
	}

	public function testParserItemsToStirng()
	{
		$this->assertTrue('bar=Bar&foo=Foo' === $this->whisper->parserItemsToStirng([
			'foo' => 'Foo',
			'bar' => 'Bar',
			'empty' => '',
			'null' => null,
			'array' => []
		]), 'Whether the array data matches the parsed data.');

		$this->assertTrue(
			'actived=1&created_at=2020-08-20 06:55:52&first_name=Foo&information={"following":123}&last_name=Bar&name=Foo&password=$2y$10$5.MAa.AWqcCsXbOJ2iUqweZcl5gDeehpfJ1KQOtf8VB1M6erf8LDm&phone_number=18898728888' ===
			$this->whisper->parserItemsToStirng([
				'name' => 'Foo',
				'first_name' => 'Foo',
				'last_name' => 'Bar',
				'phone_number' => '18898728888',
				'email' => null,
				'password' => '$2y$10$5.MAa.AWqcCsXbOJ2iUqweZcl5gDeehpfJ1KQOtf8VB1M6erf8LDm',
				'actived' => true,
				'phone_number_verify_at' => null,
				'created_at' => '2020-08-20 06:55:52',
				'updated_at' => null,
				'information' => [
					'following' => 123,
					'like' 	=> 0,
					'foo' => [],
					'bar' => null,
				],
			]),
			'Whether the generated string data matches the parsed data.'
		);

		$this->assertFalse('foo=Foo&bar=Bar' === $this->whisper->parserItemsToStirng([
			'foo' => 'Foo',
			'bar' => 'Bar',
			'empty' => '',
			'null' => null,
			'array' => [
				'foobar' => 'FooBar'
			]
		]), 'Two data that do not match');
	}

	public function testSign()
	{
		$sign = $this->whisper
			->sign([
				'name' => 'Foo',
				'first_name' => 'Foo',
				'last_name' => 'Bar',
				'phone_number' => '18898728888',
				'email' => null,
				'password' => '$2y$10$5.MAa.AWqcCsXbOJ2iUqweZcl5gDeehpfJ1KQOtf8VB1M6erf8LDm',
				'actived' => true,
				'phone_number_verify_at' => null,
				'created_at' => '2020-08-20 06:55:52',
				'updated_at' => null,
				'information' => [
					'following' => 123,
					'like' 	=> 0,
					'foo' => [],
					'bar' => null,
				],
			]);

		$this->assertFalse('' === $sign, 'Signature data matches empty string');
		$this->assertFalse('fBvZvWJcaQa5fEWYw8cQKIBs2+mY+Tv5TZIxXsKHAO5Jl8ZukBBkhCzf62MzJfj8bCi4qIefEVOBuTKVx9NJMJ4JrYevVRmXi8/FrnDnaO7lsv4GrTiJzIg6ngn3ZlBcID6+9xZd0N5hPRFiYfE52pWFS1niU+GomYnuBtegwJtkXF9l3AnjPA+NL8oIWoFIssdoRn91qiWA687PjkPYczPJbBpRKUWEvufV8d0hN0nX71NxYBudFmDMovYIBLZHxUS8MU4iyOasK7yKSsAe9IgFKoGhLfMIhBkD1+LuF3qcQW0/h6rrgZ6qNtvwYGXvXlSOm/Gi+TF4e/8Hfko8QA==' !== $sign, 'Encrypted data verification is qualified');
	}

	public function testValidate()
	{
		$this->assertTrue($this->whisper->validate([
				'name' => 'Foo',
				'first_name' => 'Foo',
				'last_name' => 'Bar',
				'phone_number' => '18898728888',
				'email' => null,
				'password' => '$2y$10$5.MAa.AWqcCsXbOJ2iUqweZcl5gDeehpfJ1KQOtf8VB1M6erf8LDm',
				'actived' => true,
				'phone_number_verify_at' => null,
				'created_at' => '2020-08-20 06:55:52',
				'updated_at' => null,
				'information' => [
					'following' => 123,
					'like' 	=> 0,
					'foo' => [],
					'bar' => null,
				],
			], 'fBvZvWJcaQa5fEWYw8cQKIBs2+mY+Tv5TZIxXsKHAO5Jl8ZukBBkhCzf62MzJfj8bCi4qIefEVOBuTKVx9NJMJ4JrYevVRmXi8/FrnDnaO7lsv4GrTiJzIg6ngn3ZlBcID6+9xZd0N5hPRFiYfE52pWFS1niU+GomYnuBtegwJtkXF9l3AnjPA+NL8oIWoFIssdoRn91qiWA687PjkPYczPJbBpRKUWEvufV8d0hN0nX71NxYBudFmDMovYIBLZHxUS8MU4iyOasK7yKSsAe9IgFKoGhLfMIhBkD1+LuF3qcQW0/h6rrgZ6qNtvwYGXvXlSOm/Gi+TF4e/8Hfko8QA=='), 'Check whether the array matches the encrypted string');

		$this->assertFalse($this->whisper->validate([
			'name' => 'Foo',
			'first_name' => 'Foo',
			'last_name' => 'Bar',
			'phone_number' => '18898728888',
			'email' => null,
			'password' => '$2y$10$5.MAa.AWqcCsXbOJ2iUqweZcl5gDeehpfJ1KQOtf8VB1M6erf8LDm',
			'actived' => true,
			'phone_number_verify_at' => null,
		], 'fBvZvWJcaQa5fEWYw8cQKIBs2+mY+Tv5TZIxXsKHAO5Jl8ZukBBkhCzf62MzJfj8bCi4qIefEVOBuTKVx9NJMJ4JrYevVRmXi8/FrnDnaO7lsv4GrTiJzIg6ngn3ZlBcID6+9xZd0N5hPRFiYfE52pWFS1niU+GomYnuBtegwJtkXF9l3AnjPA+NL8oIWoFIssdoRn91qiWA687PjkPYczPJbBpRKUWEvufV8d0hN0nX71NxYBudFmDMovYIBLZHxUS8MU4iyOasK7yKSsAe9IgFKoGhLfMIhBkD1+LuF3qcQW0/h6rrgZ6qNtvwYGXvXlSOm/Gi+TF4e/8Hfko8QA'),
		'The check array does not match the encrypted string');

	}
}
