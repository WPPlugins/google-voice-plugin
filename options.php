<?php
function gv_callme_plugin_options()
{
?>
<div class="wrap">
<div id="gvwidgetlogo">
    <div class="gvwidgettitle">Google Voice CallMe Widget<span>0.2</span></div>
    <h3>&copy; 2009 IncrediPress<sup style="font-size:8px;">TM</sup></h3>
</div>
<!-- <h2>Google Voice CallMe Widget Options</h2> -->
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<h3><label for="google_voice_callme_html">Embed Code</h3>
<div><textarea name="google_voice_callme_html" id="google_voice_callme_html" cols="80" rows="8"><?php echo get_option('google_voice_callme_html'); ?></textarea></div>
<div>
<h3><label for="google_voice_callme_dnd_html">Do Not Disturb Message</label></h3>
<?php echo get_WYSIWYG('google_voice_callme_dnd_html', 'google_voice_callme_dnd_html', get_option('google_voice_callme_dnd_html')); ?>
</div>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="google_voice_callme_html,google_voice_callme_dnd_html" />
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}

function get_WYSIWYG($id='content',$name='content',$value=''){
	$home = get_option('home');
    $editor =<<<HTML
				<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce.js"></script>
                                <script type="text/javascript" src="/wp-includes/js/tinymce/langs/wp-langs-en.js"></script>
				<script type="text/javascript">
					<!--
					tinyMCE.init({
					theme : "advanced",
					skin:"wp_theme",
					theme_advanced_buttons1:"bold,italic,strikethrough,underline,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,styleprops,separator,separator,spellchecker,search,separator,fullscreen,wp_adv",
					theme_advanced_buttons2:"fontsizeselect,formatselect,pastetext,pasteword,removeformat,separator,charmap,print,separator,forecolor,emotions,separator,sup,sub,separator,undo,redo,attribs,wp_help",
					theme_advanced_buttons3:"",
					theme_advanced_buttons4:"",
					language:"en",
					spellchecker_languages:"+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv",
					theme_advanced_toolbar_location:"top",
					theme_advanced_toolbar_align:"left",
					theme_advanced_statusbar_location:"bottom",
					theme_advanced_resizing:"1",
					theme_advanced_resize_horizontal:"",
					dialog_type:"modal",
					relative_urls:"",
					remove_script_host:"",
					convert_urls:"", apply_source_formatting:"", remove_linebreaks:"1", paste_convert_middot_lists:"1", paste_remove_spans:"1",
					paste_remove_styles:"1",
					gecko_spellcheck:"1",
					entities:"38,amp,60,lt,62,gt",
					accessibility_focus:"1", tab_focus:":prev,:next",
					wpeditimage_disable_captions:"",
					plugins:"safari,inlinepopups,autosave,spellchecker,paste,wordpress,fullscreen,-emotions,-print,-searchreplace,-xhtmlxtras,-advlink,",
					mode : "exact",
					elements : "{$id}",
					width : "565",
					height : "200",
					content_css:"{$home}/wp-content/plugins/tinymce-advanced/css/tadv-mce.css" 
					});
					
	function toggleEditor(id) {
		var elm = document.getElementById(id);

		if (tinyMCE.getInstanceById(id) == null)
			tinyMCE.execCommand('mceAddControl', false, id);
		else
			tinyMCE.execCommand('mceRemoveControl', false, id);
	}

	                        --></script>
				<textarea id="{$id}" name="{$name}" rows="6" cols="80">{$value}</textarea><br/>
                                <input type="button" onclick="toggleEditor('{$id}')" value="Toggle Editor"/>
HTML;
return $editor;
}
?>
