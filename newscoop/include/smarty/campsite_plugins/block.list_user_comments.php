<?php
/**
 * @package Newscoop
 * @copyright 2011 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Newscoop list_users block plugin
 *
 * Type:     block
 * Name:     list_users
 *
 * @param array $params
 * @param mixed $content
 * @param object $smarty
 * @param bool $repeat
 * @return string
 */
function smarty_block_list_user_comments($params, $content, &$smarty, &$repeat)
{
    $context = $smarty->getTemplateVars('gimme');

    if (!isset($content)) { // init
        $start = $context->next_list_start('UserCommentsList');
        $list = new UserCommentsList($start, $params);
        if ($list->isEmpty()) {
            $context->setCurrentList($list, array());
            $context->resetCurrentList();
            $repeat = false;
            return;
        }

        $context->setCurrentList($list, array('user_comment'));
        $context->user_comment = $context->current_user_comments_list->current;
        $repeat = true;
    } else { // next
        $context->current_user_comments_list->defaultIterator()->next();
        if (!is_null($context->current_user_comments_list->current)) {
            $context->user_comment = $context->current_user_comments_list->current;
            $repeat = true;
        } else {
            $context->resetCurrentList();
            $repeat = false;
        }
    }

    return $content;
}
