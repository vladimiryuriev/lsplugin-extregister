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

$config = array();

/*
 * Вопрос при регистрации
 */
$config['reg_question_active'] = true; //включен ли вопрос при регистрации
$config['reg_question'] = '*Вопрос редактируется в конфиге* /plugins/extregister/config/config.php'; //текст вопроса
$config['question_answer'] = 'rightanswer'; //правильный ответ

$config['only_lowercase']=true; //Логины пользователей могут быть только в нижнем регистре, при регистрации все верхнерегистровые символы переведутся в нижний.

/*
 * Расширенная форма
 */
$config['show_full_form']=true; //В поле регистрации будут отображаться поля даты рождения и пола.
/*
 * Пароль
 */
$config['show_one_pass']=true; //Показывать одно поле для пароля, вместо двух, взамен показывая ссылку "показать пароль"

/*
 * Интеграции
 */

$config['excity_use'] = true; //показывать ли выбор города с выпадающим списком при регистрации (необходим активный плагин extcity)
$config['prof_use'] = true; //показывать ли поле профессии с выпадающим списком при регистрации (необходим плагин prof)


/*массив запрещенных ников*/
$config['suspended_nicknames']=array(
	'fuck',
	'shit'
);

return $config;
?>