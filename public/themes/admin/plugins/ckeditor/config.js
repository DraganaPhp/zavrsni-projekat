/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        
        config.allowedContent=true;
        config.contentsCss=[
            '/themes/front/vendor/bootstrap/css/bootstrap.min.css',
            '/themes/front/vendor/font-awesome/css/font-awesome.min.css',
            '/themes/front/css/fontastic.css',
            '/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.css',
            '/themes/front/css/style.default.css',
            '/themes/front/css/custom.css',
            '/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css',
            '/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css'
        ]
        config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'
        
};
