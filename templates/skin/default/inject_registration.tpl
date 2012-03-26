{literal}
<style type="text/css">
    .extregister { background:url("{/literal}{$sTemplateWebPathPluginExtregister}{literal}images/post.gif") no-repeat 0px 0px; }
    .extregister img.taburet { width:200px; height:60px; float:left; padding:7px 0 7px 5px; cursor:pointer; }
    .extregister img.captcha { float:left; margin:30px 8px 0 15px; }
    .extregister .extregister_license { float:left; margin-top:5px;}
    .extregister .clear { clear:both; padding-bottom:40px; }

    input.ajax-loading {
            background: url({/literal}{cfg name="path.static.skin"}{literal}/images/update_act.gif) right no-repeat;
    }
    input.error {
            border:1px solid #C00 !important;
            background: #f6d2da !important;
    }
    input.success {
            border:1px solid #0C0 !important;
            background: #c9ffcd !important;
    }
</style>
{/literal}

<script type='text/javascript' src='{$sTemplateWebPathPluginExtregister}js/register.js'></script>
{if $oConfig->GetValue('plugin.extregister.reg_question_active')}
<label for="question">{$aLang.registration_question}</label><br />
    <span>{$oConfig->getValue('plugin.extregister.reg_question')}</span>
    <p><input type="text" class="input-text" name="question" id="question" value="{$_aRequest.question}"/></p><br />
{/if}
<div class="extregister">
    <img class="taburet" src="{$oConfig->GetValue('path.root.web')}/plugins/extregister/classes/lib/external/captcha/Zloy_Taburet/index.php?{$_sPhpSessionName}={$_sPhpSessionId}" onclick="this.src='{$oConfig->GetValue('path.root.web')}/plugins/extregister/classes/lib/external/captcha/Zloy_Taburet/index.php?{$_sPhpSessionName}={$_sPhpSessionId}&n='+Math.random(); return false;" alt="" />
    <img class="captcha" src="{$sTemplateWebPathPluginExtregister}images/arrow.gif" alt="" />
    <div class="extregister_license">
            <label for="extregister_name">{$aLang.registration_captcha_extreg}:</label><br />
            <p><input type="text" class="input-text" style="width:130px;" name="captcha_name" value="" maxlength="6" /></p>
    </div>
    <div class="clear"></div>
</div>