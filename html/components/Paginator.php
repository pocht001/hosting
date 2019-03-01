<?php
/**
 * Paginator for news items and comment
 */

class Paginator
{
    public function pag($path, $count, $currentPage=1) {
        $pageNum ='';

        for ($i = 1; $i<=$count; $i++)
        {
            if ($currentPage>2) {
            if ($i==2) $pageNum .='<input type="button" value="..." onclick="pagView()" id="pv1" class="d">'; }
            elseif ($i==3) $pageNum .='<input type="button" value="..." onclick="pagView()" id="pv1" class="d">';
            if ($i == $currentPage)
            {
                $class = 'd';
                $pageNum .= '<span class = "'.$class.'"> '.$i.' </span>';
            }
            else {
                if ($i==1 || $i==$count) $class='c1';
                else $class='c';
                $pageNum .= '<span class="e"><a href="'.$path.$i.'" class="'.$class.'" id="c'.$i.'">'.$i.'</a></span>';
            }
        }

        return $pageNum;
    }

}
