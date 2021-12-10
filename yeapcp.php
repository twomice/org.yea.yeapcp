<?php

require_once 'yeapcp.civix.php';

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function yeapcp_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
  if ($pageName == 'CRM_PCP_Page_PCPInfo') {
    // Inject custom CSS for PCP pages.
    CRM_Core_Resources::singleton()->addStyleFile('org.yea.yeapcp', 'css/yeapcp.css');
    CRM_Core_Resources::singleton()->addScriptFile('org.yea.yeapcp', 'js/yeapcp.js');

    // Get ID of parent contribution page (in 4.6, api Pcp.get doesn't exist, so
    // use BAO).
    $bao = new CRM_PCP_BAO_PCP();
    $bao->id = $page->_id;
    $bao->find();
    $bao->fetch();
    $parent_page_id = $bao->page_id;
    $pcpTitleHtml = '<h3 id="yeapcp-pcp-page-title">' . $bao->title . '</h3>';

    // Inject parent Introductory Message above PCP intro text.
    $tpl = CRM_Core_Smarty::singleton();
    $pcp = $tpl->_tpl_vars['pcp'];
    $pcp['intro_text'] = _yeapcp_get_intro_text($parent_page_id) . $pcpTitleHtml;
    $page->assign('pcp', $pcp);
  }
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function yeapcp_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_PCP_Form_Campaign') {
    // Remove the 'Welcome message' field entirely (per https://app.asana.com/0/241603776072319/1201439840173652)
    $form->removeElement('pcp_intro_text');

    // Make the 'Your Message' field required (per https://app.asana.com/0/241603776072319/1201439840173652)
    $pageTextElementLabel = $form->getElement('page_text')->_label;
    $form->addRule('page_text', ts('%1 is a required field.', [1 => $pageTextElementLabel]), 'required');
  }
  elseif ($formName == 'CRM_Contribute_Form_Contribution_Main' && !empty($form->_pcpId)) {
    // Inject parent Introductory Message above PCP intro text.
    $tpl = CRM_Core_Smarty::singleton();
    $intro_text = $tpl->_tpl_vars['intro_text'];
    $intro_text = _yeapcp_get_intro_text($form->_id) . $intro_text;
    $form->assign('intro_text', $intro_text);
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function yeapcp_civicrm_config(&$config) {
  _yeapcp_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function yeapcp_civicrm_xmlMenu(&$files) {
  _yeapcp_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function yeapcp_civicrm_install() {
  _yeapcp_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function yeapcp_civicrm_postInstall() {
  _yeapcp_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function yeapcp_civicrm_uninstall() {
  _yeapcp_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function yeapcp_civicrm_enable() {
  _yeapcp_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function yeapcp_civicrm_disable() {
  _yeapcp_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function yeapcp_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _yeapcp_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function yeapcp_civicrm_managed(&$entities) {
  _yeapcp_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function yeapcp_civicrm_caseTypes(&$caseTypes) {
  _yeapcp_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function yeapcp_civicrm_angularModules(&$angularModules) {
  _yeapcp_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function yeapcp_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _yeapcp_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

function _yeapcp_get_intro_text($page_id) {
  // Retrieve Introductory Message from parent contribution page. We'll inject
  // this into the PCP page below.
  $result = civicrm_api3('ContributionPage', 'get', array(
    'sequential' => 1,
    'return' => "intro_text",
    'id' => $page_id,
  ));
  $parent_intro_text = $result['values'][0]['intro_text'];
  return $parent_intro_text;
}
