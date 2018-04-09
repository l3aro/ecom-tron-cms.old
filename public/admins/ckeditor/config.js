/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'vi';
	config.uiColor = '#eaeaea';
	config.height = 250;
	config.filebrowserBrowseUrl= '/admins/ckfinder/ckfinder.html';
	config.filebrowserUploadUrl= '/admins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageBrowseUrl = '/admins/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserImageUploadUrl = '/admins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserWindowWidth= '1000';
	config.filebrowserWindowHeight= '700';
};
