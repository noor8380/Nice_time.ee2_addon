<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name' => 'Nice Time',
	'pi_version' => '0.1',
	'pi_author' =>'Pierre-Vincent Ledoux',
	'pi_author_email' =>'ee-addons@pvledoux.be',
	'pi_author_url' => 'http://twitter.com/pvledoux/',
	'pi_author_url' => 'http://www.twitter.com/pvledoux',
	'pi_description' => 'Display a date a a relative time format',
	'pi_usage' => Nice_time::usage()
  );

/**
 * Copyright (c) 2012, Pv Ledoux
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *	* Redistributions of source code must retain the above copyright
 *	   notice, this list of conditions and the following disclaimer.
 *	* Redistributions in binary form must reproduce the above copyright
 *	   notice, this list of conditions and the following disclaimer in the
 *	   documentation and/or other materials provided with the distribution.
 *	* Neither the name of the <organization> nor the
 *	   names of its contributors may be used to endorse or promote products
 *	   derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Nice_time
 *
 * @copyright	Pv Ledoux 2011
 * @since		20 Dec 2011
 * @author		Pierre-Vincent Ledoux <ee-addons@pvledoux.be>
 * @link		http://www.twitter.com/pvledoux/
 *
 */
class Nice_time
{
	/**
 	 * Data returned from the plugin.
	 *
	 * @access	public
	 * @var		array
	 */
	public $return_data	= null;

	private $_ee		= NULL;
	private $_date		= NULL;
	private $_format	= NULL;

	/**
	* Constructor.
	*
	* @access	public
	* @return	void
	*/
	public function __construct()
	{
		$this->_ee =& get_instance();
		$this->_date = $this->_ee->TMPL->fetch_param('date', time());
		$this->_format = $this->_ee->TMPL->fetch_param('format', '%d-%m-%Y %H:%i');

		$this->return_data = $this->_run();
	}

	/**
	* Annoyingly, the supposedly PHP5-only EE2 still requires this PHP4
	* constructor in order to function.
	*
	* @access public
	* @return void
	* method first seen used by Stephen Lewis (https://github.com/experience/you_are_here.ee2_addon)
	*/
	function Nice_time()
	{
		$this->__construct();
	}


	private function _plural($num) {
		if ($num != 1)
			return "s";
	}

	private function _run() {
		$diff = time() - $this->_date;
		if ($diff >= 0 && $diff < 5)
			return "now";
		if ($diff<60)
			return $diff . " second" . $this->_plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<60)
			return $diff . " minute" . $this->_plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<24)
			return $diff . " hour" . $this->_plural($diff) . " ago";
		$diff = round($diff/24);
		if ($diff<7)
			return $diff . " day" . $this->_plural($diff) . " ago";
		$diff = round($diff/7);
		if ($diff<4)
			return $diff . " week" . $this->_plural($diff) . " ago";
		return "on " . $this->_ee->localize->decode_date($this->_format, $this->_date);
	}


	/**
	 * Usage
	 *
	 * @return string
	 */
	function usage()
	{
			ob_start();

	?>


			Pvl Nice_time v. 0.1

			This plugin convert a date in relative time.

			<p>{exp:nice_time date="{entry_date}" format="%d-%m-%Y %H:%i"}</p>

			Parameter:

			date		is required (English format)
			format		optional (default: %d-%m-%Y %H:%i)


	 <?php

			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;
	}
	// --------------------------------------------------------------------

}
/* End of file pi.nice_time.php */
/* Location: ./system/expressionengine/third_party/nice_time/pi.nice_time.php */