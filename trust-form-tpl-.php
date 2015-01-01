<?php
function trust_form_show_input() {
	global $trust_form;
	$col_name = $trust_form->get_col_name();
	$validate = $trust_form->get_validate();
	$config = $trust_form->get_config();
	$attention = $trust_form->get_attention();
	
	$nonce = wp_nonce_field('trust_form','trust_form_input_nonce_field');

	$html = <<<EOT
		<div class="single">
		<h3 class="shadow960">CONTACT</h3>
	</div>
<ul class="flow clearfix">
	<li class="flow1 arrow active">入力画面</li>
	<li class="flow2 arrow">確認画面</li>
	<li class="flow3">送信完了</li>
</ul>
<div id="trust-form" class="contact-form contact-form-input" >
<p id="message-container-input">{$trust_form->get_input_top()}</p>
<div class="form">
<form action="#trust-form" method="post" >

EOT;

	foreach ( $col_name as $key => $name ) {
		$html .= '<dl><dt><div class="subject"><span class="content">'.$name.'</span>'.(isset($validate[$key]['required']) && $validate[$key]['required'] == 'true' ? '<span class="require">'.$config['require'].'</span>' : '' ).'</div><div class="submessage">'.$attention[$key].'</div></dt><dd><div>'.$trust_form->get_element( $key ).'</dd>';

		$err_msg = $trust_form->get_err_msg($key);
		if ( isset($err_msg) && is_array($err_msg) ) {
			$html .= '<div class="error">';
			foreach ( $err_msg as $msg ) {
				$html .= $msg.'<br />';
			}
			$html .= '</div>';
		}
		$html .= '</dl>';
	}
	$html .= <<<EOT

{$nonce}
<p id="confirm-button" class="submit-container">{$trust_form->get_form('input_bottom')}</p>
</form>
</div>
</div>
EOT;

	return $html;
}



function trust_form_show_confirm() {
	global $trust_form;
	$col_name = $trust_form->get_col_name();

	$nonce = wp_nonce_field('trust_form','trust_form_confirm_nonce_field');

	$html = <<<EOT
		<div class="single">
		<h3 class="shadow960">CONTACT</h3>
	</div>
<ul class="flow clearfix">
	<li class="flow1 arrow">入力画面</li>
	<li class="flow2 arrow active">確認画面</li>
	<li class="flow3">送信完了</li>
</ul>
<div id="trust-form" class="contact-form contact-form-confirm" >
<p id="message-container-confirm">{$trust_form->get_form('confirm_top')}</p>
<form action="#trust-form" method="post" >
<table>
<tbody>
EOT;
	foreach ( $col_name as $key => $name ) {
		$html .= '<tr><th><div class="subject">'.$name.'</div></th><td><div>'.$trust_form->get_input_data($key).'</div>';
		$html .= '</td></tr>';
	}
	$html .= <<<EOT
</tbody>
</table>
{$nonce}
<p id="confirm-button" class="submit-container">{$trust_form->get_form('confirm_bottom')}</p>
</form>
</div>
EOT;
	return $html;
}



function trust_form_show_finish() {
	global $trust_form;
	
	$html = <<<EOT
		<div class="single">
		<h3 class="shadow960">CONTACT</h3>
	</div>
<ul class="flow clearfix">
	<li class="flow1 arrow">入力画面</li>
	<li class="flow2 arrow">確認画面</li>
	<li class="flow3 active">送信完了</li>
</ul>
<div id="trust-form" class="contact-form contact-form-finish" >
<p id="message-container-confirm">{$trust_form->get_form('finish')}</p>
</div>
EOT;
	return $html;
}
?>