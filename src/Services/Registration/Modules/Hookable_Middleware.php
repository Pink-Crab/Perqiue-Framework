<?php

declare(strict_types=1);

/**
 * Registration_Middleware for all classes that implement the Resiterable
 * interface.
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
 * @package PinkCrab\Perique\Registration
 * @since 0.4.0
 */

namespace PinkCrab\Perique\Services\Registration\Modules;

use PinkCrab\Perique\Interfaces\Hookable;
use PinkCrab\Perique\Interfaces\Inject_Hook_Loader;
use PinkCrab\Perique\Interfaces\Registration_Middleware;
use PinkCrab\Perique\Services\Container_Aware_Traits\Inject_Hook_Loader_Aware;

class Hookable_Middleware implements Inject_Hook_Loader, Registration_Middleware {

	use Inject_Hook_Loader_Aware;

	/**
	 * Process the passed class
	 *
	 * @param object $class
	 * @return object
	 */
	public function process( object $class ): object {  // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.classFound
		if ( in_array( Hookable::class, class_implements( $class ) ?: array(), true ) ) { // phpcs:ignore Universal.Operators.DisallowShortTernary.Found
			/** @phpstan-ignore-next-line class must implement register for interface*/
			$class->register( $this->loader );
		}
		return $class;
	}

	/**
	 * Used to for any middleware setup before process is called
	 *
	 * @return void
	 */
	public function setup(): void {}

	/**
	 * Used after all classes have been passed through process.
	 *
	 * @return void
	 */
	public function tear_down(): void {}
}
