<?php
/**
 *
 */
class Main extends CI_Controller
{


  function index(){
    //$data['string']=$this->testData();
    $this->load->view('chart1');
  }
  function testData(){
  //return "{datasets: [{label: 'test',data :[{x: 5,y: 6},{x: 9,y: 10},{x: 3, y: 2}]}]}";
  }
  function c1(){
    $this->load->view('chart1');
  }
  function c2(){
    $this->load->view('chart2');
  }
}

 ?>
