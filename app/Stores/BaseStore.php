<?php
/*
 * @Description:
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/21
 * @Time: 11:03
 */

namespace App\Stores;

class BaseStore
{
    // 默认连接数据库
    protected $CONN_DB;
    // 数据表
    protected $USER_TB,
        $ADMIN_TB,
        $ROLE_TB,
        $ROLE_USER_TB,
        $AUTH_ACCESS_TB,
        $CONFIG_TB,
        $MENU_TB,
        $ARTICLE_TB,
        $ITEM_TB,
        $TAG_TB,
        $LINK_TB,
        $ARTICLE_ITEM_TB,
        $ARTICLE_TAG_TB,
        $ARTICLE_COMMENT_TB,
        $VERIFY_TB,
        $SLIDE_TB,
        $ARTICLE_PRAISE_TB,
        $ARTICLE_STAR_TB,
        $RESOURCE_TB,
        $RESOURCE_TAG_RELATIONSHIP_TB,
        $RESOURCE_STAR_TB,
        $USER_ACCOUNT_TB,
        $USER_GOLD_LOG_TB,
        $DOWNLOAD_TB,
        $OAUTH_USER,
        $APP,
        $APP_SMALLAPP_SESSION;

    /**
     * BaseStore constructor.
     */
    public function __construct()
    {
        $this->CONN_DB = 'mysql_laradmin';

        $this->USER_TB = 'user';
        $this->ADMIN_TB = 'admin';
        $this->ROLE_TB = 'role';
        $this->ROLE_USER_TB = 'role_user';
        $this->AUTH_ACCESS_TB = 'auth_access';
        $this->CONFIG_TB = 'config';
        $this->MENU_TB = 'menu';
        $this->ARTICLE_TB = 'article';
        $this->ITEM_TB = 'item';
        $this->TAG_TB = 'tag';
        $this->LINK_TB = 'link';
        $this->ARTICLE_ITEM_TB = 'article_item_relationship';
        $this->ARTICLE_TAG_TB = 'article_tag_relationship';
        $this->ARTICLE_COMMENT_TB = 'article_comment';
        $this->VERIFY_TB = 'verify';
        $this->SLIDE_TB = 'slide';
        $this->ARTICLE_PRAISE_TB = 'article_praise';
        $this->ARTICLE_STAR_TB = 'article_star';
        $this->RESOURCE_TB = 'resource';
        $this->RESOURCE_TAG_RELATIONSHIP_TB = 'resource_tag_relationship';
        $this->RESOURCE_STAR_TB = 'resource_star';
        $this->USER_ACCOUNT_TB = 'user_account';
        $this->USER_GOLD_LOG_TB = 'user_gold_log';
        $this->DOWNLOAD_TB = 'download';
        $this->OAUTH_USER = 'oauth_user';
        $this->APP = 'app';
        $this->APP_SMALLAPP_SESSION = 'app_smallapp_session';

    }

}
