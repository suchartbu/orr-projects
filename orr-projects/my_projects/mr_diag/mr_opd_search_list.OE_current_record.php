<?php

/*
 * เหตุการณ์ขณะที่อ่านข้อมูลแต่ละ รายการในตาราง
 * $EV_record[field_name] : ค่าของ field
 * val_filter[field_name] : ค่าที่ต้องการให้กรองข้อมูลของ field
 * ตัวอย่าง การสร้าง LInk เพื่อเชื่อม Page ใหม่
 * $event_link = '<a href="my_group.php?val_filter[group]=' . $EV_record[group] . '&val_filter[user]=' . $EV_record[user] .'&val_msg[btn_filter]=Filter" target="_parent" >' . $EV_record[user] . '</a>';
 * $this->controls[user]->OP_[text]->set($event_link);
 */
 /*
 function get_search(){
		global $my_cfg;
		$my_sec = new OrSec();
		$my_db=new OrMysql($my_cfg[db]);//(กำหนด Object ฐานข้อมูลที่จะใช้)
		$sql="SELECT * FROM `mr_discharge_summary` WHERE `visit_date` = '" . $my_sec->OP_['visit_date']->get() . "'";//(กำหนด SQL ตามเงื่อนไขที่ต้องการ)
		$my_db->get_query($sql);
		if($my_db->get_record()){
			$my_value = $my_db->record[id];
		}else{
			$my_value = null;
		}
		unset($my_db);
		return $my_value;
}
if get_search() <> ''{
	
}else{

}*/
$event_link = '<a href="mr_opd_diagnosis.php?visit_date=' . $EV_record[visit_date] . '&vn=' . $EV_record[vn] . '&hn=' . $EV_record[hn]  . '&name=' . $EV_record[name] . '&sex=' . $EV_record[sex] .'&doctor_id=' . $EV_record[doctor_id] . '&evt_form_db[navigator]=New" target="_parent" >' . $EV_record[vn] . '</a>';
$this->controls[vn]->OP_[text]->set($event_link);
?>