<?php

namespace Ofcold\Component\Whisper;

use Eastwest\Json\Json;
use Illuminate\Support\LazyCollection;
use Ofcold\Component\Whisper\Exceptions\WhisperValidateException;

class Whisper
{
	/**
	 * Create an a new Whisper instance.
	 *
	 * @return static
	 */
	public static function make(): static
	{
		return new static;
	}

	/**
	 * Certificate public key.
	 *
	 * @var string
	 */
	protected string $publicKey;

	/**
	 * Certificate private key.
	 *
	 * @var string
	 */
	protected string $privateKey;

	/**
	 * Set public key content.
	 *
	 * @param string $publicKey
	 */
	public function setPublicKey(string $publicKey)
	{
		$this->publicKey = $publicKey;

		return $this;
	}

	/**
	 * Extract public key from certificate and prepare it for use
	 *
	 * Extracts the public key from certificate and prepares it for use by other functions.
	 *
	 * @return string
	 */
	public function getPublicKey(): string
	{
		if (str_starts_with($this->publicKey, '-----BEGIN PUBLIC KEY-----') && str_ends_with($this->publicKey, '-----END PUBLIC KEY-----')) {
			return $this->publicKey;
		}

		return "-----BEGIN PUBLIC KEY-----\r\n" .
			wordwrap($this->publicKey, 64, "\r\n", true) .
			"\r\n-----END PUBLIC KEY-----";
	}

	/**
	 * Set private key content.
	 *
	 * @param string $publicKey
	 */
	public function setPrivateKey(string $privateKey)
	{
		$this->privateKey = $privateKey;

		return $this;
	}

	/**
	 * Get a private key
	 *
	 * Parses key and prepares it for use by other functions.
	 *
	 * @return string
	 */
	public function getPrivateKey(): string
	{
		if (str_starts_with($this->privateKey, '-----BEGIN RSA PRIVATE KEY-----') && str_ends_with($this->privateKey, '-----END RSA PRIVATE KEY-----')) {
			return $this->privateKey;
		}

		return "-----BEGIN RSA PRIVATE KEY-----\n" .
			wordwrap($this->privateKey, 64, "\n", true) .
			"\n-----END RSA PRIVATE KEY-----";
	}

	/**
	 * Parser data to string by items.
	 *
	 * @param LazyCollection|array $items
	 *
	 * @return string
	 */
	public function parserItemsToStirng(LazyCollection|array $items): string
	{
		return (is_array($items) ? new LazyCollection($items) : $items)
			->sortKeys()
			->filter()
			->map(function($v, $k) {
				if (is_array($v)) {
					ksort($v);
					return $k. '='.json_encode(array_filter($v));
				}

				return $k.'='.$v;
			})
			->values()
			->join('&');
	}

	/**
	 * Generate signature
	 *
	 * computes a signature for the specified data by generating a cryptographic digital signature using the private key
	 * associated with priv_key_id. Note that the data itself is not encrypted.
	 *
	 * @param LazyCollection|array $items
	 *
	 * @return string
	 */
	public function sign(LazyCollection|array $items): string
	{
		// fetch private key from file and ready it
		$pkeyid = openssl_pkey_get_private($this->getPrivateKey());

		// compute signature
		openssl_sign($this->parserItemsToStirng($items), $signature, $pkeyid, OPENSSL_ALGO_SHA256);

		return base64_encode($signature);
	}

	/**
	 * Verify signature
	 *
	 * verifies that the signature is correct for the specified data using the public key associated with pub_key_id.
	 * This must be the public key corresponding to the private key used for signing.
	 *
	 * @param  LazyCollection|array $items
	 * @param  string $sign
	 *
	 * @return boolean
	 */
	public function validate(LazyCollection|array $items, string $sign): bool
	{
		// fetch public key from certificate and ready it
		$pubkeyid = openssl_pkey_get_public($this->getPublicKey());

		$isVerify = openssl_verify(
			$this->parserItemsToStirng($items),
			base64_decode($sign),
			$pubkeyid,
			OPENSSL_ALGO_SHA256
		);

		return $isVerify;
	}
}
