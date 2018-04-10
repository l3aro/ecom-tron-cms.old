<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Frontend Zone
 */
Route::group([
    'namespace' => 'Frontend'
], function() {
    Route::get('/', [
        'as' => 'frontend.homepage',
        'uses' => 'HomeController@show'
    ]);

    /**
     * Contact routes
     */
    Route::group([
        'prefix' => 'contact'
    ], function() {
        Route::get('/', [
            'as' => 'frontend.contact.show',
            'uses' => 'ContactController@show'
        ]);
    });

    /**
     * Login routes
     */
    Route::group([
        'prefix' => 'login'
    ], function() {
        Route::get('/', [
            'as' => 'frontend.login.show',
            'uses' => 'LoginController@show'
        ]);
    });

    /**
     * Order routes
     */
    Route::group([
        'prefix' => 'cart'
    ], function() {
        Route::get('/', [
            'as' => 'frontend.order.show',
            'uses' => 'OrderController@show'
        ]);
    });

    /**
     * Product Category routes
     */
    Route::group([
        'prefix' => 'product-cat'
    ], function() {
        Route::get('/', [
            'as' => 'frontend.productcat.show',
            'uses' => 'ProductCatController@show'
        ]);
    });

    /**
     * Product routes
     */
    Route::group([
        'prefix' => 'product'
    ], function() {
        Route::get('/', [
            'as' => 'frontend.product.show',
            'uses' => 'ProductController@show'
        ]);
    });
});


/**
 * Admin Zone
 */
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function() {

    // Authenticate routes
    Route::get('login', [
        'as' => 'admin.login.showLoginForm',
        'uses' => 'LoginController@showLoginForm',
    ]);
    Route::post('login', [
        'as' => 'admin.login',
        'uses' => 'LoginController@login',
    ]);
    Route::get('logout',[
        'as' => 'admin.logout',
        'uses' => 'LoginController@logout'
    ]);

    // Password reset routes
    Route::get('reset', [
        'as' => 'admin.resetpass.showLinkRequestForm',
        'uses' => 'ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('email', [
        'as' => 'admin.resetpass.sendResetLinkEmail',
        'uses' => 'ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('reset/{token}', [
        'as' => 'admin.resetpass.showResetForm',
        'uses' => 'ResetPasswordController@showResetForm'
    ]);
    Route::post('reset', [
        'as' => 'admin.resetpass.reset',
        'uses' => 'ResetPasswordController@reset'
    ]);
    
    /**
     * Authenticated and have role only
     */
    Route::group([
        'middleware' => ['auth.admin', 'role:admin|moderator|editor|publisher'],
    ], function() {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        
        /**
         * Article Admin routes
         */
        Route::group([
            'prefix' => 'article'
        ],function() {
            Route::get('/',[
                'as' => 'admin.article.index',
                'uses' => 'ArticleController@index',
            ]);
            Route::match(['get', 'post'],'detail/{id?}', [
                'as' => 'admin.article.detail',
                'uses' => 'ArticleController@detail'
            ]);
            Route::post('delete/{arti}', [
                'as' => 'admin.article.delete',
                'uses' => 'ArticleController@delete']
            );
            Route::get('changefield', [
                'as' => 'admin.article.changefield',
                'uses' => 'ArticleController@changefield'
            ]);
            Route::get('movetop/{article}/{articlecat?}',[
                'as' => 'admin.article.movetop',
                'uses' => 'ArticleController@movetop',
            ]);
            Route::post('sort', [
                'as' => 'admin.article.sort',
                'uses' => 'ArticleController@sort'
            ]);
            Route::get('delete_image/{id}', [
                'as' => 'admin.article.delete_image',
                'uses' => 'ArticleController@delete_image'
            ]);
        });

        /**
         * ArticleCat Admin routes
         */
        Route::group([
            'prefix' => 'articlecat'
        ], function() {
            Route::get('/', [
                'as' => 'admin.articlecat.index',
                'uses' => 'ArticleCatController@index'
            ]);
            Route::match(['get','post'],'detail/{id?}', [
                'as' => 'admin.articlecat.detail',
                'uses' => 'ArticleCatController@detail'
            ]);
            Route::post('delete/{id}', [
                'as' => 'admin.articlecat.delete',
                'uses' => 'ArticleCatController@delete']
            );
            Route::post('sortcat', [
                'as' => 'admin.article.sortcat',
                'uses' => 'ArticleCatController@sortcat'
            ]);
            Route::get('delete_image/{id}', [
                'as' => 'admin.articlecat.delete_image',
                'uses' => 'ArticleCatController@delete_image'
            ]);
        });
        
        /**
         * Component Admin routes
         */
        Route::group([
            'prefix' => 'component'
        ], function() {
            Route::get('/',[
                'as' => 'admin.component.index',
                'uses' => 'ComponentController@index',
            ]);
            Route::match(['get','post'],'item',[
                'as' => 'admin.component.item',
                'uses' => 'ComponentController@item',
            ]);
            Route::post('delete_cat/{id}',[
                'as' => 'admin.component.delete',
                'uses' => 'ComponentController@delete_cat',
            ]);
        });
        
        /**
         * Gallery Admin routes
         */
        Route::group([
            'prefix' => 'gallery'
        ], function() {
            Route::get('/',[
                'as' => 'admin.gallery.index',
                'uses' => 'GalleryController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.gallery.detail',
                'uses' => 'GalleryController@detail',
            ]);
            Route::post('sort',[
                'as' => 'admin.gallery.sort',
                'uses' => 'GalleryController@sort',
            ]);
			Route::post('detail/sort',[
                'as' => 'admin.gallery.detail.sort',
                'uses' => 'GalleryController@sortitem',
            ]);
            Route::match(['get','post'],'detail_image',[
                'as' => 'admin.gallery.detail_image',
                'uses' => 'GalleryController@detailimage',
            ]);
            Route::get('delete/{gallery}',[
                'as' => 'admin.gallery.delete',
                'uses' => 'GalleryController@delete',
            ]);
			Route::get('detail/delete/{galleryitem}',[
                'as' => 'admin.gallery.detail.deleteitem',
                'uses' => 'GalleryController@deleteitem',
            ]);
            Route::get('movetop/{gallery}/{gallerycat?}',[
                'as' => 'admin.gallery.movetop',
                'uses' => 'GalleryController@movetop',
            ]);
            Route::get('changefield', [
                'as' => 'admin.gallery.changefield',
                'uses' => 'GalleryController@changefield'
            ]);
            Route::match(['get','post'],'detailupload',[
                'as' => 'admin.gallery.detail_upload_image',
                'uses' => 'GalleryController@detailupload',
            ]);
            Route::post('detailuploadImage',[
                'as' => 'admin.gallery.detailuploadImage',
                'uses' => 'GalleryController@detailuploadImage',
            ]);
			
            Route::get('detail/changefield', [
                'as' => 'admin.gallery.detail.changefield',
                'uses' => 'GalleryController@changefielditem'
            ]);
            Route::get('detail/changefield', [
                'as' => 'admin.gallery.detail.changefield',
                'uses' => 'GalleryController@changefielditem'
            ]);
			
        });
        
        /**
         * GalleryCat Admin routes
         */
        Route::group([
            'prefix' => 'gallerycat'
        ], function() {
            Route::get('/',[
                'as' => 'admin.gallerycat.index',
                'uses' => 'GalleryCatController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.gallerycat.detail',
                'uses' => 'GalleryCatController@detail',
            ]);
            Route::get('delete/{gallerycat}',[
                'as' => 'admin.productcat.delete',
                'uses' => 'GalleryCatController@delete',
            ]);
            Route::post('sortcat',[
                'as' => 'admin.gallerycat.sortcat',
                'uses' => 'GalleryCatController@sortcat',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.gallerycat.deletecategoryimage',
                'uses' => 'GalleryCatController@deletecategoryimage',
            ]);
        });

        /**
         * Language Admin routes
         */
        Route::group([
            'prefix' => 'language'
        ], function() {
            Route::get('/',[
                'as' => 'admin.language.index',
                'uses' => 'LanguageController@index',
            ]);
            Route::match(['get','post'],'item',[
                'as' => 'admin.language.item',
                'uses' => 'LanguageController@item',
            ]);
            Route::match(['get','post'],'language',[
                'as' => 'admin.language.language',
                'uses' => 'LanguageController@language',
            ]);
            Route::get('listlang',[
                'as' => 'admin.language.listlang',
                'uses' => 'LanguageController@listlang',
            ]);
            Route::post('listlang/delete_cat/{id}',[
                'as' => 'admin.language.delete',
                'uses' => 'LanguageController@delete_cat',
            ]);
        });

        /**
         * Menu Admin routes
         */
        Route::group([
            'prefix' => 'menu'
        ], function() {
            Route::get('/',[
                'as' => 'admin.menu.index',
                'uses' => 'MenuController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.menu.detail',
                'uses' => 'MenuController@detail',
            ]);
            Route::get('delete/{id}',[
                'as' => 'admin.menu.delete',
                'uses' => 'MenuController@delete',
            ]);
            Route::post('sortcat',[
                'as' => 'admin.menu.sortcat',
                'uses' => 'MenuController@sortcat',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.menu.deletecategoryimage',
                'uses' => 'MenuController@deletecategoryimage',
            ]);
            Route::get('list_products',[
                'as' => 'admin.menu.list_products',
                'uses' => 'MenuController@list_products',
            ]);
            Route::get('list_articles',[
                'as' => 'admin.menu.list_articles',
                'uses' => 'MenuController@list_articles',
            ]);
            Route::get('get_product',[
                'as' => 'admin.menu.get_product',
                'uses' => 'MenuController@get_product',
            ]);
            Route::get('get_article',[
                'as' => 'admin.menu.get_article',
                'uses' => 'MenuController@get_article',
            ]);
        });
        
        /**
         * MenuCat Admin routes
         */
        Route::group([
            'prefix' => 'menucat'
        ], function() {
            Route::get('/',[
                'as' => 'admin.menucat.index',
                'uses' => 'MenuCatController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.menucat.detail',
                'uses' => 'MenuCatController@detail',
            ]);
            Route::get('delete/{menucat}',[
                'as' => 'admin.productcat.delete',
                'uses' => 'MenuCatController@delete',
            ]);
            Route::post('sortcat',[
                'as' => 'admin.menucat.sortcat',
                'uses' => 'MenuCatController@sortcat',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.menucat.deletecategoryimage',
                'uses' => 'MenuCatController@deletecategoryimage',
            ]);
        });
        
        /** 
         * Contact Admin routes
         */
        Route::group([
            'prefix' => 'contact'
        ], function() {
            Route::get('/',[
                'as' => 'admin.contact.index',
                'uses' => 'ContactController@index',
            ]);
            Route::get('detail',[
                'as' => 'admin.contact.detail',
                'uses' => 'ContactController@detail',
            ]);
            Route::post('delete_cat/{id}',[
                'as' => 'admin.contact.delete',
                'uses' => 'ContactController@delete_cat',
            ]);
            Route::get('delete/{contact}',[
                'as' => 'admin.contact.delete',
                'uses' => 'ContactController@delete',
            ]);
        });       
        
        /**
         * Order Admin routes
         */
        Route::group([
            'prefix' => 'order'
        ], function() {
            Route::match(['get','post'],'/',[
                'as' => 'admin.order.index',
                'uses' => 'OrderController@index',            
            ]);
            Route::match(['get','post'],'item',[
                'as' => 'admin.order.item',
                'uses' => 'OrderController@item',
            ]);
            Route::match(['get','post'],'printfile',[
                'as' => 'admin.order.printfile',
                'uses' => 'OrderController@printfile',
            ]);     
            Route::post('delete_cat/{id}',[
                'as' => 'admin.order.delete',
                'uses' => 'OrderController@delete_cat',
            ]);
            Route::get('delete/{order}',[
                'as' => 'admin.order.delete',
                'uses' => 'OrderController@delete',
            ]);
        });
        
        /**
         * Product Admin routes
         */
        Route::group([
            'prefix' => 'product'
        ], function() {
            Route::get('/',[
                'as' => 'admin.product.index',
                'uses' => 'ProductController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.product.detail',
                'uses' => 'ProductController@detail',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.product.deleteimage',
                'uses' => 'ProductController@deleteimage',
            ]);
            Route::get('deleteproductimage',[
                'as' => 'admin.product.deleteproductimage',
                'uses' => 'ProductController@deleteproductimage',
            ]);
            Route::post('sort',[
                'as' => 'admin.product.sort',
                'uses' => 'ProductController@sort',
            ]);
            Route::get('delete/{product}',[
                'as' => 'admin.product.delete',
                'uses' => 'ProductController@delete',
            ]);
            Route::get('movetop/{product}/{productcat?}',[
                'as' => 'admin.product.movetop',
                'uses' => 'ProductController@movetop',
            ]);
            Route::get('changefield', [
                'as' => 'admin.product.changefield',
                'uses' => 'ProductController@changefield'
            ]);
            Route::post('uploadImage',[
                'as' => 'admin.product.uploadImage',
                'uses' => 'ProductController@uploadImage',
            ]);
        });
        
        /**
         * ProductCat Admin routes
         */
        Route::group([
            'prefix' => 'productcat'
        ], function() {
            Route::get('/',[
                'as' => 'admin.productcat.index',
                'uses' => 'ProductCatController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.productcat.detail',
                'uses' => 'ProductCatController@detail',
            ]);
            Route::get('delete/{productcat}',[
                'as' => 'admin.productcat.delete',
                'uses' => 'ProductCatController@delete',
            ]);
            Route::post('sortcat',[
                'as' => 'admin.productcat.sortcat',
                'uses' => 'ProductCatController@sortcat',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.productcat.deletecategoryimage',
                'uses' => 'ProductCatController@deletecategoryimage',
            ]);
        });
                
        /**
         * Video Admin routes
         */
        Route::group([
            'prefix' => 'video'
        ], function() {
            Route::get('/',[
                'as' => 'admin.video.index',
                'uses' => 'VideoController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.video.detail',
                'uses' => 'VideoController@detail',
            ]);
            Route::post('sort',[
                'as' => 'admin.video.sort',
                'uses' => 'VideoController@sort',
            ]);
            Route::post('uploadImage',[
                'as' => 'admin.video.uploadImage',
                'uses' => 'VideoController@uploadImage',
            ]);
            Route::get('changfield', [
                'as' => 'admin.video.changfield',
                'uses' => 'VideoController@changfield'
            ]);
            Route::get('delete/{video}',[
                'as' => 'admin.video.delete',
                'uses' => 'VideoController@delete',
            ]);
        });
        
        /**
         * VideoCat Admin routes
         */
        Route::group([
            'prefix' => 'videocat'
        ], function() {
            Route::get('/',[
                'as' => 'admin.videocat.index',
                'uses' => 'VideoCatController@index',
            ]);
            Route::match(['get','post'],'detail',[
                'as' => 'admin.videocat.detail',
                'uses' => 'VideoCatController@detail',
            ]);
            Route::get('delete/{videocat}',[
                'as' => 'admin.videocat.delete',
                'uses' => 'VideoCatController@delete',
            ]);
            Route::post('sortcat',[
                'as' => 'admin.videocat.sortcat',
                'uses' => 'VideoCatController@sortcat',
            ]);
            Route::get('deleteimage',[
                'as' => 'admin.videocat.deletecategoryimage',
                'uses' => 'VideoCatController@deletecategoryimage',
            ]);
        });

        /**
         * Setting Admin routes
         */
        Route::group([
            'prefix' => 'setting'
        ], function() {
            Route::get('/',[
                'as' => 'admin.setting.index',
                'uses' => 'SettingController@index',
            ]);
            Route::match(['get','post'],'info',[
                'as' => 'admin.setting.info',
                'uses' => 'SettingController@info',
            ]);
            Route::get('seo',[
                'as' => 'admin.setting.seo',
                'uses' => 'SettingController@seo',
            ]);
            Route::post('seo',[
                'as' => 'admin.setting.seo',
                'uses' => 'SettingController@seo',
            ]);
            Route::match(['get','post'],'sendmail',[
                'as' => 'admin.setting.sendmail',
                'uses' => 'SettingController@sendmail',
            ]);
            Route::get('file',[
                'as' => 'admin.setting.file',
                'uses' => 'SettingController@file',
            ]);
            Route::get('emailcontent',[
                'as' => 'admin.setting.emailcontent',
                'uses' => 'SettingController@emailcontent',
            ]);
            Route::post('emailcontent',[
                'as' => 'admin.setting.emailcontent',
                'uses' => 'SettingController@emailcontent',
            ]);
            Route::get('itememailcontent',[
                'as' => 'admin.setting.itememailcontent',
                'uses' => 'SettingController@itememailcontent',
            ]);
            Route::post('itememailcontent',[
                'as' => 'admin.setting.itememailcontent',
                'uses' => 'SettingController@itememailcontent',
            ]);
        });
        
        
        /**
         * User Admin routes
         */
        Route::group([
            'prefix' => 'user'
        ], function() {
            Route::get('/',[
                'as' => 'admin.user.index',
                'uses' => 'UserController@index',
            ]);
            Route::match(['get','post'],'info',[
                'as' => 'admin.user.info',
                'uses' => 'UserController@info',
            ]);
            Route::match(['get','post'],'changepass',[
                'as' => 'admin.user.changepass',
                'uses' => 'UserController@changepass',
            ]);
            Route::post('delete_user/{id}',[
                'as' => 'admin.user.delete',
                'uses' => 'UserController@delete_user',
            ]);
            Route::match(['get','post'],'profile',[
                'as' => 'admin.user.profile',
                'uses' => 'UserController@profile',
            ]);
        });
        
        /**
         * Authorized for admin, mod, editor
         */
        Route::group([
            'middleware' => ['role:admin|moderator|editor'],
        ], function() {
            Route::get('role_editor', function() {
                return "here editor";
            });

            /**
             * Authorized for admin, mod
             */
            Route::group([
                'middlware' => ['role:admin|moderator'],
            ], function() {
                Route::get('role_moderator', function() {
                    return "here moderator";
                });

                /**
                 * Authorized for admin only
                 */
                Route::group([
                    'middleware' => ['role:admin'],
                ], function() {
                    Route::get('role_admin', function() {
                        return "here admin";
                    });

                });
            });
        });
    });
});
