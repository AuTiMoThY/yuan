<?php 
    function css_url($filename = '') {
		return base_url('assets/css/'.$filename);
	}

	function js_url($filename = '') {
		return base_url('assets/js/'.$filename);
	}

	function plugins_url($filename = '') {
		return base_url('assets/plugins/'.$filename);
	}

	function img_url($filename = '') {
		return base_url('assets/images/'.$filename);
	}
	function favicon_url($filename = '') {
		return base_url('favicon/'.$filename);
	}
?>