<?php
interface MyInterface
{
	public function A();
	public function B();
	public function setName($name);
}

class MyClass implements MyInterface
{
	protected $name;
	public function A()
	{
		echo ("Ini dari fungsi A <br>");
	}
	public function B()
	{
		echo ("Ini dari fungsi B <br>");
	}
	public function setName($name)
	{
		$this->name = $name;
		echo $this->name;
	}
}

$call = new MyClass();
$call->A();
$call->B();
$call->setName('Edo Kurniawan');
