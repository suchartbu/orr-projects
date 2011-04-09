<?php
/******************************************************************
 * @version php5
 * @author Suchart Bunhachirat
 * @copyright Copyright &copy; 2007, orr
 * กรุณาตรวจสอบ
 * ค่าใน config.inc.php ให้ถูกต้อง
 * กำหนดข้อมูลของโปรแกรม
 * กำหนดเขตข้อมูล
 * ตัวอย่างการเขียนเพื่อแสดงข้อมูลแบบรายงาน
 *******************************************************************/
 
require_once('my_page.cls.php');

class my extends my_page {
	function __construct()
	{
		parent:: __construct();
		$this->set_skin_ccs("my_list.css");
		/*
		 * กำหนดไฟล์ css ที่ใช้กำหนดความกว้างในแต่ละช่องข้อมูล
		 * โดยปกติจะตั้งชื่อเดียวกับ ชื่อไฟล์โปรแกรมแต่มีนามสกุลเป็น .css
		 * อ่านรายละเอียด การกำหนดค่าได้ในไฟล์ new_page_list.css
		 */
		$this->set_skin_ccs("new_page_list.css");//<-กำหนดชื่อไฟล์ css
		/*
		 * กำหนดคำสั่ง SQL ที่ใช้ในการแสดงข้อมูลในฐานข้อมูล ในดัวแปร $sql
		 * ตัวอย่างเป็นแสดงข้อมูลจากตาราง my_user
		 */
		$sql = "SELECT `mr_discharge_summary`.`id`, `mr_discharge_summary`.`icd_date`, `mr_discharge_summary`.`iopd`, `mr_discharge_summary`.`hn`, `mr_discharge_summary`.`vn`, CONCAT( `patient`.`prefix`, `patient`.`fname`, '  ', `patient`.`lname` ) AS `name`, `patient`.`sex`, `mr_discharge_summary`.`age_year`, `mr_discharge_summary`.`age_month`, `mr_discharge_summary`.`age_day`, `mr_discharge_summary`.`principal_diag1`, `mr_diag`.`name_e`, `mr_discharge_summary`.`external_cause`, `mr_discharge_summary`.`signature1`, CONCAT( `doctor`.`prefix`, `doctor`.`fname`, '  ', `doctor`.`lname` ) AS `doctor_name` FROM `theptarin_utf8`.`mr_discharge_summary` AS `mr_discharge_summary`, `theptarin_utf8`.`patient` AS `patient`, `theptarin_utf8`.`doctor` AS `doctor`, `theptarin_utf8`.`mr_diag` AS `mr_diag` WHERE `mr_discharge_summary`.`hn` = `patient`.`hn` AND `mr_discharge_summary`.`signature1` = `doctor`.`doctor_code` AND `mr_discharge_summary`.`principal_diag1` = `mr_diag`.`code` AND `mr_discharge_summary`.`iopd` = 'O'";//<-กำหนดคำสั่ง SQL
		
		$my_form = new OrDbFrmList('my_form' , $this->get_my_db() );
                $my_form->OP_[edit_page_url]->set('_.php');//กำหนด URL ของหน้าแก้ไขข้อมูล
                $my_form->OP_[edit_field_link]->set('id');//กำหนด ชื่อ Field ที่ต้องการให้เป็น Link หนาแก้ไขข้อมูล
                $my_form->OP_[edit_key_field]->set('id'); //กำหนด ชื่อ Field ที่เป็นคีย์แก้ไข
                
		/*
		 * กำหนดคำสั่งที่ต้องในเหตุการณ์ของ Form เช่น on current record โดยปกติจากสร้างไฟล์เก็บคำสั่งไว้
		 * โดยใช้ [ชื่อไฟล์โปรแกรม] .[ชื่อเหตุการณ์] เช่น new_page_list.OE_current_record.php เป็นต้น
		 * สามารถดูรายละเอียดได้ในไฟล์ดังกล่าว
		 */
		//$my_form->OE_[current_record]->set("include('new_page_list.OE_current_record.php');");//<-แก้ไขถ้าต้องการใช้คำสั่งตามเหตุการณ์
		
		/*
		 * สร้าง Control ในฟอร์ม โดยปกติจะใช้ class OrLabel
		 * ตามตัวอย่างประกอบด้วยฟิลด์ตามคำสั่ง SQL ในตาราง my_user
		 */
		
		$my_form->set_controls(new OrLabel('id'));
		$my_form->set_controls(new OrLabel('icd_date'),'วันที่มาตรวจ');
			$my_form->controls[icd_date]->set_format('th_date' , 'mysql');
		$my_form->set_controls(new OrLabel('iopd'));
		$my_form->set_controls(new OrLabel('hn'));
		$my_form->set_controls(new OrLabel('vn'));
		$my_form->set_controls(new OrLabel('name'));
		$my_form->set_controls(new OrLabel('sex'));
		//$my_form->set_controls(new OrLabel('age_year'));
		//$my_form->set_controls(new OrLabel('age_month'),'เดือน');
		//$my_form->set_controls(new OrLabel('age_day'),'เดือน');
		$my_form->set_controls(new OrLabel('principal_diag1'),'Principal diagnosis');
		$my_form->set_controls(new OrLabel('name_e'));
		$my_form->set_controls(new OrLabel('external_cause'),'External cause(accident/toxic)');
		$my_form->set_controls(new OrLabel('signature1'),'Signature');
		$my_form->set_controls(new OrLabel('doctor_name'));
		
		/*
		* กำหนดชนิด filter controls ตามตัวอย่างคำสั่ง
		* $my_form->set_filter_controls(new OrSelectbox('status'));
		* $my_form->set_filter_controls(new OrTextCalendar2('service_reg_date'));
		*/
		
		
		/*
		 * กำหนด Function คำนวณการคำสั่ง SQL
		 * $my_form->set_total_function('id' , 'count');
		 */
		 
		 
		/*
		 * กำหนดข้อมูลการคัดกรองข้อมูล ใหม่กรณีเกิดข้อผิดพลาด เช่น ฟิลด์ name เกิดจากคำสั่ง concat ดังดัวอย่าง
		 * $my_form->set_filter_name('name',"concat(`prefix`,`fname`, ' ' , `lname`)");
		 */
		 
		
		/*
		 * กำหนดเงื่อนไขการเปรียบเทียบเริ่มต้น ฟิลด์ frequency ต้องให้เริ่มเปรียบเทียบด้วย = ให้กำหนดตามตัวอย่างด้านล่าง
		 * $my_form->set_filter_compare('frequency',"=");
		 */
		 
		 
		/*
		 * กระบวนการจัดการข้อมูลจากฐานข้อมูล
		 */
		$my_form->fetch_record($sql);
		/*
		 * กำหนดส่วนหัวของฟอร์ม ปกติจะแสดงช่อง Filter สำหรับกรองข้อมูล
		 */
		 //$my_form->set_header('This is Header.');
		 /*
		  * กำหนดส่วนล่างของฟอร์ม กรณีที่ต้องการ เช่นแสดง ยอดรวม
		  */
		  //$my_form->set_footer($my_form->total_controls[conunt_id]->get_tag());
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