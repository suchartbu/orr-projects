<?php

/*
 * เหตุการณ์ขณะที่อ่านข้อมูลแต่ละ รายการในตาราง
 * $EV_record[field_name] : ค่าของ field
 * val_filter[field_name] : ค่าที่ต้องการให้กรองข้อมูลของ field
 * ตัวอย่าง การสร้าง LInk เพื่อเชื่อม Page ใหม่
 * $event_link = '<a href="my_group.php?val_filter[group]=' . $EV_record[group] . '&val_filter[user]=' . $EV_record[user] .'&val_msg[btn_filter]=Filter" target="_parent" >' . $EV_record[user] . '</a>';
 * $this->controls[user]->OP_[text]->set($event_link);
 */
$event_link = '<a href="JavaScript:window.close()" >' . $EV_record[id] . '</a>';
$this->controls[id]->OP_[text]->set($event_link);

?>
