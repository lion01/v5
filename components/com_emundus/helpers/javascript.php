<?php
/**
 * @version		$Id: javascript.php 14401 2013-03-19 14:10:00Z brivalland $
 * @package		Joomla
 * @subpackage	Emundus
 * @copyright	Copyright (C) 2008 - 2013 Decision Publique. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * eMundus is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.helper');
/**
 * Content Component Query Helper
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class EmundusHelperJavascript{
	
	function onSubmitForm(){
		$itemid = JRequest::getVar('Itemid', null, 'GET', 'none',0);
		$view = JRequest::getVar('view', null, 'GET', 'none',0);
		
		$script = '
function OnSubmitForm() { 
	if(typeof document.pressed !== "undefined") { 
		document.adminForm.task.value = "";
		var button_name=document.pressed.split("|"); 
		switch(button_name[0]) {
		   case \'affect\': 
		   		document.adminForm.task.value = "setAssessor";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=setAssessor";
			break;
			case \'unaffect\': 
				if (confirm("'.JText::_("CONFIRM_UNAFFECT_ASSESSORS").'")) {
					document.adminForm.task.value = "unsetAssessor";
					document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=unsetAssessor";
				} else 
					return false;
			break;
			case \'export_zip\': 
				if (is_checked()) {
					document.adminForm.task.value = "export_zip";
					document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=export_zip";
				}
				else alert("'.JText::_("PLEASE_SELECT_APPLICANT").'");
			break;
			case \'export_to_xls\': 
				document.adminForm.task.value = "transfert_view";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&Itemid='.$itemid.'&task=transfert_view&v='.$view.'";
			break;
			case \'custom_email\': 
				document.adminForm.task.value = "customEmail";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=customEmail";
			break;
			case \'applicant_email\': 
				document.adminForm.task.value = "applicantEmail";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=applicantEmail";
			break;
			case \'default_email\': 
				if (confirm("'.JText::_("CONFIRM_DEFAULT_EMAIL").'")) {
					document.adminForm.task.value = "defaultEmail";
					document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=defaultEmail";
				} else 
					return false;
			break;
			case \'search_button\': 
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&Itemid='.$itemid.'";
			break;
			case \'clear_button\': 
				document.adminForm.task.value = "clear";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=clear";
			break;
			case \'delete\':
			if(confirm("'.JText::_("CONFIRM_DELETE").'")) {
				document.adminForm.task.value = "delete";
				document.adminForm.action = "index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=delete&sid="+button_name[1];
			}
			break;
			case \'push_true\': 
				document.adminForm.task.value = "push_true";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=push_true";
			break;
			case \'push_false\':
				document.adminForm.task.value = "push_false";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=push_false";
			break;
			case \'validate\': 
				document.adminForm.task.value = "administrative_check";
				document.getElementById("cb"+button_name[1]).checked = true;
				document.getElementById("validation_list").value = 1;
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=administrative_check";
			break;
			case \'unvalidate\': 
				document.adminForm.task.value = "administrative_check";
				document.getElementById("cb"+button_name[1]).checked = true;
				document.getElementById("validation_list").value = 0;
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=administrative_check";
			break;
			case \'set_status\':
				document.adminForm.task.value = "administrative_check";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=administrative_check";
			break;
			case \'delete_eval\': 
			if(confirm("'.JText::_("CONFIRM_DELETE_EVAL").'")) {
				document.adminForm.task.value = "delete_eval";
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&Itemid='.$itemid.'&task=delete_eval&sid="+button_name[1];
			} else return false;
			break;
			case \'export_account_to_xls\': 
				document.adminForm.task.value = "export_account_to_xls"; 
				document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=export_account_to_xls&Itemid='.$itemid.'";
			break;
			
			case \'archive\': 
				document.adminForm.task.value = "archive";
				document.adminForm.action ="index.php?option=com_emundu&view='.$view.'&controller='.$view.'&task=archive&Itemid='.$itemid.'";
			break;
			case \'delusers\': 
				document.adminForm.task.value = "delusers";
				if (confirm("'.JText::_("CONFIRM_DELETE").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&Itemid='.$itemid.'&task=delusers&v='.$view.'";
			 	} else 
			 		return false;
			break;
			case \'delrefused\': 
				document.adminForm.task.value = "delrefused";
				if (confirm("'.JText::_("CONFIRM_DELETE").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=delrefused&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			case \'delincomplete\': 
				document.adminForm.task.value = "delincomplete";
				if (confirm("'.JText::_("CONFIRM_INCOMPLETE").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=delincomplete&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			case \'delnonevaluated\': 
				document.adminForm.task.value = "delnonevaluated";
				if (confirm("'.JText::_("CONFIRM_NON_EVALUATED").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=delnonevaluated&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			case \'delete_attachements\': 
				document.adminForm.task.value = "delete_attachements";
				if (confirm("'.JText::_("CONFIRM_DELETE_SELETED_ATTACHEMENTS").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=delete_attachements&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			case \'delete_comments\': 
				document.adminForm.task.value = "delete_comments";
				if (confirm("'.JText::_("CONFIRM_DELETE_SELETED_COMMENTS").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=delete_comments&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			case \'add_comment\': 
				document.adminForm.task.value = "add_comment";
				if (confirm("'.JText::_("ADD_COMMENT").'")) {
	        		document.adminForm.action ="index.php?option=com_emundus&view='.$view.'&controller='.$view.'&task=add_comment&Itemid='.$itemid.'";
			 	} else 
			 		return false;
			break;
			default: return false;
		}
		return true;
	}
} ';

		return $script;
	}
	
	/*
	** @todo : 
	*/
	
	function addElement(){
		$script = 
		'function addElement() {
			var ni = document.getElementById("myDiv");
		  	var numi = document.getElementById("theValue");
		  	var num = (document.getElementById("theValue").value -1)+ 2;
		  	numi.value = num;
		  	var newdiv = document.createElement("div");
		  	var divIdName = "my"+num+"Div";
		  	newdiv.setAttribute("id",divIdName);
			newdiv.innerHTML = "<select name=\"elements[]\" id=\"elements\" onChange=\"javascript:submit();\"><option value=\"\">'.JText::_("PLEASE_SELECT").'</option>';
		$groupe =""; $i=0; 
		$length = 50; 
		$all_elements = EmundusHelperFilters::getElements();
		foreach($all_elements as $elements) { 
			$groupe_tmp = $elements->group_label; 
			$dot_grp = strlen($groupe_tmp)>=$length?'...':''; 
			$dot_elm = strlen($elements->element_label)>=$length?'...':''; 
			if ($groupe != $groupe_tmp) { 
				$script .= '<option class=\"emundus_search_grp\" disabled=\"disabled\" value=\"\">'.substr(strtoupper($groupe_tmp), 0, $length).$dot_grp.'</option>'; 
				$groupe = $groupe_tmp; 
			} 
			$script .= '<option class=\"emundus_search_elm\" value=\"'.$elements->table_name.'.'.$elements->element_name.'\">'.substr(htmlentities($elements->element_label, ENT_QUOTES), 0, $length).$dot_elm.'</option>'; 
			$i++; 
		} 
		$script .= '</select><a href=\"#removeElement\" onclick=\"removeElement(\'"+divIdName+"\', 1)\"><img src=\"'.JURI::Base().'media/com_emundus/images/icones/viewmag-_16x16.png\" alt=\"'.JText::_('REMOVE_SEARCH_ELEMENT').'\" id=\"add_filt\"/></a>"; ni.appendChild(newdiv); } ';
		//die($script);
		return $script;
	}
	
	function addElementOther($tables){
		$script = 
		'function addElementOther() {
			var ni = document.getElementById("otherDiv");
		  	var numi = document.getElementById("theValue");
		  	var num = (document.getElementById("theValue").value -1)+ 2;
		  	numi.value = num;
		  	var newdiv = document.createElement("div");
		  	var divIdName = "other"+num+"Div";
		  	newdiv.setAttribute("id",divIdName);
			newdiv.innerHTML = "<select name=\"elements_other[]\" id=\"elements_other\" onChange=\"javascript:submit();\"><option value=\"\">'.JText::_("PLEASE_SELECT").'</option>';
		$groupe =""; $i=0; 
		$length = 50;
		$elements = EmundusHelperFilters::getElementsOther($tables);
		if(!empty($elements))
			foreach($elements as $element) { 
				$groupe_tmp = $element->group_label;  
				$dot_grp = strlen($groupe_tmp)>=$length?'...':''; 
				$dot_elm = strlen($element->element_label)>=$length?'...':''; 
				if ($groupe != $groupe_tmp) { 
					$script .= '<option class=\"emundus_search_grp\" disabled=\"disabled\" value=\"\">'.substr(strtoupper($groupe_tmp), 0, $length).$dot_grp.'</option>'; 
					$groupe = $groupe_tmp; 
				}
				$script .= '<option class=\"emundus_search_elm_other\" value=\"'.$element->table_name.'.'.$element->element_name.'\">'.substr(htmlentities($element->element_label, ENT_QUOTES), 0, $length).$dot_elm.'</option>'; 
				$i++; 
			}
		$script .= '</select><a href=\"#removeElement\" onclick=\"removeElement(\'"+divIdName+"\', 2)\"><img src=\"'.JURI::Base().'media/com_emundus/images/icones/viewmag-_16x16.png\" alt=\"'.JText::_('REMOVE_SEARCH_ELEMENT').'\" id=\"add_filt\"/></a>"; ni.appendChild(newdiv); } ';
		return $script;
	}
	
	function delayAct(){
		$itemid = JRequest::getVar('Itemid', null, 'GET', 'none',0);
		$script = 
		'function delayAct(user_id){
			document.adminForm.action = "index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&Itemid='.$itemid.'";
			setTimeout("document.adminForm.submit()",10) }';
		return $script;
	}
	
	function getPreferenceFilters(){
		global $option;
		$mainframe = JFactory::getApplication();
		
		$script = '
		function save_filter()
		{
			var name=prompt("'.JText::_('FILTER_NAME').'","");
			while (name=="")
			{
				alert("'.JText::_('ALERT_EMPTY_FILTER').'");
				name=prompt("'.JText::_('FILTER_NAME').'","name");
			}
			if(name){
				getJsonInput(name);
			}
		}


		function makeArray(items)
		{
			try {
				//this converts object into an array in non-ie browsers
				return Array.prototype.slice.call(items);
			}catch (ex) {
				var i = 0,
				len = items.length,
				result = Array(len);
				while(i < len) {
					result[i] = items[i];
					i++;
				}
				return result; 
			}	
		}

		function getJsonInput(name){
			var selects_object = document.getElementById(\'filters\').getElementsByTagName(\'select\');
			var inputs_object = document.getElementById(\'filters\').getElementsByTagName(\'input\');
			var inputs = makeArray(inputs_object);
			var selects = makeArray(selects_object);
			var jsonObj = [];
			
			for(var i=0;i<selects.length;i++){
				var select = selects[i];
				var name_s = select.id;
				var research = name_s.split(\'_\');
				if(research[0]==\'select-multiple\'){
					for(j=0;j<select.length;j++) {
						if(select[j].selected){
							var value_s = select[j].value;
							// alert(name_s+" "+value_s);
							jsonObj.push({\'id\': name_s, \'value\': value_s});
						}
					}
				}else{
					var value_s = select.value;
					// alert(name_s+" "+value_s);
					jsonObj.push({\'id\': name_s, \'value\': value_s});
				}
			}
			for(var i=0;i<inputs.length;i++){
				var input = inputs[i];
				var name_i = input.id;
				var define_type = name_i.split(\'_\');
				if(define_type[0]==\'check\'){
					var value_i = input.checked;
				}else{
					var value_i = input.value;
				}
				// alert(name_i+" "+value_i+" "+input.checked);
				jsonObj.push({\'id\': name_i, \'value\': value_i});
			}
			// alert(jsonObj[1][\'id\']+" "+jsonObj[1][\'value\']);
			
			var jsonObjString = JSON.stringify(jsonObj); // constraints

			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					window.document.getElementById(\'emundus_filters_response\').innerHTML = xhr.responseText;
					if(xhr.responseText!="SQL Error"){
						// var filter_id = $(\'select_filter\').options[$(\'select_filter\').options.length - 1].value; // lastSavedFilter();
						var xhr2 = getXMLHttpRequest();
						xhr2.onreadystatechange = function(){
							if(xhr2.readyState == 4){
								var filter_id = xhr2.responseText;
								// filter_id=parseInt(filter_id)+1;
								$(\'select_filter\').options[$(\'select_filter\').options.length] = new Option(name, filter_id);
								$(\'select_filter\').value=$(\'select_filter\').options[$(\'select_filter\').options.length-1].value;
							}
						}
						xhr2.open("POST", "index.php?option=com_emundus&controller=users&format=raw&task=lastSavedFilter&Itemid="+itemid, true);
						xhr2.send(null);
					}
				}
			};
			var itemid = getUrlVars()["Itemid"];
			// alert(itemid);
			xhr.open("POST", "index.php?option=com_emundus&controller=users&format=raw&task=savefilters&Itemid="+itemid, true); // document.location.href
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("&constraints="+jsonObjString+"&name="+name+"&Itemid="+itemid);

		}
		
		function getUrlVars() {
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
			});
			return vars;
		}

		function getXMLHttpRequest() {
			var xhr = null;
			 
			if (window.XMLHttpRequest || window.ActiveXObject) {
				if (window.ActiveXObject) {
					try {
						xhr = new ActiveXObject("Msxml2.XMLHTTP");
					} catch(e) {
						xhr = new ActiveXObject("Microsoft.XMLHTTP");
					}
				} else {
					xhr = new XMLHttpRequest();
				}
			} else {
				alert("Votre navigateur ne supporte pas l\'objet XMLHTTPRequest...");
				return null;
			}
			 
			return xhr;
		}

		function getConstraints(select){
			var select_id = select.options[select.selectedIndex].value; 
			var xhr = getXMLHttpRequest();
			var constraints=[];
			// alert(select_id);
			xhr.onreadystatechange = function()
			{
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					constraints = xhr.responseText; //getConstraintsFilter
					if(constraints!=""){
						setFilters(select, constraints);
						setSessionFilterId(select_id);
						submitFilters();
					}
				}
			};
			xhr.open("POST", "index.php?option=com_emundus&controller=users&format=raw&task=getConstraintsFilter", true); // document.location.href
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("&filter_id="+select_id);
		}

		function setFilters(select, constraints) {
			var constraintsObj = JSON.parse(constraints);
			var k =0;
			for (var i = 0; i < constraintsObj.length; i++) {
				// alert(constraintsObj[i].id+\' - \'+constraintsObj[i].value);
				var field = $(constraintsObj[i].id);
				var define_type = constraintsObj[i].id.split(\'_\');
				if(define_type[0]==\'select\'){
					field.value = constraintsObj[i].value;
				}else if(define_type[0]==\'select-multiple\'){
					for(j=0;j<field.length;j++) {
						if(field[j].value == constraintsObj[i].value){
							field[j].selected = true;							
							// alert(field[j].value);
						}else if(!in_array(field[j].value,constraintsObj)){
							field[j].selected = false;
						}
					}
				}else if(define_type[0]==\'text\'){
					field.value = constraintsObj[i].value;
				}else if(define_type[0]==\'check\'){
					field.checked = constraintsObj[i].value;
					// alert(constraintsObj[i].id+\' - \'+constraintsObj[i].value);
				}else{
					if(constraintsObj[i].id==\'elements\' || constraintsObj[i].id==\'elements_values\'){
						if(constraintsObj[i].id==\'elements\'){
							constraintsObj[i].value = constraintsObj[i].value;
							var ni = document.getElementById("em_adv_filters");
							var newdiv = document.createElement("div");
							var divIdName = "post_advance-filter"+k;
							newdiv.setAttribute("id",divIdName);
							var valueS=constraintsObj[i].value.split(".");
							var input ="<input type=\'hidden\' id=\'elements\' name=\'elements[]\' value=\'"+constraintsObj[i].value+"\' />";
							k++; 
						}else if(constraintsObj[i].id==\'elements_values\'){
							newdiv.innerHTML = input+"<input type=\'hidden\' id=\'elements_values\' name=\'elements_values[]\' value=\'"+constraintsObj[i].value+"\' />";
							ni.appendChild(newdiv);
						}
					}
				}
			}
		}
		
		function in_array(value,tab){
			for(var j=0;j<tab.length;j++) {
				if(value==tab[j].value){
					return true;
				}
			}
			return false;
		}
		
		function clear_filter(){
		
			// delete advance filter
			if(document.getElementById(\'myDiv\')){
				var selects_object = document.getElementById(\'myDiv\').getElementsByTagName(\'select\');
				var selects = makeArray(selects_object);
				var d = document.getElementById(\'myDiv\');
				for(var i=0; i<selects.length/2; i++){
					var olddiv = document.getElementById(\'filter\'+i);
					d.removeChild(olddiv);
				}
			}
			

			var view="'.JRequest::getVar('view', null, 'GET', 'none', 0).'";
			var xhr2 = getXMLHttpRequest();
			xhr2.onreadystatechange = function()
			{
				if (xhr2.readyState == 4 && (xhr2.status == 200 || xhr2.status == 0))
				{
					return true;
				}
			};
			xhr2.open("POST", "index.php?option=com_emundus&controller="+view+"&format=raw&task=clear", true); // document.location.href
			xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr2.send();
		}

		function delete_filters(){
		//deleteFilter
			var select_id = $(\'select_filter\').value;
			var xhr = getXMLHttpRequest();
			
			xhr.onreadystatechange = function()
			{
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					window.document.getElementById(\'emundus_filters_response\').innerHTML = xhr.responseText;
					if(xhr.responseText!="SQL Error"){
						for(var i=0; i<$(\'select_filter\').options.length;i++)
						if($(\'select_filter\').options[i].selected){
							// alert(i);
							$(\'select_filter\').remove(i);
						}
					}
				}
			};
			xhr.open("POST", "index.php?option=com_emundus&controller=users&format=raw&task=deletefilters", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("&filter_id="+select_id);
		}
		
		function setCookie(pLabel, pVal, psec)
		{
			var tExpDate=new Date();
			tExpDate.setTime( tExpDate.getTime()+(psec*1000) );
			document.cookie= pLabel + "=" +escape(pVal)+ ( (psec==null) ? "" : ";expires="+ tExpDate.toGMTString() );
		}	
		
		function getCookie(c_name)
		{
			var c_value = document.cookie;
			var c_start = c_value.indexOf(" " + c_name + "=");
			if (c_start == -1){
				c_start = c_value.indexOf(c_name + "=");
			}
			if (c_start == -1){
				c_value = null;
			}else{
				c_start = c_value.indexOf("=", c_start) + 1;
				var c_end = c_value.indexOf(";", c_start);
				if (c_end == -1){
					c_end = c_value.length;
				}
				c_value = unescape(c_value.substring(c_start,c_end));
			}
			return c_value;
		}
		
		function submitFilters(){
			var selected_id = $(\'select_filter\').options[$(\'select_filter\').selectedIndex].value;
			setCookie("selected_id",selected_id,5);
			document.getElementById(\'search_button\').click();
		}
				
		function getLegend(){
			var legend = document.getElementById(\'legend\');
			var select = document.getElementById(\'select-multiple_schoolyears\');
			var output = document.getElementById(\'lschoolyears\');
			var text="";
			var count=0;
			
			var options = select.options;
			for(j=0;j<options.length;j++) {
				if(options[j].selected){
					var value_s = options[j].value;
					if(value_s!="%"){
						if(j==options.length || (j+1)==options.length || options[(j+1)].selected==false){
							text+=value_s;
						}else{
							text+=value_s+", ";
						}
					}
				}
			}
			document.getElementById(\'lschoolyears\').innerHTML=text;
			return ;
		}
		
		function setSessionFilterId(select_id){
				var xhr3 = getXMLHttpRequest();
				$select_id=$(\'select_filter\').value;
				xhr3.onreadystatechange = function()
				{
					if (xhr3.readyState == 4 && (xhr3.status == 200 || xhr3.status == 0))
					{
					
					}
				};
				xhr3.open("GET", "index.php?option=com_emundus&controller=users&format=raw&task=addsession", true);
				xhr3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr3.send("&select_id="+select_id);
		}
		
		window.onload=function() {
			$(\'select_filter\').options['.$mainframe->getUserState($option.'select_id', 'select_id').'].selected=true;
			/* getLegend();*/
		}
		';
		return $script;
	}
}
?>