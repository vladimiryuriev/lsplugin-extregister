<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*
*	Plugin Extregister
*	Vladimir Yuriev (extravert)
*	site: http://lsmods.ru
*	contact e-mail: vladimir.o.yuriev@gmail.com
*
*/

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginExtregister extends Plugin {

	
	protected $aInherits=array(
	   'action'=>array('ActionRegistration'),
        );

        protected $aDelegates=array(
            'template'=>array(
                'actions/ActionRegistration/index.tpl'=>'_actions/ActionRegistration/index.tpl',
            ),
        );
	
	public function Activate() {
		return true;
	}
	/**
	 * Init plugin
	 */
	public function Init() {
        //$this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/register.js');
	}
}
?>