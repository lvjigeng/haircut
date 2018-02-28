<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/3
 * Time: 13:52
 */
class PageTool
{
    public static function show($count, $totalPage, $pageSize, $page, $urlParams)
    {

        //上一页:
        $pre_page = ($page - 1) < 1 ? 1 : ($page - 1);
        //下一页:
        $next_page = ($page + 1) > $totalPage ? $totalPage : ($page + 1);

        $html = <<<PAGE
    <table id="page-table" cellspacing="0">
        <tbody>
            <tr>
                <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                    <div id="turn-page">
                        总计  <span id="totalRecords">{$count}</span>个记录分为 <span id="totalPages">{$totalPage}</span>页当前第 <span id="pageCurrent">{$page}</span>
                        页，每页 <input type="text" size="3" id="pageSize" value="{$pageSize}" onkeypress="return listTable.changePageSize(event)">
                        <span id="page-link">
                            <a href="index.php?{$urlParams}&page=1">首页</a>
                            <a href="index.php?{$urlParams}&page={$pre_page}">上一页</a>
                            <a href="index.php?{$urlParams}&page={$next_page}">下一页</a>
                            <a href="index.php?{$urlParams}&page={$totalPage}">末页</a>
                        </span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
PAGE;
        //返回html
        return $html;
    }
}