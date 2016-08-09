<?php
class book {
    function getName() {
        return 'bookname';
    }
}
$func = 'getName';
$book = new book();
$book->$func();
?>