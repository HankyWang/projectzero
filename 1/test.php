<?php
class book {
    function getName() {
        return 'bookname';
    }
}
$func = 'getName';
$book = new book();
$book->$func();
echo $func;
echo '</ br>';
echo $book->$func;
?>