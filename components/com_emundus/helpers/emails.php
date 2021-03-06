<?php
/**
 * @version		$Id: email.php 14401 2010-01-26 14:10:00Z guillossou
 * @package		Joomla
 * @subpackage	Emundus
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
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
 * @subpackage	Helper
 * @since 1.5
 */
class EmundusHelperEmails{
	function createEmailBlock($params){
		$current_user = JFactory::getUser();
		$email = '<div class="em_email_block" id="em_email_block">';
		if(in_array('default',$params)){
			$email .= '<fieldset>
				<legend> 
					<span class="editlinktip hasTip" title="'.JText::_('EMAIL_ASSESSORS_DEFAULT').'::'.JText::_('EMAIL_ASSESSORS_DEFAULT_TIP').'">
						<img src="'.JURI::Base().'media/com_emundus/images/icones/mail_replayall_22x22.png" alt="'.JText::_('EMAIL_ASSESSORS_DEFAULT').'"/>'.JText::_('EMAIL_ASSESSORS_DEFAULT').'
					</span>
				</legend>
				<div><input type="submit" class="blue" name="default_email" onclick="document.pressed=this.name" value="'.JText::_( 'SEND_DEFAULT_EMAIL' ).'" ></div>
			</fieldset>';
		}
		if(in_array('custom',$params)){
			$current_eval = JRequest::getVar('user', null, 'POST', 'none',0);
			$current_group = JRequest::getVar('groups', null, 'POST', 'none',0);
			$all_groups = EmundusHelperFilters::getGroups();
			$evaluators = EmundusHelperFilters::getEvaluators();
			$email_template = EmundusHelperEmails::getEmail('assessors_set');
			$email .= '
			<fieldset><legend> 
						<span class="editlinktip hasTip" title="'.JText::_('EMAIL_SELECTED_ASSESSORS').'::'.JText::_('EMAIL_SELECTED_ASSESSORS_TIP').'">
							<img src="'.JURI::Base().'media/com_emundus/images/icones/mail_replay_22x22.png" alt="'.JText::_('EMAIL_ASSESSORS_DEFAULT').'"/> '.JText::_( 'EMAIL_SELECTED_ASSESSORS' ).'
						</span>
					</legend>
				<div>
					<div>
						<dd>
							[NAME] : '.JText::_('TAG_NAME_TIP').'<br />
							[APPLICANTS_LIST] : '.JText::_('TAG_APPLICANTS_LIST_TIP').'<br />
							[SITE_URL] : '.JText::_('SITE_URL_TIP').'<br />
							[EVAL_CRITERIAS] : '.JText::_('EVAL_CRITERIAS_TIP').'<br />
							[EVAL_PERIOD] : '.JText::_('EVAL_PERIOD_TIP').'<br />
						</dd>
					</div><BR />
					<div>
						'.JText::_( 'SUBJECT' ).'
						<input name="mail_subject" type="text" class="inputbox" id="mail_subject" value="'.$email_template->subject.'" size="80" />
					</div>
				</div><br/>
				<div id="addressee">
					<div id="addressee_title">'.JText::_('TO').'</div>
					<div id="addressee_left">
						<label for="a1">
							<input type="radio" name="addressee" id="a1" onclick="hidden_addressee(this);" value="1" checked="yes">
							'.JText::_('ALL_EVALUATORS').'
						</label>
					</div>
					<div id="addressee_center">
						<div>
							<label for="a2">
								<input type="radio" name="addressee" id="a2" onclick="hidden_addressee(this);" value="2">
								'.JText::_('SELECTED_GROUP').'
							</label>
						</div>
						<div id="hidden_addressee_group">
							<select name="mail_group">
								<option value=""> '.JText::_('PLEASE_SELECT_GROUP').' </option>' ;
									foreach($all_groups as $groups) { 
										$email .= '<option value="'.$groups->id.'"';
										if($current_group==$groups->id) $email .= ' selected';
										$email .= '>'.$groups->label.'</option>'; 
									}
							$email .= '</select>
						</div>
					</div>
					<div id="addressee_right">
						<div>
							<label for="a3">
								<input type="radio" name="addressee" id="a3" onclick="hidden_addressee(this);" value="3">
								'.JText::_('SELECTED_EVALUATOR').'
							</label>
						</div>
						<div id="hidden_addressee_evaluator">
							<select name="mail_user">
								<option value="">'.JText::_('PLEASE_SELECT_ASSESSOR').' </option>' ;
								foreach($evaluators as $eval_users) { 
									$email .= '<option value="'.$eval_users->id.'"';
									if($current_eval==$eval_users->id) $email .= ' selected';
									$email .= '>'.$eval_users->name.'</option>'; 
								}
							$email .= ' </select>
						</div>
					</div>
				</div>';
				$editor = &JFactory::getEditor();
				$mail_body = $editor->display( 'mail_body', $email_template->message, '99%', '400', '20', '20', false, 'mail_body', null, null );
				$email .='<label for="mail_body">'.JText::_( 'MESSAGE' ).' </label><br/>'.$mail_body.'
				<div><input type="submit" name="custom_email" onclick="document.pressed=this.name" value="'.JText::_( 'SEND_CUSTOM_EMAIL' ).'" ></div>
			</fieldset>';
		}
		if(in_array('applicants', $params)){
			$email.= '<fieldset>
				<legend> 
					<span class="editlinktip hasTip" title="'.JText::_('EMAIL_SELECTED_APPLICANTS').'::'.JText::_('EMAIL_SELECTED_APPLICANTS_TIP').'">
						<img src="'.JURI::Base().'media/com_emundus/images/icones/mail_replay_22x22.png" alt="'.JText::_('EMAIL_SELECTED_APPLICANTS').'"/> '.JText::_( 'EMAIL_SELECTED_APPLICANTS' ).'
					</span>
				</legend>
				<div>
					<p>
					<dd>
					[NAME] : '.JText::_('TAG_NAME_TIP').'<br />
					[SITE_URL] : '.JText::_('SITE_URL_TIP').'<br />
					</dd>
					</p><br />
					<label for="mail_subject">'.JText::_( 'SUBJECT' ).' </label><br/>
					<input name="mail_subject" type="text" class="inputbox" id="mail_subject" value="" size="80" />
				</div>
				<label for="select_template">'.JText::_( 'TEMPLATE' ).'</label>';
				$AllEmail_template = EmundusHelperEmails::getAllEmail();
				$email.='<select name="select_template" onChange="getTemplate(this);">
				<option value="%">'.JText::_( 'SELECT_TEMPLATE' ).'</option>';
				foreach ($AllEmail_template as $email_template){
					$email.='<option value="'.$email_template->id.'">'.$email_template->subject.'</option>';
				}
				$email.='</select>';
				$editor = &JFactory::getEditor();
				$mail_body = $editor->display( 'mail_body', '[NAME], ', '99%', '400', '20', '20', false, 'mail_body', null, null );
				$email .='<label for="mail_body">'.JText::_( 'MESSAGE' ).' </label><br/>'.$mail_body.'<BR />
				<div><input type="submit" name="applicant_email" onclick="document.pressed=this.name" value="'.JText::_( 'SEND_CUSTOM_EMAIL' ).'" ></div>
			</fieldset>
			<script>
			'.EmundusHelperJavascript::getTemplate().'
			</script>';
		}
		if(in_array('evaluation_result', $params)){
			$editor = &JFactory::getEditor();
			$mail_body = $editor->display( 'mail_body', '', '99%', '400', '20', '20', false, 'mail_body', null, null );

			$student_id = JRequest::getVar('jos_emundus_evaluations___student_id', null, 'GET', 'INT',0);
			$campaign_id = JRequest::getVar('jos_emundus_evaluations___campaign_id', null, 'GET', 'INT',0);
			$applicant = JFactory::getUser($student_id);
			
			$email.= '<fieldset>
				<legend> 
					<span class="editlinktip hasTip" title="'.JText::_('EMAIL_APPLICATION_RESULT').'::'.JText::_('EMAIL_APPLICATION_RESULT_TIP').'">
						<img src="'.JURI::Base().'media/com_emundus/images/icones/mail_replay_22x22.png" alt="'.JText::_('EMAIL_TO').'"/> '.JText::_( 'EMAIL_TO' ).' '.$applicant->name.'
					</span>
				</legend>
				<div>
				<p><label for="mail_subject">'.JText::_( 'SUBJECT' ).' </label><br/>
					<input name="mail_subject" type="text" class="inputbox" id="mail_subject" value="" size="80" />
				<p>
					<input name="mail_to" type="hidden" class="inputbox" id="mail_to" value="'.$applicant->id.'" />
					<input name="campaign_id" type="hidden" class="inputbox" id="campaign_id" value="'.$campaign_id.'" size="80" />
				</div>
				<p><label for="mail_body"> '.JText::_( 'MESSAGE' ).' </label><br/>'.$mail_body.'
				</p>
					<input name="mail_attachments" type="hidden" class="inputbox" id="mail_attachments" value="" />
					<input name="mail_type" type="hidden" class="inputbox" id="mail_type" value="evaluation_result" />
				<br><br>
				<p><div><input type="submit" name="evaluation_result_email" onclick="document.pressed=this.name" value="'.JText::_( 'SEND_CUSTOM_EMAIL' ).'" ></div>
				</p>
			</fieldset>';
		}
		if(in_array('this_applicant', $params)){
			$email_to = JRequest::getVar('sid', null, 'GET', 'none',0);
			$student = JFactory::getUser($email_to);
			$email.= '<fieldset>
				<legend> 
					<span class="editlinktip hasTip" title="'.JText::_('EMAIL_SELECTED_APPLICANTS').'::'.JText::_('EMAIL_SELECTED_APPLICANTS_TIP').'">
						<img src="'.JURI::Base().'media/com_emundus/images/icones/mail_replay_22x22.png" alt="'.JText::_('EMAIL_SELECTED_APPLICANTS').'"/> '.JText::_( 'EMAIL_SELECTED_APPLICANTS' ).'
					</span>
				</legend>
				<div>
					<p>
					<dd>
					[NAME] : '.JText::_('TAG_NAME_TIP').'<br />
					[SITE_URL] : '.JText::_('SITE_URL_TIP').'<br />
					</dd>
					</p><br />
					<label for="mail_subject">'.JText::_( 'SUBJECT' ).' </label><br/>
					<input name="mail_subject" type="text" class="inputbox" id="mail_subject" value="" size="80" /><br />
					<label for="mail_to">'.JText::_( 'APPLICANT' ).' </label><br/>
					<input name="mail_to" type="text" class="inputbox" id="mail_to" value="'.$student->username.'" size="80" disabled/>
					<input type="hidden" name="ud[]" value="'.$email_to.'" >
				</div>';
				$editor = &JFactory::getEditor();
				$mail_body = $editor->display( 'mail_body', '[NAME], ', '99%', '400', '20', '20', false, 'mail_body', null, null );
				$email .='<label for="mail_body">'.JText::_( 'MESSAGE' ).' </label><br/>'.$mail_body.'<br />
				<div><input type="submit" name="applicant_email" onclick="document.pressed=this.name" value="'.JText::_( 'SEND_CUSTOM_EMAIL' ).'" ></div>
			</fieldset>';
		}
		$email .= '</div>';
		return $email;
	}
	
	function getEmail($lbl)
	{
		$query = 'SELECT * FROM #__emundus_setup_emails WHERE lbl="'.mysql_real_escape_string($lbl).'"';
		$this->_db->setQuery( $query );
		return $this->_db->loadObject();
	}
	
	function getAllEmail()
	{
		$query = 'SELECT * FROM #__emundus_setup_emails ';
		$this->_db->setQuery( $query );
		return $this->_db->loadObjectList();
	}
	
	function getTemplate(){
		$db = &JFactory::getDBO();
		$select = JRequest::getVar('select', null, 'POST', 'none', 0);
		$query = 'SELECT * FROM #__emundus_setup_emails WHERE id='.$select;
		$db->setQuery($query);
		$email = $db->loadObject();
		$return = $email->subject.'(***)'.$email->message;
		echo $return;
		die();
	}
	/*
	function sendDefaultEmail(){
		$current_user = JFactory::getUser();
		//$allowed = array("Super Users", "Administrator", "Editor");
		$menu=JSite::getMenu()->getActive();
		$access=!empty($menu)?$menu->access : 0;
		if (!EmundusHelperAccess::isAllowedAccessLevel($current_user->id,$access)) {
			die(JText::_("ACCESS_DENIED"));
		}
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$limitstart = JRequest::getVar('limitstart', null, 'POST', 'none',0);
		$filter_order = JRequest::getVar('filter_order', null, 'POST', null, 0);
		$filter_order_Dir = JRequest::getVar('filter_order_Dir', null, 'POST', null, 0);
		$itemid = JRequest::getVar('Itemid', null, 'GET', null, 0);
		$select_id = JRequest::getVar('ud', array(), 'POST', 'array');
		$filters_users = JRequest::getVar('filters_users', null, 'POST', 'none', 0);
		$filters_users  = explode(', ',$filters_users);	
		
		global $option;
		$campaigns = $mainframe->getUserStateFromRequest( $option."campaigns", "campaigns");
		
		// List of evaluators
		$query = 'SELECT eg.user_id 
					FROM `#__emundus_groups` as eg 
					LEFT JOIN `#__emundus_groups_eval` as ege on ege.group_id=eg.group_id 
					WHERE eg.user_id is not null 
					GROUP BY eg.user_id';
		$db->setQuery( $query );
		$users_1 = $db->loadResultArray();
		
		$query = 'SELECT ege.user_id 
					FROM `#__emundus_groups_eval` as ege 
					WHERE ege.user_id is not null 
					GROUP BY ege.user_id';
		$db->setQuery( $query );
		$users_2 = $db->loadResultArray();
		
		$users = array_unique(array_merge($users_1, $users_2));
		
		/*
		$query = 'SELECT e.email
					FROM #__emundus_users eu
					JOIN #__users e ON e.id = eu.user_id
					WHERE eu.profile IN (2,4,5)';
		$db->setQuery( $query );
		$copy = $db->loadResultArray();
		foreach($copy as $c){
			$cc[] = $c;
		}
		*/
		// R�cup�ration des donn�es du mail
		/*$query = 'SELECT id, subject, emailfrom, name, message
						FROM #__emundus_setup_emails
						WHERE lbl="assessors_set"';
		$db->setQuery( $query );
		$db->query();
		$obj=$db->loadObjectList();
		
		// setup mail
		/*if (isset($current_user->email)) {
			$from = $current_user->email;
			$from_id = $current_user->id;
			$fromname=$current_user->name;
		} elseif ($mainframe->getCfg( 'mailfrom' ) != '' && $mainframe->getCfg( 'fromname' ) != '') {
			$from = $mainframe->getCfg( 'mailfrom' );
			$fromname = $mainframe->getCfg( 'fromname' );
			$from_id = 62;
		} else {
			$query = 'SELECT id, name, email' .
				' FROM #__users' .
				// administrator
				' WHERE gid = 25 LIMIT 1';
			$db->setQuery( $query );
			$admin = $db->loadObject();
			$from = $admin->email;
			$from_id = $admin->id;
			$fromname = $admin->name;
		}
		
		// Evaluations criterias
		$query = 'SELECT id, label, sub_labels
						FROM #__fabrik_elements
						WHERE group_id=41 AND (plugin like "fabrikradiobutton" OR plugin like "fabrikdropdown")';
		$db->setQuery( $query );
		$db->query();
		$eval_criteria=$db->loadObjectList();
		
		$eval = '<ul>';
		foreach($eval_criteria as $e) {
			$eval .= '<li>'.$e->label.' ('.$e->sub_labels.')</li>';
		}
		$eval .= '</ul>';

		// template replacements
		$patterns = array ('/\[ID\]/', '/\[NAME\]/', '/\[EMAIL\]/', '/\[APPLICANTS_LIST\]/', '/\[SITE_URL\]/', '/\[EVAL_CRITERIAS\]/', '/\[EVAL_PERIOD\]/', '/\n/');
		$error=0;
		foreach ($users as $uid) {
			$user = JFactory::getUser($uid);
			
			if(empty($select_id)){
				$query = 'SELECT ee.student_id, ee.campaign_id
							FROM #__emundus_evaluations as ee
							WHERE ee.user <>'.$user->id;
				$db->setQuery( $query );
				$db->query();
				$evaluated_applicant=$db->loadObjectList();
							
				$query = 'SELECT ege.applicant_id, ege.campaign_id
							FROM #__emundus_groups_eval as ege
							WHERE (ege.user_id='.$user->id.' 
							OR ege.group_id IN (SELECT group_id FROM #__emundus_groups WHERE user_id='.$user->id.') )';
				$db->setQuery( $query );
				$db->query();
				$applicants=$db->loadObjectList(); // [APPLICANTS_LIST]
				
				foreach($applicants as $ap) {
					$bool[$ap->applicant_id][$ap->campaign_id] = false;
				}
				
				$query = 'SELECT ege.applicant_id
							FROM #__emundus_groups_eval as ege
							LEFT JOIN #__emundus_evaluations as ee ON ee.student_id=ege.applicant_id AND ee.campaign_id=ege.campaign_id 
							WHERE (ege.user_id='.$user->id.' 
							OR ege.group_id IN (SELECT group_id FROM #__emundus_groups WHERE user_id='.$user->id.') ) AND ee.student_id IS NULL';
				$db->setQuery( $query );
				$db->query();
				$non_evaluated_applicant=$db->loadResultArray();
				
				$model=$this->getModel('campaign');
				
				$list = '<ul>';
				foreach($applicants as $ap) {
					foreach($evaluated_applicant as $e_applicant){
						if(!empty($filters_users) && in_array($ap->applicant_id,$filters_users)){
							if( (($ap->applicant_id==$e_applicant->student_id) && ($ap->campaign_id==$e_applicant->campaign_id)) || (in_array($ap->applicant_id,$non_evaluated_applicant)) && $bool[$ap->applicant_id][$ap->campaign_id]==false){
								$bool[$ap->applicant_id][$ap->campaign_id] = true;
								$app = JFactory::getUser($ap->applicant_id);		
								$campaign=$model->getCampaignByID($ap->campaign_id);
								$list .= '<li>'.$app->name.' ['.$app->id.'] - '.$campaign["label"].' ['.$campaign["year"].']</li>';
							}
						}
					}	
				}
				if($list=='<ul>'){
					$list.='<li>'.JText::_('NO_APPLICANT').'</li>';
				}
				$list .= '</ul>';
			}else{
				foreach ($select_id as $select){
					$params=explode('|',$select);
					$selected[$params[0]][$params[1]]=true;
				}
				$query = 'SELECT ee.student_id, ee.campaign_id
							FROM #__emundus_evaluations as ee
							WHERE ee.user <>'.$user->id;
				$db->setQuery( $query );
				$db->query();
				$evaluated_applicant=$db->loadObjectList();
							
				$query = 'SELECT ege.applicant_id, ege.campaign_id
							FROM #__emundus_groups_eval as ege
							WHERE (ege.user_id='.$user->id.' 
							OR ege.group_id IN (SELECT group_id FROM #__emundus_groups WHERE user_id='.$user->id.') )';
				$db->setQuery( $query );
				$db->query();
				$applicants=$db->loadObjectList(); // [APPLICANTS_LIST]
				
				foreach($applicants as $ap) {
					$bool[$ap->applicant_id][$ap->campaign_id] = false;
				}
				
				$query = 'SELECT ege.applicant_id
							FROM #__emundus_groups_eval as ege
							LEFT JOIN #__emundus_evaluations as ee ON ee.student_id=ege.applicant_id AND ee.campaign_id=ege.campaign_id 
							WHERE (ege.user_id='.$user->id.' 
							OR ege.group_id IN (SELECT group_id FROM #__emundus_groups WHERE user_id='.$user->id.') ) AND ee.student_id IS NULL';
				$db->setQuery( $query );
				$db->query();
				$non_evaluated_applicant=$db->loadResultArray();
				
				$model=$this->getModel('campaign');
				$list = '<ul>';
				foreach(@$applicants as $ap) {
					foreach(@$evaluated_applicant as $e_applicant){
						if(!empty($selected[$ap->applicant_id][$ap->campaign_id])){
							if(!empty($campaigns) && in_array($ap->campaign_id,$campaigns)){
								if( (($ap->applicant_id==$e_applicant->student_id) && ($ap->campaign_id==$e_applicant->campaign_id)) || (in_array($ap->applicant_id,$non_evaluated_applicant)) && $bool[$ap->applicant_id][$ap->campaign_id]==false){
									$bool[$ap->applicant_id][$ap->campaign_id] = true;
									$app = JFactory::getUser($ap->applicant_id);		
									$campaign=$model->getCampaignByID($ap->campaign_id);
									$list .= '<li>'.$app->name.' ['.$app->id.'] - '.$campaign["label"].' ['.$campaign["year"].']</li>';
								}
							}
						}
					}	
				}
				if($list=='<ul>'){
					$list.='<li>'.JText::_('NO_APPLICANT').'</li>';
				}
				$list .= '</ul>';
			}
			
			$query = 'SELECT esp.evaluation_start, esp.evaluation_end 
					FROM #__emundus_setup_profiles AS esp 
					LEFT JOIN #__emundus_users AS eu ON eu.profile=esp.id  
					WHERE user_id='.$user->id;
			$db->setQuery( $query );
			$db->query();
			$period=$db->loadRow();
			
			$period_str = strftime(JText::_('DATE_FORMAT_LC2'), strtotime($period[0])).' '.JText::_('TO').' '.strftime(JText::_('DATE_FORMAT_LC2'), strtotime($period[1]));
			
			$replacements = array ($user->id, $user->name, $user->email, $list, JURI::base(), $eval, $period_str, '<br />');
			
			// template replacements
			$body = preg_replace($patterns, $replacements, $obj[0]->message);
			
			
			// mail function
			if (count($applicants)>0) {
				if (JUtility::sendMail($from, $obj[0]->name, $user->email, $obj[0]->subject, $body, 1, $cc)) {
					$sql = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `subject`, `message`, `date_time`) 
						VALUES ('".$from_id."', '".$user->id."', ".$db->quote($obj[0]->subject).", ".$db->quote($body).", NOW())";
					$db->setQuery( $sql );
					$db->query();
					$sent .= '&rsaquo; '.$user->name.' - '.$user->email.'<br />';
				} else {
					$error++;
				}
			}
			unset($replacements);
			unset($list);
		}
		if ($error>0)	
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid, $sent.JText::_('ACTION_ABORDED'), 'error');
		else 
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid, $sent.JText::_('ACTION_DONE'), 'message');
	
	}*/
	
	function sendCustomEmail(){
		$user = JFactory::getUser();
		global $option;
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
	
		$limitstart = JRequest::getVar('limitstart', null, 'POST', 'none',0);
		$filter_order = JRequest::getVar('filter_order', null, 'POST', null, 0);
		$filter_order_Dir = JRequest::getVar('filter_order_Dir', null, 'POST', null, 0);
		$itemid = JRequest::getVar('Itemid', null, 'GET', null, 0);
		
		$menu=JSite::getMenu()->getActive();
		$access=!empty($menu)?$menu->access : 0;
		if (!EmundusHelperAccess::isAllowedAccessLevel($user->id,$access)) {
			die(JText::_("ACCESS_DENIED"));
		}
		
		// list of applicants with current filters
		include_once(JPATH_BASE.'/components/com_emundus/models/evaluation.php');
		$model = new EmundusModelEvaluation;
		$model->getUsers();
		$applicants=$model->_applicants;
		
		// selected option for choose evaluators
		$addressee = JRequest::getVar('addressee', null, 'POST', 'none',0);
		
		//checkbox ckecked
		$select_id = JRequest::getVar('ud', array(), 'POST', 'array');
		
		if($addressee==1){ // ALL EVALUATORS
			if(!empty($select_id)){ // CHECKBOX
				$select_length=count($select_id);
				$i=1;
				$WHERE ='';
				foreach($select_id as $select){
					$params=explode('|',$select);
					if($i!=$select_length){
						$WHERE .= '(applicant_id='.$params[0].' AND campaign_id='.$params[1].') OR ';
					}else{
						$WHERE .= '(applicant_id='.$params[0].' AND campaign_id='.$params[1].')';
					}
					$i++;
				}
				
				$query='SELECT user_id
				FROM #__emundus_groups_eval 
				WHERE group_id IS NULL AND ('.$WHERE.') 
				GROUP BY user_id';
				$db->setQuery( $query );
				$evaluator_list = $db->loadResultArray(); // list of evaluators

				$query='SELECT group_id
				FROM #__emundus_groups_eval 
				WHERE user_id IS NULL AND ('.$WHERE.') 
				GROUP BY group_id';
				$db->setQuery( $query );
				$group_list = $db->loadResultArray(); // list of evaluators groups
				
				if(!empty($group_list)){
					if(!empty($evaluator_list)){
						$query='SELECT user_id 
						FROM #__emundus_groups WHERE group_id IN ('.implode(", ",$group_list).') AND user_id NOT IN ('.implode(", ",$evaluator_list).')
						GROUP BY user_id';
					}else{
						$query='SELECT user_id 
						FROM #__emundus_groups WHERE group_id IN ('.implode(", ",$group_list).') 
						GROUP BY user_id';
					}
					$db->setQuery( $query );
					$tab=$db->loadResultArray();
					if(!empty($tab)){
						foreach($tab as $element){
							if(!in_array($element,$evaluator_list)){
								$evaluator_list[] = $element; // list of evaluators final
							}
						}
					}
				}
			}else{ // FILTERS
				$i=1;
				$WHERE='';
				$applicants_length=count($applicants);
				foreach($applicants as $applicant){
					if($i!=$applicants_length){
						$WHERE .= '(applicant_id='.$applicant["user_id"].' AND campaign_id='.$applicant["campaign_id"].') OR ';
					}else{
						$WHERE .= '(applicant_id='.$applicant["user_id"].' AND campaign_id='.$applicant["campaign_id"].') ';
					}
					$i++;
				}
				
				$query='SELECT user_id
				FROM #__emundus_groups_eval
				WHERE group_id IS NULL AND ('.$WHERE.') 
				GROUP BY user_id';
				$db->setQuery( $query );
				$evaluator_list = $db->loadResultArray(); // list of evaluators
				
				$query='SELECT group_id
				FROM #__emundus_groups_eval
				WHERE user_id IS NULL AND ('.$WHERE.') 
				GROUP BY group_id';
				$db->setQuery( $query );
				$group_list = $db->loadResultArray(); // list of evaluators groups
				
				if(!empty($group_list)){
					if(!empty($evaluator_list)){
						$query='SELECT user_id 
						FROM #__emundus_groups WHERE group_id IN ('.implode(", ",$group_list).') AND user_id NOT IN ('.implode(", ",$evaluator_list).')
						GROUP BY user_id';
					}else{
						$query='SELECT user_id 
						FROM #__emundus_groups WHERE group_id IN ('.implode(", ",$group_list).') 
						GROUP BY user_id';
					}
					$db->setQuery( $query );
					$tab=$db->loadResultArray();
					if(!empty($tab)){
						foreach($tab as $element){
							if(!in_array($element,$evaluator_list)){
								$evaluator_list[] = $element; // list of evaluators final
							}
						}
					}
				}
			}
		}elseif($addressee==2){ // SELECTED GROUP
			// selected group
			$ag_id = JRequest::getVar('mail_group', null, 'POST', 'none',0);
			
			if (isset($ag_id) && $ag_id > 0) {
				$query = 'SELECT group_id  
				FROM #__emundus_groups 
				WHERE group_id='.$ag_id.' 
				GROUP BY group_id';
				$db->setQuery( $query );
				$group_list = $db->loadResultArray();  // list of evaluators groups
				
				if(!empty($group_list)){
					$query='SELECT user_id 
					FROM #__emundus_groups WHERE group_id IN ('.implode(", ",$group_list).') 
					GROUP BY user_id';
					$db->setQuery( $query );
					$tab=$db->loadResultArray();
					if(!empty($tab)){
						foreach($tab as $element){
							if(!in_array($element,$evaluator_list)){
								$evaluator_list[] = $element; // list of evaluators final
							}
						}
					}
				}else{
					$evaluator_list = array();
				}
			}else{
				JError::raiseWarning( 500, JText::_('ERROR_YOU_MUST_SELECT_AN_EVALUATOR') );
				$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
				return;
			}
			
		}elseif($addressee==3){ // SELECTED EVALUATOR
			// selected user
			$ae_id = JRequest::getVar('mail_user', null, 'POST', 'none',0);
			$evaluator_list=array();
			
			if (isset($ae_id) && $ae_id > 0){
				$evaluator_list[] = $ae_id;
			}else{
				JError::raiseWarning( 500, JText::_('ERROR_YOU_MUST_SELECT_AN_EVALUATOR') );
				$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
				return;
			}
			
		}else{
			JError::raiseWarning( 500, JText::_('ERROR_YOU_MUST_SELECT_AN_EVALUATOR') );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
			return;
		}
		// VARIABLE : $evaluator_list - $select_id (Checkbox) - $applicants (Filters)
		
		// Model for GetCampaignWithID()
		$model=$this->getModel('campaign');
		
		// Content of email
		$subject = JRequest::getVar('mail_subject', null, 'POST', 'none',0);
		$message = JRequest::getVar('mail_body', null, 'POST', 'none',0);
		if ($subject == '') {
			JError::raiseWarning( 500, JText::_( 'ERROR_YOU_MUST_PROVIDE_SUBJECT' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
			return;
		}
		if ($message == '') {
			JError::raiseWarning( 500, JText::_( 'ERROR_YOU_MUST_PROVIDE_A_MESSAGE' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
			return;
		}
		
		// setup mail
		$from = $user->email;
		$from_id = $user->id;
		$fromname=$user->name;
				
		// Evaluations criterias [EVAL_CRITERIAS]
		$query = 'SELECT id, label, params
		FROM #__fabrik_elements
		WHERE group_id=41 AND (plugin like "radiobutton" OR plugin like "dropdown")';
		$db->setQuery( $query );
		$db->query();
		$eval_criteria=$db->loadObjectList();
		
		$evaluation = '<ul>';
		foreach($eval_criteria as $e) {
			$params=json_decode($e->params);
			if(!empty($params->sub_options->sub_labels)){
				$evaluation .= '<li>'.$e->label.' ('.implode(", ",$params->sub_options->sub_labels).')</li>';
			}
		}
		$evaluation .= '</ul>';
		
		// include model email for Tag
		include_once(JPATH_BASE.'/components/com_emundus/models/emails.php');
		$emails = new EmundusModelEmails;
		
		// SEND EMAIL TO THE EVALUATORS
		foreach($evaluator_list as $eval){
			$evaluator = JFactory::getUser($eval);
			$evaluation_list=array();
			if(!empty($select_id)){ // CHECKBOX
				
				// list of evaluation concerned by the selection
				foreach($select_id as $select){
					$params=explode('|',$select);
					$query='SELECT id
					FROM #__emundus_groups_eval
					WHERE applicant_id='.$params[0].' AND campaign_id='.$params[1];
					$db->setQuery( $query );
					$results=$db->loadResultArray();
					foreach($results as $result){
						if(!empty($result) && !in_array($result,$evaluation_list)){
							$evaluation_list[]=$result;
						}
					}
				}
				
			} else { // FILTERS
			
				// list of evaluation concerned by the filter
				foreach($applicants as $applicant){
					$query='SELECT id
					FROM #__emundus_groups_eval
					WHERE applicant_id='.$applicant["user_id"].' AND campaign_id='.$applicant["campaign_id"];
					$db->setQuery( $query );
					$results=$db->loadResultArray();
					foreach($results as $result){
						if(!empty($result) && !in_array($result,$evaluation_list)){
							$evaluation_list[]=$result;
						}
					}
				}
			}
			
				// All Applicant assigned to this evaluator
				$query='SELECT ege.applicant_id, ege.campaign_id
				FROM #__emundus_groups_eval as ege
				WHERE ege.user_id='.$evaluator->id.' AND ege.id IN ('.implode(", ",$evaluation_list).')';
				$db->setQuery( $query );
				// var_dump(str_replace('#__','jos_',$query));
				$applicant_list = $db->loadObjectList();
				
				// All Applicant assigned to the group of this evaluator
				$query='SELECT ege.applicant_id, ege.campaign_id
				FROM #__emundus_groups_eval as ege
				LEFT JOIN #__emundus_groups as eg ON eg.group_id=ege.group_id
				WHERE eg.user_id='.$evaluator->id.' AND ege.id IN ('.implode(", ",$evaluation_list).')';
				$db->setQuery( $query );
				// var_dump(str_replace('#__','jos_',$query));
				$object=$db->loadObject();
				if(!empty($object)){
					$applicant_list[] = $object;
				}
				
				// Applicant already evaluated by this evaluator
				$query='SELECT ege.applicant_id, ege.campaign_id
				FROM #__emundus_groups_eval as ege
				LEFT JOIN #__emundus_evaluations as ee ON ee.student_id=ege.applicant_id AND ee.campaign_id=ege.campaign_id
				WHERE ee.user='.$evaluator->id.' AND ege.id IN ('.implode(", ",$evaluation_list).')';
				$db->setQuery( $query );
				// var_dump(str_replace('#__','jos_',$query));
				$evaluated_applicant_list = $db->loadObjectList();
				
				// create list of all Applicant hasn't been evaluated
				$i=0;
				$bool=array();
				if(!empty($applicant_list)){
					foreach($applicant_list as $applicant){
						
						if(!empty($evaluated_applicant_list)){
							foreach($evaluated_applicant_list as $evaluated){
								if(!isset($bool[$applicant->applicant_id][$applicant->campaign_id]) ){
									if($applicant->applicant_id==$evaluated->applicant_id && $applicant->campaign_id==$evaluated->campaign_id){
										$bool[$applicant->applicant_id][$applicant->campaign_id]=true;
										unset($applicant_list[$i]);
									}
								}
								
							}
						}
						$i++;
					}
				}
				
				// [APPLICANTS_LIST]
				$list = '<ul>';	
				foreach($applicant_list as $applicant){
					$student = JFactory::getUser($applicant->applicant_id);
					$campaign=$model->getCampaignByID($applicant->campaign_id);
					$list .= '<li>'.$student->name.' ['.$student->id.'] - '.$campaign["label"].' ['.$campaign["year"].'] </li>';
				}
				$list .= '</ul>';
				
				// [EVAL_PERIOD]
				$query = 'SELECT esp.evaluation_start, esp.evaluation_end 
				FROM #__emundus_setup_profiles AS esp 
				LEFT JOIN #__emundus_users AS eu ON eu.profile=esp.id  
				WHERE user_id='.$evaluator->id;
				$db->setQuery( $query );
				$db->query();
				$period=$db->loadRow();
				
				//$period_str = strftime(JText::_('DATE_FORMAT_LC2'), strtotime($period[0])).' '.JText::_('TO').' '.strftime(JText::_('DATE_FORMAT_LC2'), strtotime($period[1]));
				$period_str = JHtml::_('date', $period[0], JText::_('DATE_FORMAT_LC2')).' '.JText::_('TO').' '.JHtml::_('date', $period[1], JText::_('DATE_FORMAT_LC2'));
				
				// SEND EMAIL
				if(empty($applicant_list)){
					JError::raiseNotice( 100, JText::_('EMPTY_EVAL_LIST').' : '.$evaluator->name.'<BR />'.JText::_('EMAIL_TO_EVAL_NOT_SEND') );
				}else{
					// template replacements (patterns)
					$post = array(	'EVAL_PERIOD' => $period_str,
									'EVAL_CRITERIAS' => $evaluation, 
									'SITE_URL' => JURI::base(), 
									'APPLICANTS_LIST' => $list,
									'NAME' => $evaluator->name, 
									'EMAIL' => $evaluator->email );

					$tags = $emails->setTags($evaluator->id, $post);
					
					$body = preg_replace($tags['patterns'], $tags['replacements'], $message);
					
					// mail function
					if(JUtility::sendMail($from, $fromname, $evaluator->email, $subject, $body, 1)){
						usleep(1000);
						$sql = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `subject`, `message`, `date_time`) 
							VALUES ('".$from_id."', '".$evaluator->id."', ".$db->quote($subject).", ".$db->quote($body).", NOW())";
						$db->setQuery( $sql );
						$db->query();
					}
					unset($replacements);
					JFactory::getApplication()->enqueueMessage(JText::_('EMAIL_TO_EVAL_SEND').' : '.$evaluator->name);
				}
		}
		
		$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.$itemid);
	}
	
	function sendApplicantEmail() {
		//$allowed = array("Super Users", "Administrator", "Editor");
		$user = JFactory::getUser();
		$menu=JSite::getMenu()->getActive();
		$access=!empty($menu)?$menu->access : 0;
		if (!EmundusHelperAccess::isAllowedAccessLevel($user->id,$access)) {
			die(JText::_("ACCESS_DENIED"));
		}
		
		$mainframe = JFactory::getApplication();

		$db	= JFactory::getDBO();
		$current_user = JFactory::getUser();

		$cids = JRequest::getVar( 'ud', array(), 'post', 'array' );
		foreach ($cids as $cid){
			$params=explode('|',$cid);
			$users_id[] = intval($params[0]);
		}
		
		$captcha	= 1;//JRequest::getInt( JR_CAPTCHA, null, 'post' );

		$subject	= JRequest::getVar( 'mail_subject', null, 'post' );
		$message	= JRequest::getVar( 'mail_body', null, 'post' );

		if ($captcha !== 1) {
			JError::raiseWarning( 500, JText::_( 'ERROR_NOT_A_VALID_POST' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.JRequest::getCmd( 'Itemid' ));
			return;
		}
		if (count( $users_id ) == 0) {
			JError::raiseWarning( 500, JText::_( 'ERROR_NO_ITEMS_SELECTED' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.JRequest::getCmd( 'Itemid' ));
			return;
		}
		if ($subject == '') {
			JError::raiseWarning( 500, JText::_( 'ERROR_YOU_MUST_PROVIDE_SUBJECT' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.JRequest::getCmd( 'Itemid' ));
			return;
		}
		if ($message == '') {
			JError::raiseWarning( 500, JText::_( 'ERROR_YOU_MUST_PROVIDE_A_MESSAGE' ) );
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.JRequest::getCmd( 'Itemid' ));
			return;
		}


		$query = 'SELECT u.id, u.name, u.email' .
					' FROM #__users AS u' .
					' WHERE u.id IN ('.implode( ',', $users_id ).')';
		$db->setQuery( $query );
		$users = $db->loadObjectList();


		// setup mail
		if (isset($current_user->email)) {
			$from = $current_user->email;
			$from_id = $current_user->id;
			$fromname=$current_user->name;
		} elseif ($mainframe->getCfg( 'mailfrom' ) != '' && $mainframe->getCfg( 'fromname' ) != '') {
			$from = $mainframe->getCfg( 'mailfrom' );
			$fromname = $mainframe->getCfg( 'fromname' );
			$from_id = 62;
		} else {
			$query = 'SELECT id, name, email' .
				' FROM #__users' .
				// administrator
				' WHERE gid = 25 LIMIT 1';
			$db->setQuery( $query );
			$admin = $db->loadObject();
			$from = $admin->name;
			$from_id = $admin->id;
			$fromname = $admin->email;
		}

		// template replacements
		$patterns = array ('/\[ID\]/', '/\[NAME\]/', '/\[EMAIL\]/', '/\[SITE_URL\]/', '/\n/');

		$nUsers = count( $users );
		for ($i = 0; $i < $nUsers; $i++) {
			$user = &$users[$i];

			// template replacements
			$replacements = array ($user->id, $user->name, $user->email, JURI::base(), '<br />');
			// template replacements
			$body = preg_replace($patterns, $replacements, $message);

			// mail function
			if (JUtility::sendMail($from, $fromname, $user->email, $subject, $body, 1)) {
				$sql = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `subject`, `message`, `date_time`) 
					VALUES ('".$from_id."', '".$user->id."', ".$db->quote($subject).", ".$db->quote($body).", NOW())";
				$db->setQuery( $sql );
				$db->query();
			} else {
				$error++;
			}
		}
		if ($error>0) {
			JError::raiseWarning( 500, JText::_( 'ACTION_ABORDED' ) );
			return;
		} else {
			$this->setRedirect('index.php?option=com_emundus&view='.JRequest::getCmd( 'view' ).'&limitstart='.$limitstart.'&filter_order='.$filter_order.'&filter_order_Dir='.$filter_order_Dir.'&Itemid='.JRequest::getCmd( 'Itemid' ), JText::_('REPORTS_MAILS_SENT'), 'message');
		}	
	}

}
?>