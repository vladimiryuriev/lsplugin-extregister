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


class PluginExtregister_ActionRegistration extends PluginExtrgister_Inherit_ActionRegistration {

    public function Init(){
        parent::Init();
        /**
		 * Загружаем в шаблон JS текстовки
		 */
		$this->Lang_AddLangJs(array(
			'error',
            'extreg_too_short_login',
            'extreg_email_format_error',
            'registration_hide_pass',
            'registration_show_pass',
            'extreg_pass_short',
            'extreg_pass_not_equal',
            'extreg_login_short',
            'extreg_login_susp'
        ));
    }

    /**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
            parent::RegisterEvent();
            $this->AddEvent('ajaxcheckregister','EventAjaxCheckRegister');

    }

    /**
     * Ajax проверка на занятость логина/емайла и совпадение паролей
     */
    protected function EventAjaxCheckRegister() {
        $this->Viewer_SetResponseAjax('json');

        // Проверяем все-ли переменные дошли
        if (!getRequest('var') || !getRequest('do')) {
               $this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
               return;
        }
        if (getRequest('do') == 'login'){
                if ( $this->User_GetUserByLogin(getRequest('var')) ){
                        $this->Message_AddErrorSingle($this->Lang_Get('extreg_login_used'),$this->Lang_Get('error'));
                        return;
                } else {
                        if(in_array(getRequest('var'), Config::Get('plugin.extregister.suspended_nicknames'))){
                            $this->Message_AddErrorSingle($this->Lang_Get('extreg_login_susp'),$this->Lang_Get('error'));
                            return;
                        } elseif ( func_check(getRequest('var'),'login',3,30) ){
                            $this->Message_AddNoticeSingle($this->Lang_Get('extreg_login_free'),$this->Lang_Get('error'));
                            return;
                        } else {
                            $this->Message_AddErrorSingle($this->Lang_Get('extreg_login_susp'),$this->Lang_Get('error'));
                            return;
                        }
                }
        }
        if (getRequest('do') == 'mail'){

                if ( $this->User_GetUserByMail(getRequest('var')) ){
                        $this->Message_AddErrorSingle($this->Lang_Get('extreg_email_used'),$this->Lang_Get('error'));
                        return;
                } else {
                        if ( func_check(getRequest('var'),'mail') ){
                            $this->Message_AddNoticeSingle($this->Lang_Get('extreg_email_free'),$this->Lang_Get('error'));
                            return;
                        } else {
                            $this->Message_AddErrorSingle($this->Lang_Get('extreg_email_format_error'),$this->Lang_Get('error'));
                            return;
                        }
                }
        }

    }
    /**
	 * Показывает страничку регистрации и обрабатывает её
	 *
	 * @return unknown
	 */
	protected function EventIndex() {
		/**
		 * Если нажали кнопку "Зарегистрироваться"
		 */
		if (isPost('submit_register')) {
			//Проверяем  входные данные
			$bError=false;
			/**
			 * Проверка логина
			 */
			if (!func_check(getRequest('login'),'login',3,30)) {
				$this->Message_AddError($this->Lang_Get('registration_login_error'),$this->Lang_Get('error'));
				$bError=true;
			}
            /**
			 * Проверка логина на заблокированность
			 */
			if (in_array(mb_strtolower(getRequest('login'),'UTF-8'),Config::Get('plugin.extregister.suspended_nicknames'))) {
				$this->Message_AddError($this->Lang_Get('registration_login_suspend_error'),$this->Lang_Get('error'));
				$bError=true;
			}
			/**
			 * Проверка мыла
			 */
			if (!func_check(getRequest('mail'),'mail')) {
				$this->Message_AddError($this->Lang_Get('registration_mail_error'),$this->Lang_Get('error'));
				$bError=true;
			}
			/**
			 * Проверка пароля
			 */
			if (!func_check(getRequest('password'),'password',5)) {
				$this->Message_AddError($this->Lang_Get('registration_password_error'),$this->Lang_Get('error'));
				$bError=true;
			} elseif (!Config::Get('plugin.extregister.show_one_pass') && getRequest('password')!=getRequest('password_confirm')) {
				$this->Message_AddError($this->Lang_Get('registration_password_error_different'),$this->Lang_Get('error'));
				$bError=true;
			}
			
            
            if(Config::Get('plugin.extregister.show_full_form')){
                /**
                 * Проверяем пол
                 */
                if (!in_array(getRequest('profile_sex'),array('man','woman'))) {
                    $this->Message_AddError($this->Lang_Get('registration_sex_error'),$this->Lang_Get('error'));
                    $bError=true;
                }
                /**
                 * Проверяем дату рождения
                 */
                if (!func_check(getRequest('profile_birthday_day'),'id',1,2) or !func_check(getRequest('profile_birthday_month'),'id',1,2) or !func_check(getRequest('profile_birthday_year'),'id',4,4)) {
                    $this->Message_AddError($this->Lang_Get('registration_bday_error'),$this->Lang_Get('error'));
                    $bError=true;
                }
                
            }
            
            if(Config::Get('plugin.extregister.excity_use') && in_array('extcity',$this->Plugin_GetActivePlugins())){
                
                
                /**
                 * Проверяем страну
                 */
                if (!func_check(getRequest('profile_country'),'text',1,30)) {
                    $this->Message_AddError($this->Lang_Get('registration_country_error'),$this->Lang_Get('error'));
                    $bError=true;
                }

                /**
                 * Проверяем город
                 */
                if (!func_check(getRequest('profile_city'),'text',1,30)) {
                    $this->Message_AddError($this->Lang_Get('registration_city_error'),$this->Lang_Get('error'));
                    $bError=true;
                }
                
            }
            
            if(Config::Get('plugin.extregister.prof_use') && in_array('prof',$this->Plugin_GetActivePlugins())){
                
                
                /**
                 * Проверяем страну
                 */
                if (!func_check(getRequest('profile_prof'),'text',1,100)) {
                    $this->Message_AddError($this->Lang_Get('registration_prof_error'),$this->Lang_Get('error'));
                    $bError=true;
                }

                
            }
            
            
			if(Config::Get('plugin.extregister.reg_question_active')) {
				/**
				 * Проверка ответа на вопрос
				 */
				if (!func_check(getRequest('question'),'mail')) {
					$reg_answer = Config::Get('plugin.extregister.question_answer');
					if (preg_match("/^{$reg_answer}$/iu", getRequest('question')) == false) {
						$this->Message_AddError($this->Lang_Get('answer_error'),$this->Lang_Get('error'));
						$bError=true;
					}
				}
            }
            
			/**
			 * Проверка капчи(циферки с картинки)
			 */
			if (!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring']!=strtolower(getRequest('captcha_name'))) {
				$this->Message_AddError($this->Lang_Get('registration_captcha_error'),$this->Lang_Get('error'));
				$bError=true;
			}
                        
			
			/**
			 * А не занят ли логин?
			 */
			if ($this->User_GetUserByLogin(getRequest('login'))) {
				$this->Message_AddError($this->Lang_Get('registration_login_error_used'),$this->Lang_Get('error'));
				$bError=true;
			}
			/**
			 * А не занято ли мыло?
			 */
			if ($this->User_GetUserByMail(getRequest('mail'))) {
				$this->Message_AddError($this->Lang_Get('registration_mail_error_used'),$this->Lang_Get('error'));
				$bError=true;
			}
			/**
			 * Если всё то пробуем зарегить
			 */
			if (!$bError) {
				/**
				 * Создаем юзера
				 */
				$oUser=Engine::GetEntity('User');
                if(Config::Get('plugin.extregister.only_lowercase')){
                   $login= mb_strtolower(getRequest('login'));
                }else{
                    $login= getRequest('login');
                }
				$oUser->setLogin($login);
				$oUser->setMail(getRequest('mail'));
				$oUser->setPassword(func_encrypt(getRequest('password')));
				$oUser->setDateRegister(date("Y-m-d H:i:s"));
				$oUser->setIpRegister(func_getIp());
				/**
				 * Если используется активация, то генерим код активации
				 */
				if (Config::Get('general.reg.activation')) {
					$oUser->setActivate(0);
					$oUser->setActivateKey(md5(func_generator().time()));
				} else {
					$oUser->setActivate(1);
					$oUser->setActivateKey(null);
				}
				/**
				 * Регистрируем
				 */
				if ($this->User_Add($oUser)) {
					/**
					 * Убиваем каптчу
					 */
					unset($_SESSION['captcha_keystring']);
					/**
					 * Создаем персональный блог
					 */
					$this->Blog_CreatePersonalBlog($oUser);


					/**
					 * Если юзер зарегистрировался по приглашению то обновляем инвайт
					 */
					if (Config::Get('general.reg.invite') and $oInvite=$this->User_GetInviteByCode($this->GetInviteRegister())) {
						$oInvite->setUserToId($oUser->getId());
						$oInvite->setDateUsed(date("Y-m-d H:i:s"));
						$oInvite->setUsed(1);
						$this->User_UpdateInvite($oInvite);
					}
					/**
					 * Если стоит регистрация с активацией то проводим её
					 */
					if (Config::Get('general.reg.activation')) {
						/**
						 * Отправляем на мыло письмо о подтверждении регистрации
						 */
						$this->Notify_SendRegistrationActivate($oUser,getRequest('password'));
						Router::Location(Router::GetPath('registration').'confirm/');
					} else {
						$this->Notify_SendRegistration($oUser,getRequest('password'));
						$this->Viewer_Assign('bRefreshToHome',true);
						$oUser=$this->User_GetUserById($oUser->getId());
						$this->User_Authorization($oUser,false);
						$this->SetTemplateAction('ok');
						$this->DropInviteRegister();
					}
				} else {
					$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
					return Router::Action('error');
				}
			}
		}
	}

        public function EventShutdown() {
            parent::EventShutdown();
            $this->Viewer_Assign('sTemplateWebPathPluginExtregister',Plugin::GetTemplateWebPath(__CLASS__));
            $this->Viewer_Assign('sTemplatePathPluginExtregister',Plugin::GetTemplatePath(__CLASS__));
        }
}
?>