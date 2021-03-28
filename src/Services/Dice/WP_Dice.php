<?php

declare(strict_types=1);

/**
 * Wrapper for DICE to handle DICE returning a new instance when new rules are added.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Core\Dice
 */

namespace PinkCrab\Core\Services\Dice;

use Dice\Dice;


class WP_Dice {

	public const ADD_RULES_FILTER = 'pc_wp_dice_add_rules_filter';

	/**
	 * Holds the instnace of DICE to work with.
	 *
	 * @var Dice;
	 */
	protected $dice;

	/**
	 * Passes in the inital dice instance.
	 *
	 * @param Dice $dice
	 */
	public function __construct( Dice $dice ) {
		$this->dice = $dice;
	}


	/**
	 * Lazy stack instancing.
	 *
	 * @param Dice $dice
	 * @return self
	 */
	public static function constructWith( Dice $dice ): self { // phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
		return new static( $dice );
	}

	/**
	 * Proxy for addRule.
	 *
	 * @param string $name
	 * @param array<string, string|object|array> $rule
	 * @return self
	 */
	public function addRule( string $name, array $rule ): self { // phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
		$this->dice = $this->dice->addRule( $name, $rule );
		return $this;
	}

	/**
	 * Proxy for addRules
	 *
	 * @param array<string, array> $rules
	 * @return self
	 * @filter WP_Dice::ADD_RULES_FILTER(array<string, array>):array<string, array>
	 */
	public function addRules( array $rules ): self { // phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
		$this->dice = $this->dice->addRules(
			apply_filters( self::ADD_RULES_FILTER, $rules )
		);
		return $this;
	}

	/**
	 * Proxy for create, but with third param removed (see dice code comments)
	 *
	 * @param string $name
	 * @param array<mixed> $args
	 * @return object|null
	 */
	public function create( string $name, array $args = array() ) {
		return $this->dice->create( $name, $args );
	}
}
