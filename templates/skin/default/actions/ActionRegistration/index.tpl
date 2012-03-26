{assign var="noSidebar" value=true}
{include file='header.light.tpl'}


<script language="JavaScript" type="text/javascript">
    var DIR_WEB_ROOT 			= '{cfg name="path.root.web"}';
    var DIR_STATIC_SKIN 		= '{cfg name="path.static.skin"}';
    var DIR_ROOT_ENGINE_LIB     = '{cfg name="path.root.engine_lib"}'; 
    var LIVESTREET_SECURITY_KEY = '{$LIVESTREET_SECURITY_KEY}';
    var SESSION_ID              = '{$_sPhpSessionId}'; 
    var BLOG_USE_TINYMCE		= '{cfg name="view.tinymce"}';

    var TINYMCE_LANG='en';
    {if $oConfig->GetValue('lang.current')=='russian'}
        TINYMCE_LANG='ru';
    {/if}

    var aRouter = new Array();
    {foreach from=$aRouter key=sPage item=sPath}
        aRouter['{$sPage}'] = '{$sPath}';
    {/foreach}
</script>

{$aHtmlHeadFiles.js}

<script language="JavaScript" type="text/javascript">
    var tinyMCE=false;
    ls.lang.load({json var=$aLangJs});
</script>

<div class="center">
	<form action="{router page='registration'}" method="POST">
		<h2>{$aLang.registration}</h2>

		{hook run='form_registration_begin'}

		<p><label>{$aLang.registration_login}<br />
		<input type="text" name="login" value="{$_aRequest.login}" class="input-text input-wide" /><br />
		<span class="note">{$aLang.registration_login_notice}</span></label></p>

		<p><label>{$aLang.registration_mail}<br />
		<input type="text" name="mail" value="{$_aRequest.mail}" class="input-text input-wide" /><br />
		<span class="note">{$aLang.registration_mail_notice}</span></label></p>

		<p><label>{$aLang.registration_password}
        {if $oConfig->GetValue('plugin.extregister.show_one_pass')}
            <a href="#" class="togglelink" id="togglelink" onclick="checkpass();return false;">[ {$aLang.registration_show_pass} ]</a><br/>
		{/if}
		<input type="password" id="password_reg" name="password" value="" class="input-text input-wide" /><br />
        
        <span class="note">{$aLang.registration_password_notice}</span></label></p>

        {if !$oConfig->GetValue('plugin.extregister.show_one_pass')}
            <p><label>{$aLang.registration_password_retry}<br />
            <input type="password" value="" id="repass" name="password_confirm" class="input-text input-wide" /></label></p>
        {/if}

        {if $oConfig->GetValue('plugin.extregister.show_full_form')}
            <p>
                {$aLang.settings_profile_sex}:<br />
                <label><input type="radio" name="profile_sex" id="profile_sex_m" value="man" {if $_aRequest.profile_sex=='man'}checked{/if} class="checkbox" />{$aLang.settings_profile_sex_man}</label><br />
                <label><input type="radio" name="profile_sex" id="profile_sex_w" value="woman" {if $_aRequest.profile_sex=='woman'}checked{/if} class="checkbox" />{$aLang.settings_profile_sex_woman}</label><br />
            </p>
            <p>
                <label for="">{$aLang.settings_profile_birthday}:</label><br />
                <select name="profile_birthday_day">
                    <option value="">{$aLang.date_day}</option>
                    {section name=date_day start=1 loop=32 step=1}
                        <option value="{$smarty.section.date_day.index}" {if $smarty.section.date_day.index==$_aRequest.profile_birthday_day}selected{/if}>{$smarty.section.date_day.index}</option>
                    {/section}
                </select>
                <select name="profile_birthday_month">
                    <option value="">{$aLang.date_month}</option>
                    {section name=date_month start=1 loop=13 step=1}
                        <option value="{$smarty.section.date_month.index}" {if $smarty.section.date_month.index==$_aRequest.profile_birthday_month}selected{/if}>{$aLang.month_array[$smarty.section.date_month.index][0]}</option>
                    {/section}
                </select>
                <select name="profile_birthday_year">
                    <option value="">{$aLang.date_year}</option>
                    {section name=date_year start=1940 loop=2000 step=1}
                        <option value="{$smarty.section.date_year.index}" {if $smarty.section.date_year.index==$_aRequest.profile_birthday_year}selected{/if}>{$smarty.section.date_year.index}</option>
                    {/section}
                </select>
            </p>
        {/if}


		{if $oConfig->GetValue('plugin.extregister.excity_use') && $aPluginActive.extcity}
            {hook run='extcity_register'}
        {/if}

        {if $oConfig->GetValue('plugin.extregister.prof_use') && $aPluginActive.prof}
            {hook run='prof_register'}
        {/if}

        {include file="$sTemplatePathPluginExtregister/inject_registration.tpl"}

		{hook run='form_registration_end'}

		<input type="submit" name="submit_register" class="button" value="{$aLang.registration_submit}" />
	</form>
</div>


{include file='footer.light.tpl'}