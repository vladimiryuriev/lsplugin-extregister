{assign var="noSidebar" value=true}
{include file='header.tpl'}


<div class="center">
	<form action="{router page='registration'}" method="POST" class="form-add">
		<h4 class="sub-header">{$aLang.registration}</h4>

		{hook run='form_registration_begin'}

		<p><label>{$aLang.registration_login}<br />
		<input id="login_reg" type="text" name="login" value="{$_aRequest.login}" class="input-wide" /></label></p>

		<p><label>{$aLang.registration_mail}<br />
		<input id="mail" type="text" name="mail" value="{$_aRequest.mail}" class="input-wide" /></label></p>

		<p><label>{$aLang.registration_password}
        {if $oConfig->GetValue('plugin.extregister.show_one_pass')}
            <a href="#" class="togglelink" id="togglelink" onclick="checkpass();return false;">[ {$aLang.registration_show_pass} ]</a>
		{/if}<br />
		<input id="password_reg" type="password" name="password" value="" class="input-wide" /></label></p>

		{if !$oConfig->GetValue('plugin.extregister.show_one_pass')}
            <p><label>{$aLang.registration_password_retry}<br />
            <input type="password" value="" id="repass" name="password_confirm" class="input-wide" /></label></p>
        {/if}

        {if $oConfig->GetValue('plugin.extregister.show_full_form')}
            <p>
                {$aLang.settings_profile_sex}:<br />
                <select id="gender" name="profile_sex" class="w210">
                    <option value="man" {if $_aRequest.profile_sex=='man'}selected{/if} >{$aLang.settings_profile_sex_man}</option>
                    <option value="woman" {if $_aRequest.profile_sex=='woman'}selected{/if} >{$aLang.settings_profile_sex_woman}</option>
                </select>
            </p>
            <p>
                <label for="">{$aLang.settings_profile_birthday}:</label><br />
                <select style="width:70px;" name="profile_birthday_day">
                    <option value="">{$aLang.date_day}</option>
                    {section name=date_day start=1 loop=32 step=1}
                        <option value="{$smarty.section.date_day.index}" {if $smarty.section.date_day.index==$_aRequest.profile_birthday_day}selected{/if}>{$smarty.section.date_day.index}</option>
                    {/section}
                </select>
                <select style="width:150px;" name="profile_birthday_month">
                    <option value="">{$aLang.date_month}</option>
                    {section name=date_month start=1 loop=13 step=1}
                        <option value="{$smarty.section.date_month.index}" {if $smarty.section.date_month.index==$_aRequest.profile_birthday_month}selected{/if}>{$aLang.month_array[$smarty.section.date_month.index][0]}</option>
                    {/section}
                </select>
                <select style="width:70px;" name="profile_birthday_year">
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

		<input type="submit" class="submit" name="submit_register" value="{$aLang.registration_submit}" />
	</form>
</div>


{include file='footer.tpl'}