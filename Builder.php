<?php
/**
*
*/

require_once(Helper.php);

namespace Msqueeg/Lib;

class Builder
{
	
	/**
	 * build html tags using php
	 * examples : 
	 * echo buildTag('input', array('type'=>'button', 'value'=>'WOOT!'), TRUE);
	 *
	 * echo buildTag('div', array('style'=>'border:solid 1px #000'), FALSE, buildTag('a', array('href'=>'http://google.com'), FALSE, 'Google'));
	 * 
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @since    2016-08-30
	 * @param   [type]     $tag       tag name (e.g., "option", "select")
	 * @param   array      $att       attributes for tag (e.g., array('url' => 'http://www.google.com'))
	 * @param   boolean    $selfColse self collapsing tag (e.g., <img /> versus <b></b>)
	 * @param   string     $inner     content enclosed in the tags
	 * @return  string                tag with nested content
	 */
	public function buildTag($tag, $att = array(), $selfColse = FALSE, $inner = ''){
	    $html = '<'.$tag.' ';
	    foreach($att as $k => $v){
	        $html .= $k.'="'.$v.'"';
	    }
	    if(!$selfColse)
	        $html .= '>';
	    else
	        $html .= ' />';
	    if(!$selfColse)
	        $html .= $inner.'</'.$tag.'>';
	    return $html;
	}

	/**
	 * build select menu options from arrays of pages
	 *
	 * @author msqueeg <msqueeg@gmail.com>
	 * @version [version]
	 * @since    2016-08-30
	 * @param   array      $pages          associative or sequential array - array('http://www.google.com' => 'Google') or array('/pages', '/events')
	 * @param   array      $selectOptions  options for select (e.g., array('name' => 'surprise1'))
	 * @return  html                       [description]
	 */
	public function buildSelectDropDown($list = array(), $defaultOption = '', $selectOptions = array())
	{
		//build internal list of options tags
		$options = buildOptionsList($list,$defaultOption);
		
		//wrap options in <select> tag
		$html = $this->buildTag('select', $select_options, FALSE, $options);

		return $html;		
	}

	public function buildAnchor($url,$anchor,$alt ='')
	{

		if($alt === '') {
			$html = $this->buildTag('a', array('url' => $url),FALSE, $anchor);
		} else {
			$html = $this->buildTag('a', array('url' => $url, 'alt' => $alt),FALSE, $anchor);
		}
	}

	public function checkSelected($question,$check)
	{
		if($question === $check) {
			return array('selected' => 'selected');
		} else {
			return false;
		}
	}

	public function buildOptionsList($options = array(), $defaultOption = '')
	{
		if(isAssoc($options)) {
			foreach($options as $value => $display) {
				$attributes = array('value' => $value);
				$selected = $this->checkSelected($display, $defaultOption)
				$attributes = (is_array($selected)? array_merge($attributes, $selected): $attributes);
				$html .= $this->buildTag('option',$attributes, FALSE, $display);
			}
		} else {
			foreach($options as $option) {
				$attributes = array('value' => $option);
				$selected = $this->checkSelected($option, $defaultOption)
				$attributes = (is_array($selected)? array_merge($attributes, $selected): $attributes);
				$html .= $this->buildTag('option', $attributes ,FALSE, $option);
			}

		}

		return $html;

	}

	public function getCountryOptions($country = 'United States', $selectOptions = array('name' => 'countryList'))
	{
		$countries = array("Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","The Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and HerzegovinaBotswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burma","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African RepublicChad","Chile","China","Colombia","Comoros","Congo (Brazzaville)","Congo (Kinshasa)","Costa Rica","Côte d'Ivoire","Croatia","Cuba","Cyprus","Czech RepublicDenmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","The Gambia","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Vatican City (Holy See)","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","North KoreaSouth Korea","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Federated States of Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe");

			$html = $this->buildSelectDropDown($countries,$country,$selectOptions);

			return $html;

	}

	public function getStatesOptions($defaultState = 'Ohio', $selectOptions = array('name' => 'statesList'))
	{
		//list of US states
		$states = array();

		$html = $this->buildSelectDropDown($states,$defaultState,$selectOptions)


	}

}