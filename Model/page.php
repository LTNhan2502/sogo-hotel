<?php
    class page{
        //Phương thức tính số trang dựa vào tổng số sản phẩm và limit
        function findPage($count, $limit)
        {
            $page = (($count % $limit) == 0 ? $count / $limit : ceil($count / $limit));
            return $page;
        }

        //Phương thức tính start bắt đầu cần lấy giá trị trong sql
        //Dựa vào current_page trên URL, thông qua biến tự đặt tên là page
        function findStart($limit)
        {
            if (!isset($_GET['page']) || $_GET['page'] == 1) {
                $start = 0;
            } else {
                $start = ($_GET['page'] - 1) * $limit;
            }
            return $start;
        }

        //Phân trang mới
        public static function pagination($totalPage, $currentPage, $link)
        {
            // str_replace("[i]", $totalPage, $link);
            //Thay thế [i] bằng $totalPage trong $link

            //Trang đầu/cuối
            $linkPagiFirst = str_replace("[i]", 1, $link);
            $linkPagiLast = str_replace("[i]", $totalPage, $link);

            //Lùi 1 trang
            $previous = $currentPage - 1;
            $previous = max($previous, 1);
            $linkPagiPre = str_replace("[i]", $previous, $link);

            //Tiến 1 trang
            $next = $currentPage + 1;
            $next = min($next, $totalPage);
            $linkPagiNext = str_replace("[i]", $next, $link);

            //Hiển thị trang
            $start = $currentPage - 3;
            $start = max(1, $start);
            $end = $currentPage + 3;
            $end = min($end, $totalPage);
            ob_start();
            ?>
            <ul class="pagination d-flex justify-content-center">
                <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo $linkPagiFirst; ?>">Đầu</a>
                </li>
                <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo $linkPagiPre; ?>">&laquo;</a>
                </li>
                <?php
                for ($i = $start; $i <= $end; $i++) {
                    $linkPagi = str_replace("[i]", $i, $link);
                    ?>
                    <li class="page-item <?php echo $currentPage == $i ? 'active' : '' ?>">
                        <a class="page-link" href="<?php echo $linkPagi; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li class="page-item <?php echo $currentPage == $totalPage ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo $linkPagiNext; ?>">&raquo;</a>
                </li>
                <li class="page-item <?php echo $currentPage == $totalPage ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo $linkPagiLast; ?>">Cuối</a>
                </li>
            </ul>
            <?php
            return $str = ob_get_clean();
        }
    }
?>