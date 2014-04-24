CKEDITOR.editorConfig = function(config)
{
	config.language = 'fr';
	config.entities_latin = false;
	config.width = 640;
	config.height = 320;
	config.toolbar_App =
	[
	    ['Source','-','Save','Preview','-','About'],
	    ['Cut','Copy','Paste','-','Print'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],
	    ['Maximize', 'ShowBlocks']
	];
	config.toolbar = 'App';
};
