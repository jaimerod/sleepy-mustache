<?php
require_once('class.css.php');

/**
 * Automatically compresses CSS files when the environment is live
 * @return string The CSS tags to embed in the head
 */
function css_render_placeholder() {

	if (ENV === "live") {
		$c = new CSS();

		$files = "";

		foreach (func_get_args() as $file) {
			if (empty($file)) {
				continue;
			}

			if (strlen($files) < 1) {
				$files = $file;
			} else {
				$files .= "&" . $file;
			}
		}

		$files = urlencode($files);
		return "<link rel=\"stylesheet\" href=\"/modules/enabled/css-compress/?css={$files}\">";
	} else {
		foreach (func_get_args() as $file) {
			if (empty($file)) {
				continue;
			}
			$buffer .= "<link rel=\"stylesheet\" href=\"/css/{$file}.css\">";
		}

		return $buffer;
	}
}

Hook::applyFilter('render_placeholder_css', 'css_render_placeholder');