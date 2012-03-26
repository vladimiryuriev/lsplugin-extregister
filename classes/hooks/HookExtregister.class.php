<?php

/*-------------------------------------------------------
*
*	Plugin "Extregister"
*	Author: Vladimir Yuriev (extravert)
*	Site: lsmods.ru
*	Contact e-mail: support@lsmods.ru
*
---------------------------------------------------------
*/

class PluginExtregister_HookExtregister extends Hook {
	public function RegisterHook() {
        //$this->AddHook('template_form_registration_end', 'registration',__CLASS__,-3);
        $this->AddDelegateHook('module_user_add_after','usadd',__CLASS__,-3);
        
	}
    
    public function registration($aVars) {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject_registration.tpl');
    }
    
    public function usadd($aVars) {
        
        
        $oUser=$aVars['params'][0];
        $oUser=$this->User_GetUserById($oUser->getId());
        
        
        if(Config::Get('plugin.extregister.excity_use') && in_array('extcity',$this->Plugin_GetActivePlugins())){
            /**
             * Проверяем страну
             */
            if (func_check(getRequest('profile_country'),'text',1,30)) {
                $oUser->setProfileCountry(getRequest('profile_country'));
            } else {
                $oUser->setProfileCountry(null);
            }
            /**
             * Проверяем город
             */
            if (func_check(getRequest('profile_city'),'text',1,30)) {
                $oUser->setProfileCity(getRequest('profile_city'));
            } else {
                $oUser->setProfileCity(null);
            }

            /**
             * Добавляем страну
             */
            if ($oUser->getProfileCountry()) {
                if (!($oCountry=$this->User_GetCountryByName($oUser->getProfileCountry()))) {
                    $oCountry=Engine::GetEntity('User_Country');
                    $oCountry->setName($oUser->getProfileCountry());
                    $this->User_AddCountry($oCountry);
                }
                $this->User_SetCountryUser($oCountry->getId(),$oUser->getId());
            }
            /**
             * Добавляем город
             */
            if ($oUser->getProfileCity()) {
                if (!($oCity=$this->User_GetCityByName($oUser->getProfileCity()))) {
                    $oCity=Engine::GetEntity('User_City');
                    $oCity->setName($oUser->getProfileCity());
                    $this->User_AddCity($oCity);
                }
                $this->User_SetCityUser($oCity->getId(),$oUser->getId());
            }
        }
        
        if(Config::Get('plugin.extregister.prof_use') && in_array('prof',$this->Plugin_GetActivePlugins())){
            
            if (func_check(getRequest('profile_prof'),'text',1,100)) {
                $oUser->setProfileProf($this->Text_Parser(mb_strtolower(getRequest('profile_prof'))));
            } else {
                $oUser->setProfileProf(null);
            }

            if ($oUser->getProfileProf()) {
                if (!($oProf=$this->PluginProf_Prof_GetByFilter(array('prof_name'=>$oUser->getProfileProf()),'PluginProf_ModuleProf_EntityProf'))) {
                    $oProf=Engine::GetEntity('PluginProf_ModuleProf_EntityProf');
                    $oProf->setName($oUser->getProfileProf());
                    $oProf->Add();
                }
                $this->PluginProf_Prof_SetProfUser($oProf->getProfId(),$oUser->getId());
            }
        }
        
        if(Config::Get('plugin.extregister.show_full_form')){
            if(getRequest('profile_sex')){
                $oUser->setProfileSex(getRequest('profile_sex'));
            }
            if(getRequest('profile_birthday_month') && getRequest('profile_birthday_day') && getRequest('profile_birthday_year')) {
                $oUser->setProfileBirthday(date("Y-m-d H:i:s",mktime(0,0,0,getRequest('profile_birthday_month'),getRequest('profile_birthday_day'),getRequest('profile_birthday_year'))));
            }
        }
        
        $this->User_Update($oUser);

    }


}
?>