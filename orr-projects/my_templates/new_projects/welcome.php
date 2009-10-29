<?php

/*
 * Created on 16-Mar-06
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require_once ("my_page.cls.php");
require_once ("config.inc.php");

class my extends my_page {
	function my() {
		global $my_cfg;
		parent :: __construct('บันทึกเข้าใช้งาน',false);
		$this->set_skin($my_cfg[skins_path] .'my_welcome.html');
		$my_sec = new OrSec(false);
		$val_ = new OrSysvalue();
		$val_controls = $val_->controls;
		/*val_controls*/
		//echo "<b>debug</b> ".__FILE__." | ".__LINE__." | val_controls[user] " . print_r(array_values($val_controls[user] )). "<br>";
		//echo "<b>debug</b> ".__FILE__." | ".__LINE__." | val_controls[pass] " . $val_controls[pass] . "<br>";
		if ($val_controls[login] == 'login')
			$my_sec->login($val_controls[user], $val_controls[pass]);
		if ($val_controls[logout] == 'logout')
			$my_sec->logout();
		//$skin_help = new OrSkin($my_cfg[skins_path]."my_help.html");
		$skin_description = new OrSkin($my_cfg[skins_path] . "my_description.html");
		$skin_description->set_skin_tag('my_message', $this->get_text('message.inc'));

		$skin_help = new OrSkin($my_cfg[skins_path] . "my_help.html");
		$skin_help->set_skin_tag('my_help', $this->get_frame('help/login_help.html'));

		$my_form = new OrForm('my_form');

		if ($my_sec->OP_[user]->get() == '') {
			$my_form->set_controls(new OrTextbox('user'));
			$my_form->controls[user]->set_size(10);

			$my_form->set_controls(new OrTextbox('pass'));
			$my_form->controls[pass]->set_size(10);
			$my_form->controls[pass]->OP_[type]->set('password');

			$my_form->set_controls(new OrButton('login'));
			$my_form->set_skin($my_cfg[skins_path] . "frm_login.html");
			$my_form->skin->set_skin_tag('user', $my_form->controls[user]->get_tag());
			$my_form->skin->set_skin_tag('pass', $my_form->controls[pass]->get_tag());
			$my_form->skin->set_skin_tag('login', $my_form->controls[login]->get_tag('login'));

		} else {
			header("Location:portal.php");
		}

		$my_form->set_body($my_form->skin->get_tag());

		$this->set_caption('บันทึกเข้าใช้งาน');
		$this->set_form($my_form->get_tag());
		//$this->set_footer($this->get_text('footer.inc'));
		//$this->skin->set_skin_tag('my_description' , $skin_description->get_tag());
		//$this->skin->set_skin_tag('my_help' , $skin_help->get_tag());
		//$this->set_body($this->skin->get_tag());
		$this->show();
	}
}

$my = new my();
?>
