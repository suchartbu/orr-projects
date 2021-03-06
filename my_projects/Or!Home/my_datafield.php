<?php

/******************************************************************
 * @version php5
 * @author Suchart Bunhachirat
 * @copyright Copyright &copy; 2007, orr
 * ค่าใน config.inc.php ให้ถูกต้อง
 * กำหนดข้อมูลของโปรแกรม
 * กำหนดเขตข้อมูล
 *******************************************************************/

require_once ('my_page.cls.php');

class my extends my_page {
	function __construct()
	{
		parent:: __construct();
		$this->set_skin_ccs("my_form.css");
		/*
		 * กำหนดคุณสมบัติของหน้าจอดังนี้
		 * $table : ชื่อ Table
		 * $sql : คำสั่ง SQL
		 * $key : ชื่อ Field ที่เป็น PRIMARY
		 */
		$table = 'my_datafield';
		$sql = 'SELECT * FROM `' . $table .'` ';
		$key = 'field_id';
		
		$my_form = new OrDbFrmForm('my_form' , $this->get_my_db() , $table ,$key);
                $my_form->OP_[list_page_url]->set('my_datafield_list.php');
                //$my_form->OP_[column]->set(2);
		/*
		 * สร้าง Control ในฟอร์ม ประกอบด้วย Class ในกลุ่ม GUI
		 */
		$my_form->set_controls(new OrTextbox('field_id'));
		$my_form->controls[field_id]->OP_[title]->set('Field Name ที่ต้องการกำหนดคุณสมบัติ');
		$my_form->controls[field_id]->set_size(20,50);
		
		$my_form->set_controls(new OrTextbox('name')  );
		$my_form->controls[name]->OP_[title]->set('ชื่อของ Field Name ที่ต้องการแสดงในโปรแกรม');
		$my_form->controls[name]->set_size(20,50);
		
		$my_form->set_controls(new OrTextarea('description') );
		$my_form->controls[description]->OP_[title]->set('คำอธิบายต่างๆ ใน Title ของ Field');
		$my_form->controls[description]->OP_[check_null]->set(false);
		/*
		 * ตัวอย่างการสร้าง controls textbox ความกว้าง 10 ฟิลด์ชื่อ name
		 * $my_form->set_controls(new OrTextbox('name'));
		 * $my_form->controls[name]->set_size(10);
		 * เพิ่ม control ต่อไว้ด้านล่างนี้
		 */
		 
		 /*
		 * กำหนดข้อมูลการคัดกรองข้อมูล ใหม่กรณีเกิดข้อผิดพลาด เช่น ฟิลด์ name เกิดจากคำสั่ง concat ดังดัวอย่าง
		 * $my_form->set_filter_name('name',"concat(`prefix`,`fname`, ' ' , `lname`)");
		 */
		
		/*
		 * กระบวนการจัดการข้อมูลจากฐานข้อมูล
		 */
		$my_form->fetch_record($sql);
		/*
		 * กำหนดส่วนหัวของฟอร์ม ปกติจะแสดงช่อง Filter สำหรับกรองข้อมูล
		 */
		 $my_form->set_header('ค้นหา ' . $my_form->get_control_filter() .' เรียง ' . $my_form->get_control_order() . ' ' . $my_form->get_button_filter());
		 /*
		  * กำหนดฟอร์มลงในหน้า และแสดงหน้าจอ
		  */
		 $this->set_form( $my_form->get_tag());
		 $this->set_filter_msg( $my_form->OP_[cmd_msg]->get());
		 $this->show();
	}

}
$my = new my();
?>
