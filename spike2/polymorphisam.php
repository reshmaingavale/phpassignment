<?php

class A{

function Disp(){

echo "Inside the Base class<br/>";}}

class B extends A{

function Disp(){
A::Disp();
echo "Inside the Chlid class<br/>";}}



$obj=new B();

$obj->Disp();



?>
