<?php
class LinkHelper extends AppHelper {
	
	function spanlink($title, $url = null, $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true, $imagetitle=null) {
		if ($url !== null) {
			$url = $this->url($url);
		} else {
			$url = $this->url($title);
			$title = $url;
			$escapeTitle = false;
		}

		if (isset($htmlAttributes['escape']) && $escapeTitle == true) {
			$escapeTitle = $htmlAttributes['escape'];
		}

		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		if (!empty($htmlAttributes['confirm'])) {
			$confirmMessage = $htmlAttributes['confirm'];
			unset($htmlAttributes['confirm']);
		}
		if ($confirmMessage) {
			$confirmMessage = str_replace("'", "\'", $confirmMessage);
			$confirmMessage = str_replace('"', '\"', $confirmMessage);
			$htmlAttributes['onclick'] = "return confirm('{$confirmMessage}');";
		} elseif (isset($htmlAttributes['default']) && $htmlAttributes['default'] == false) {
			if (isset($htmlAttributes['onclick'])) {
				$htmlAttributes['onclick'] .= ' event.returnValue = false; return false;';
			} else {
				$htmlAttributes['onclick'] = 'event.returnValue = false; return false;';
			}
			unset($htmlAttributes['default']);
		}
		if(isset($imagetitle)) {
			$imagetitle = "<b>".$imagetitle."</b>";
		}
		return $this->output(sprintf('<a href="%s"%s><span>%s</span>'.$imagetitle.'</a>', $url, $this->_parseAttributes($htmlAttributes), $title));
	}
}