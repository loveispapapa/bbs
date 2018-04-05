<?php
/**
 *      QQ2374198406   www.junmi360.com
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class plugin_xlmmylt
{
    protected $xlmmqiyon = false;
    function __construct()
    {
        global $_G;
        $setting =& $_G['cache']['plugin']['xlmmylt'];
        if ($setting['xlmmqiyon']) {
            $fid = intval($_G['fid']);
            $forumid = unserialize($setting['forumid']);
            if (in_array($fid, $forumid)) {
                $this->xlmmqiyon = true;
            }
        }
    }
}
/*论坛主题列表页嵌入*/
class plugin_xlmmylt_forum extends plugin_xlmmylt
{
    function forumdisplay_forumaction()
    {
        if (!$this->xlmmqiyon) {
            return;
        }
        global $_G;
        $setting =& $_G['cache']['plugin']['xlmmylt'];
        $xlmmstyle = $setting['xlmmstyle'];
        $xlmmstylec = $setting['xlmmstylec'];
        $xlmmstylef = $setting['xlmmstylef'];
        $xlmmstylefs = $setting['xlmmstylefs'];
        $thsumt = $setting['thsumt'];
        $xlmm_pict = $setting['xlmm_pict'];
        $xlmmyc = $setting['xlmmyc'];
        include template('xlmmylt:default');
        return $return;
    }
    function forumdisplay_thread_subject_output()
    {
        if (!$this->xlmmqiyon) {
            return;
        }
        global $_G;
        if ($_G['forum']['picstyle'] == 0 || $_G['cookie']['forumdefstyle'] == 1) {
            $setting =& $_G['cache']['plugin']['xlmmylt'];
            $threadlist = $_G['forum_threadlist'];
            $xlmmcl = array();
            $xlmmmessage = $setting['xlmmmessage'];
            $xlmmnum = $setting['xlmmnum'];
            $xlmmkd = $setting['xlmmkd'];
            $xlmmwl = $setting['xlmmwl'];
            $xlmmgd = $setting['xlmmgd'] ? $setting['xlmmgd'] : 90;
            $xlmmpictj = $setting['xlmmpictj'];
            include_once libfile('function/post');
            $xlmmtid = "'-1'";
            foreach ($_G['forum_threadlist'] as $key => $thread) {
                $xlmmtid .= ",'" . $thread['tid'] . "'";
            }
            $fpost = DB::fetch_all("SELECT pid,message,tid FROM " . DB::table('forum_post') . " WHERE first='1' AND tid IN(" . $xlmmtid . ") ");
            // 查询帖子pid,message,tid
            foreach ($fpost as $k => $s) {
                $sub[$s['tid']] = array_shift($fpost);
            }
            foreach ($threadlist as $key => $thread) {
                if ($thread['displayorder'] <= 0 || $setting['xlmmzdt']) {
                    $post = $sub[$thread['tid']];
                    /*主题列表页贴内摘要*/
                    if ($xlmmmessage > 0) {
                        $message = messagecutstr($post['message'], $xlmmmessage);
                        // 帖子摘要
                        if ($message) {
                            $xlmmcl[$key] .= '<p class="thsum">' . $message . '</p>';
                            // 显示帖子摘要
                        }
                    }
                    /*主题列表页贴内图片*/
                    if ($xlmmnum <= 0) {
                        continue;
                    }
                    $xlmmattach = C::t('forum_attachment_n')->fetch_all_by_pid_width('pid:'.$post['pid'],$post['pid'],10);
                    // 根据条件获取帖子图片附件等
                    $xlmmal = count($xlmmattach);
                    if ($xlmmal < $xlmmnum) {
                        if ($xlmmwl) {
                            preg_match_all('/(\\[img\\]|\\[img=\\d{1,4}[x|\\,]\\d{1,4}\\]|<img.*?src=")\\s*([^\\[\\<\\r\\n]+?)\\s*(\\[\\/img\\]|".*>)/is', $post['message'], $xlmmpic, PREG_SET_ORDER);
                            // 外链图片
                        }
                        foreach ($xlmmpic as $img) {
                            $xlmmattach[] = array('attachment' => $img[2]);
                            $xlmmal++;
                            if ($xlmmal >= $xlmmnum) {
                                break;
                            }
                        }
                    }
                    $attachment = $attach['attachment'];
                    if ($xlmmal > $xlmmnum) {
                        array_splice($xlmmattach, $xlmmnum);
                    }
                    if ($xlmmattach) {
                        $xlmmcl[$key] .= '<div class="xlmm_pic">';
                        if ($xlmmal > $xlmmpictj) {
                            $xlmmcl[$key] .= '<span class="nums">
                                <span class="numicn icon-27"></span>
                                <span class="img_count">' . $xlmmal . '</span>
                            </span>';
                        }
                        // 显示图片张数
                        foreach ($xlmmattach as $attach) {
                            if ($attach['aid']) {
                                $forumimg = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']) . 'forum/' . $attach['attachment'];
                                // 图片附件地址
                            } else {
                                $forumimg = $attach['attachment'];
                            }
                            // 外链图片地址
                            $xlmmcl[$key] .= '<a style="height: ' . $xlmmgd . 'px;max-width:' . $xlmmkd . 'px; ">
                                            <img class="lazy" src="' . $forumimg . '" data-original="' . $forumimg . '" height="' . $xlmmgd . '" onclick="zoom(this, this.src, 0, 0, 0)"  id="aimg_' . $attach['aid'] . '" inpost="1" />

                                        </a>';
                            // 显示图片
                        }
                        $xlmmcl[$key] .= '</div>';
                    }
                }
            }
            return $xlmmcl;
        }
    }
}