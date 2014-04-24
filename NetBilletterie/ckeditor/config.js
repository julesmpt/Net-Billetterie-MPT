/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.editorConfig = function( config )
{
//Define changes to default configuration here. For example:
config.language ='fr';
config.uiColor = '#AADC6E';
config.filebrowserBrowseUrl = '/NetBilletterie/kcfinder/browse.php?type=files'; 
config.filebrowserImageBrowseUrl = '/NetBilletterie/kcfinder/browse.php?type=images'; 
config.filebrowserFlashBrowseUrl = '/NetBilletterie/kcfinder/browse.php?type=flash'; 
config.filebrowserUploadUrl = '/NetBilletterie/kcfinder/upload.php?type=files'; 
config.filebrowserImageUploadUrl = '/NetBilletterie/kcfinder/upload.php?type=images'; 
config.filebrowserFlashUploadUrl = '/NetBilletterie/kcfinder/upload.php?type=flash';
config.templates_files =['/NetBilletterie/ckeditor/plugins/templates/templates/default.js'];
config.enterMode = CKEDITOR.ENTER_BR;
};
CKEDITOR.config.toolbar_Full = [
    ['Source','-','Preview','-','Templates','Image','Link'],
    ['Undo','Redo','-'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    '/',
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor','Maximize']
];
CKEDITOR.replace( 'toolbar_Full',
    {
        on :
        {
            instanceReady : function( ev )
            {
                // Output paragraphs as <p>Text</p>.
                this.dataProcessor.writer.setRules( 'p',
                    {
                        indent : false,
                        breakBeforeOpen : false,
                        breakAfterOpen : false,
                        breakBeforeClose : false,
                        breakAfterClose : false
                    });
            }
        }
    });
