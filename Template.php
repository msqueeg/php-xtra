<?php
/**
* https://www.sitepoint.com/5-inspiring-and-useful-php-snippets/
*
* usage:
* $t = new Template();
*
* $t->greeting = 'Hello World';
*
* $t->set("number", 42);
*
* $t->set(array('foo' => 'bar','zip' => 'zap'));
*
* $t->out('myTemplate');
*/
class Template
{
	
	protected $dir;
	protected $vars;

	public function __construct($dir = "")
	{
		$this->dir = (substr($dir,-1) == "/") ? $dir : $dir . "/";

		$this->vars = array();
	}

	public function __set(($var, $value)
	{
		$this->vars[$var] = $value;
	}

	public function __get($var)
	{
		return $this->vars[$var];
	}

	public function __isset($var)
	{
		return isset($this->vars[$var]);
	}

	public function set()
	{
		$args = func_get_args();
		if(func_num_args() == 2) {
			$this->__set($args[0], $args[1]);
		} else {
			foreach($args[0] as $var => $value) {
				$this->__set($var, $value);
			}
		}
	}

	public function out($template, $asString = false)
	{
		ob_start();
		require $this->dir . $template . ".php";
		$content = ob_get_clean();

		if($asString) {
			return $content;
		} else {
			echo $content;
		}
	}

}