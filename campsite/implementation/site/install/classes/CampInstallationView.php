<?php
/**
 * @package Campsite
 *
 * @author Holman Romero <holman.romero@gmail.com>
 * @copyright 2007 MDLF, Inc.
 * @license http://www.gnu.org/licenses/gpl.txt
 * @version $Revision$
 * @link http://www.campware.org
 */

/**
 * Includes
 *
 * We indirectly reference the DOCUMENT_ROOT so we can enable
 * scripts to use this file from the command line, $_SERVER['DOCUMENT_ROOT']
 * is not defined in these cases.
 */
$g_documentRoot = $_SERVER['DOCUMENT_ROOT'];


/**
 * Class CampInstallationView
 */
final class CampInstallationView
{
    /**
     * @var string
     */
    private $m_step = null;

    /**
     * @var array
     */
    private $m_lists = array();


    /**
     * Class constructor.
     *
     * @param string $p_step
     */
    public function __construct($p_step)
    {
        $this->m_step = $p_step;
        $this->controller();
    } // fn __construct


    private function controller()
    {
        switch($this->m_step) {
        case 'precheck':
            $this->preInstallationCheck();
            break;
        case 'license':
            break;
        case 'database':
            $this->databaseConfiguration();
            break;
        case 'mainconfig':
            break;
        case 'loaddemo':
            break;
        case 'finish':
            break;
        }
    } // fn controller


    private function preInstallationCheck()
    {
        $requirementsOk = $this->phpFunctionsCheck() && $this->sysCheck();
        $this->phpRecommendedOptions();

        $template = CampTemplate::singleton();

        $template->assign('php_req_ok', $requirementsOk);
        $template->assign('php_functions', $this->m_lists['phpFunctions']);
        $template->assign('sys_requirements', $this->m_lists['sysRequirements']);
        $template->assign('php_options', $this->m_lists['phpOptions']);
    } // fn preInstallationCheck


    private function databaseConfiguration()
    {
        $template = CampTemplate::singleton();
    } // fn databaseConfiguration


    private function sysCheck()
    {
        $success = true;

        $to_check = array(
            CS_PATH_SITE => 'Document Root Writable',
            CS_INSTALL_DIR.DIR_SEP.'cron_jobs' => 'Cron Jobs Writable',
            CS_PATH_CONFIG => 'Configuration Files Writable',
            CS_PATH_SITE.DIR_SEP.'templates' => 'Templates Folder Writable',
            CS_PATH_SITE.DIR_SEP.'templates_c' => 'Templates Cache Writable',
            CS_PATH_SITE.DIR_SEP.'plugins' => 'Plugins Folder Writable',
        );
        
        foreach ($to_check as $path => $tag) {
            $isWritable = CampInstallationViewHelper::CheckDirWritable($path);
            $success = ($isWritable == 'Yes') ? $success : false;
            $sysRequirements[] = array(
                                   'tag' => $tag,
                                   'exists' => $isWritable,
                                   'path' => $path
                                   );   
        }

        if (CampInstallation::GetHostOS() == 'windows') {
            $sysRequirements[] = array(
                                       'tag' => 'Apache mod_rewrite enabled',
                                       'exists' => '<a href="#" onmouseover="domTT_activate(this, event, \'caption\', \'What is this?\', \'content\', \''.wordwrap('As you are installing Campsite on a Windows server you will need to have the Apache mod_rewrite module enabled in order to be able to use friendly short names URLs.<br /><br />This, however, is not mandatory, as you still will can run Campsite by using template path URLs.', 60, '<br />', true).'\', \'trail\', true, \'delay\', 0);">?</a>'
                                       );
        }
        $this->m_lists['sysRequirements'] = $sysRequirements;

        return $success;
    } // fn sysCheck


    /**
     *
     */
    private function phpFunctionsCheck()
    {
        $success = true;

        $isPHP5 = CampInstallationViewHelper::CheckPHPVersion();
        $success = ($isPHP5 == 'Yes') ? $success : false;
        $phpFunctions[] = array(
                                'tag' => 'PHP >= 5.0',
                                'exists' => $isPHP5
                                );

        $hasMySQL = CampInstallationViewHelper::CheckPHPMySQL();
        $success = ($hasMySQL == 'Yes') ? $success : false;
        $phpFunctions[] = array(
                                'tag' => 'MySQL Support',
                                'exists' => $hasMySQL
                                );

        $hasAPC = CampInstallationViewHelper::CheckPHPAPC();
        $phpFunctions[] = array(
                                'tag' => 'APC (PHP Cache) Support',
                                'exists' => $hasAPC
                                );

        $hasGD = CampInstallationViewHelper::CheckPHPGD();
        $success = ($hasGD == 'Yes') ? $success : false;
        $phpFunctions[] = array(
                                'tag' => 'GD Image Functions Support',
                                'exists' => $hasGD
                                );

        $hasSession = CampInstallationViewHelper::CheckPHPSession();
        $success = ($hasSession == 'Yes') ? $success : false;
        $phpFunctions[] = array(
                                'tag' => 'Session Handling Support',
                                'exists' => $hasSession
                                );

        $hasRewriteModule = CampInstallationViewHelper::CheckRewriteModule();
        $success = ($hasRewriteModule == 'Yes') ? $success : false;
        $phpFunctions[] = array(
                                'tag' => 'Rewrite Module',
                                'exists' => $hasRewriteModule
                                );

        $this->m_lists['phpFunctions'] = $phpFunctions;

        return $success;
    } // fn phpFunctionsCheck


    /**
     *
     */
    private function phpRecommendedOptions()
    {
        $safeModeState = (ini_get('safe_mode') == '1') ? 'On' : 'Off';
        $phpOptions[] = array(
                              'tag' => 'Safe Mode',
                              'rec_state' => 'Off',
                              'cur_state' => $safeModeState
                              );
        $fileUploadsState = (ini_get('file_uploads') == '1') ? 'On' : 'Off';
        $phpOptions[] = array(
                              'tag' => 'File Uploads',
                              'rec_state' => 'On',
                              'cur_state' => $fileUploadsState
                              );
        $sessionAutoState = (ini_get('session.auto_start_') == '1') ? 'On' : 'Off';
        $phpOptions[] = array(
                              'tag' => 'Session Auto Start',
                              'rec_state' => 'Off',
                              'cur_state' => $sessionAutoState
                              );

        $this->m_lists['phpOptions'] = $phpOptions;
    } // fn phpRecommendedOptions

} // class CampInstallationView


final class CampInstallationViewHelper
{
    public static function CheckPHPVersion()
    {
        return (phpversion() > '5.0') ? 'Yes' : 'No';
    } // fn checkPHPVersion


    public static function CheckPHPMySQL()
    {
        return (function_exists('mysql_connect')) ? 'Yes' : 'No';
    } // fn CheckPHPMySQL


    public static function CheckRewriteModule()
    {
        return array_search('mod_rewrite', apache_get_modules()) !== FALSE ? 'Yes' : 'No';
    }


    public static function CheckPHPAPC()
    {
        return (ini_get('apc.enabled') && function_exists('apc_store')) ? 'Yes' : 'No';
    } // fn CheckPHPAPC


    public static function CheckPHPGD()
    {
        return (function_exists('gd_info')) ? 'Yes' : 'No';
    } // fn CheckPHPGD


    public static function CheckPHPSession()
    {
        return (function_exists('session_start')) ? 'Yes' : 'No';
    } // fn CheckPHPSession


    public static function CheckDirWritable($p_directory)
    {
        return (is_writable($p_directory)) ? 'Yes' : 'No';
    } // fn CheckConfigDirRights

} //

?>
