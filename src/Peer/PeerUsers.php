<?php
/**
 * Created by PhpStorm.
 * User: peyman
 * Date: 22/01/19
 * Time: 10:10
 */

namespace Vicente\Bale\Peer;


use Vicente\Bale\Exception\MessageException;

class PeerUsers {

	private $type = '';
	private $id = '';
	private $accessHash = '';

	/**
	 * PeerUsers constructor.
	 *
	 * @param string $type نوع
	 * @param integer $id شناسه کاربر
	 * @param string $accessHash کد دسترسی کاربر
	 */
	public function __construct( $type, $id, $accessHash ) {

		$this->type       = $type;
		$this->id         = $id;
		$this->accessHash = $accessHash;

	}

	/**
	 *
	 * @return array
	 * @throws MessageException
	 */
	public function getPeer() {

		if ( ! in_array( $this->type, [ 'Group', 'User' ] ) ) {
			throw new MessageException( 'نوع کاربر را وارد نمایید.' );
		}

		if ( ! $this->id ) {
			throw new MessageException( 'شناسه کاربر را وارد نمایید.' );
		}

		if ( ! $this->accessHash ) {
			throw new MessageException( 'کد دستری کاربر را وارد نمایید.' );
		}

		return [
			'$type'      => $this->type,
			'id'         => $this->id,
			'accessHash' => $this->accessHash
		];

	}

}